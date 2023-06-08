<?php
/**
 * Validate and unvalidates a question.
 */

require_once 'functions.php';

$is_admin     = get_user() !== null ? get_user()->is_admin() : false;

// Check if user is connected as admin
if( !$is_admin ) {
    header("Location: admin.php");
    exit();
}

$question_id  = $_GET['question-id'] ?? null;
$question = Question::get($question_id);

// End if question_id is not given
if($question_id === null || $question=== null) {
    // Redirect to previous page
    header("Location: index.php");
    exit();
}


// Different actions if question is already validated
if($question->is_validated()) {
    // Unvalidating
    $sql = "UPDATE question SET id_validator = NULL WHERE id = $question_id;";
    // Removing all likes
    $sql .= "DELETE FROM likes WHERE id_question=$question_id;";
} else {
    // Validating
    $admin_id = get_user()->get_id();
    $sql = "UPDATE question SET id_validator = $admin_id WHERE id = $question_id;";
}
$conn->multi_query($sql);

header("Location: index.php");
exit();
