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
class JFormFieldBlestacompanies extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'Blestacompanies';

	
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
			$this->value	=	$config->get( 'blestacompany' );
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
		$companies	=	$api->getcompanies();
		
		// Catch errors
		if (! $companies || ! is_array( $companies ) ) {
			return array();
		}
		
		// Initialize variables.
		$options = array();
		
		foreach ( $companies as $company ) {
			// Create option
			$tmp = JHtml::_( 'select.option', (string) $company->id, (string) $company->name );
			$options[]	=	$tmp;
		}
		
		return $options;
	}
}