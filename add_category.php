<?php
require_once 'functions.php';

// TODO : Display error messages

$name_category  = isset( $_POST['name'] ) && !empty( $_POST['name'] ) ? $_POST['name'] : null;
$is_admin       = get_user() ? get_user()['is_admin'] : false;

// Check if user is connected an admin
if( !$is_admin ) {
    header("Location: admin.php");
    exit();
}

// Checks the form inputs
if( $name_category === null ) {
    header("Location: account.php?tab=interface_admin");
    exit();
}

$categories = Database::get_categories();

if( in_array($name_category, $categories) ){
    $msg_error = "Cette catégorie existe déjà !";
} else {
    $insertCategory = Database::create_category($name_category);
}

header("Location: account.php?tab=interface_admin");
exit();
?>