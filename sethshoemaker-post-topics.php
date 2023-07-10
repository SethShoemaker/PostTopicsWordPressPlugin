<?php 

/*
    Plugin Name: Post Topics
    Plugin URI: https://github.com/SethShoemaker/PostTopicsWordPressPlugin
    Description: Allows you to declare different "topics" for posts.
    Version: 1.0
    Author: Seth Shoemaker
    AuthorURI: https://github.com/SethShoemaker
*/

define("SETHSHOEMAKER_POST_TOPIC_MIN_NAME_LENGTH", 1);
define("SETHSHOEMAKER_POST_TOPIC_MAX_NAME_LENGTH", 32);

define("SETHSHOEMAKER_POST_TOPIC_MIN_SLUG_LENGTH", 1);
define("SETHSHOEMAKER_POST_TOPIC_MAX_SLUG_LENGTH", 32);

define("SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME", $wpdb->prefix . "sethshoemaker_post_topics");
define("SETHSHOEMAKER_POST_TOPICS_META_KEY", "sethshoemaker_post_topics_meta_key");

define("SETHSHOEMAKER_POST_TOPICS_APPLIED_META_BOX_INPUT_NAME", "sethshoemaker_post_topics_applied");

register_activation_hook( __FILE__, 'sethshoemaker_post_topics_activate' );

function sethshoemaker_post_topics_activate() {
    require_once(dirname(__FILE__) . "/includes/activate.php");
}


if( is_admin() ){
    require_once(dirname(__FILE__) . "/includes/add-topics-page.php");

    $is_edit_php = isset($pagenow) && $pagenow == "edit.php";
    $is_post_php = isset($pagenow) && $pagenow == "post.php";
    $is_post_new_php = isset($pagenow) && $pagenow == "post-new.php";
    $is_admin_ajax = isset($pagenow) && $pagenow == "admin-ajax.php";
    $page_query_is_not_set = !isset($_GET["page"]);
    $is_post_topics_page = !$page_query_is_not_set && $_GET["page"] == "post-topics";

    if($is_edit_php && $is_post_topics_page){
        require_once(dirname(__FILE__) . "/includes/topics-page-html.php");
    }
    else if($is_post_php || $is_post_new_php){
        require_once(dirname(__FILE__) . "/includes/add-topic-meta-box.php");
        require_once(dirname(__FILE__) . "/includes/topic-meta-box-html.php");
        require_once(dirname(__FILE__) . "/includes/save-topics-handler.php");
    }
    else if( $is_edit_php && $page_query_is_not_set ){
        require_once(dirname(__FILE__) . "/includes/topics-column.php");
    }
    else if( $is_admin_ajax ){
        require_once(dirname(__FILE__) . "/includes/add-new-topic-handler.php");
    }
}