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
 * @desc		This class renders the default view back to Blesta
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
	 * Builds the view from the display task for the user
	 * @access		public
	 * @version		@fileVers@
	 * @param 		string			presumably a template name never used
	 * 
	 * @since		1.0.0
	 */
	public function display($tpl = null)
	{
		$app		=	JFactory::getApplication();
		$params		=	$app->getParams();
		
		$this->assignRef('params',	$params);
		parent :: display( $tpl );
	}
}