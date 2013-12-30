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
 * JBlestaController
 * @desc		This is the base controller for J!Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaController extends AppController
{
	
	/**
	 * This ensures that Dunamis and J!Blesta get initialized on the front end
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	protected function init()
	{
		// Get and require file
		$path	=	PLUGINDIR . 'dunamis' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'dunamis.php';
		require_once $path;
		
		// Initialize Dunamis
		if (! function_exists( 'get_dunamis' ) ) {
			$this->Input->setErrors( array( 'dunamis'=> array( 'message' => 'Unable to locate the Dunamis Framework - check that it is installed properly') ) );
		}
		
		get_dunamis( 'jblesta' );
	}
	
	
	/**
	 * Preaction hook point
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function preAction()
	{
		if ( strtolower( $this->action ) == "fixfile") {
			Configure::set("Blesta.verify_csrf_token", false);
		}
		
		parent::preAction();
		
		get_dunamis( 'jblesta' );
		
	}
}