<?php

function sethshoemaker_post_topics_get_topic_by_id($id): array{
    global $wpdb;

    $id_escaped = esc_sql($id);

    $query = "
        SELECT
            id,
            name,
            slug
        FROM " . SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME . "
        WHERE id='{$id_escaped}'";

    $result = $wpdb->get_row($query, ARRAY_A);

    $topic_was_not_found = $result == null;
    if ($topic_was_not_found)
        die();

    return $result;
}

function sethshoemaker_post_topics_edit_html(){

    $topic = sethshoemaker_post_topics_get_topic_by_id($_GET['topicID']);

    ?>

    <div class="wrap">
        <h1>Topics</h1>
        <div id="ajax-response"></div>
        <div class="form-wrap mt-4">
            <h2 class="font-bold text-sm">Edit Topic</h2>
            <form url="<?= esc_url( admin_url('admin-ajax.php') );  ?>" 
                id="edit-topic-form"
                action="sethshoemaker_post_topics_edit_topic"
                topic-id="<?= $topic["id"] ?>">
                <div class="form-field form-required term-name-wrap">
                    <label for="edit-topic-name">Name</label>
                    <input type="text" 
                        name="edit-topic-name" 
                        id="edit-topic-name" 
                        aria-describedby="name-description"
                        aria-required="true"
                        autofocus
                        minlength="<?= SETHSHOEMAKER_POST_TOPIC_MIN_NAME_LENGTH ?>"
                        maxlength="<?= SETHSHOEMAKER_POST_TOPIC_MAX_NAME_LENGTH ?>"
                        value="<?= $topic['name'] ?>">
                    <p class="name-description">
                        Name must be <?= SETHSHOEMAKER_POST_TOPIC_MIN_NAME_LENGTH . "-" . SETHSHOEMAKER_POST_TOPIC_MAX_NAME_LENGTH ?> characters long
                    </p>
                </div>
                <div class="form-field form-required term-slug-wrap">
                    <label for="edit-topic-slug">Slug</label>
                    <input type="text" 
                        name="edit-topic-slug" 
                        id="edit-topic-slug"
                        aria-describedby="slug-description"
                        aria-required="false"
                        minlength="<?= SETHSHOEMAKER_POST_TOPIC_MIN_SLUG_LENGTH ?>"
                        maxlength="<?= SETHSHOEMAKER_POST_TOPIC_MAX_SLUG_LENGTH ?>"
                        value="<?= $topic['slug'] ?>">
                    <p class="slug-description">
                        Slug must be <?= SETHSHOEMAKER_POST_TOPIC_MIN_SLUG_LENGTH . "-" . SETHSHOEMAKER_POST_TOPIC_MAX_SLUG_LENGTH ?> characters long
                    </p>
                </div>
                <?php submit_button( __( 'Save Changes', 'textdomain' ) ); ?>
            </form>
        </div>
    </div>

<?php }

add_action('admin_enqueue_scripts', 'sethshoemaker_post_topics_enqueue_edit_page_assets');

function sethshoemaker_post_topics_enqueue_edit_page_assets(){
    $version_number = wp_get_theme()->get('Version');
    wp_enqueue_style('sethshoemaker-post-topics-page-style', plugin_dir_url(__FILE__) . "../assets/dist/css/topics-page.css", array(), $version_number);
    wp_enqueue_script('sethshoemaker-post-topics-edit-page-script', plugin_dir_url(__FILE__) . "../assets/dist/js/edit-topic-page.js", array('jquery'), $version_number, true);
}