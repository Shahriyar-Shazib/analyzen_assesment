<?php
namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = app(UserService::class);

        Storage::fake('public');
    }

    public function test_it_can_list_users()
    {
        $loggedInUser = User::factory()->create();

        $this->actingAs($loggedInUser);

        $users = User::factory()->count(3)->create();
        $userList = $this->userService->listUsers();

        $this->assertCount(3, $userList);
        $this->assertFalse($userList->contains($loggedInUser));
    }

    public function test_it_can_add_user()
    {

        $data = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'picture' => UploadedFile::fake()->image('profile.jpg'),
            'address' => 'Dhaka Dhaka'
        ];

        $user = $this->userService->addUser($data);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
        ]);

        Storage::disk('public')->assertExists($user->picture);
    }

    public function test_it_can_update_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    
        $newProfilePicture = UploadedFile::fake()->image('new_profile.jpg');
    
        $data = [
            'user_id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
            'picture' => $newProfilePicture,
            'address' => 'Dhaka Dhaka'
        ];
    
        $this->userService->updateUser($user->id, $data);
    
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ]);
    
        Storage::disk('public')->assertExists("pro_picture/{$newProfilePicture->hashName()}");
    }
    

    public function test_it_can_soft_delete_user()
    {
        $user = User::factory()->create();

        $this->userService->deleteUser($user->id);

        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);
    }

    public function test_it_can_restore_user()
    {
        $user = User::factory()->create();
        $user->delete();

        $this->userService->restoreUser($user->id);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }

    public function test_it_can_list_trashed_users()
    {
        $trashedUsers = User::factory()->count(2)->create();
        foreach ($trashedUsers as $user) {
            $user->delete();
        }

        $trashedList = $this->userService->getTrashedUsers();

        $this->assertCount(2, $trashedList);
    }

    public function test_it_can_force_delete_user()
    {
        $user = User::factory()->create();
        $user->delete();

        $this->userService->forceDeleteUser($user->id);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
