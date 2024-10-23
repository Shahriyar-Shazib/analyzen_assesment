<x-app-layout>
    
    <dib class="card">

    <div class="card-header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User List') }}
        </h2>
        <div class = "d-flex">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        Create
        </button>
            <!-- <a class = "btn btn-sm  btn-info " style = "color:white;"href="{{route('user.create')}}">create</a> -->
        </div>
    </div>
        <div class="pl-10 py-12 table">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Sl</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td>{{++$key}}</td>
                            <td><img src="{{ Storage::url($user->picture) }}" alt=""style="width: 60px; height: auto;"></td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary" onclick="userEdit({{$user}})">Edit</a>
                                <a href="{{ route('user.delete', ['id' => $user->id]) }}" class="btn btn-sm btn-danger">Delete</a>
                                <a href="#" class="btn btn-sm btn-primary" onclick="addAddress({{$user->id}})">add address</a>
                                <a href="#" class="btn btn-sm btn-info"onclick="viewAddress({{$user->id}})">View address</a>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User Create</h5>
            
            </div>
            <form action="" id="user_create_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="name-field-lebel">Name</span>
                            <input type="text" class="form-control" id = "name-field" name ="name" aria-label="Enter your name" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="email-field-lebel">@</span>
                            <input type="text" class="form-control" id = "email-field" name ="email" aria-label="Enter your email" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="password-field-lebel">password</span>
                            <input type="password" class="form-control"  id = "password-field" name ="password" aria-label="Enter your email" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="picture-field-lebel">Image</span>
                            <input type="file" src=""  class="form-control"  id = "picture-field" name ="picture" alt="">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="address-field-lebel">Address</span>
                            <textarea class="form-group" name="address" id="address-field"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                
                </div>
                <form action="" id="user_edit_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        
                        @csrf
                        <input type="hidden" name="user_id" id="edit-user_id">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="name-field-lebel">Name</span>
                            <input type="text" class="form-control" id = "edit-name-field" name ="name" aria-label="Enter your name" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="email-field-lebel">@</span>
                            <input type="text" class="form-control" id = "edit-email-field" name ="email" aria-label="Enter your email" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="picture-field-lebel">Image</span>
                            <input type="file" src=""  class="form-control"  id = "edit-picture-field" name ="picture" alt="">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="address-field-lebel">Address</span>
                            <textarea class="form-group" name="address" id="edit-address-field"></textarea>
                        </div>
                            
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="edit-submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- view address fields -->
    <div class="modal fade" id="addressViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Addreses of this User</h5>
                </div>
                <table class="address-table table">
                    <thead>
                        <th>Address</th>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- add address fields -->
    <div class="modal fade" id="addressCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Addreses of this User</h5>
                
                </div>
                <form action="" id ="add_address" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="address_user_id">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="create-address-field-lebel">Address</span>
                            <textarea class="form-group" name="address" id="create-address-field"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="addressCreatesubmit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('js')
   <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#user_create_form').submit(function() {
        event.preventDefault();

        var name = $('#name-field').val()
        var email = $('#email-field').val()
        var password = $('#password-field').val()
        
        if(name == '' || email == '' || password == ''){
            alert("fillup all input field")
        }else{
                var formData = new FormData($('#user_create_form')[0]);
                var fileInput = $('#picture-field')[0].files[0];
                if (fileInput) {
                    formData.append('picture', fileInput);  // Ensure the file is correctly appended
                }
                $.ajax({
                    type: 'POST',
                    url: "{{ route('user.save') }}",
                    data: formData,
                    processData: false, // Required for sending FormData
                    contentType: false, // Required for sending FormData
                    dataType: 'json',
                    success: function(result) {
                        toastr.success('Data saved successfully!', 'Success'); // Correct usage
                        $('#createModal').modal('hide')
                        window.location.href = "{{ route('user.list') }}";
                        
                    },
                    error: function(data) {
                        alert('Error:', data)
                        console.log('Error:', data);
                        $('#saveBtn').html('Save');
                    }
                });

        }
    })
    function userEdit(user){
        event.preventDefault();
        $('#edit-user_id').val(user.id)
        $('#edit-name-field').val(user.name)
        $('#edit-email-field').val(user.email)
        $('#editModal').modal('show')

    }

    function addAddress(id){
        event.preventDefault();
        $('#address_user_id').val(id)
        $('#addressCreateModal').modal('show')
        
    }

    $('#add_address').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData($('#add_address')[0]); // Get form data

        $.ajax({
            type: 'POST',
            url: "{{ route('user.address.add') }}", // Ensure this route exists
            data: formData,
            contentType: false, // Important for FormData
            processData: false, // Important for FormData
            success: function(result) {
                console.log(result); // Log the result for debugging
                toastr.success('Data saved successfully!', 'Success'); // Show success message
                $('#addressCreateModal').modal('hide'); // Hide modal after success
            },
            error: function(data) {
                alert('Error:', data); // Alert on error
                console.log('Error:', data); // Log error details
                $('#saveBtn').html('Save'); // Reset button text
            }
        });
    });


    function viewAddress(id){
        var url = '{{ route("user.address", ":id") }}';

        url = url.replace(':id', id);
         $.ajax({
            type: 'GET',
            url: url,
            success: function(result) {
                $('.address-table tbody').empty()
                result.forEach(function(item) {
                    console.log(item.address)
                   
                    var newRow = `<tr><td>${item.address}</td></tr>`;
                    
                    $('.address-table tbody').append(newRow);
                });
               
                    $('#addressViewModal').modal('show') ;
            },
            error: function(data) {
                alert('Error:', data)
                console.log('Error:', data);
                $('#saveBtn').html('Save');
            }
        });
    }
    $('#user_edit_form').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($('#user_edit_form')[0]);
        var fileInput = $('#edit-picture-field')[0].files[0];
        if (fileInput) {
            formData.append('picture', fileInput); // Ensure the file is correctly appended
        }
        $.ajax({
            type: 'POST',
            url: "{{ route('user.edit') }}",
            data: formData,
            processData: false, // Required for sending FormData
            contentType: false, // Required for sending FormData
            dataType: 'json',
            success: function(result) {
                console.log(result);
                toastr.success('Data saved successfully!', 'Success'); // Correct usage
                $('#editModal').modal('hide');
                 window.location.href = "{{ route('user.list') }}";
            },
            error: function(data) {
                alert('Error:', data)
                console.log('Error:', data);
                $('#saveBtn').html('Save');
            }
        });
    });
   </script>
@endsection
</x-app-layout>

