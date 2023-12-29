
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/login-page.css') }}" rel="stylesheet" />
</head>
<body>
    <div class="sidenav">
        <div class="login-main-text">
           <h1>Crud Application<br> Login Page</h1>
           <p>Login from here to access.</p>
        </div>
     </div>
     <div class="main">
        <div class="col-md-6 col-sm-12">
           <div class="login-form">
              <form>
                 <div class="form-group">
                    <label>User Name</label>
                    <input type="text" class="form-control" placeholder="User Name">
                 </div>
                 <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Password">
                 </div>
                 <button type="submit" class="btn btn-black">Login</button>
              </form>
           </div>
        </div>
     </div>
</body>
</html>