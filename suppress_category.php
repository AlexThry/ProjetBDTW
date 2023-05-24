<?php
require_once 'functions.php';

if (isset($_POST["suppress_choice"])){
    
    $category_selected= $_POST["suppress_choice"];
    echo $category_selected;
    $delete_category = Database::delete_category($category_selected);
   
    header("Location: account.php?tab=interface_admin");
}
else{
    $msg_error = "Erreur lors de la suppression ! Veuillez sélectionner une catégorie";
    header("Location: account.php?tab=interface_admin&error=".htmlentities($msg_error));
}
?>