<?php 

/*
    Get all post topics from database
*/
function sethshoemaker_post_topics_get_all(): array{
    global $wpdb;

    $query = "SELECT * FROM " . SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME . " ;";
    $results = $wpdb->get_results($query, ARRAY_A);

    return $results;
}