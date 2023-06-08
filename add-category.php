<?php
require_once 'functions.php';

$label    = !empty( $_POST['name'] ) ? strtoupper($_POST['name']) : null;
$is_admin = get_user() !== null ? get_user()->is_admin() : false;

// Check if user is connected as admin
if( !$is_admin ) {
    header("Location: admin.php");
    exit();
}

// Checks the form inputs
if( $label === null ) {
    $msg_error = "Veuillez remplir le nom de la categorie";
    header("Location: index.php&error=".$msg_error);
    exit();
}

$categories = Category::all();

// Check if category already exists
if( in_array($label, $categories) ){
    $msg_error = "Cette catégorie existe déjà !";
    header("Location: index.php&error=".htmlentities($msg_error));
    exit();
}
Category::add($label);

header("Location: index.php");
exit();
