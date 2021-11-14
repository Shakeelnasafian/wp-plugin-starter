<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Amazing_Dream
 * @subpackage Amazing_Dream/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Amazing_Dream
 * @subpackage Amazing_Dream/admin
 * @author     Your Name <email@example.com>
 */
class Amazing_Dream_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Amazing_Dream       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function save_form_data()
	{
		if(!isset( $_POST['securityNonce']) || ! wp_verify_nonce( $_POST['securityNonce'], 'personalFormData')) :
            wp_die(new WP_Error(
                'invalid_nonce', __('Sorry, I\'m afraid you\'re not authorised to do this.')
            ));
            exit;
        endif;

	
		$my_post = array(
			'post_title'    => wp_strip_all_tags( $_POST['post_title'] ),
			'post_content'  => $_POST['post_content'],
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_category' => array( 8,39 )
		);
   
		// Insert the post into the database
		wp_insert_post( $my_post );
       
        wp_redirect($_POST['_wp_http_referer']);
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Amazing_Dream_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Amazing_Dream_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/amazing-dream-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Amazing_Dream_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Amazing_Dream_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/amazing-dream-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_menu()
    {
        // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        add_menu_page( "Manage Emails", "Emails", 'manage_options', $this->plugin_name . '-emails', array( $this, 'page_email' ));
    }

	public function page_email() {
        include( plugin_dir_path( __FILE__ ) . 'partials/page_email_list.php' );
    }

}
