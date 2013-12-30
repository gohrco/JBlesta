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

/**
 * JBlesta Default View
 * @desc		This is the default view handler for the admin area of J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaViewDefault extends JblestaViewExt
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
		$user	= & JFactory::getUser();
		$task	=   JblestaHelper :: get( 'task' );
		
		$doc	=	dunloader( 'document', true );
		load_bootstrap( 'jblesta' );
		
		// Retrieve ACL permitted actions
		$canDo	= JblestaHelper :: getActions();
		
		// Create the toolbar
		JblestaToolbar :: build( 'default', $task, $canDo );
		
		// Grab the icons for the cpanel
		$icons = $this->_getButtons( $canDo );
		
		JblestaHelper :: addMedia( 'icons/css' );
		JblestaHelper :: addMedia( 'ajax/js' );
		
		$this->assignRef('icons',	$icons); // Icon definitions
		
		parent::display($tpl);
	}
	
	
	/**
	 * Method to get the buttons
	 * @access		private
	 * @version		@fileVers@
	 * @param		JObject		- $canDo: object of things user is permitted to do
	 *
	 * @return		array
	 * @since		1.0.0
	 */
	private function _getButtons( $canDo )
	{
		$ret	=	array();
		$api	=	dunloader( 'api', 'com_jblesta' );
		
		if ( $canDo->get( 'core.admin' ) ) {
			$ret[] = $this->_makeIconDefinition( 'apicnxn-48.png', 'COM_JBLESTA_DEFAULT_VIEW_BUTTON_APICONXN', 'apicnxn', null, null, null );
			$ret[] = $this->_makeIconDefinition( 'ajax-loader-48.gif', 'COM_JBLESTA_BUTTON_UPDATESLOADING', 'updates', 'jblesta_icon_updates' );
			
			if ( $api->isEnabled() ) {
				$ret[] = $this->_makeIconDefinition( 'sync-48.png', 'COM_JBLESTA_BUTTON_SETTINGSSYNC', null, null, null, 'settingssync' );
			}
		}
		
		return $ret;
	}
	
	
	/**
	 * Method to create an icon definition
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		$iconFile
	 * @param		string		$label
	 * @param		string		$controller
	 * @param		string		$id				The id tag of the image to use
	 * @param		string		$view
	 * @param		string		$task
	 *
	 * @return		stdClass	object containing elements for rendering the buttons 
	 * @since		1.0.0
	 */
	private function _makeIconDefinition($iconFile, $label, $controller = null, $id = null, $view = null, $task = null )
	{
		$mediapath	= JUri :: root()."media/com_jblesta/icons/";
		
		return (object) array(
				'link'		=> JRoute :: _('index.php?option=com_jblesta' 
								. (! is_null( $controller ) ? '&amp;controller=' . $controller : '' ) 
								. (! is_null( $task ) ? '&amp;task=' . $task : '' )
								. (! is_null( $view ) ? '&amp;view=' . $view : '' )
						),
				'icon'		=> $mediapath . $iconFile,
				'label'		=> JText :: _( $label ),
				'id'		=> (! is_null( $id ) ? $id : str_replace( '.png', '', $iconFile ) )
				);
	}
}