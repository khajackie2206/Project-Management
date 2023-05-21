<?php

class InitProjectManagement
{

    protected $post_type = 'project';
    protected $new_post_type = 'new';

    public function __construct()
    {
        // init register post type
        add_action('init', [$this, 'create_project_post_type']);

        // Add Project Manager role
        add_role('project manager', 'Project Manager', get_role('author')->capabilities);

        // Validate input before update project data
        add_action('pre_post_update', [$this, 'validate_project_data']);

        // Show error notice when validate fail
        add_action('admin_notices', [$this, 'show_validate_notices']);

        // Replace title
        add_filter('enter_title_here', [$this, 'custom_title'], 10, 2);

        // require_once PROJECT_MANAGEMENT_PATH . '/features/class-custom-author-box.php';
        require_once PROJECT_MANAGEMENT_PATH . '/features/class-custom-metabox.php';
        require_once PROJECT_MANAGEMENT_PATH . '/features/class-members-metabox.php';
        require_once PROJECT_MANAGEMENT_PATH . '/features/class-project-type-taxonomy.php';
        require_once PROJECT_MANAGEMENT_PATH . '/features/class-report-submenu.php';

        //validate by script
        $this->validateByScript();
    }

    function create_project_post_type()
    {
        $args = array(
            'labels' => array(
                'name' => __('Projects'),
                'singular_name' => __('Project'),
                'search_items' => __('Search Projects'),
                'view_item' => __('View Projects'),
                'not_found' =>  __('No project Found'),
                'edit' => __('Edit Project'),
                'new_item_name' => __('New project type'),
                'add_new_item' => __('Add new project'),
                'edit_item' => __('Update project information')
            ),
            'taxonomies' => array('project-type'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'service'),
            'supports' => array('title', 'thumbnail', 'author'),
            'menu_icon' => 'dashicons-portfolio',
            'capability_type' => 'post',
            'show_in_rest' => true,
            'hierarchical' => false,
            'menu_position' => null,
        );

        register_post_type($this->post_type, $args);
    }

    /**
     * Show validate errors
     */
    public function show_validate_notices()
    {
        /** Get and remove message (Just like Flash message) */
        $errors = get_transient('validate_errors');
        delete_transient('validate_errors');

        if (isset($errors) && $errors !== false) {
            foreach ($errors as $error) {
?>
                <div class="notice notice-error is-dismissible">
                    <p>
                        <?php echo $error; ?>
                    </p>
                </div>
<?php
            }
        }
    }

    function custom_title($placeholder, $post)
    {
        if ($this->post_type === $post->post_type) {
            $placeholder = 'Enter your project name';
        }
        return $placeholder;
    }

    private function validateByScript()
    {
        if ($this->isCorrectPage()) {
            wp_enqueue_script('validation-project-management', PROJECT_MANAGEMENT_URL . '/assets/js/pm-validation.js');
        }
    }

    private function isCorrectPage()
    {
        global $pagenow;

        $isCorrectPage = false;

        if ($pagenow == 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == $this->post_type) {
            $isCorrectPage = true;
        }

        if ($pagenow == 'post.php') {
            if (isset($_GET['post'])) {
                $post_id = $_GET['post'];
                $post = get_post($post_id);
                $isCorrectPage = $post->post_type == $this->post_type;
            }

            if (isset($_POST['post_type']) && $_POST['post_type'] == $this->post_type) {
                $isCorrectPage = true;
            }
        }

        return $isCorrectPage;
    }

    /**
     * Validate player form data. Check if user filled squad number, nationality and suburbs
     */
    public function validate_project_data()
    {
        /** Don't check if delete player */
        if (isset($_GET['action']) && $_GET['action'] == 'trash') {
            return;
        }
        $errors = [];

        if (!isset($_POST['start_date']) || $_POST['start_date'] == '') {
            $errors[] = 'Start Date is required';
        }
        if (!isset($_POST['estimize']) || $_POST['estimize'] == '') {
            $errors[] = 'Estimize is required';
        }

        /** If have error */
        // if (sizeof($errors) != 0) {
        //     /** Set errors */
        //     set_transient('validate_errors', $errors, 60);

        //     /** Redirect back */
        //     $back_location = $_REQUEST['_wp_http_referer'];
        //     wp_safe_redirect($back_location);
        //     exit();
        // }
    }
}
