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
 * JBlesta System Plugin API Edit User
 * @desc		This file handles the Edituser routine through our API
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class EdituserJblestaAPI extends JblestaAPI
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
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_EDITUSER_NOTFOUND' ), $sent->email ) );
		}
		
		$user	=	JUser :: getInstance( $uid );
		$data	=	array();
		
		if ( isset( $sent->name ) ) {
			$data['name']	=	$sent->name;
		}
		
		if ( isset ( $sent->username ) ) {
			$data['username']	=	$sent->username;
		}
		
		if ( isset( $sent->status ) ) {
			$data['block']	=	$sent->status == 1 ? 0 : 1;
		}
		
		if ( isset( $sent->password ) && isset( $sent->password2 ) && $sent->password == $sent->password2 ) {
			$data['password']	=	$sent->password;
			$data['password2']	=	$sent->password2;
		}
		
		if ( isset( $sent->newemail ) && ! empty( $sent->newemail ) ) {
			$data['email']	=	$sent->newemail;
		}
		
		
		// ===================================================================
		// Bind and save the data array
		// ===================================================================
		if (! $user->bind( $data ) ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_EDITUSER_BIND' ), $user->getError() ) );
		}
		
		if (! $user->save() ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_EDITUSER_SAVE' ), $user->getError() ) );
		}
		
		$this->success( sprintf( JText :: _( 'JBLESTA_SYSM_API_EDITUSER_SUCCESS' ), $sent->email ) );
	}
}