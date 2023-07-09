<?php

global $wpdb;
global $sethshoemaker_post_topics_db_table_name;

$sethshoemaker_post_topics_version = "1.0";

$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $sethshoemaker_post_topics_db_table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  name varchar(32) DEFAULT '' NOT NULL UNIQUE,
  slug varchar(32) DEFAULT '' NOT NULL UNIQUE,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

add_option( 'sethshoemaker_post_topics_version', $sethshoemaker_post_topics_version );