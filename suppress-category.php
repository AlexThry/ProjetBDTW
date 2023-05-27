<?php
require_once 'functions.php';

$category_selected  = isset( $_POST['suppress_choice'] ) && !empty( $_POST['suppress_choice'] ) ? $_POST['suppress_choice'] : null;
$is_admin           = get_user() ? get_user()['is_admin'] : false;

// Check if user is connected as admin
if( !$is_admin ) {
    header("Location: admin.php");
    exit();
}

// Checks the form inputs
if( $category_selected === null ) {
    $msg_error = "Veuillez selectionner une categorie a supprime";
    header("Location: index.php?error=".htmlentities($msg_error));
    exit();
}

$delete_category = Database::delete_category($category_selected);
header("Location: index.php");
