<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class SupportListTable extends WP_List_Table
{
    private $table_data;

    public function __construct()
    {
        parent::__construct(array(
            'singular' => 'item',
            'plural' => 'items',
            'ajax' => false
        ));
    }

    public function get_columns()
    {
        $columns = array(
            'ID'   => __('ID', 'supporthost-cookie-consent'),
            'project_name'  => __('Project Name', 'supporthost-cookie-consent'),
            'Image'  => __('Image', 'supporthost-cookie-consent'),
            'Description'   => __('Description', 'supporthost-cookie-consent'),
            'Start Date'   => __('Start Date', 'supporthost-cookie-consent'),
            'End Date'  => __('End Date', 'supporthost-cookie-consent'),
            'Status'  => __('Status', 'supporthost-cookie-consent'),
            'Type'  => __('Type', 'supporthost-cookie-consent')
        );

        return $columns;
    }

    public function get_views()
    {
        // Lấy danh sách các bộ lọc tùy chỉnh
        $filters = array(
            'all' => 'All',
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed'
        );

        // Hiển thị các liên kết bộ lọc
        $current_filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $views = array();
        foreach ($filters as $filter_key => $filter_label) {
            $class = ($filter_key === $current_filter) ? 'current' : '';
            $query_args = array(
                'post_type' => 'project',
                'page' => 'projects-report',
                'filter' => $filter_key
            );
            $url = add_query_arg($query_args, admin_url('edit.php'));
            $views[$filter_key] = "<a class='$class' href='$url'>$filter_label</a>";
        }

        return $views;
    }

    public function extra_tablenav($which)
    {
        if ($which === 'top') {
            // Hiển thị form bộ lọc tùy chỉnh
            $current_filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
            // $filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
?>
            <label for="filter" class="screen-reader-text">Filter by Status</label>
            <div class="alignleft actions">
                <select name="filter" id="filter">
                    <option value="all" <?= selected($current_filter, 'all'); ?>>All status</option>
                    <option value="pending" <?= selected($current_filter, 'pending'); ?>>Pending</option>
                    <option value="in_progress" <?= selected($current_filter, 'in_progress'); ?>>In Progress</option>
                    <option value="completed" <?= selected($current_filter, 'completed'); ?>>Completed</option>
                </select>
                <input type="submit" name="" id="post-query-submit" class="button" value="Filter status">
            </div>
<?php
            require_once(PROJECT_MANAGEMENT_PATH . 'includes/filter-ui.php');
        }
    }

    public function prepare_items()
    {
        $filter = isset($_POST['filter']) ? $_POST['filter'] : 'all';
        $startDate = isset($_POST['start_date_filter']) ? $_POST['start_date_filter'] : '';
        $endDate = isset($_POST['end_date_filter']) ? $_POST['end_date_filter'] : '';

        //data
        if (!empty($_POST['s'])) {
            $this->table_data = $this->get_table_data($_POST['s'], $filter, '', '');
        } else {
            $this->table_data = $this->get_table_data('', $filter, $startDate, $endDate);
        }

        $columns = $this->get_columns();
        $hidden  = array();
        $sortable = $this->get_sortable_columns();
        $primary  = 'name';

        $this->_column_headers = array($columns, $hidden, $sortable, $primary);

        usort($this->table_data, array(&$this, 'usort_reorder'));

        /* pagination */
        $per_page = $this->get_items_per_page('elements_per_page', 5);
        $current_page = $this->get_pagenum();
        $total_items = count($this->table_data);
        $this->table_data = array_slice($this->table_data, (($current_page - 1) * $per_page), $per_page);

        $this->set_pagination_args(array(
            'total_items' => $total_items, // total number of items
            'per_page'    => $per_page, // items to show on a page
            'total_pages' => ceil($total_items / $per_page) // use ceil to round up
        ));

        $this->items = $this->table_data;
    }

    private function get_table_data($search = '', $status = 'all', $startDate = '', $endDate = '')
    {
        global $wpdb;

        $table = $wpdb->prefix . 'posts';
        $whereClause = "`post_type` = 'project' AND `post_status` = 'publish'";

        if (!empty($search)) {
            return $wpdb->get_results(
                "SELECT ID, post_title from {$table} WHERE `ID` LIKE '%{$search}%' OR `post_title` LIKE '%{$search}%' AND {$whereClause}",
                ARRAY_A
            );
        } else {
            $posts = [];
            $postDateRange = [];

            if ($status != 'all') {
                $args = array(
                    'post_type' => 'project', // Loại bài viết bạn muốn lấy
                    'meta_key' => '_status', // Tên của post_meta chứa trạng thái
                    'meta_value' => $status, // Giá trị của post_meta trạng thái
                    'fields' => 'ids', // Chỉ lấy ID của bài viết
                    'posts_per_page' => -1, // Số lượng bài viết trên mỗi trang (-1 để lấy tất cả)
                );
                $posts = get_posts($args);
                $ids = implode(',', $posts);
                $whereClause .= " AND `ID` IN ({$ids})";
                return $wpdb->get_results(
                    "SELECT ID, post_title from {$table} WHERE {$whereClause}",
                    ARRAY_A
                );
            }

            if (!empty($startDate) || !empty($endDate)) {
                $metaQuery = [];

                $startDateFormat = !empty($startDate) ? DateTime::createFromFormat('d-m-Y', $startDate)->format('Y-m-d') : '';
                $endDateFormat = !empty($endDate) ? DateTime::createFromFormat('d-m-Y', $endDate)->format('Y-m-d') : '';
                if (!empty($startDateFormat) && empty($endDateFormat)) {
                    $metaQuery[] = array(
                        'key'     => '_start_date',
                        'value'   => $startDateFormat,
                        'compare' => '>=',
                        'type'    => 'DATE',
                    );
                }

                if (empty($startDateFormat) && !empty($endDateFormat)) {
                    $metaQuery[] = array(
                        'key'     => '_end_date',
                        'value'   => $endDateFormat,
                        'compare' => '<=',
                        'type'    => 'DATE',
                    );
                }

                if (!empty($startDateFormat) && !empty($endDateFormat)) {
                    $metaQuery[] = array(
                        'relation' => 'AND',
                        array(
                            'key'     => '_start_date',
                            'value'   => $startDateFormat,
                            'compare' => '>=',
                            'type'    => 'DATE',
                        ),
                         array(
                            'key'     => '_end_date',
                            'value'   => $endDateFormat,
                            'compare' => '<=',
                            'type'    => 'DATE',
                        ),
                    );
                }

                $args = array(
                    'post_type'  => 'project', // Loại bài viết bạn muốn lấy
                    'posts_per_page' => -1, // Số lượng bài viết trên mỗi trang (-1 để lấy tất cả),
                    'fields' => 'ids',
                    'meta_query' => $metaQuery,
                );

                $postDateRange = implode(',', get_posts($args));

                $whereClause .= " AND `ID` IN ({$postDateRange})";
                return $wpdb->get_results(
                    "SELECT ID, post_title from {$table} WHERE {$whereClause}",
                    ARRAY_A
                );
            }

            return $wpdb->get_results(
                "SELECT ID, post_title from {$table} WHERE {$whereClause}",
                ARRAY_A
            );
        }
    }

    // Add a new method to handle form submission and process bulk action
    public function handle_form_submission()
    {
        // Check if form is submitted and the action is set
        if (isset($_REQUEST['action']) && $_REQUEST['action'] != '-1') {
            $this->process_bulk_action();
        }
    }

    public function column_default($item, $column_name)
    {
        $arr_terms = [];
        $terms = '';

        if (is_array(get_the_terms($item['ID'], 'project-type'))) {
            foreach (get_the_terms($item['ID'], 'project-type') as $key => $term) {
                $arr_terms[] = $term->name;
            }
        }

        $terms = implode(', ', $arr_terms);
        switch ($column_name) {
            case 'ID':
                return $item['ID'];
            case 'project_name':
                echo '<strong>' . $item['post_title'] . '</strong>';
                return;
            case 'Image':
                $image = get_the_post_thumbnail_url($item['ID']);
                echo '<img src="' . $image . '" width="50px">';
                return;
            case 'Description':
                $description = get_post_meta($item['ID'], '_description', true);
                echo '<strong>' . $description . '</strong>';
                return;
            case 'Start Date':
                $startDate = get_post_meta($item['ID'], '_start_date', true);
                echo '<strong>' . $startDate . '</strong>';
                return;
            case 'End Date':
                $endDate = get_post_meta($item['ID'], '_end_date', true);
                echo '<strong>' . $endDate . '</strong>';
                return;
            case 'Status':
                $endDate = get_post_meta($item['ID'], '_status', true);
                echo '<div>' . $endDate . '</div>';
                return;
            case 'Type':
                echo '<div>' . $terms . '</div>';
                return;
            default:
                return;
        }
    }

    protected function get_sortable_columns()
    {
        $sortable_columns = array(
            'ID'  => array('ID', false),
            'project_name'  => array('post_title', true),
        );

        return $sortable_columns;
    }

    public function column_project_name($item)
    {

        $actions = array(
            'edit' => sprintf('<a href="%s">Detail</a>', admin_url('post.php?action=edit&post=' . $item['ID'])),
        );

        return sprintf('%s %s', $item['post_title'], $this->row_actions($actions));
    }

    // Sorting function
    public function usort_reorder($a, $b)
    {
        // If no sort, default to user_login
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'ID';

        // If no order, default to asc
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';

        // Determine sort order
        $result = strcmp($a[$orderby], $b[$orderby]);

        // Send final sort direction to usort
        return ($order === 'asc') ? $result : -$result;
    }
}
?>