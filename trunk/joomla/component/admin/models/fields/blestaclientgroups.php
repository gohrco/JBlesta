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
	 * We fetch our optns when we get the input so we can disable if we fail
	 * @var		array
	 * @since	1.0.0
	 */
	private $_myoptns = array();
	
	
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
		$config			=	dunloader( 'config', 'com_jblesta' );
		
		// Grab the default value if not set
		if ( empty( $this->value ) ) {
			$this->value	=	$config->get( 'defaultclientgroup' );
		}
		
		// Lets get the options here ;-)
		$api = dunloader( 'api', 'com_jblesta' );
		$this->_myoptns	=	$api->getclientgroups( $config->get( 'blestacompany', false ) );
		
		if ( empty( $this->_myoptns ) || $this->_myoptns === false ) {
			$this->element->addAttribute( 'disabled', 'true' );
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
		$groups		=	$this->_myoptns;
		
		// Catch errors
		if (! $groups || ! is_array( $groups ) ) {
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