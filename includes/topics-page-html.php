<?php

function sethshoemaker_post_topics_page_html(){ ?>

    <div class="wrap">
        <h1>Topics</h1>
        <div id="ajax-response"></div>
        <div class="grid lg:grid-cols-[1fr_2fr]">
            <div class="form-wrap">
                <h2 class="font-bold text-sm">Add New Topic</h2>
                <form url="<?= esc_url( admin_url('admin-ajax.php') );  ?>" 
                    id="new-topic-form"
                    action="sethshoemaker_post_topics_add_new_topic" >
                    <div class="form-field form-required term-name-wrap">
                        <label for="new-topic-name">Name</label>
                        <input type="text" 
                            name="new-topic-name" 
                            id="new-topic-name" 
                            aria-describedby="name-description"
                            aria-required="true"
                            autofocus
                            minlength="<?= SETHSHOEMAKER_POST_TOPIC_MIN_NAME_LENGTH ?>"
                            maxlength="<?= SETHSHOEMAKER_POST_TOPIC_MAX_NAME_LENGTH ?>">
                        <p class="name-description">
                            Name must be <?= SETHSHOEMAKER_POST_TOPIC_MIN_NAME_LENGTH . "-" . SETHSHOEMAKER_POST_TOPIC_MAX_NAME_LENGTH ?> characters long
                        </p>
                    </div>
                    <div class="form-field form-required term-slug-wrap">
                        <label for="new-topic-slug">Slug</label>
                        <input type="text" 
                            name="new-topic-slug" 
                            id="new-topic-slug"
                            aria-describedby="slug-description"
                            aria-required="false"
                            minlength="<?= SETHSHOEMAKER_POST_TOPIC_MIN_SLUG_LENGTH ?>"
                            maxlength="<?= SETHSHOEMAKER_POST_TOPIC_MAX_SLUG_LENGTH ?>">
                        <p class="slug-description">
                            Slug must be <?= SETHSHOEMAKER_POST_TOPIC_MIN_SLUG_LENGTH . "-" . SETHSHOEMAKER_POST_TOPIC_MAX_SLUG_LENGTH ?> characters long
                        </p>
                    </div>
                    <?php submit_button( __( 'Add New Topic', 'textdomain' ) ); ?>
                </form>
            </div>
            <div class="lg:mx-5">
                <?php 
                    $table = new SethShoemaker_Post_Topics_Topics_Table();
                    $table->prepare_items();
                    $table->display(); 
                ?>
            </div>
        </div>
    </div>

<?php }

require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
class SethShoemaker_Post_Topics_Topics_Table extends WP_List_Table {

    public function prepare_items() {
        $this->items = $this->get_items();

        $this->_column_headers = [
            $this->columns, 
            $this->hidden_values, 
            $this->sortable_columns,
            $this->primary_column
        ];
    }

    public function get_items(): array {
        global $wpdb;

        $topics_query = '
            SELECT 
                id, 
                name, 
                slug,
                (
                    SELECT 
                        COUNT(*)
                    FROM ' . $wpdb->postmeta . '
                    WHERE 
                        meta_key="' . SETHSHOEMAKER_POST_TOPICS_META_KEY . '"
                        AND meta_value LIKE CONCAT("%", id, "%")
                ) AS count
            FROM ' . SETHSHOEMAKER_POST_TOPIC_DB_TABLE_NAME;

        return $wpdb->get_results($topics_query, ARRAY_A);
    }

    function column_name($item) {
        $actions = array(
            'edit' => "<a href=\"" . admin_url("edit.php") . "?page=edit-topic&topicID=" . $item['id'] . "\">Edit</a>",
            'delete' => "",
        );

        return $item['name'] . $this->row_actions($actions);
    }

    public function column_default($item, $column_name) {
        return $item[$column_name] ?? "null";
    }

    public $columns = [
        'name' => 'Name',
        'slug' => 'Slug',
        'count' => 'Count'
    ];

    public $hidden_values = [];

    public $sortable_columns = [];

    public $primary_column = "name";
}

add_action('admin_enqueue_scripts', 'sethshoemaker_post_topics_page_styles');

function sethshoemaker_post_topics_page_styles(){
    $version_number = wp_get_theme()->get('Version');
    wp_enqueue_style('sethshoemaker-post-topics-page-style', plugin_dir_url(__FILE__) . "../assets/dist/css/topics-page.css", array(), $version_number);
}

add_action('admin_enqueue_scripts', 'sethshoemaker_post_topics_page_scripts');

function sethshoemaker_post_topics_page_scripts(){
    $version_number = wp_get_theme()->get('Version');
    wp_enqueue_script('sethshoemaker-post-topics-page-script', plugin_dir_url(__FILE__) . "../assets/dist/js/topics-page.js", array("jquery"), $version_number, true);
}