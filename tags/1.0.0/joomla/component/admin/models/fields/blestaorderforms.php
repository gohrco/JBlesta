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

// -------------------------------------------------------
// Ensure we have Dunamis and it's loaded
if (! function_exists( 'get_dunamis' ) ) {
	$path	= dirname( dirname( dirname( dirname( dirname( dirname(__FILE__) ) ) ) ) ) . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'dunamis' . DIRECTORY_SEPARATOR . 'dunamis.php';
	if ( file_exists( $path ) ) require_once( $path );
}

if (! function_exists( 'get_dunamis' ) ) {
	// EPIC FAILURE HERE
	return;
}

get_dunamis( 'com_jblesta' );


/**
 * JBlesta Companies Field
 * @desc		This class retrieves a list of companies from Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JFormFieldBlestaorderforms extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'Blestaorderforms';

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
		$config			=	dunloader( 'config', 'com_jblesta' );
		
		// Grab the default value if not set
		if ( empty( $this->value ) ) {
			$this->value	=	$config->get( 'registrationform' );
		}
		
		// Lets get the options here ;-)
		$api = dunloader( 'api', 'com_jblesta' );
		$this->_myoptns	=	$api->getorderforms( $config->get( 'blestacompany', false ) );
		
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
		$forms	=	$this->_myoptns;
		
		// Catch errors
		if (! $forms || ! is_array( $forms ) ) {
			return array();
		}
		
		// Initialize variables.
		$options = array();
		
		foreach ( $forms as $form ) {
			
			if ( $form->type != 'registration' || $form->status != 'active' ) {
				continue;
			}
			
			// Create option
			$tmp = JHtml::_( 'select.option', (string) $form->id, (string) $form->name );
			$options[]	=	$tmp;
		}
		
		return $options;
	}
}