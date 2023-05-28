<?php
require_once 'functions.php';
//to check if a category was checked
$is_category_checked = false;
foreach ($_POST as $key => $value) {
    if (strpos($key, 'checkbox-item-') === 0) {
        $is_category_checked = true;
    }
}

if(isset($_POST["name"]) && $_POST["markdown-editor"] && $is_category_checked){
   

    $title = htmlentities($_POST["name"]);
    $content = htmlentities($_POST["html-input"]);
    $categories_checked = array();
    $current_id_user = get_user()["id"];
    
    // recup all categories check
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'checkbox-item-') === 0) {
            array_push($categories_checked, $value);
        }
    }

    Database::add_question($title, $content, $current_id_user, $categories_checked);
    header("Location: single-question.php?new_question");
    
}
else{
    $error = "Veuillez remplir tous les champs";
    header("Location: single-question.php?new_question&error=".htmlentities($error));
}
?>