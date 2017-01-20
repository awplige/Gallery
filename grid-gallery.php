<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
@package New Grid Gallery
Plugin Name: New Grid Gallery 
Plugin URI: http://awplife.com/
Description: Grid gallery plugin with preview for WordPress
Version: 0.1.7
Author: A WP Life
Author URI: http://awplife.com/
Text Domain: GGP_TXTDM
License: GPLv2 or later
Domain Path: /languages
*/

if ( ! class_exists( 'Awl_Grid_Gallery' ) ) {

	class Awl_Grid_Gallery {
		
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}	
		
		protected function _constants() {
			//Plugin Version
			define( 'GG_PLUGIN_VER', '0.1.4' );
			
			//Plugin Text Domain
			define("GGP_TXTDM","awl-grid-gallery" );
 
			//Plugin Name
			define( 'GG_PLUGIN_NAME', __( 'New Grid Gallery', GGP_TXTDM ) );

			//Plugin Slug
			define( 'GG_PLUGIN_SLUG', 'grid_gallery' );

			//Plugin Directory Path
			define( 'GG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			//Plugin Directory URL
			define( 'GG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

			/**
			 * Create a key for the .htaccess secure download link.
			 * @uses    NONCE_KEY     Defined in the WP root config.php
			 */
			define( 'GG_SECURE_KEY', md5( NONCE_KEY ) );
			
		} // end of constructor function
		
		
		/**
		 * Setup the default filters and actions
		 */
		protected function _hooks() {
			
			//Load text domain
			add_action( 'plugins_loaded', array( $this, '_load_textdomain' ) );
			
			//add gallery menu item, change menu filter for multisite
			add_action( 'admin_menu', array( $this, '_Grid_Menu' ), 65 );
			
			//Create grid Gallery Custom Post
			add_action( 'init', array( $this, '_Grid_Gallery' ));
			
			//Add meta box to custom post
			add_action( 'add_meta_boxes', array( $this, '_admin_add_meta_box' ) );
			
			add_action('wp_ajax_grid_gallery_js', array(&$this, '_ajax_grid_gallery'));
		
			add_action('save_post', array(&$this, '_gg_save_settings'));

			//Shortcode Compatibility in Text Widgets
			add_filter('widget_text', 'do_shortcode');

		} // end of hook function
		
		public function _load_textdomain() {
			load_plugin_textdomain( 'GGP_TXTDM', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}
		
		public function _Grid_Menu() {
			$help_menu = add_submenu_page( 'edit.php?post_type='.GG_PLUGIN_SLUG, __( 'Docs', 'GGP_TXTDM' ), __( 'Docs', 'GGP_TXTDM' ), 'administrator', 'sr-doc-page', array( $this, '_gg_doc_page') );
		}
		
		/**
		 * Grid Gallery Custom Post
		 * Create gallery post type in admin dashboard.
		*/
		public function _Grid_Gallery() {
			$labels = array(
				'name'                => _x( 'Grid Gallery', 'Post Type General Name', 'GGP_TXTDM' ),
				'singular_name'       => _x( 'Grid Gallery', 'Post Type Singular Name', 'GGP_TXTDM' ),
				'menu_name'           => __( 'Grid Gallery', 'GGP_TXTDM' ),
				'name_admin_bar'      => __( 'Grid Gallery', 'GGP_TXTDM' ),
				'parent_item_colon'   => __( 'Parent Item:', 'GGP_TXTDM' ),
				'all_items'           => __( 'All Grid Gallery', 'GGP_TXTDM' ),
				'add_new_item'        => __( 'Add Grid Gallery', 'GGP_TXTDM' ),
				'add_new'             => __( 'Add Grid Gallery', 'GGP_TXTDM' ),
				'new_item'            => __( 'Grid Gallery', 'GGP_TXTDM' ),
				'edit_item'           => __( 'Edit Grid Gallery', 'GGP_TXTDM' ),
				'update_item'         => __( 'Update Grid Gallery', 'GGP_TXTDM' ),
				'search_items'        => __( 'Search Grid Gallery', 'GGP_TXTDM' ),
				'not_found'           => __( 'Grid Gallery Not found', 'GGP_TXTDM' ),
				'not_found_in_trash'  => __( 'Grid Gallery Not found in Trash', 'GGP_TXTDM' ),
			);
			$args = array(
				'label'               => __( 'Grid Gallery', 'GGP_TXTDM' ),
				'description'         => __( 'Custom Post Type For Grid Gallery', 'GGP_TXTDM' ),
				'labels'              => $labels,
				'supports'            => array( 'title'),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 65,
				'menu_icon'           => 'dashicons-grid-view',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,		
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);
			register_post_type( 'grid_gallery', $args );
			
		} // end of post type function
		
		/**
		 * Adds Meta Boxes
		*/
		public function _admin_add_meta_box() {
			// Syntax: add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
			add_meta_box( '', __('Add Image', GGP_TXTDM), array(&$this, 'gg_upload_multiple_images'), 'grid_gallery', 'normal', 'default' );
		}
		
		public function gg_upload_multiple_images($post) { 
			wp_enqueue_script('media-upload');
			wp_enqueue_script('awl-gg-uploader.js', GG_PLUGIN_URL . 'js/awl-gg-uploader.js', array('jquery'));
			wp_enqueue_style('awl-gg-uploader-css', GG_PLUGIN_URL . 'css/awl-gg-uploader.css');
			wp_enqueue_media();			
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'awl-gg-color-picker-js', plugins_url('js/gg-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
			?>
			<div id="slider-gallery">
				<input type="button" id="remove-all-slides" name="remove-all-slides" class="button button-large remove-all-slides" rel="" value="<?php _e('Delete All Images', GGP_TXTDM); ?>">
				<ul id="remove-slides" class="sbox">
				<?php
				$allimagesetting = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_gg_settings_'.$post->ID, true)));
				if(isset($allimagesetting['slide-ids'])) {
					$count = 0;
					foreach($allimagesetting['slide-ids'] as $id) {
						$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
						$attachment = get_post( $id );
						//$image_link = $allimagesetting['slide-link'][$count];
						?>
						<li class="slide">
							<img class="new-slide" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
							<input type="hidden" id="slide-ids[]" name="slide-ids[]" value="<?php echo $id; ?>" />
							<!-- Image Title, Caption, Alt Text, Description-->
							<input type="text" name="slide-title[]" id="slide-title[]" style="width: 100%;" placeholder="Image Title" value="<?php echo get_the_title($id); ?>">
							<input type="button" name="remove-slide" id="remove-slide" class="button remove-single-slide button-danger" style="width: 100%;" value="Delete">
						</li>
						<?php $count++; 
					} // end of foreach
				} //end of if
				?>
				</ul>
			</div>
			
			<!--Add New Image Button-->
			<div name="add-new-slider" id="add-new-slider" class="new-slider" style="height: 200px; width: 205px; border-radius: 20px;">
				<div class="menu-icon dashicons dashicons-format-image"></div>
				<div class="add-text"><?php _e('Add Image', GGP_TXTDM); ?></div>
			</div>
			<div style="clear:left;"></div>
			<br>
			<br>
			<h1><?php _e('Copy Grid Gallery Shortcode', GGP_TXTDM); ?></h1>
			<hr>
			<p class="input-text-wrap">
				<p><?php _e('Copy & Embed shotcode into any Page/ Post / Text Widget to display your grid gallery on site.', GGP_TXTDM); ?><br></p>
				<input type="text" name="shortcode" id="shortcode" value="<?php echo "[GGAL id=".$post->ID."]"; ?>" readonly style="height: 60px; text-align: center; font-size: 24px; width: 25%; border: 2px dashed;" onmouseover="return pulseOff();" onmouseout="return pulseStart();">
			</p>
			<br>
			<br>
			<h1><?php _e('Grid Gallery Setting', GGP_TXTDM); ?></h1>
			<hr>
			<?php
			require_once('grid-gallery-settings.php');
		
		} // end of upload multiple image
	
		public function _gg_ajax_callback_function($id) {
			//thumb, thumbnail, medium, large, post-thumbnail
			$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
			$attachment = get_post( $id ); // $id = attachment id
			?>
			<li class="slide">
				<img class="new-slide" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
				<input type="hidden" id="slide-ids[]" name="slide-ids[]" value="<?php echo $id; ?>" />
				<input type="text" name="slide-title[]" id="slide-title[]" style="width: 100%;" placeholder="Image Title" value="<?php echo get_the_title($id); ?>">
				<input type="button" name="remove-slide" id="remove-slide" style="width: 100%;" class="button" value="Delete">
			</li>
			<?php
		}
		
		public function _ajax_grid_gallery() {
			echo $this->_gg_ajax_callback_function($_POST['slideId']);
			die;
		}
		
		public function _gg_save_settings($post_id) {
			if(isset($_POST['gg_save_nonce'])) {
				if ( !isset( $_POST['gg_save_nonce'] ) || !wp_verify_nonce( $_POST['gg_save_nonce'], 'gg_save_settings' ) ) {
				   print 'Sorry, your nonce did not verify.';
				   exit;
				} else {
					//update image title & description
					$image_ids = $_POST['slide-ids'];
					$image_titles = $_POST['slide-title'];

					$i = 0;
					foreach($image_ids as $image_id) {
						$single_image_update = array(
							'ID'           => $image_id,
							'post_title'   => $image_titles[$i],
						);
						wp_update_post( $single_image_update );
						$i++;
					}				
					$awl_grid_gallery_shortcode_setting = "awl_gg_settings_".$post_id;
					update_post_meta($post_id, $awl_grid_gallery_shortcode_setting, base64_encode(serialize($_POST)));
				}
			}
		}// end save setting

		/**
		 * Grid Gallery Docs Page
		 * Create doc page to help user to setup plugin
		 */
		public function _gg_doc_page() {
			require_once('docs.php');
		}
	
	} // end of class

	/**
	 * Instantiates the Class
	 */
	$gg_gallery_object = new Awl_Grid_Gallery();
	require_once('grid-gallery-shortcode.php');
} // end of class exists
?>