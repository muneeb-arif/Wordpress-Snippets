<?php 
include_once 'SubmitQuestion.php';

add_action('wp_ajax_submit_question', 'submit_question');
add_action('wp_ajax_nopriv_submit_question', 'submit_question');
function submit_question() {
    $s = new SubmitQuestion($_POST);
    $s->validate_fields();
    $s->insert_form_data();
}

?>