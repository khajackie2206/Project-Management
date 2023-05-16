<?php
/* Plugin Name: Display Custom Post
Plugin URI: https://wordpress.org/plugins/display-custom-post/
Description: Display Custom Posts Using a Simple Shortcode 
Version: 2.2.1
Author: Vikas Vatsa
Author URI: https://vikasvatsa.com/
License: MIT
*/ 
 
/**
 * List of JavaScript / CSS files for admin
 */
 
add_action('admin_init', 'dcp_scripts');
add_action('admin_menu', 'dcp_menu');

	
/**
 * List of JavaScript / CSS files for admin
 */

if (!function_exists('dcp_scripts')) {
    function dcp_scripts() {
        if (is_admin()) {
			wp_register_style('admin.display.css', plugin_dir_url( __FILE__ ) . '/css/admin.display.css');
			wp_enqueue_style('admin.display.css');
		 
			wp_enqueue_script('jquery');
			
			wp_register_script('admin.script.js', plugin_dir_url( __FILE__ ) . '/js/admin.script.js');
			wp_enqueue_script('admin.script.js');
        }
    }
}


//Adding stylesheet for front-end display

add_action('wp_enqueue_scripts', 'dcp_styles');
function dcp_styles() {
    wp_register_style('display-custom-post', plugin_dir_url( __FILE__ ) . 'css/display-custom-post.css');
	wp_register_style('dcp-layout', plugin_dir_url( __FILE__ ) . 'css/dcp-layout.css');
	wp_enqueue_style('display-custom-post');
	wp_enqueue_style('dcp-layout');
}


/**
 * Activation Hook for Custom Post Display
 */

function dcp_activation() {
}
register_activation_hook(__FILE__, 'dcp_activation');


/**
 * Deactivation Hook for Custom Post Display
 */
 
function dcp_deactivation() {
}
register_deactivation_hook(__FILE__, 'dcp_deactivation');

/**
 * Plugin Menu for Custom Post Display
 */
 
function dcp_menu() {
	add_menu_page('Display Custom Post', 'Display Custom Post', 'administrator', 'display-custom-post', 'dcp_core', 'dashicons-table-col-before');
}

/**
 * Function for Admin Menu Page Option 
 */
 
function dcp_core(){
	$cposts = get_post_types();

	// Builtin types needed.
	$exclude_post_types = array(
		'page',
		'attachment'
	);
	$cposts = get_post_types( array(
		'public'   => true
	) );
	
	$html = '';
	$html .= '<div class="dash-area">';
		$html .= '<div class="settings">';
			$html .= '<h1>Create Shortcode with just few clicks: </h1><br/>';
			$html .= '<span class="metainfo">*Choose the below settings and your shortcode would be ready.</span>';
			$html .= '<h3>Post Type <span class="optional">(required)</span>: <span class="metainfo">Please select any post type registered on website</span></h3>';
			$html .= '<select id="dropdown_selector">'; 
				$html .= '<option value="" selected disabled>Select an option</option>';
				foreach($cposts as $cpost){ 
					if(!in_array($cpost, $exclude_post_types)){
						$html .= '<option value="'. strtolower($cpost) .'">' .$cpost . '</option>'; 
					}
				}
			$html .='</select><br/>'; 
			
			$html .= '<h3>Layout: <span class="metainfo">Please check layout screenshots on <a href="https://wordpress.org/plugins/display-custom-post/" target="_blank">plugin official page</a>.<br/>*Custom options does not work with Default layout such s meta info or title tag.</span></h3>';
			$html .= '<select id="layout_selector">'; 
				$html .= '<option value="" selected>Default</option>';
				$html .= '<option value="dcp-column-grid">Grid Layout</option>';
				$html .= '<option value="dcp-grid-full-width">Full Width Layout</option>';
				$html .= '<option value="dcp-grid-full-width-img-left">Boxed Layout (Image Left - Content Right)</option>';
				$html .= '<option value="dcp-grid-full-width-img-right">Boxed Layout (Content Left - Image Right)</option>';
				$html .= '<option value="dcp-grid-overlay">Content Overlay Layout</option>';
			$html .='</select><br/>'; 			

			$html .= '<h3>Grid Columns <span class="optional">(required)</span>: <span class="metainfo">Only for Grid Layout & Content Overlay Layout; Default: 1</span></h3>';
			$html .= '<select id="cols_selector">'; 
				$html .= '<option value="1" selected>1</option>';
				for($i=2; $i<=12; $i++){
					$html .= '<option value="'.$i.'">'.$i.'</option>';
				}
			$html .='</select><br/>';
			
			$html .= '<h3>Show Posts <span class="optional">(optional)</span>: <span class="metainfo">Please add post IDs (comma seperated).<br/> *In order to show only specific posts</span></h3>';
			$html .= '<input type="text" name="includeposts" id="includeposts" placeholder="Post IDs (comma seperated)" /><br/>';			
			$html .= '<h3>Exclude Posts <span class="optional">(optional)</span>: <span class="metainfo">Please add posts ID (comma seperated).<br/>*In order to exclude specific posts from display</span></h3>';
			$html .= '<input type="text" name="excludeposts" id="excludeposts" placeholder="Post IDs (comma seperated)" /><br/>';
			$html .= '<h3>Post Limit Per Page <span class="optional">(optional)</span>: <span class="metainfo">Please add -1 for showing all posts</span></h3>';	
			$html .= '<input type="number" name="numberposts" id="numberposts" placeholder="Number of posts to be shown on per page" min="-1" /><br/>';	
			$html .= '<h3>Post Order <span class="optional">(optional)</span>:</h3>';
			$html .= '<select id="order_selector">'; 
				$html .= '<option value="" selected disabled>Select an option</option>';
				$html .= '<option value="ASC">Ascending</option>';
				$html .= '<option value="DESC">Descending</option>';
			$html .='</select><br/>'; 	
			$html .= '<h3>Post Orderby <span class="optional">(optional)</span>:</h3>';
			$html .= '<select id="orderby_selector">'; 
				$html .= '<option value="" selected disabled>Select an option</option>';
				$html .= '<option value="author">Author</option>';
				$html .= '<option value="comment_count">Comment count</option>';
				$html .= '<option value="date">Date</option>';
				$html .= '<option value="modified">Modified Date</option>';
				$html .= '<option value="none">None</option>';
				$html .= '<option value="menu_order">Page order</option>';
				$html .= '<option value="parent">Parent Post/Page IDs</option>';
				$html .= '<option value="rand">Random</option>';
				$html .= '<option value="title">Title</option>';
			$html .='</select><br/>'; 
			$html .= '<h3>Meta Info <span class="optional">(optional)</span>: <span class="metainfo">Please check the below checkboxes in order to enable them</span></h3>';
			$html .= '<div class="dcp_metadata">';
			$html .= '<input type="checkbox" id="dcp_author" name="dcp_author" value="yes"> <label for="dcp_author">Author</label>';
			$html .= '<input type="checkbox" id="dcp_comments" name="dcp_comments" value="yes"> <label for="dcp_comments">Comments</label>';
			$html .= '<input type="checkbox" id="dcp_date" name="dcp_date" value="yes"><label for="dcp_date">Date</label>';
			$html .= '</div>';
			$html .= '<h3>Post Title <span class="optional">(optional)</span>: <span class="metainfo">Default H3</span></h3>';
			$html .= '<select id="heading_selector">'; 
				$html .= '<option value="" selected disabled>Choose an option</option>';
				for($i=1; $i<=6; $i++){
					$html .= '<option value="h'.$i.'">H'.$i.'</option>';
				}
			$html .= '</select></br/>';
			$html .= '<h3>Post Content Length <span class="optional">(optional)</span>: <span class="metainfo">Default 120 words</span></h3>';
			$html .= '<input type="number" name="contentlength" id="contentlength" placeholder="Please add numbers only. e.g. 150" min="0" /><br/>';
		$html .= '</div>';
		$html .= '<div class="shortcode">';
			$html .= '<div class="shortcode-warpper">';	
				$html .= '<div class="create_shortcode"><a id="build_shortcode" class="fancy-button">Generate Shortcode</a></div>';
				$html .= '<h3><span class="metainfo"><strong>Note:</strong> Shortcode would get updated by clicking the above button<br/> based on settings given from left panel.</span></h3>';			
				$html .= '<div class="dcp_shortcodeblock"><input type="text" name="name" id="showoption" placeholder="Shortcode will display here..." readonly="readonly" /><span class="dashicons dashicons-clipboard" onclick="copy_clipboard();"></span></div>';
				$html .= '<div><span class="validationError hide">*Please select the Post Type from the dropdown.</span></div>';
				$html .= '<span id="shortalert" class="metainfo">*Please copy above shortcode and paste it on any page.</span>';	
				$html .= '<div class="reset"><a id="reset_settings" class="fancy-button danger">RESET ALL</a></div>';	
				$html .= '<div class="dcp-contact">';
					$html .= '<p>For any customization or additional feature,<br/> please feel free to <a href="https://vikasvatsa.com/contact/?source='.$_SERVER['SERVER_NAME'].'" target="_blank">contact us</a>.</p>';
				$html .= '</div>';	
			$html .= '</div>';	
		$html .= '</div>';
	$html .= '</div>';
	echo $html;
}

/**
 * Function for the Shortcode in order to Display Custom Post  
 */
 
// Add Shortcode

function dcp_show( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'number' => '-1',
			'post_type' => '',
			'layout' => '',
			'columns' => '',
			'orderby' => '',
			'order' => '',
			'type' => '',
			'include' => '',
			'exclude' => '',
			'is_author' => '',
			'is_comments' => '',
			'is_date' => '',
			'title' => '',
			'length' => '',
			'paged' => '',
		), $atts ) 
	);
	
	global $post;

	$html = "";

	// In case if no specific posts are provided, 'post__in' must have empty array
	if($include == '' && $include == null){
		$include = array();
	}else{
		$include = explode(',',$include);
	}

	$my_query = new WP_Query( 
						array(
								'post_type' => $type,
								'posts_per_page' => $number, 
								'orderby' => $orderby, 
								'order' => $order, 
								'post__in' => $include,
								'post__not_in' => explode(',',$exclude),
								'paged' => $paged
							  ));		  

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 

		if($layout == 'dcp-column-grid' || $layout == 'dcp-grid-overlay'){
			$dcp_custom_style = "style='grid-template-columns: repeat(".$columns.", 1fr);'";
		}

		if($layout !== '' && $layout !== NULL){
			$html .= "<div class='dcp-container dcp-grid ". $layout."' $dcp_custom_style>";
		}						  

		if($title == '' || $title == NULL){
			$title = 'h3';
		}

      	if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();

			if($length !== '' && $length !== NULL){
				$dcp_content = get_the_content($post->ID);
				$dcp_strip_content = substr($dcp_content, 0, $length) . '<span class="dots">...</span>';
			}else{
				$dcp_content = get_the_content($post->ID);
				$dcp_strip_content = substr($dcp_content, 0, 120) . '<span class="dots">...</span>';
			}

			if($layout !== '' && $layout !== NULL){
				$html .= "<div class='dcp-post'>";
					$html .= "<div class='dcp-post-wrapper'>";
						$html .= "<div class='dcp-post-thumb'>";
							$html .= "<a href=". esc_url( get_permalink() ) . ">" . get_the_post_thumbnail() . "</a>";
						$html .= "</div>";
						$html .= "<div class='dcp-post-content'>";
							$html .= "<div class='dcp-post-title'><".$title."><a href=". esc_url( get_permalink() ) . ">" . get_the_title() . "</a></".$title."></div>";
							$html .= "<div class='dcp-post-desc'><p>". $dcp_strip_content ."</p></div>";
							$html .= "<div class='dcp-read-more'><a href=". esc_url( get_permalink() ) . " class='read-more button'>Read More</a></div>";

							if( $is_author || $is_comments || $is_date ){
								$html .= "<div class='dcp-post-meta'>";

									if($is_author){
										$html .= "<span class='dcp-post-author'><span>Author:</span> ". get_the_author_link() ."</span>";
									}

									if($is_comments){
										$html .= "<span class='dcp-comment-count'><span>Comments:</span> ". get_comments_number() ."</span>";
									}
									
									if($is_date){
										$html .= "<span class='dcp-post-date'><span>Posted on:</span> ". get_the_date() ."</span>";
									}

								$html .= "</div>";
							}

						$html .= "</div>";
					$html .= "</div>";
				$html .= "</div>";	

			}else{
				$html .= "<div class='custom-post-block'><div class='innerwrapper'>";
				$html .= "<div class='custom-post-thumb'>" . "<a href=". esc_url( get_permalink() ) . ">" . get_the_post_thumbnail() . "</a>" . "</div>";
				$html .= "<h2><a href=". esc_url( get_permalink() ) . ">" . get_the_title() . "</a>";
				$html .= "</h2>";
				$html .= "<div class='custom-post-content'>";
				$html .= "<p>" . get_the_excerpt() . "</p><a href=". esc_url( get_permalink() ) . " class='read-more button'>Read More</a>";
				$html .= "</div></div></div>";	
			}				  
	  

		endwhile; endif;

		if($layout !== '' && $layout !== NULL){
			$html .= "</div>";
		}			

			$big = 9999999999;
			$html .="<div class='custom-post-nav-links'>" . paginate_links( 
				array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $my_query->max_num_pages 
				) ) . "</div>";
		return $html;
}
add_shortcode( 'dcp_show', 'dcp_show' ); 



?>