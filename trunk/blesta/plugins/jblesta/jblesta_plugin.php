<?php
/**
 * -------------------------------------------
 * @packageName@
 * -------------------------------------------
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @packageAuth@
 * @link            @packageLink@
 * @copyright       @packageCopy@
 * @license         @packageLice@
 */


/**
 * JBlestaPlugin
 * @desc		This is the plugin file for J!Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaPlugin extends Plugin
{
	
	/**
	 * Constructor Method
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function __construct()
	{
		Loader :: loadComponents( $this, array( 'Input' ) );
	}
	
	
	/**
	 * Method to get events attachable to the framework
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return      array		an array of arrays containing event / callback pairs
	 * @since		1.0.0
	 */
	public function getEvents()
	{
		return
			array(
				array(
						'event' => "Appcontroller.preAction",
						'callback' => array("this", "preaction" )
				)
				// Add multiple events here
		);
	}
	
	
	/**
	 * Method to get the logo of the plugin
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string			Contains the path to the logo
	 * @since		1.0.0
	 */
	public function getLogo()
	{
		return	'assets' . DIRECTORY_SEPARATOR .
				'logo.png';
	}
	
	
	/**
	 * Method to get the name of the plugin
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string			Indicating the name of the product
	 * @since		1.0.0
	 */
	public function getName()
	{
		return "J!Blesta";
	}
	
	
	/**
	 * Method to get the version of the product
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string			Indicating the version of the product
	 * @since		1.0.0
	 */
	public function getVersion()
	{
		return '@fileVers@';
	}
	
	
	/**
	 * Method to get the authors of the product
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		array			Containing the name and URL of the authors  
	 * @since		1.0.0
	 */
	public function getAuthors()
	{
		return
			array(
				array(
						'name'	=>	'@packageAuth@',
						'url'	=>	'@packageLink@'
				)
		);
	}
	
	
	/**
	 * Method to handle any install tasks
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$plugin_id		The plugin id we are assigned
	 *
	 * @since		1.0.0
	 */
	public function install( $plugin_id )
	{
		echo 'line 136 Hi'; die();
		// Test for Dunamis is installed and active
		if (! function_exists( 'get_dunamis' ) || ( defined( 'DUN_ENV' ) && DUN_ENV != 'BLESTA' ) || ( function_exists( 'is_enabled_on_blesta' ) && ! is_enabled_on_blesta() ) ) {
			$this->Input->setErrors(
					array(
						'install' => array(
							'invalid' => "Dunamis not found or not installed."
					)
				)
			);
			return;
		}
		
		get_dunamis( 'jblesta' );
		$module = dunmodule( 'jblesta.install' );
		$module->install();
	}
	
	
	/**
	 * Preaction event
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function preaction()
	{
		
		if (! function_exists( 'dunmodule' ) ) {
			$path	=	PLUGINDIR . 'dunamis' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'dunamis.php';
			
			if (! file_exists( $path ) ) {
				return;
			}
			
			include_once $path;
		}
		
		// Assume if this function doesnt exist the plugin isnt loading
		if (! function_exists( 'is_ajax' ) ) {
			return;
		}
		
		// Ensure we aren't in an ajax request 
		if (! is_ajax() ) {
			
			$d = get_dunamis('jblesta');
			
			// Run front end stuff
			if (! is_admin() ) {
				dunloader( 'actions', 'jblesta' )->preaction();
				dunmodule( 'jblesta.render' )->execute();
			}
			else {
				dunloader( 'actions', 'jblesta' )->adminpreaction();
			}
		}
		else {
			// We have 1 ajax catch to make
			if ( is_admin() ) {
				get_dunamis('jblesta');
				dunloader( 'actions', 'jblesta' )->adminajaxpreaction();
			}
		}
	}
	
	
	/**
	 * Method to handle any uninstall tasks
	 * @access		public
	 * @version		1.0.0
	 * @param		string		$plugin_id		The plugin id we are assigned
	 * @param		boolean		$last_instance	Indicates this it the last instance of our plugin
	 *
	 * @since		1.0.0
	 */
	public function uninstall( $plugin_id, $last_instance )
	{
		// Test for Dunamis is installed and active
		if (! function_exists( 'get_dunamis' ) || ( defined( 'DUN_ENV' ) && DUN_ENV != 'BLESTA' ) || ( function_exists( 'is_enabled_on_blesta' ) && ! is_enabled_on_blesta() ) ) {
			$this->Input->setErrors(
					array(
							'uninstall' => array(
									'invalid' => "Dunamis not found or not installed - you must reinstall before uninstalling J!Blesta."
							)
					)
			);
			return;
		}
		
		get_dunamis( 'jblesta' );
		$module =	dunmodule( 'jblesta.install' );
		$result	=	$module->uninstall();
		
		if (! $result ) {
			foreach ( $module->getErrors() as $error ) {
				$this->Input->setErrors(
						array(
								'uninstall' => array(
										'fileerrors' => $error
								)
						)
				);
			}
		}
	}
	
	
	/**
	 * Method to handle any upgrade tasks
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$current_version	The currently installed version of Dunamis
	 * @param		string		$plugin_id			The plugin id we are assigned
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function upgrade( $current_version, $plugin_id )
	{
		
	}
}