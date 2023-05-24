<?php
require_once 'functions.php';

if(isset($_POST["name"]) && !empty($_POST["name"])){
    $name_category = $_POST["name"];
    $categories = Database::get_categories();
    
    if(in_array($name_category, $categories)){
        $msg_error = "Cette catégorie existe déjà !";
    }
    else{
        $insertCategory = Database::create_category($name_category);
        header("Location: account.php?tab=interface_admin");
    }

}

?>