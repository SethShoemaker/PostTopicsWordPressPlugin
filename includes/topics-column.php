<?php

add_filter("manage_post_posts_columns", 'sethshoemaker_post_topics_add_topics_column');

function sethshoemaker_post_topics_add_topics_column($columns){
    return array_merge($columns, ['topics' => __('Topics', 'textdomain')]);
}

add_action('manage_post_posts_custom_column', "sethshoemaker_post_topics_propagate_topics_column", 10, 2);

function sethshoemaker_post_topics_propagate_topics_column($column_key, $post_id){
    if ($column_key != "topics"){
        return;
    }

    // TODO: Implement this
    echo "test test";
}