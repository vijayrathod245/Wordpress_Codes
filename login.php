<?php
/**
 * Plugin Name:       Login
 * Plugin URI:        https://wordpress.org
 * Description:       Login
 * Version:           1.10.3
 * Author:            Test
 * Author URI:        #
 * License:           #
 * License URI:       #
 * Text Domain:       login
 * Domain Path:       /languages
 */

/*
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

define('SP_TEXTDOMAIN', 'login');
define('SP_DIR', plugin_dir_url( __FILE__ ));

/*
 *Create a class called "Login" if it doesn't already exist
 */
if ( !class_exists( 'Login' ) ) {

	Class Login{
		
		public function __construct() {
			add_action('init', array($this, 'sch_check_notice'));
			add_action('wp_enqueue_scripts', array($this, 'login_style_scripts'));
			add_shortcode('login_shortcode', array( $this, 'login_shortcode_fn'));
			// Add a link to the plugin's settings in the plugins list table.
			add_filter( 'plugin_action_links', array( __CLASS__, 'add_settings_link' ), 10, 2 );
		}
			/**
		 * Add a link to the settings on the Plugins screen.
		 */
		public static function add_settings_link( $links, $file ) {
			
			if ( $file === 'login/login.php' && current_user_can( 'manage_options' ) ) {
				if ( current_filter() === 'plugin_action_links' ) {
					$url = admin_url( 'admin.php?page=login' );
				}
				// Prevent warnings in PHP 7.0+ when a plugin uses this filter incorrectly.
				$links = (array) $links;
				$links[] = sprintf( '<a href="%s">%s</a>', $url, __( 'Settings', 'login' ) );
			}

			return $links;
		}
		
		public function sch_check_notice() {
			add_action( 'admin_menu', array($this, 'sph_layouts_menu'), 100);
		}
		public function sph_layouts_menu(){	
	 	 add_menu_page( 
				'Login', 
				'Login', 
				'manage_options', 
				'login', 'login', 
				'dashicons-businessman', 90 );
		 add_submenu_page(
        'login',
        'Add New Login', //page title
        'Student Login', //menu title
        'manage_options', //capability,
        'add-login',//menu slug
        'login' //callback function
    );
			/**
			*@return html Display
			*/
			function login(){
				include_once('includes/login_layout.php');	
			}
		}
		
		function login_shortcode_fn( $attributes ) {?>
					<div class="login-btn-item">
						<ul>
							<li><a href="http://localhost/test_plugin/wp-content/plugins/login/includes/user.php">User</a></li>
							<li><a href="http://localhost/test_plugin/wp-content/plugins/login/includes/student.php">Student</a></li>
							<li><a href="http://localhost/test_plugin/wp-content/plugins/login/includes/teacher.php">Teacher</a></li>
							<li><a href="http://localhost/test_plugin/wp-content/plugins/login/includes/staff.php">Staff</a></li>
						</ul>
					</div>
		<?php }
		
		public function login_style_scripts(){
			  wp_enqueue_style( 'custom_style', SP_DIR. 'assets/css/custom_style.css',array());
		}
	}
}	
/*
 * Created new object of the Login.
 */
new Login();