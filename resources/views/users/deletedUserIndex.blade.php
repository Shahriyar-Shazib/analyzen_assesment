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
                                <a href="{{ route('restore.user', ['id' => $user->id]) }}" class="btn btn-sm btn-primary" >Restore</a>
                                <a href="{{ route('user.forceDelete', ['id' => $user->id]) }}" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                        console.log('Error:', data);
                        $('#saveBtn').html('Save');
                    }
                });

        }
    })
    function userEdit(user){
        event.preventDefault();
        console.log(user)
        $('#edit-user_id').val(user.id)
        $('#edit-name-field').val(user.name)
        $('#edit-email-field').val(user.email)
        $('#editModal').modal('show')
        // $('#edit-password-field').val(user.)

    }
    $('#editModal').submit(function(event) {
        event.preventDefault();
        console.log(123)
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
                console.log('Error:', data);
                $('#saveBtn').html('Save');
            }
        });
    });
   </script>
@endsection
</x-app-layout>

