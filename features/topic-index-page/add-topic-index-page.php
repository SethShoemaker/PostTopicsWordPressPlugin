<?php

add_action("admin_menu", "sethshoemaker_post_topics_add_topic_index_page");

function sethshoemaker_post_topics_add_topic_index_page(){
    // TODO: set up correct user permission
    add_posts_page("Topics", "Topics", 'manage_options', "post-topics", "sethshoemaker_post_topics_page_html");
}