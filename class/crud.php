<?php 

class Crud {

    public $id;
    public $name;
    public $lastname;
    public $username;
    public $password;
    public $email;
   

    public function display_user() {

        $sql = "SELECT * FROM users";
        $result = $this->connect->query($sql);

        if($result == false) {
            return false;
        }

        $rows = [];

        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }
        return $rows;
    }

    public function insert_user() {

        $stmt = $this->connect->prepare("INSERT into users (`name`,`lastname`,`username`,`password`,`email`) VALUES (?,?,?,?,?);");
        $stmt->bind_param("sssss", $this->name, $this->lastname, $this->username, $this->password, $this->email);
        $stmt->execute();

        if($stmt) {
            return true;
            $stmt->close();      
        } else {
            return false;
        }
        return $stmt;
    }

    public function update_user() {

        $stmt = $this->connect->prepare("UPDATE users SET name= ? , lastname = ?, username = ?, password = ?, email= ? WHERE id = ?");
        $stmt->bind_param("sssssi",$this->name,$this->lastname,$this->username,password_hash($this->password,PASSWORD_DEFAULT),$this->email, $this->id);
        $stmt->execute();

        if($stmt) {
            return true;
            $stmt->close();
        } else {
            return false;
        }
        return $stmt;
    }
    

    public function delete_user() {
        
        $stmt = $this->connect->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i",$this->id);
        $stmt->execute();

        if($stmt) {
            return true;
            $stmt->close();
        } else {
            return false;
        }
        return $stmt;
    }
    

    //Capitalize first letter of users
    public static function capitalize($field) {
        return ucfirst($field);
    }
    
    //Reecho the validation text
    public static function echo_char($field) {
        return htmlentities($field);
    }
}

?>