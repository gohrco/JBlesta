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

defined('_JEXEC') or die( 'Restricted access' );

/**
 * JBlesta System Plugin API Verify
 * @desc		This file handles the verification routine through our API
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class VerifyJblestaAPI extends JblestaAPI
{
	
	/**
	 * Method for executing on the API
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function execute()
	{
		if (! function_exists( 'curl_exec' ) ) {
			$this->error( JText :: _( 'JBLESTA_SYSM_API_PING_NOCURL' ) );
		}
		
		$this->success( 'pong' );
	}
}