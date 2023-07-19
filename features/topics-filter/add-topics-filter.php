<?php

add_action('restrict_manage_posts','sethshoemaker_post_topics_topic_filter_html');

add_filter( 'parse_query', 'sethshoemaker_post_topics_filter_by_topic_id');