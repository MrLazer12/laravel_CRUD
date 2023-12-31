<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRUD</title>

    <!-- Fonts -->
    <link href="{{ asset('lib/bootsrap/css/bootsrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" />
    <script src="{{ asset('lib/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('lib/bootsrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lib/popper.min.js') }}"></script>
    <style>
        code {
            color: red !important;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-flex justify-content-between">
        <a class="navbar-brand" href="#">CRUD</a>
        <!-- <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Manage Users</a>
                </li>
            </ul>
        </div> -->

        <a class="navbar-brand" href="#">Username: {{ session('username') }}
            <code>role: {{ session('role') }} </code></a>
    </nav>

    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2><b>Users</b></h2>
                        </div>
                        @if(session()->has('role') && session('role') === 'admin')
                        <div class="col-sm-6">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                                <span>Add New Employee</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            @if(session()->has('role') && session('role') === 'admin')
                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->phone }}</td>
                            @if(session()->has('role') && session('role') === 'admin')
                            <td>
                                <a id="linkToEditModal" href="#editEmployeeModal" class="edit"
                                    onclick="getUserData('{{ $user->id }}')" data-toggle="modal">Edit</a>
                                <a onclick="linkToDeleteModal({{ $user->id }})" href="#deleteEmployeeModal"
                                    class="delete" data-toggle="modal">Delete</a>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">0 results</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- ADD Employee Modal HTML -->
    <div id="addEmployeeModal" class="modal fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Add Employee</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control" required=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success" value="Add">
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    @if(isset($user))
    <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editUserId" name="editUserId" value="">

                    <div class="modal-header">
                        <h4 class="modal-title">Edit Employee</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button onclick="Add_updatedUserData()" type="submit" class="btn btn-info">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    @if(isset($user))
    <!-- Delete Modal HTML -->
    <div id="deleteEmployeeModal" class="modal fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="deleteUserId" name="deleteUserId" value="">

                    <div class="modal-header">
                        <h4 class="modal-title">Delete Employee</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete these Records?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button onclick="deleteUserData()" type="button" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    @if(session('token'))
    <script>
        localStorage.setItem('token', '{{ session('token') }}');
        window.location.href = '/crud';
    </script>
    @endif
    <script>
        function decodeJWT(token) {
            const base64Url = token.split('.')[1];
            const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            const jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));

            return JSON.parse(jsonPayload);
        }

        const storedToken = localStorage.getItem('token');

        if (storedToken) {
            const decodedToken = decodeJWT(storedToken);
            console.log(decodedToken);
        }

        function getUserData(userId) {
            $.ajax({
                url: '/users/' + userId + '/edit',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    const user = response.user;
                    console.log(response);
                    $('#editUserId').val(user.id);
                    $('#name').val(user.name);
                    $('#email').val(user.email);
                    $('#address').val(user.address);
                    $('#phone').val(user.phone);
                },
                error: function (error) {
                    console.log('Error fetching user data:', error);
                }
            });
        }
        function Add_updatedUserData() {
            // Get the values from the form
            var userId = $("#editUserId").val();
            var name = $("#name").val();
            var email = $("#email").val();
            var address = $("#address").val();
            var phone = $("#phone").val();

            // Create an object with the updated user data
            var updatedUserData = {
                name: name,
                email: email,
                address: address,
                phone: phone
            };

            // Make an Ajax request to update the user data
            $.ajax({
                url: '/users/' + userId,
                method: 'PUT',
                data: updatedUserData,
                dataType: 'json',
                success: function (response) {
                    console.log('User data updated successfully:', response);
                    // window.location.reload();
                },
                error: function (error) {
                    console.log('Error updating user data:', error);
                }
            });
        }
        function linkToDeleteModal(id) {
            $("#deleteUserId").val(id);
        }
        function deleteUserData() {
            var userId = $("#deleteUserId").val();
            // console.log(userId);
            $.ajax({
                url: '/users/' + userId + '/delete',
                method: 'DELETE',
                dataType: 'json',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                },
                success: function (response) {
                    console.log(response.message);
                },
                error: function (error) {
                    console.log('Error deleting user data:', error);
                }
            });
        }

    </script>
</body>

</html>
