<?php

class CustomTaxomony extends InitProjectManagement
{
    public function __construct()
    {
        // Add custom taxonomy
        add_action('init', [$this, 'addCustomTaxomony']);
    }

    function addCustomTaxomony()
    {

        $labels = array(
            'name'              => __('Project type'),
            'singular_name'     => __('Project type'),
            'menu_name'         => __('Project type'),
            'all_items'         => 'All project types',
            'new_item_name' => 'New project type',
            'add_new_item' => 'Add new project type',
            'edit_item' => 'Edit project type',
            'update_item' => 'Update project type',
            'search_items' => 'Search project type',
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'ProjectType'),
        );

        register_taxonomy('project-type', array($this->post_type), $args);
    }
}

new CustomTaxomony();
