<?php
/**
 * Validate and unvalidates a question.
 */

require_once 'functions.php';

$question_id  = isset( $_GET['question-id'] ) ? $_GET['question-id'] : null;
$is_admin     = get_user() ? get_user()['is_admin'] : false;

// Check if user is connected as admin
if( !$is_admin ) {
    header("Location: admin.php");
    exit();
}

// End if question_id is not given
if($question_id === null) {
    // Redirect to previous page
    header("Location: account.php?tab=interface_admin");
    exit();
}

// Different actions if question is already validated
$is_validated = Database::question_is_validated( $question_id );

if($is_validated) {
    // Unvalidating
    $sql = "UPDATE question SET id_validator = NULL WHERE id = $question_id;";
} else {
    // Validating
    $admin_id = get_user()['id'];
    $sql = "UPDATE question SET id_validator = $admin_id WHERE id = $question_id;";
}

$conn->query($sql);

header("Location: account.php?tab=interface_admin");
exit();
