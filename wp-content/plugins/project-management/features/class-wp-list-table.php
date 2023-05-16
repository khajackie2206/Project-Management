<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class SupportListTable extends WP_List_Table
{

    function get_columns()
    {
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'name'          => __('Name', 'supporthost-cookie-consent'),
            'description'         => __('Description', 'supporthost-cookie-consent'),
            'status'   => __('Status', 'supporthost-cookie-consent'),
            'order'        => __('Order', 'supporthost-cookie-consent')
        );
        
        return $columns;
    }
}
