<?php

add_action("admin_menu", "sethshoemaker_post_topics_add_topic_edit_page");

function sethshoemaker_post_topics_add_topic_edit_page(){
    // TODO: set up correct user permission
    add_posts_page("Edit Topic", "", "manage_options", "edit-topic", "sethshoemaker_post_topics_edit_html");
}