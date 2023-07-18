<?php 

add_action("wp_ajax_sethshoemaker_post_topics_add_new_topic", "sethshoemaker_post_topics_add_new_topic_ajax_handler");

function sethshoemaker_post_topics_add_new_topic_ajax_handler(){
    global $wpdb;


    header('Content-Type: application/json');
    $response = array(
        "was-successful" => true,
        "new-topic-name" => array(
            'has-valid-length' => true,
            'is-taken' => false
        ),
        "new-topic-slug" => array(
            'has-valid-length' => true,
            'is-taken' => false
        ),
    );


    $new_topic_name = $_REQUEST["new-topic-name"];
    $new_topic_slug = $_REQUEST["new-topic-slug"];

    $new_topic_name = sanitize_text_field($new_topic_name);
    if (strlen($new_topic_slug) == 0)
        $new_topic_slug = sanitize_title_with_dashes($new_topic_name);
    else
        $new_topic_slug = sanitize_text_field($new_topic_slug);


    $new_topic_name_length = strlen($new_topic_name);
    if ($new_topic_name_length < SETHSHOEMAKER_POST_TOPIC_MIN_NAME_LENGTH || $new_topic_name_length > SETHSHOEMAKER_POST_TOPIC_MAX_NAME_LENGTH){
        $response["new-topic-name"]["has-valid-length"] = false;
        $response["was-successful"] = false;
    }

    $new_topic_slug_length = strlen($new_topic_slug);
    if ($new_topic_slug_length < SETHSHOEMAKER_POST_TOPIC_MIN_SLUG_LENGTH || $new_topic_slug_length > SETHSHOEMAKER_POST_TOPIC_MAX_SLUG_LENGTH){
        $response["new-topic-slug"]["has-valid-length"] = false;
        $response["was-successful"] = false;
    }


    // Check to see if name or slug already exists
    $new_topic_name_escaped = esc_sql($new_topic_name);
    $new_topic_slug_escaped = esc_sql($new_topic_slug);

    $query = "SELECT * FROM " . SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME . "
        WHERE name= '{$new_topic_name_escaped}'
        OR slug= '{$new_topic_slug_escaped}' ";

    // TODO: Use prepared statements
    $results = $wpdb->get_results($query, ARRAY_A);

    foreach ($results as $result) {
        if ($result["name"] == $new_topic_name){
            $response["new-topic-name"]["is-taken"] = true;
            $response["was-successful"] = false;
        }

        if ($result["slug"] == $new_topic_slug){
            $response["new-topic-slug"]["is-taken"] = true;
            $response["was-successful"] = false;
        }
    }


    $was_successful = $response["was-successful"];
    $response = json_encode($response);

    if ($was_successful){
        // TODO: use prepared statements
        $wpdb->insert(
            SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME, 
            array('name' => $new_topic_name, 'slug' => $new_topic_slug));
    }

    wp_die($response);
}