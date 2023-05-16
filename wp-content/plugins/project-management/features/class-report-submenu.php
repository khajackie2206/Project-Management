<?php


class CreateReportSubmenu extends InitProjectManagement
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'addNewReportSubmenu']);
        require_once PROJECT_MANAGEMENT_PATH . '/features/class-wp-list-table.php';
    }

    function addNewReportSubmenu()
    {
        add_submenu_page('edit.php?post_type=project', 'Report', 'Report', 'manage_options', 'projects-report',  [$this, 'show_report_submenu_page']);
    }

    function show_report_submenu_page()
    {

        // Creating an instance
        $table = new SupportListTable();

        echo '<div class="wrap"><h2>SupportHost List Table</h2>';
        // Prepare table
        $table->get_columns();

        echo '</div>';
    }
}

new CreateReportSubmenu();
