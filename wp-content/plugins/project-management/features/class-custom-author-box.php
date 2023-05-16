<?php

class CustomAuthor extends InitProjectManagement
{


    public function __construct()
    {
        // Replace box author
        add_action('remove_author_metabox', [$this, 'removeCustomPostAuthorMetabox']);
        add_action('add_meta_boxes', [$this, 'addCustomPostAuthorMetabox']);
        add_action('save_post', [$this, 'saveCustomPostAuthorMetabox'], 10);
    }


    function removeCustomPostAuthorMetabox()
    {
        remove_meta_box('authordiv', $this->post_type, 'normal');
    }

    function addCustomPostAuthorMetabox()
    {
        add_meta_box(
            'custom_post_author',
            __('Author', 'textdomain'),
            [$this, 'customPostAuthorMetaboxCallback'],
            $this->post_type,
            'side',
            'low'
        );
    }

    function customPostAuthorMetaboxCallback($post)
    {
        $authors = get_users(
            array(
                'who' => 'authors'
            )
        );

        $author_id = $post->post_author;
        $author_name = get_the_author_meta('display_name', $author_id);
        $author_avatar = get_avatar_url($author_id);
        if ($author_avatar) {
            echo '<p><img src="' . $author_avatar . '" alt="' . $author_name . '" /></p>';
        }
?>
        <label for="post_author">Select author:</label>
        <select name="post_author" id="post_author">
            <?php
            foreach ($authors as $author) {
                $selected = '';
                if ($author->ID == $post->post_author) {
                    $selected = ' selected="selected"';
                }
            ?>
                <option value="<?php echo esc_attr($author->ID); ?>" <?php echo $selected; ?>><?php echo esc_html($author->display_name); ?></option>
            <?php
            }
            ?>
        </select>
<?php
    }


    function saveCustomPostAuthorMetabox($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
  
        if (isset($_POST['post_author']) && $_POST['post_author']) {
            $new_author_id = sanitize_text_field($_POST['post_author']);
            if ($new_author_id) {
                wp_update_post(
                    array(
                        'ID' => $post_id,
                        'post_author' => $new_author_id
                    )
                );
            }
        }
    }
}

new CustomAuthor();

