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
 * JBlesta Countries Field
 * @desc		This class retrieves a list of available countries from Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JFormFieldBlestacountries extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'Blestacountries';

	
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
			$this->value	=	$config->get( 'defaultcountry' );
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
		$api		=	dunloader( 'api', 'com_jblesta' );
		$countries	=	$api->getcountries();
		
		// Initialize variables.
		$options = array();
		
		foreach ( $countries as $country ) {
			// Create option
			$tmp = JHtml::_( 'select.option', (string) $country->alpha2, (string) $country->name );
			$options[]	=	$tmp;
		}
		
		return $options;
	}
}