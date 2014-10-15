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
	 * We fetch our optns when we get the input so we can disable if we fail
	 * @var		array
	 * @since	1.0.0
	 */
	private $_myoptns = array();
	
	
	/**
	 * Method to get the input field from the form object
	 * @access		protected
	 * @version		@fileVers@
	 *
	 * @return		string containing html field
	 * @since		1.0.0
	 */
	protected function getInput()
	{
		// Grab the default value if not set
		if ( empty( $this->value ) ) {
			$config			=	dunloader( 'config', 'com_jblesta' );
			$this->value	=	$config->get( 'defaultcountry' );
		}
		
		$api			=	dunloader( 'api', 'com_jblesta' );
		$this->_myoptns	=	$api->getcountries();
		
		if ( empty( $this->_myoptns ) || $this->_myoptns === false ) {
			$this->element->addAttribute( 'disabled', 'true' );
		}
		
		return parent :: getInput();
	}
	
	
	/**
	 * Method to get options from the form field
	 * @access		protected
	 * @version		@fileVers@
	 *
	 * @return		array
	 * @since		1.0.0
	 */
	protected function getOptions()
	{
		$countries	=	$this->_myoptns;
		
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