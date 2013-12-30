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

/*-- Security Protocols --*/
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * JBlesta Toolbar class
 * @desc		This class builds our toolbar in the admin area of J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaToolbar extends JObject
{
	/**
	 * Build the toolbar buttons based on permissions
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $controller:  where we are
	 * @param		string		- $task: what we are doing
	 * @param		JObject		- $canDo: contains permissions user has
	 *
	 * @since		1.0.0
	 */
	public function build( $controller, $task = null, $canDo = null )
	{
		switch ( $controller ) {
			case 'default':
				JToolBarHelper :: title( JText::_( 'COM_JBLESTA' ), 'jblesta.png' );
				
				if ( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
					if ( $canDo->get( 'core.admin' ) ) {
						JToolBarHelper :: preferences(	'com_jblesta', '550', '875', 'JToolbar_Options'  );
					}
				}
				else {
					JToolBarHelper :: custom( 'config', 'config.png', '', JText::_( 'COM_JBLESTA_ADMIN_BUTTON_PARAMETERS'), false, false );
				}
	
				break;
				
			case 'apicnxn':
				JToolBarHelper :: title( JText::_( 'COM_JBLESTA_INSTALL_VIEW_APICNXN_TITLE' ), 'apicnxn.png' );
				
				if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
					JToolBarHelper :: custom( 'mainscreen', 'star', 'star', 'J!Blesta', false, false );
				}
				else {
					JToolBarHelper :: custom( 'display', 'jblesta.png', 'jblesta.png', 'J!Blesta', false, false );
				}
			
				break;
				
			case 'updates' :
				
				JToolBarHelper :: title( JText::_("COM_JBLESTA_UPDATES_VIEW_TITLE"), 'updates.png' );
				
				if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
					JToolBarHelper :: custom( 'cpanel', 'star', 'star', 'J!Blesta', false, false );
				}
				else {
					JToolBarHelper :: custom( 'cpanel', 'jblesta.png', 'jblesta.png', 'J!Blesta', false, false );
				}
				
				break;
				
		}
	
	}
	
}