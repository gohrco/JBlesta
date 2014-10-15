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

/**
 * JblestaControllerApicnxn class is the task handler for the api connection checker in the admin area
 * @version		@fileVers@
 *
 * @since		1.0.0
 * @author		Steven
 */
class JblestaControllerApicnxn extends JblestaControllerExt
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
	 * @see			JblestaController :: display()
	 */
	public function display()
	{
		$input	=	dunloader( 'input', true );
		$input->setVar( 'view', 'apicnxn' );
		
		if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
			$input->setVar( 'layout', 'default35' );
		}

		parent::display();
	}
	
	
	/**
	 * Task to return user to main screen of JBLESTA
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function mainscreen()
	{
		$this->setRedirect( 'index.php?option=com_jblesta&controller=default' );
		$this->redirect();
	}
}