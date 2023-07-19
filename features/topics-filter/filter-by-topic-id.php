<?php 

function sethshoemaker_post_topics_filter_by_topic_id($query){
    $is_main_query_of_admin_page = is_admin() && $query->is_main_query();
    if($is_main_query_of_admin_page == false)
        return $query;

    $post_type_is_post = $query->query['post_type'] === "post";
    if($post_type_is_post == false)
        return $query;

    $topic_id_is_set = isset($_REQUEST[SETHSHOEMAKER_POST_TOPICS_TOPICS_FILTER_INPUT_NAME]);
    if ($topic_id_is_set == false)
        return $query;

    $topic_id_is_default_value = $_REQUEST[SETHSHOEMAKER_POST_TOPICS_TOPICS_FILTER_INPUT_NAME] == SETHSHOEMAKER_POST_TOPICS_TOPICS_FILTER_INPUT_DEFAULT_VALUE;
    if($topic_id_is_default_value)
        return $query;

    $query->set('meta_query', array(
        array(
            'key'       => SETHSHOEMAKER_POST_TOPICS_META_KEY,
            'value'     => $_REQUEST[SETHSHOEMAKER_POST_TOPICS_TOPICS_FILTER_INPUT_NAME], // This cannot be empty because of a bug in WordPress
            'compare'   => 'LIKE'
        )
    ));

    return $query;
}