<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Plugin Name: Sample REST API Plugin
 * Plugin URI:
 * Description: Simple image sample plugin
 * Version: 0.1
 * Author: Haris Ainur Rozak
 * Author URI: https://harisrozak.github.io
 */

// define plugin contants
define( 'SRAP_FILE', __FILE__ );
define( 'SRAP_PATH', plugin_dir_path( __FILE__ ) );
define( 'SRAP_URL', plugin_dir_url( __FILE__ ) );

// main class
Class SRAP {
	// instance
	private static $instance;
	
	// getInstance
	public static function getInstance() {
		if( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		// register post type product
		add_action( 'init', array( $this, 'register_post_type' ) );

		// enqueue admin script
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) , 100);

		// admin menu
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}
	
	public function register_post_type() {
        $args = array(
            'labels' => array(
                'name' => 'Products',
                'singular_name' => 'Product',
                'add_new' => 'Add Product',
                'add_new_item' => 'Add Product Item',
                'edit' => 'Edit',
                'edit_item' => 'Edit Product',
                'new_item' => 'New Product',
                'view' => 'View',
                'view_item' => 'View Product',
                'search_items' => 'Search Product',
                'not_found' => 'No Products Found',
                'not_found_in_trash' => 'No Product found in the trash',
                'parent' => 'Parent Product view'
                ),
            'public' => true,            
            'supports' => array( 'editor','title','thumbnail'),            
            'has_archive' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'menu_position' => 5, // places menu item directly below Posts
            'menu_icon' => 'dashicons-image-filter', // image icon
            'taxonomies' => array( 'category' ),
            'show_in_rest' => true,
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        	'rest_base' => 'simple_product',
        );

        register_post_type( 'simple_product', $args );
	}

	public function admin_enqueue_scripts() {
		wp_enqueue_script( 'custom-script-admin', SRAP_URL . 'script-admin.js' );

		// add inline script
		wp_localize_script( 'custom-script-admin', 'wpApiSettings', array(
		    'root' => esc_url_raw( rest_url() ),
		    'nonce' => wp_create_nonce( 'wp_rest' )
		) );
	}

	public function admin_menu() {
	    add_menu_page( 'Sample Page', 'Sample Page', 'administrator', SRAP_PATH . 'admin-page.php', '' );	    
	}
}

SRAP::getInstance();