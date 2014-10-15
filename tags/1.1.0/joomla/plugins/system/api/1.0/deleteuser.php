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
 * JBlesta System Plugin API Delete User
 * @desc		This file handles the Deleteuser routine through our API
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class DeleteuserJblestaAPI extends JblestaAPI
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
		$input	=	dunloader( 'input', true );
		$method	=	$input->getMethod();
		$sent	=	(object) $input->getVar('data', array(), 'array', $method );
		
		// ===================================================================
		// Select the userid based on the email
		// ===================================================================
		$query	=	$db->setQuery( "SELECT u.id FROM #__users AS u WHERE u.email = " . $db->Quote( $sent->email ) );
		if (! ($uid = $db->loadResult() ) ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_DELETEUSER_NOTFOUND' ), $sent->email ) );
		}
		
		$user	=	JUser :: getInstance( $uid );
		
		// Check for super admins (no-no-no)
		if ( $user->authorise('core.admin') ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_DELETEUSER_CANTDELETEADMIN' ), $sent->email ) );
		}
		
		if (! $user->delete() ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_DELETEUSER_DELETE' ), $user->getError() ) );
		}
		
		$this->success( sprintf( JText :: _( 'JBLESTA_SYSM_API_DELETEUSER_SUCCESS' ), $sent->email ) );
	}
}