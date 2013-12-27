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
 * JblestaControllerDefault class is the default task handler for the admin area
 * @version		@fileVers@
 *
 * @since		1.0.0
 * @author		Steven
 */
class JblestaControllerDefault extends JblestaControllerExt
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
		
		
// 		$this->registerTask( 'cpanel',	'display' );
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
		$input->setVar( 'view', 'default' );
		
		if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
// 			$input->setVar( 'layout', 'default35' );
// 			JblestaHelper :: set( 'view', 'default' );
// 			JblestaHelper :: set( 'layout', 'default35' );
		}

		parent::display();
	}
	
	
	/**
	 * Task to sync settings to WHMCS
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function settingssync()
	{
		$app	=	JFactory :: getApplication();
		$model	=   $this->getModel( 'default' );
		$result	=	$model->settingssync();
		
		if ( $result === true ) {
			$type	=	'message';
			$msg	=	JText :: _( 'COM_JBLESTA_SETTINGSSYNC_DONE' );
		}
		// Assume string returns are error messages
		else {
			$type	=	'error';
			$msg	=	JText :: _( 'COM_JBLESTA_SETTINGSSYNC_' . $result );
		}
		
		$this->setRedirect( 'index.php?option=com_jblesta', $msg, $type )
				->redirect();
	}
}