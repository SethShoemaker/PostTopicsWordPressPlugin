<?php 

add_action( 'add_meta_boxes', 'sethshoemaker_post_topics_add_custom_box' );

function sethshoemaker_post_topics_add_custom_box() {
    add_meta_box(
        'sethshoemaker_post_topics_box',
        'Topics',
        'sethshoemaker_post_topics_custom_box_html',
        'post',
        'side'
    );
}