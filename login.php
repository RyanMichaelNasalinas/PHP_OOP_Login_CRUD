<?php 
    include "includes/header.php"; 

    $msg = "";

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $login = new Session;

        if ($login_user = $login->login_user($username, $password)) {
            header("Location: index.php");
        } elseif (empty($username) && empty($password)) {
            $msg = "This fields should not be empty";
        } elseif ($_POST['username'] != $username && $_POST['password'] != $password) {
            $msg = "Username or Password is incorrect";
        } else {
            header("Location: login.php");
            return false;
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
                            <h1 class="text-danger"><?= $msg; ?></h1>
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