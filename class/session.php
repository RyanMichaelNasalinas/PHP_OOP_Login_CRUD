<?php 

class Session extends Database {
    
    public function login_user($username, $password) {
        $database = new Database;

        $stmt = $database->connect->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss",$username,$password);
        if($stmt->execute()) {
            $result = $stmt->get_result();
            $num_rows = $result->num_rows;

            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_type'] = $row['user_type'];
        }
        if($num_rows > 0) {
           
            return true;
        } else {
            return false;
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