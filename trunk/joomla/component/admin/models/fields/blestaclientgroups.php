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

defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('list');

/**
 * JBlesta Client Groups Field
 * @desc		This class retrieves a list of client groups from Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JFormFieldBlestaclientgroups extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'Blestaclientgroups';

	
	/**
	 * Method to get the input field from the form object
	 * @access		protected
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		string containing html field
	 * @since		2.5.0
	 */
	protected function getInput()
	{
		// Grab the default value if not set
		if ( empty( $this->value ) ) {
			$config			=	dunloader( 'config', 'com_jblesta' );
			$this->value	=	$config->get( 'defaultclientgroup' );
		}
		
		return parent :: getInput();
	}
	
	
	/**
	 * Method to get options from the form field
	 * @access		protected
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		array
	 * @since		2.5.0
	 */
	protected function getOptions()
	{
		$config		=	dunloader( 'config', 'com_jblesta' );
		$api		=	dunloader( 'api', 'com_jblesta' );
		$groups		=	$api->getclientgroups( $config->get( 'blestacompany', '1' ) );
		
		// Catch errors
		if (! $groups || ! is_array( $groups ) ) {
			$msg	=	$api->getError();
			
			// Get to the error message
			if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
				JFactory::getApplication()->enqueueMessage( "{$msg}" );
			}
			else {
				JError::raiseNotice( 100, "{$msg}" );
			}
			
			return array();
		}
		
		// Initialize variables.
		$options = array();
		
		foreach ( $groups as $group ) {
			// Create option
			$tmp = JHtml::_( 'select.option', (string) $group->id, (string) $group->name );
			$options[]	=	$tmp;
		}
		
		return $options;
	}
}