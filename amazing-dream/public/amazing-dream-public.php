<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Amazing_Dream
 * @subpackage Amazing_Dream/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Amazing_Dream
 * @subpackage Amazing_Dream/public
 * @author     Your Name <email@example.com>
 */
class Amazing_Dream_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode('formShortCode', array($this,'createFrom'));
	}

	
	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/amazing-dream-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/amazing-dream-public.js', array( 'jquery' ), $this->version, false );

	}

	public function createFrom()
	{
		return '<form action="'.admin_url( 'admin-post.php' ).'" method="post">
				<input type="hidden" name="action" value="front_end_form">
				<label for="fname">Post Title:</label>
				<input type="text" id="fname" name="post_title"><br><br>
				<label for="lname">Post Content:</label>
				<textarea name="post_content" rows="10" cols="30">
            
            	</textarea>
				<br><br>
				'.wp_nonce_field('personalFormData', 'securityNonce').'
				<input type="submit" value="Submit">
			</form>';

	}//function ends


	public function saveFrontEndForm()
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

	}//function ends

}
