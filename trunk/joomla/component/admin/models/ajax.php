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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );


/**
 * JBlesta Ajax Model
 * @desc		This class is used to handle ajax model data manipulations
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaModelAjax extends JblestaModelExt
{
	/**
	 * Constructor method
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
	 * Method to check the api connection
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array
	 * @since		1.0.0
	 */
	public function apicnxncheck()
	{
		$data			=	array( 'result' => 'error' );
		$input			=	dunloader( 'input', true );
		$config			=	dunloader( 'config', 'com_jblesta' );
		$blestaurl		=	$input->getVar( 'blestaapiurl', null );
		
		// No URL yet
		if ( empty( $blestaurl ) ) {
			$data['message']	=	'No URL entered';
			$data['helpful']	=	JText :: _( 'COM_JBLESTA_APICNXN_HELP_NOURL' );
			return $data;
		}
		
		// Be sure to urldecode the variables
		$blestaapiusername	=	$input->getVar( 'blestaapiusername', null );
		$blestaapikey		=	$input->getVar( 'blestaapikey', null );
		$blestaapiurl		=	$input->getVar( 'blestaapiurl', null );
		
		// If the accesskey should be empty, set it to null
		if (! $blestaapiaccesskey ) $blestaapiaccesskey = null;
		
		// If there wasn't a username or password then don't continue
		if ((! $blestaapiusername ) || (! $blestaapikey ) ) {
			$data['message']	= "Please enter a " . ((! $blestaapiusername ) ? "API Username" : "API Key" );
			$data['helpful']	=	JText :: _( 'COM_JBLESTA_APICNXN_HELP_NO' . (! $blestaapiusername ? 'USER' : 'KEY' ) );
			return $data;
		}
		
		$config->set( 'blestaapiurl', $blestaurl );
		$config->set( 'blestaapiusername', $blestaapiusername );
		$config->set( 'blestaapikey', $blestaapikey );
		
		$api	=	dunloader( 'api', 'com_jblesta', array( 'force' => true ) );
		
		if ( $api->hasErrors() ) {
			$data['message']	=	$api->getError();
			$data['helpful']	=	JText :: _( 'COM_JBLESTA_APICNXN_HELP_ER' . $api->getErrorcode() );
			return $data;
		}
		
		if ( ( $msg = $config->save() ) !== true ) {
			$data['message']	=	$msg;
			$data['helpful']	=	JText :: _( 'COM_JBLESTA_APICNXN_HELP_DBERR' );
			return $data;
		}
		
		$data['result']		=	'success';
		$data['message']	=	'Successfully connected!';
		$data['helpful']	=	JText :: _( 'COM_JBLESTA_APICNXN_HELP_SAVED' );
		return $data;
	}
}

?>