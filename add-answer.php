<?php
require_once 'functions.php';

$user      = get_user();
$is_admin  = $user ? $user->is_admin() : false;

// Check if user is connected as admin
if( !$is_admin ) {
    header("Location: admin.php"); exit;
}

$content     = isset($_POST['html-input']) ? htmlentities($_POST['html-input']) : null;
$id_question = isset($_POST['id-question']) ? htmlentities($_POST['id-question']) : null;

// Check inputs
if($content === null || $id_question === null) {
    // TODO : [UX | hard] : re-open the question (in the accordion) that the admin was trying to answer
    // With something like "Location: index.php?opened-question=$id_question"
    header("Location: index.php"); exit;
}

$question = Question::get($id_question);
if($question === null) {
    header("Location: index.php"); exit;
}

// Check if question is already answer
if($question->is_answered()) {
    header("Location: index.php"); exit;
}

// All checks done, creating the answer$id_question, $id_admin, $content
Answer::add($id_question, $user->get_id(), $content);
header("Location: index.php"); exit;
