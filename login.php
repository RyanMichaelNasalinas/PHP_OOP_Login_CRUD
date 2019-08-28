<?php 
    include "includes/header.php"; 

        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $login = new Session;

            $login_user = $login->login_user($username, $password);

            if ($login_user) {
                header("Location: index.php");
            } elseif (empty($username) && empty($password)) {
                Session::$msg = "This fields should not be empty";
            } elseif ($login_user == false) {
                Session::$msg = "Username or Password is incorrect";
            } else {
                header("Location: login.php");
                Session::$msg = "Incorrect Username or password";
            }

        }   
?>
<body class="bg-dark">
    <div class="container">
        <div class="row mx-auto my-5">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1 class="text-danger"><?= Session::$msg; ?></h1>
                        </div>
                        <h4 class="card-title text-center">Enter Credentials</h4>
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username">

                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" name="login" value="Login" class="btn btn-dark">
                                <input type="submit" value="cancel" class="btn btn-danger">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include "includes/footer.php"; ?>