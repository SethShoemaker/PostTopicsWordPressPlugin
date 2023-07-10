<?php 

add_action( 'save_post', 'sethshoemaker_post_topics_save_handler' );

function sethshoemaker_post_topics_save_handler( $post_id ) {
    global $wpdb;

	$topic_ids_were_submitted = array_key_exists(SETHSHOEMAKER_POST_TOPICS_APPLIED_META_BOX_INPUT_NAME, $_POST);
	if ($topic_ids_were_submitted == false)
		return;

	$topic_ids = json_decode($_POST[SETHSHOEMAKER_POST_TOPICS_APPLIED_META_BOX_INPUT_NAME]);

	$post_data_was_invalid = $topic_ids == null;
	if ($post_data_was_invalid)
		return;

	// Queries the database for each $topic_id, will return the function early if not found.
	// Since there won't be any record with the id of a string, this also covers the case where the user enters a string
	foreach ($topic_ids as $topic_id) {
		$topic_id_escaped = esc_sql($topic_id);
		$query = "SELECT id FROM " . SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME . " WHERE id='{$topic_id_escaped}'";
		$result = $wpdb->get_row($query, ARRAY_A);

		$topic_id_was_not_found = $result == null;
		if ($topic_id_was_not_found)
			return;
	}

	update_post_meta($post_id, SETHSHOEMAKER_POST_TOPICS_META_KEY, $topic_ids);
}