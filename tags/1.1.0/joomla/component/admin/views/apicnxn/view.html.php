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

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
jimport( 'joomla.application.component.helper' );

/**
 * JBlesta API Connection View
 * @desc		This is the view handler for the API Connection area of J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaViewApicnxn extends JblestaViewExt
{
	
	/**
	 * Assembles the page for the application to send to user
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$tpl		Internal tpl override option
	 * 
	 * @since		1.0.0
	 */
	public function display($tpl = null)
	{
		$doc	=	dunloader( 'document', true );
		load_bootstrap( 'jblesta' );
		
		$params	=	JComponentHelper :: getParams( 'com_jblesta' );
		$data	=	new stdClass();
		
		foreach ( array( 'blestaapiurl', 'blestaapiusername', 'blestaapikey' ) as $item ) {
			$data->$item = $params->get( $item );
		}
		
		JblestaToolbar :: build( 'apicnxn' );
		
		if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
			JblestaHelper :: addMedia( 'bootstrap/css' );
		}
		
		JblestaHelper :: addMedia( 'common/js' );
		JblestaHelper :: addMedia( 'ajax/js' );
		JblestaHelper :: addMedia( 'icons/css' );
		
		$this->assignRef( 'data', $data );
		parent :: display( $tpl );
	}
}