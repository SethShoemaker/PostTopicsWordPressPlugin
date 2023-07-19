<?php

function sethshoemaker_post_topics_topic_filter_html($post_type){
    if($post_type !== "post")
        return;

    $topics_filter_was_set = isset($_REQUEST[SETHSHOEMAKER_POST_TOPICS_TOPICS_FILTER_INPUT_NAME]);
    $selected_topic_id = $topics_filter_was_set
        ? (int)$_REQUEST[SETHSHOEMAKER_POST_TOPICS_TOPICS_FILTER_INPUT_NAME]
        : SETHSHOEMAKER_POST_TOPICS_TOPICS_FILTER_INPUT_DEFAULT_VALUE;

    $get_all_topics_function_exists = function_exists("sethshoemaker_post_topics_get_all");
    if($get_all_topics_function_exists == false)
        require_once(plugin_dir_path(__FILE__) . "../../functions/get-all-topics.php");

    $topics = sethshoemaker_post_topics_get_all();

    ?>
    <select name="<?= SETHSHOEMAKER_POST_TOPICS_TOPICS_FILTER_INPUT_NAME ?>">
        <option value="<?= SETHSHOEMAKER_POST_TOPICS_TOPICS_FILTER_INPUT_DEFAULT_VALUE ?>">Any Topic</option>
        <?php
        foreach ($topics as $topic):
            $is_selected = $selected_topic_id == $topic['id'];
            ?>  
            <option value="<?= $topic['id'] ?>" <?= $is_selected ? "selected" : "" ?>>
                <?= $topic['name'] ?>
            </option> 
            <?php
        endforeach; 
        ?>
    </select>

    <?php
}