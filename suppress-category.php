<?php
require_once 'functions.php';

$id_category  = isset( $_POST['id'] ) && !empty( $_POST['id'] ) ? $_POST['id'] : null;
$is_admin     = get_user() ? get_user()['is_admin'] : false;

// Check if user is connected as admin
if( !$is_admin ) {
    header("Location: admin.php");
    exit();
}

// Checks the form inputs
if( $id_category === null ) {
    $msg_error = "Veuillez selectionner une categorie a supprime";
    header("Location: index.php?error=".htmlentities($msg_error));
    exit();
}

Database::delete_category($id_category);
header("Location: index.php");
