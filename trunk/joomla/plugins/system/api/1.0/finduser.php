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
 * JBlesta System Plugin API Find User
 * @desc		This file handles the Finduser routine through our API
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class FinduserJblestaAPI extends JblestaAPI
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
		$db		=	dunloader( 'database', true );
		$find	=	dunloader('input',true)->getVar('find', false );
		
		// ===================================================================
		// Select the userid based on the email
		// ===================================================================
		$query	=	$db->setQuery( "SELECT u.id FROM #__users AS u WHERE u.email = " . $db->Quote( $find ) );
		if (! ($uid = $db->loadResult() ) ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_EDITUSER_NOTFOUND' ), $find ) );
		}
		
		$user	=	JUser :: getInstance( $uid );
		$data	=	array(
				'name'		=> $user->get( 'name', null ),
				'username'	=> $user->get('username', null ),
				'email'		=> $find
				);
		
		$this->success( (object) $data );
	}
}