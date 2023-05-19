<?php

/**
 * Plugin Name: Project Management Plugin
 * Plugin URI: http://wordpress.test/
 * Description: This is a plugin for management projects
 * Version: 1.0
 * Author: Kha Nguyen
 * Author URI: http://wordpress.test
 * License: GPLv2
 **/
if (!defined('PROJECT_MANAGEMENT_PATH')) {
  define('PROJECT_MANAGEMENT_PATH', plugin_dir_path(__FILE__));
}

if (!defined('PROJECT_MANAGEMENT_URL')) {
    define('PROJECT_MANAGEMENT_URL', plugin_dir_url(__FILE__));
}


require_once(PROJECT_MANAGEMENT_PATH . 'features/class-project-management-init.php');

new InitProjectManagement();