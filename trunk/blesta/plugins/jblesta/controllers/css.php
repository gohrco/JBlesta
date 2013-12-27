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


/**
 * JBlesta CSS Controller
 * @desc		This class is called up directly when retrieving custom CSS override files
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Css extends JblestaController
{
	/**
	 * Method to assemble the index
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function index()
	{
		// Initialize Dunamis!
		$this->init();
		
		$doc	=	dunloader( 'document', true );
		$input	=	dunloader( 'input', true );
		$file	=	$input->getVar( 'f', false );
		$dir	=	$input->getVar( 'd', false );
		$type	=	$input->getVar( 't', false );
		
		if (! $file ) {
			$this->redirect();
		}
		
		if (! $dir && ! $type ) {
			$dir	=	'/client/default/css';
		}
		
		if (! $type ) {
			$type	=	'templates' . DIRECTORY_SEPARATOR . get_version();
		}
		
		$dir	=	str_replace( '/', DIRECTORY_SEPARATOR, $dir );
		$path	=	dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . $type . $dir . DIRECTORY_SEPARATOR . $file . '.css';
		
		// See if the file exists first
		if (! file_exists( $path ) ) {
			$this->redirect();
		}
		
		$css	=	file_get_contents( $path );
		
		header("Content-type: text/css");
		echo $css;
		exit;
	}
}
?>