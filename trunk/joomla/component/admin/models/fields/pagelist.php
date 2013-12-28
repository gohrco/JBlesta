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

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');


// -------------------------------------------------------
// Ensure we have Dunamis and it's loaded
if (! function_exists( 'get_dunamis' ) ) {
	$path	= dirname( dirname( dirname( dirname( dirname( dirname(__FILE__) ) ) ) ) ) . DS . 'libraries' . DS . 'dunamis' . DS . 'dunamis.php';
	if ( file_exists( $path ) ) require_once( $path );
}

if (! function_exists( 'get_dunamis' ) ) {
	// EPIC FAILURE HERE
	return;
}

get_dunamis( 'com_jblesta' );

/**
 * JBlesta Page List Field
 * @desc		This class retrieves a list of pages that can be used for menu items in Joomla
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JFormFieldPageList extends JFormFieldList
{
	/**
	 * Our field name type
	 * @access		public
	 * @var			string
	 * @since		2.5.0
	 */
	public $_name		= 'PageList';
	
	
	/**
	 * Method to fetch the options for the element
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * 
	 * @return		array of objects
	 * @since		1.0.0
	 */
	protected function getOptions()
	{
		static $options	= null;
		
		if ( $options == null ) {
			
			$options[]	=   (object) array( 'value' => '', 'text' => '- Select a Page -');
			$config		=	dunloader( 'config', 'com_jblesta' );
			$pagetxt	=	explode( "\r\n", trim( $config->get( 'pagelist' ) ) );
			
			foreach( $pagetxt as $page ) {
				$page	=	trim( $page );
				if ( empty( $page ) ) continue;
				$tmp	=	explode( "=", $page );
				$name	=	array_shift( $tmp );
				$options[]	=	(object) array( 'value'	=> base64_encode( implode( "=", $tmp ) ), 'text' => $name );
			}
			
		}
		
		return $options;
	}
}
