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
 * JBlesta Logout Controller
 * @desc		This class is called up directly when logging out from Joomla
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Logout extends JblestaController
{
	
	/**
	 * Method for logging a user out
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function index()
	{
		// Initialize Dunamis!
		$this->init();
		$this->uses(array("Users"));
		
		// log user out
		$this->Users->logout( $this->Session );
		
		$input	=	dunloader( 'input', true );
		$return	=	base64_decode( $input->getVar( 'jblesta', null ) );
		
		$this->redirect( $return );
	}
}
?>