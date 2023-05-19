<?php


class CreateReportSubmenu extends InitProjectManagement
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'addNewReportSubmenu']);
        // add_action('manage_users_extra_tablenav', [$this, 'my_author_filter']);
        // add_action('pre_get_posts', [$this, 'my_author_filter_results']);
        // add_action('admin_menu', 'my_add_menu_items');
    }

    public function addNewReportSubmenu()
    {
        add_submenu_page(
            'edit.php?post_type=project',
            'Report',
            'Report',
            'manage_options',
            'projects-report',
            [$this, 'show_report_submenu_page']
        );
    }

    public function show_report_submenu_page()
    {
        // UI report
        require_once PROJECT_MANAGEMENT_PATH . 'includes/report-page.php';

        // table report project list
        require_once PROJECT_MANAGEMENT_PATH . '/features/class-wp-list-table.php';

        $table = new SupportListTable();

        echo '<div class="wrap"><h2>PROJECT ANALYST</h2>';
        echo '<style>#the-list .row-actions{left:0;}</style>';

        $table->prepare_items();
        $table->handle_form_submission();

        // $table->process_bulk_action();
        echo '<form method="post">';
        echo '<input type="hidden" name="page" value="projects-report" />';

        $table->search_box('search', 'search_id');
        // Display table
        $table->display();

        echo '</div></form>';
    }

    // add screen options
    public function supporthost_sample_screen_options()
    {

        global $supporthost_sample_page;
        global $table;

        $screen = get_current_screen();

        // get out of here if we are not on our settings page
        if (!is_object($screen) || $screen->id != $supporthost_sample_page) {
            return;
        }

        $args = array(
            'label' => __('Elements per page', 'supporthost-admin-table'),
            'default' => 2,
            'option' => 'elements_per_page'
        );
        add_screen_option('per_page', $args);

        $table = new CreateReportSubmenu();
    }
}

new CreateReportSubmenu();
