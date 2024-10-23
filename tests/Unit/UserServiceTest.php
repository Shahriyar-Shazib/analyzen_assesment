<?php

// test('example', function () {
//     expect(true)->toBeTrue();
// });

namespace Tests\Unit;

use App\Services\UserService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase {
    use RefreshDatabase;

    protected $userService;

    protected function setUp(): void {
        parent::setUp();
        $this->userService = new UserService();
    }

    public function test_it_can_list_users() {
        User::factory()->count(3)->create();
        $users = $this->userService->listUsers();
        $this->assertCount(3, $users);
    }

    public function test_it_can_add_user() {
        $userData = ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => bcrypt('password')];
        $user = $this->userService->addUser($userData);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_it_can_update_user() {
        $user = User::factory()->create();
        $updatedData = ['name' => 'Jane Doe'];
        $updatedUser = $this->userService->updateUser($user->id, $updatedData);
        $this->assertEquals('Jane Doe', $updatedUser->name);
    }

    public function test_it_can_soft_delete_user() {
        $user = User::factory()->create();
        $result = $this->userService->deleteUser($user->id);
        $this->assertTrue($result);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_it_can_restore_user() {
        $user = User::factory()->create();
        $user->delete();
        $this->userService->restoreUser($user->id);
        $this->assertFalse($user->fresh()->trashed());
    }

    public function test_it_can_list_trashed_users() {
        $user = User::factory()->create();
        $user->delete();
        $trashedUsers = $this->userService->getTrashedUsers();
        $this->assertCount(1, $trashedUsers);
    }
    public function test_it_can_force_delete_user() {
        $user = User::factory()->create();
        $user->delete(); // Soft delete
        $result = $this->userService->forceDeleteUser($user->id);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
  
}
