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
 * JBlesta Default Model
 * @desc		This class is used by Dunamis to initialise J!Blesta for Joomla
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaModelDefault extends JblestaModelExt
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
	 * Method to synchronize settings with WHMCS
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string on error or true on success
	 * @since		1.0.0
	 */
	public function settingssync()
	{
		$api	=	dunloader( 'api', 'com_jblesta' );
		$config	=	dunloader( 'config', 'com_jblesta' );
		
		// Verify API is enabled and working
		if (! $api->isEnabled() ) {
			return 'APIDISABLED';
		}
		
		$data	=	array(
				'enable'				=>	$config->get( 'enable' ),
				'debug'					=>	$config->get( 'debug' ),
				'token'					=>	$config->get( 'token' ),
				'enableuserbridging'	=>	$config->get( 'enableuserbridging' ),
				'languageenable'		=>	$config->get( 'languageenable' ),
				'regmethod'				=>	$config->get( 'regmethod' )
				);
		
		if (! $api->updatesettings( $data ) ) {
			return 'APIERROR';
		}
		
		return true;
	}
}