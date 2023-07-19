<?php

add_filter("manage_post_posts_columns", 'sethshoemaker_post_topics_manage_topics_column');

function sethshoemaker_post_topics_manage_topics_column($columns){
    unset($columns["tags"]);
    unset($columns["categories"]);
    unset($columns["comments"]);
    $columns["topics"] = "Topics";
    return $columns;
}

add_action('manage_post_posts_custom_column', "sethshoemaker_post_topics_propagate_topics_column", 10, 2);

function sethshoemaker_post_topics_propagate_topics_column($column_key, $post_id){
    if ($column_key != "topics")
        return;

    // Get the names of the topics this post is associated with
    $topic_ids = get_post_meta($post_id, SETHSHOEMAKER_POST_TOPICS_META_KEY, true);

    $topic_ids_is_not_set = strlen($topic_ids) == 0;
    if($topic_ids_is_not_set)
        return;

    global $wpdb;

    $topic_names = "";

    $topic_ids = json_decode($topic_ids);

    foreach($topic_ids as $topic_id){
        $topic_id_escaped = esc_sql($topic_id);
        $query = "SELECT name FROM " . SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME . " WHERE id={$topic_id_escaped}";
        $topic = $wpdb->get_row($query, ARRAY_A);

        $topic_does_not_exist = $topic == null;
        if ($topic_does_not_exist)
            continue;

        $topic_names .= $topic["name"] . ", ";
    }

    // Remove the trailing ', " left from the foreach loop
    $topic_names = rtrim($topic_names, ", ");

    echo $topic_names;
}