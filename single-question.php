<?php

require_once 'includes/header.php';
$user = get_user();
$question = Database::get_question_by_id( $_GET['id'] );
$answers = Database::get_answer_by_question_id( $_GET['id'] );

?>


