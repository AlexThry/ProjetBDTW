<?php

require_once '../includes/header.php';

var_dump(Database::get_user(1));
var_dump(Database::get_user(456));

var_dump(Database::get_users());

var_dump(Database::get_question(1));
var_dump(Database::get_question(456));

var_dump(Database::get_questions());

var_dump(Database::get_user_answers(1));
var_dump(Database::get_user_answers(456));

var_dump(Database::get_categories());

var_dump(Database::get_question_answer(1));
var_dump(Database::get_question_answer(456));