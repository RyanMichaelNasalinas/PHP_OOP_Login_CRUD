<?php 

spl_autoload_register(function($className){
    include_once './class/'. lcfirst($className) .'.php';
});


$session = new Session;
$crud = new Crud;
$database = new Database;
$validation = new Validation;




?>