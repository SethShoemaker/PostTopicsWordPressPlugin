<?php

add_action("wp_ajax_sethshoemaker_post_topics_delete_topic", "sethshoemaker_post_topics_delete_topic_ajax_handler");

function sethshoemaker_post_topics_delete_topic_ajax_handler(){
    global $wpdb;


    header('Content-Type: application/json');
    $response = array(
        "was-successful" => true,
    );


    $topic_id = intval($_REQUEST['topic-id']);
    
    $topic_id_was_not_set = $topic_id == 0;
    if ($topic_id_was_not_set)
        $response["was-successful"] = false;


    // Check to make sure topic exists
    $topic_id_escaped = esc_sql($topic_id);

    $query = "SELECT id FROM " . SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME . " WHERE id={$topic_id_escaped}";
    $result = $wpdb->get_row($query, ARRAY_A);

    $topic_id_does_not_exist = $result == null;
    if ($topic_id_does_not_exist)
        $response["was-successful"] = false;


    $was_successful = $response["was-successful"];
    $response = json_encode($response);


    if($was_successful)
        $wpdb->delete(SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME, array('id' => $topic_id));

    wp_die($response);
}