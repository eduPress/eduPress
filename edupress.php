<?php

/**
 * The eduPress Plugin
 *
 * eduPress is EAD software from the creators of WordPress.
 *
 * @package eduPress
 * @subpackage Main
 */

/**
 * Plugin Name: eduPress
 * Plugin URI:  https://github.com/eduPress/eduPress
 * Description: eduPress is EAD software from the creators of WordPress.
 * Author:      Francisco Rodrigo Cunha de Sousa
 * Author URI:  http://rodrigosousa.info
 * Version:     1.0.0
 * Text Domain: edupress
 * Domain Path: /languages/
 */

// Sai se for acessado diretamente
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'eduPress' ) ) :




/**
 * Main eduPress Class
 *
 * "How doth the little busy bee, improve each shining hour..."
 *
 * @since eduPress
 */
final class edupress{

/**
	 * eduPress uses many variables, several of which can be filtered to
	 * customize the way it operates. Most of these variables are stored in a
	 * private array that gets updated with the help of PHP magic methods.
	 *
	 * This is a precautionary measure, to avoid potential errors produced by
	 * unanticipated direct manipulation of edupress's run-time data.
	 *
	 * @see eduPress::setup_globals()
	 * @var array
	 */
	private $data;

	/**
	 * @var mixed False when not logged in; WP_User object when logged in
	 */
	public $current_user = false;

	/**
	 * @var array Topic views
	 */
	public $views        = array();

	/**
	 * @var array Overloads get_option()
	 */
	public $options      = array();

	/**
	 * @var array Overloads get_user_meta()
	 */
	public $user_options = array();

	/**
	 * Main eduPress Instance
	 *
	 * euPress is fun
	 * Please load it only one time
	 * For this, we thank you
	 *
	 * Insures that only one instance of eduPress exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since eduPress
	 * @staticvar object $instance
	 * @uses eduPress::setup_globals() Setup the globals needed
	 * @uses eduPress::includes() Include the required files
	 * @uses eduPress::setup_actions() Setup the hooks and actions
	 * @see edupress()
	 * @return The one true eduPress
	 */
	public static function instance() {

		// Store the instance locally to avoid private static replication
		static $instance = null;

		// Only run these methods if they haven't been ran previously
		if ( null === $instance ) :
			$instance = new eduPress;
			$instance->setup_globals();
			$instance->includes();
			$instance->setup_actions();
		endif;

		// Always return the instance
		return $instance;
	}

	/** Magic Methods *********************************************************/

	/**
	 * A dummy constructor to prevent eduPress from being loaded more than once.
	 *
	 * @since eduPress
	 * @see eduPress::instance()
	 * @see edupress();
	 */
	private function __construct() {
		/* Do nothing here */ 
	}

	/**
	 * A dummy magic method to prevent eduPress from being cloned
	 *
	 * @since eduPress
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'edupress' ), '1.0' );
	}

	/**
	 * A dummy magic method to prevent eduPress from being unserialized
	 *
	 * @since eduPress
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'edupress' ), '1.0' );
	}

	/**
	 * Magic method for checking the existence of a certain custom field
	 *
	 * @since eduPress
	 */
	public function __isset( $key ) {
		return isset( $this->data[$key] );
	}

	/**
	 * Magic method for getting eduPress variables
	 *
	 * @since eduPress
	 */
	public function __get( $key ) {
		return isset( $this->data[$key] ) ? $this->data[$key] : null;
	}

	/**
	 * Magic method for setting eduPress variables
	 *
	 * @since eduPress
	 */
	public function __set( $key, $value ) {
		$this->data[$key] = $value;
	}

	/**
	 * Magic method for unsetting eduPress variables
	 *
	 * @since eduPress
	 */
	public function __unset( $key ) {
		if ( isset( $this->data[$key] ) ) unset( $this->data[$key] );
	}

	/**
	 * Magic method to prevent notices and errors from invalid method calls
	 *
	 * @since eduPress
	 */
	public function __call( $name = '', $args = array() ) {
		unset( $name, $args ); return null;
	}

	/** Private Methods *******************************************************/

	/**
	 * Set some smart defaults to class variables. Allow some of them to be
	 * filtered to allow for early overriding.
	 *
	 * @since eduPress (r2626)
	 * @access private
	 * @uses plugin_dir_path() To generate eduPress plugin path
	 * @uses plugin_dir_url() To generate eduPress plugin url
	 * @uses apply_filters() Calls various filters
	 */
	private function setup_globals() {

/*****
Nesta sessão, cada propriedade é setada em um filtro do wp e passa uma tag para o filtro e um valor, que também é passado por funções nativas do wp. como trailingslashit() que insere uma barra no final de urls.
*****/

		/** Versions **********************************************************/

		$this->version    = '1.0.1';
		$this->db_version = '1';

		/** Paths *************************************************************/

		// Setup some base path and URL information
		$this->file       = __FILE__;
		$this->basename   = apply_filters( 'edup_plugin_basenname', plugin_basename( $this->file ) );
		$this->plugin_dir = apply_filters( 'edup_plugin_dir_path',  plugin_dir_path( $this->file ) );
		$this->plugin_url = apply_filters( 'edup_plugin_dir_url',   plugin_dir_url ( $this->file ) );

		// Core
		$this->core_dir = apply_filters( 'edup_core_dir', trailingslashit( $this->plugin_dir . 'core'  ) );
		$this->core_url = apply_filters( 'edup_core_url', trailingslashit( $this->plugin_url . 'core'  ) );

		// Admin
		$this->admin_dir = apply_filters( 'edup_admin_dir', trailingslashit( $this->plugin_dir . 'admin'  ) );
		$this->admin_url = apply_filters( 'edup_admin_url', trailingslashit( $this->plugin_url . 'admin'  ) );

		// Templates
		$this->templates_dir   = apply_filters( 'edup_templates_dir',   trailingslashit( $this->plugin_dir . 'template' ) );
		$this->templates_url   = apply_filters( 'edup_ttemplates_url',   trailingslashit( $this->plugin_url . 'template' ) );

		/** Users *************************************************************/

		$this->current_user   = new WP_User(); // Currently logged in user
		$this->displayed_user = new WP_User(); // Currently displayed user

		/** Misc **************************************************************/

		$this->domain         = 'edupress';     // Unique identifier for retrieving translated strings
		$this->extend         = new stdClass(); // Plugins add data here
		$this->errors         = new WP_Error(); // Feedback
		$this->tab_index      = apply_filters( 'edup_default_tab_index', 100 );
	}

	/**
	 * Include required files
	 *
	 * @since eduPress
	 * @access private
	 * @uses is_admin() If in WordPress admin, load additional file
	 */
	private function includes() {

		/** Core **************************************************************/

		require( $this->core_dir . 'functions.php'          );
		require( $this->core_dir . 'options.php'            );
		require( $this->core_dir . 'template.php'           );
		require( $this->core_dir . 'actions.php'            );
		require( $this->core_dir . 'filters.php'            );

		/** Admin *************************************************************/

		// Quick admin check and load if needed
		if ( is_admin() ) {
			require( $this->admin_dir . 'admin.php'   );
			$admin = new ED_Admin();
		}
	}

	/**
	 * Setup the default hooks and actions
	 *
	 * @since eduPress (r2644)
	 * @access private
	 * @uses add_action() To add various actions
	 */
	private function setup_actions() {

		// Add actions to plugin activation and deactivation hooks
		add_action( 'activate_'   . $this->basename, 'edup_activation'   );
		add_action( 'deactivate_' . $this->basename, 'edup_deactivation' );
	}

	function load_class($class=NULL, $name=NULL, $instance=TRUE){
		$CI =& edupress::instance();
		if ( is_array($class) ):
			foreach ($class as $k => $v):
				eval("\$".$k." = \"".$v."\";");
			endforeach;
		endif;
		if ( ! class_exists('ED_'.$class) ):
			$file = NULL;
			if ( file_exists( $this->core_dir . $class . '.php' ) ):
				$file = $this->core_dir . $class . '.php';
			elseif ( file_exists( $this->admin_dir . $class . '.php' ) ):
				$file = $this->admin_dir . $class . '.php';
			elseif ( file_exists( $this->templates_dir . $class . '.php') ):
				$file = $this->templates_dir . $class . '.php';
			else:
				return FALSE;
			endif;
		else:
			return FALSE;
		endif;
		if ( $class != NULL ):
			require( $file );
			if ( $name == NULL ) $name = $class;
			$class = 'ED_'.ucfirst( $class );
			if ( $instance ):
				$this->$name = new $class();
				return TRUE;
			endif;
		endif;
	}


}

/**
 * The main function responsible for returning the one true eduPress Instance
 * to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $edup = edupress(); ?>
 *
 * @return The one true eduPress Instance
 */
function instance() {
	return edupress::instance();
}

/**
 * Hook eduPress early onto the 'plugins_loaded' action.
 *
 * This gives all other plugins the chance to load before eduPress, to get their
 * actions, filters, and overrides setup without eduPress being in the way.
 */
if ( defined( 'EDUPRESS_LATE_LOAD' ) ):
	add_action( 'plugins_loaded', 'edupress', (int) EDUPRESS_LATE_LOAD );

// "And now here's something we hope you'll really like!"
else:
	instance();
endif;





endif; // class_exists check