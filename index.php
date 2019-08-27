<?php
    include "includes/header.php"; 

    if (empty($_SESSION['user_id'])) {
        header("Location: login.php");
    }
?>
<body class="bg-dark">
    <div class="container mt-5">
        <div class="text-white">
            <div class="table-responsive">
                <div class="d-block">
                    <h1 class="text-light"><?php echo $_SESSION['username']; ?></h1>
                    <a href="logout.php">Logout</a>
                </div>

                <table class="table text-white table-bordered text-center">
                    <?php
                        $result = $database->display_user(); 

                        if ($_SESSION['user_type'] == 'admin') {
                            $result = $database->display_user(); 
                        } elseif($_SESSION['user_type'] == 'user') {
                            $result = $database->display_user_by_id($_SESSION['user_id']);
                        }
                    ?>
                    <thead>
                        <th>Name</th>
                        <th>Lastname</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $res) : ?>
                        <tr>
                            <td><?php echo $res['name']; ?></td>
                            <td><?php echo $res['lastname']; ?></td>
                            <td><?php echo $res['username']; ?></td>
                            <td><?php echo $res['password']; ?></td>
                            <td><?php echo $res['email']; ?></td>
                            <td>

                                <a class="btn btn-primary" href="index.php?update&id=<?php echo $res['id']; ?>" name="edit">Edit</a>
                                &nbsp;
                                <?php if ($_SESSION['user_type'] == "admin") : ?>
                                    <a class="btn btn-danger" href="index.php?delete&id=<?php echo $res['id']; ?>" name="delete_user" onclick="return confirm('Are you sure want to delete this data?');">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container mt-5 text-white">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-sm-12 col-md-12">
                <form action="" method="post">
                    <?php
                    //Delete user 
                    if (isset($_GET['delete'])) {
                        $database->id = $database->escape_string($_GET['id']);

                        $delete = $database->delete_user();
                        header("Location: index.php");
                    }
                    //End Delete user

                    //Register user
                    if (isset($_POST['register'])) {

                        $database->name = Crud::capitalize($database->escape_string($_POST['name']));
                        $database->lastname = Crud::capitalize($database->escape_string($_POST['lastname']));
                        $database->username = $database->escape_string($_POST['username']);
                        $database->password = $database->escape_string($_POST['password']);
                        $database->email = $database->escape_string($_POST['email']);



                        $msg =  $validation->check_empty($_POST, ['name', 'lastname', 'username', 'confirm_password', 'password', 'email']);
                        if ($msg != null) {
                            echo "<div class='alert alert-danger text-center'>" . $msg . "</div>";
                        } else {
                            $insert = $database->insert_user();
                            header("Location: index.php");
                        }
                    }
                    //End user registration

                    //Update user profile
                    if (isset($_POST['update'])) {

                        $database->id = $_GET['id'];
                        $database->name = $_POST['name'];
                        $database->lastname = $_POST['lastname'];
                        $database->username = $_POST['username'];
                        $database->password = $_POST['password'];
                        $database->email = $_POST['email'];


                        if ($msg =  $validation->check_empty($_POST, ['name', 'lastname', 'username', 'password', 'confirm_password', 'email'])) {
                            echo "<div class='alert alert-danger'>" . $msg . "</div>";
                        } else {
                            $update = $database->update_user();

                            header("Location: index.php");
                        }


                        //End user update   
                    }

                    ?>
                    <?php
                    if (isset($_GET['update'])):
                        $database->escape_string($id = $_GET['id']);

                        $result = $database->query("SELECT * FROM users WHERE id = $id");
                        while ($row = $result->fetch_assoc()) :
                            ?>
                             
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $row['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" value="<?= $row['lastname']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?= $row['username']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password </label>
                        <input type="password" name="password" id="password" class="form-control" value="<?= $row['password']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= $row['email']; ?>">
                    </div>
                    <div>
                        <button class="btn btn-success" name="update" id="regiser">Update</button>
                        &nbsp;
                        <button class="btn btn-danger" name="cancel" id="cancel" type="button" onClick="window.location.href='index.php'">Cancel</button>
                    </div>
                        
                    <?php endwhile; ?>
                    <?php else : ?>
                         <?php if($_SESSION['user_type'] == "admin"): ?>   
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= (isset($_POST['name'])) ?  Crud::echo_char($_POST['name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" value="<?= (isset($_POST['lastname'])) ? Crud::echo_char($_POST['lastname']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?= (isset($_POST['username'])) ? Crud::echo_char($_POST['username']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password </label>
                        <input type="password" name="password" id="password" class="form-control" value="<?= (isset($_POST['password'])) ? Crud::echo_char($_POST['password']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" value="<?= (isset($_POST['confirm_password'])) ? Crud::echo_char($_POST['confirm_password']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= (isset($_POST['email'])) ? Crud::echo_char($_POST['email']) : ''; ?>">
                    </div>
                    <div>
                        <button class="btn btn-success" name="register" id="regiser">Register</button>
                        &nbsp;
                        <button class="btn btn-danger" name="cancel" id="cancel" type="button" onClick="window.location.href='index.php'">Cancel</button>
                    </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    <?php include "includes/footer.php"; ?>