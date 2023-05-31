<?php
$nearby_questions = Database::get_nearby_questions( $question_id );
?>

<?php if(!empty($nearby_questions)) :
    $url = "single-question.php?id=".$question['id'];
    ?>
    <aside class="p-5 w-40">
        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Voir aussi</h6>
        <?php foreach($nearby_questions as $question) : ?>
            <a href="<?= $url ?>" class="inline-flex items-center ml-2 text-sm font-medium text-blue-600 md:ml-2 dark:text-blue-500 hover:underline">
                <?= $question['title'] ?>
            </a>
        <?php endforeach ?>
    </aside>
<?php endif ?>