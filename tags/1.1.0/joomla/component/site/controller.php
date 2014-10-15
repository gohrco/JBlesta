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

// Deny direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once( JPATH_SITE . DIRECTORY_SEPARATOR . 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_jblesta' . DIRECTORY_SEPARATOR . 'jblesta.legacy.php' );


/**
 * JBlesta Controller
 * @desc		This is the base controller for the front end of J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaController extends JblestaControllerExt
{

	/**
	 * Constructor task
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function __construct()
	{
		parent::__construct();
	}



	/**
	 * Display task
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function display()
	{
		$input	=	dunloader( 'input', true );
		
		if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
			//$input->setVar( 'layout', 'default35' );
		}
		
		parent::display();
	}
}