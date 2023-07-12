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

    public function __construct() {
        parent::__construct([
            'singular' => __('Item', 'textdomain'),
            'plural' => __('Items', 'textdomain'),
            'ajax' => false
        ]);
    }

    public function get_columns() {
        return [
        'column_1' => __('Column 1', 'textdomain'),
        'column_2' => __('Column 2', 'textdomain'),
        'column_3' => __('Column 3', 'textdomain'),
        ];
    }

    public function prepare_items() {
        $data = array(
            array(
                'column_1' => 'Data 1',
                'column_2' => 'Data 2',
                'column_3' => 'Data 3',
            ),
            array(
                'column_1' => 'Data 4',
                'column_2' => 'Data 5',
                'column_3' => 'Data 6',
            ),
        );

        $this->_column_headers = $this->get_column_info();
        $this->items = $data;
    }

    public function column_default($item, $column_name) {
        switch ($column_name) {
            case 'column_1':
            case 'column_2':
            case 'column_3':
            return $item[$column_name];
            default:
            return __('Unknown column', 'textdomain');
        }
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