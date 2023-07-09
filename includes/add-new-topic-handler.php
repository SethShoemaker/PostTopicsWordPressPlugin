<?php 

add_action("wp_ajax_sethshoemaker_post_topics_add_new_topic", "sethshoemaker_post_topics_add_new_topic_handler");

function sethshoemaker_post_topics_add_new_topic_handler(){
    global $wpdb;
    global $sethshoemaker_post_topics_db_table_name;


    $new_topic_name = $_REQUEST["new-topic-name"];
    $new_topic_slug = $_REQUEST["new-topic-slug"];


    $new_topic_name = sanitize_text_field($new_topic_name);
    if (strlen($new_topic_slug) == 0)
        $new_topic_slug = sanitize_title_with_dashes($new_topic_name);
    else
        $new_topic_slug = sanitize_text_field($new_topic_slug);


    $new_topic_name_escaped = esc_sql($new_topic_name);
    $new_topic_slug_escaped = esc_sql($new_topic_slug);

    $query = "SELECT * FROM $sethshoemaker_post_topics_db_table_name 
        WHERE name= '{$new_topic_name_escaped}'
        OR slug= '{$new_topic_slug_escaped}' ";
    
    $results = $wpdb->get_results($query, ARRAY_A);

    $response = array(
        "wasSuccessful" => true,
        "new-topic-name" => array(
            'isValid' => true,
            'isTaken' => false
        ),
        "new-topic-slug" => array(
            'isValid' => true,
            'isTaken' => false
        ),
    );

    foreach ($results as $result) {
        if ($result["name"] == $new_topic_name){
            $response["new-topic-name"]["isTaken"] = true;
            $response["wasSuccessful"] = false;
        }

        if ($result["slug"] == $new_topic_slug){
            $response["new-topic-slug"]["isTaken"] = true;
            $response["wasSuccessful"] = false;
        }
    }

    wp_die(json_encode($response));
}