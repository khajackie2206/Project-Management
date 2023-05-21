<?php

class custom_members_metabox extends InitProJectManagement
{
    public function __construct()
    {
        // Add meta box members
        add_action('add_meta_boxes', [$this, 'custom_members_metabox']);
        add_action('save_post', [$this, 'save_custom_members_metabox'], 30);
    }

    /**************************************************
     * Start Customize meta box for members
     **************************************************/
    public function custom_members_metabox()
    {
        add_meta_box(
            // ID của metabox, phải là duy nhất
            'custom_members_metabox',
            // Tiêu đề của metabox
            'Members infomation',
            // Callback function để hiển thị nội dung metabox
            [$this, 'custom_members_metabox_callback'],
            // Tên của custom post type mà bạn muốn thêm metabox vào
            $this->post_type,
            // Vị trí của metabox: normal (bên cạnh editor), side (ở bên phải) hoặc advanced (ở dưới editor)
            'normal',
            // Ưu tiên hiển thị của metabox (high, core hoặc default)
            'high'
        );
    }

    public function custom_members_metabox_callback($post)
    {
        require_once PROJECT_MANAGEMENT_PATH . 'includes/metabox-members.php';
    }

    // Lưu giá trị của các trường trong metabox khi lưu post
    public function save_custom_members_metabox($post_id)
    {
        // Kiểm tra quyền hạn của user
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['member_position'])) {
            update_post_meta($post_id, '_members', array_map('intval', $_POST['members']));
        }

        if (isset($_POST['member_level'])) {
            update_post_meta($post_id, '_members', array_map('intval', $_POST['members']));
        }
    }
    /**************************************************
     * End Customize meta box for members
     **************************************************/
}

new custom_members_metabox();
