<?php

/**
 * Gets a two-dimensional associative array of all the post topics available.
 * Topic IDs are the keys, which lead to another associative array, which has both a "name" and "is-applied" key.
 * @param mixed $post_id 
 * @return array
 */
function sethshoemaker_post_topics_get_array_for_post($post_id): array{
    global $wpdb;

    $all_topics_query = "SELECT * FROM " . SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME;
    $all_topics = $wpdb->get_results($all_topics_query, ARRAY_A);

    $applied_topic_ids = get_post_meta($post_id, SETHSHOEMAKER_POST_TOPICS_META_KEY, true);

    $topics = [];

    foreach($all_topics as $topic)
        $topics[$topic["id"]] = array(
            "name" => $topic["name"],
            "is-applied" => false
        );

    $applied_topic_ids_is_empty = gettype($applied_topic_ids) == "string";
    if($applied_topic_ids_is_empty == false)
        foreach($applied_topic_ids as $id)
            $topics[$id]["is-applied"] = true;

    return $topics;
}

function sethshoemaker_post_topics_custom_box_html($post){
    $topics = sethshoemaker_post_topics_get_array_for_post($post->ID); ?>

    <input type="hidden" name="<?= SETHSHOEMAKER_POST_TOPICS_APPLIED_META_BOX_INPUT_NAME ?>">
	<div id="post-topics-list" role="list">
        <?php foreach($topics as $id => $details){ ?>
            <div class="post-topic-list-item" role="list-item">
                <label for="<?= "topic-" . $id ?>">
                    <?= $details['name'] ?>
                </label>
                <input type="checkbox" 
                    id="<?= "topic-" . $id ?>"
                    data-topic-id="<?= $id ?>"
                    <?= $details["is-applied"] ? "checked" : "" ?> />
            </div>
        <?php } ?>
    </div>

<?php }


add_action('admin_enqueue_scripts', 'sethshoemaker_post_topics_page_scripts');

function sethshoemaker_post_topics_page_scripts(){
    $version_number = wp_get_theme()->get('Version');
    wp_enqueue_script('sethshoemaker-post-topics-page-script', plugin_dir_url(__FILE__) . "../../assets/dist/js/topics-meta-box.js", array(), $version_number, true);
}