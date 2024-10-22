<x-app-layout>
    
    <dib class="card">

    <div class="card-header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User List') }}
        </h2>
        <div class = "d-flex">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <a href="" class="btn btn-sm btn-primary">Edit</a>
                                <a href="" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
<!-- Create Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User Create</h5>
       
      </div>
      <form action="" id="user_create_form" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="name-field">Name</span>
                    <input type="text" class="form-control" id = "name-field" name ="name" aria-label="Enter your name" aria-describedby="inputGroup-sizing-default" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="email-field">@</span>
                    <input type="text" class="form-control" id = "email-field" name ="email" aria-label="Enter your email" aria-describedby="inputGroup-sizing-default" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="password-field">password</span>
                    <input type="text" class="form-control"  id = "password-field" name ="password" aria-label="Enter your email" aria-describedby="inputGroup-sizing-default" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="picture-field">Image</span>
                    <input type="file" src=""  class="form-control"  id = "picture-field" name ="picture" alt="">
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@section('js')
   <script>
    $('#user_create_form').submit(function() {
        event.preventDefault();

        var name = $('#name-field').val()
        var email = $('#email-field').val()
        var password = $('#password-field').val()
        if(name == '' || email == '' || password == ''){
            alert("fillup all input field")
        }else{
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
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
                        console.log(result)
                        
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save');
                    }
                });

        }
        alert(123);
    })
   </script>
@endsection
</x-app-layout>

