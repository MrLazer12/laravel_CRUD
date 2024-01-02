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

        .display-form {
            position: fixed;
            top: 0;
            left: 35%;
            padding: 1vw;

            background: white;
            width: 30vw;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-flex justify-content-between">
        <a class="navbar-brand" href="#">CRUD</a>
        <a class="navbar-brand" href="#">
            Username: {{ session('username') }} <code>role: {{ session('role') }} </code>
        </a>
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
                                <a class="edit" data-toggle="modal" onclick="showEditForm('{{ $user->id }}')">
                                    Edit
                                </a>
                                <form id="editForm{{ $user->id }}" class="display-form" style="display: none;"
                                    method="post" action="{{ route('users.update', ['id' => $user->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" required
                                            value="{{ $user->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" required
                                            value="{{ $user->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" class="form-control"
                                            required="">{{ $user->address }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" class="form-control" required
                                            value="{{ $user->phone }}">
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-default" onclick="hideEditForm('{{ $user->id }}')">Cancel</button>
                                        <button type="submit" class="btn btn-info">Save</button>
                                    </div>
                                </form>
                                <a class="delete">
                                    <form method="post" action="{{ route('users.delete', ['id' => $user->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </a>
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

    @if(session('token'))
    <script>
        localStorage.setItem('token', '{{ session('token') }}');
        window.location.href = '/crud';
    </script>
    @endif
    <script>
        function showEditForm(userId) {
            $('#editForm' + userId).show();
        }

        function hideEditForm(userId) {
            $('#editForm' + userId).hide();
        }
    </script>
</body>

</html>