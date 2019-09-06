<?php 

class Session extends Database {

    public $password;
    public static $msg;

    public function password_verify($input_pass,$db_pass) {
        return password_verify($input_pass,$db_pass);
    }
    
    public function login_user($username,$password) {
       global $database;

        $stmt = $database->connect->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s",$username);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
            $num_rows = $result->num_rows;

            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_type'] = $row['user_type'];
            $this->password =  $row['password'];

            if($num_rows == 1) {
                 return password_verify($password, $this->password);
            } else {
                return false;
            }
        }
        
    }



    public function logout() {
        session_destroy();
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        header("Location: login.php");
    }
}





?>