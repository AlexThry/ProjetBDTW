<?php
require_once 'functions.php';

if(isset($_POST["button"]) && !empty($_POST["button"])){
    $name_category = $_POST["button"];
    $categories = Database::get_categories();
    
    if(in_array($name_category, $categories)){
        $msg_error = "Cette catégorie existe déjà !";
        header("Location: account.php?tab=interface_admin&error=".htmlentities($msg_error));
    }
    else{
        $insertCategory = Database::create_category($name_category);
        header("Location: account.php?tab=interface_admin");
    }

}
else{

    $msg_error = "Veuillez remplir ce champ !";
    header("Location: account.php?tab=interface_admin&error=$msg_error");

}

?>