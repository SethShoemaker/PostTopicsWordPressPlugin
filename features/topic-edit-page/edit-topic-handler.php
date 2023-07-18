<?php

add_action("wp_ajax_sethshoemaker_post_topics_edit_topic", "sethshoemaker_post_topics_edit_topic_ajax_handler");

function sethshoemaker_post_topics_edit_topic_ajax_handler(){
    global $wpdb;


    header('Content-Type: application/json');
    $response = array(
        "was-successful" => true,
        "edit-topic-name" => array(
            'has-valid-length' => true,
            'is-taken' => false
        ),
        "edit-topic-slug" => array(
            'has-valid-length' => true,
            'is-taken' => false
        ),
    );


    $edit_topic_id = $_REQUEST["edit-topic-id"];
    $edit_topic_name = $_REQUEST["edit-topic-name"];
    $edit_topic_slug = $_REQUEST["edit-topic-slug"];


    $edit_topic_id = sanitize_text_field($edit_topic_id);
    $edit_topic_name = sanitize_text_field($edit_topic_name);
    if (strlen($edit_topic_slug) == 0)
        $edit_topic_slug = sanitize_title_with_dashes($edit_topic_name);
    else
        $edit_topic_slug = sanitize_text_field($edit_topic_slug);


    $edit_topic_name_length = strlen($edit_topic_name);
    if ($edit_topic_name_length < SETHSHOEMAKER_POST_TOPIC_MIN_NAME_LENGTH || $edit_topic_name_length > SETHSHOEMAKER_POST_TOPIC_MAX_NAME_LENGTH){
        $response["edit-topic-name"]["has-valid-length"] = false;
        $response["was-successful"] = false;
    }

    $edit_topic_slug_length = strlen($edit_topic_slug);
    if ($edit_topic_slug_length < SETHSHOEMAKER_POST_TOPIC_MIN_SLUG_LENGTH || $edit_topic_slug_length > SETHSHOEMAKER_POST_TOPIC_MAX_SLUG_LENGTH){
        $response["edit-topic-slug"]["has-valid-length"] = false;
        $response["was-successful"] = false;
    }


    // Check to see if name or slug already exists
    $edit_topic_id_escaped = esc_sql($edit_topic_id);
    $edit_topic_name_escaped = esc_sql($edit_topic_name);
    $edit_topic_slug_escaped = esc_sql($edit_topic_slug);

    $query = "SELECT * FROM " . SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME . "
        WHERE (name= '{$edit_topic_name_escaped}'
        OR slug= '{$edit_topic_slug_escaped}')
        AND id<>{$edit_topic_id_escaped}";

    // TODO: Use prepared statements
    $results = $wpdb->get_results($query, ARRAY_A);

    foreach ($results as $result) {
        if ($result["name"] == $edit_topic_name){
            $response["edit-topic-name"]["is-taken"] = true;
            $response["was-successful"] = false;
        }

        if ($result["slug"] == $edit_topic_slug){
            $response["edit-topic-slug"]["is-taken"] = true;
            $response["was-successful"] = false;
        }
    }


    $was_successful = $response["was-successful"];
    $response = json_encode($response);

    if ($was_successful){
        // TODO: use prepared statements
        $wpdb->update(
            SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME, 
            array('name' => $edit_topic_name, 'slug' => $edit_topic_slug),
            array('id' => $edit_topic_id)
        );
    }

    wp_die($response);
}