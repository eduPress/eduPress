<?php



class ED_Admin{

	/** Directory *************************************************************/

	/**
	 * @var string Path to the eduPress admin directory
	 */
	public $admin_dir = '';

	/** URLs ******************************************************************/

	/**
	 * @var string URL to the eduPress admin directory
	 */
	public $admin_url = '';

	/**
	 * @var string URL to the eduPress images directory
	 */
	public $images_url = '';

	/**
	 * @var string URL to the eduPress admin styles directory
	 */
	public $styles_url = '';

	/**
	 * @var string URL to the eduPress admin css directory
	 */
	public $css_url = '';

	/**
	 * @var string URL to the eduPress admin js directory
	 */
	public $js_url = '';

	/** Capability ************************************************************/

	/**
	 * @var bool Minimum capability to access Tools and Settings
	 */
	public $minimum_capability = 'keep_gate';

	/** Separator *************************************************************/

	/**
	 * @var bool Whether or not to add an extra top level menu separator
	 */
	public $show_separator = false;

	/** Functions *************************************************************/

	/**
	 * The main eduPress admin loader
	 *
	 * @since eduPress
	 *
	 * @uses ED_Admin::setup_globals() Setup the globals needed
	 * @uses ED_Admin::includes() Include the required files
	 */
	public function __construct() {
		$this->setup_globals();
		$this->includes();
	}

	/**
	 * Admin globals
	 *
	 * @since eduPress
	 * @access private
	 */
	private function setup_globals() {
		$ED = instance();
		$this->admin_dir  = trailingslashit( $edp->admin_dir ); // Admin path
		$this->admin_url  = trailingslashit( $edp->admin_url  ); // Admin url
		$this->images_url = trailingslashit( $this->admin_url   . 'images' ); // Admin images URL
		$this->styles_url = trailingslashit( $this->admin_url   . 'styles' ); // Admin styles URL
		$this->css_url    = trailingslashit( $this->admin_url   . 'css'    ); // Admin css URL
		$this->js_url     = trailingslashit( $this->admin_url   . 'js'     ); // Admin js URL
	}

	/**
	 * Include required files
	 *
	 * @since eduPress
	 * @access private
	 */
	private function includes() {
		require( $this->admin_dir . 'courses.php'   );
		require( $this->admin_dir . 'actions.php'   );
	}


}

