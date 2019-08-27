<?php 

class Validation {
 
    public function check_empty($data, $fields) {
        $msg = null;
        foreach($fields as $value) {
            if(empty($data[$value])) {
             $msg .= "<b>".ucfirst($value)."</b> field cannot be emptied <br/>";
            }
        }
        return $msg;
    }

}

$validation = new Validation;

?>