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
 * JBlesta Updates View Handler
 * @desc		This is the view handler for the updates area of the admin area of J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaViewUpdates extends JblestaViewExt
{
	
	/**
	 * Assembles the page for the application to send to user
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$tpl		Internal tpl override option
	 * 
	 * @since		1.0.0
	 */
	function display( $tpl = null )
	{
		$model	=	$this->getModel();
		$data	=	$model->getData( true );
		
		$doc	=	dunloader( 'document', true );
		load_bootstrap( 'jblesta' );
		
		// Retrieve ACL permitted actions
		$canDo	= JblestaHelper :: getActions();
		
		JblestaToolbar :: build( 'updates', null, $canDo );
		
		JblestaHelper :: addMedia( 'common/js' );
		JblestaHelper :: addMedia( 'ajax/js' );
		JblestaHelper :: addMedia( 'icons/css' );
		
		$this->data	= $data;
		
		parent::display($tpl);
	}
	
	
	/**
	 * Displays the proces view
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $tpl: conains the template to overload with
	 * 
	 * return		parent :: display()
	 * @since		1.0.0
	 */
	function process( $tpl = null )
	{
		$this->setLayout( 'process' );
		
		parent::display($tpl);
	}
}