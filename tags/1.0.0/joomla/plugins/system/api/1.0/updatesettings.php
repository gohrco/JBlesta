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
 * JBlesta System Plugin API Updatesettings
 * @desc		This file handles the Update Settings routine through our API
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class UpdatesettingsJblestaAPI extends JblestaAPI
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
		$config	=	dunloader( 'config', 'com_jblesta' );
		return;
		// ===================================================================
		// Select the userid based on the email
		// ===================================================================
		$query	=	$db->setQuery( "SELECT u.id FROM #__users AS u WHERE u.email = " . $db->Quote( $sent->email ) );
		if (! ($uid = $db->loadResult() ) ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_CHANGEPASSWORD_NOTFOUND' ), $sent->email ) );
		}
		
		$user	=	JUser :: getInstance( $uid );
		$data	=	array(
				'password'	=> $sent->password,
				'password2' => $sent->password2
				);
		
		
		// ===================================================================
		// Bind and save the data array
		// ===================================================================
		if (! $user->bind( $data ) ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_CHANGEPASSWORD_BIND' ), $user->getError() ) );
		}
		
		if (! $user->save() ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_CHANGEPASSWORD_SAVE' ), $user->getError() ) );
		}
		
		$this->success( sprintf( JText :: _( 'JBLESTA_SYSM_API_CHANGEPASSWORD_SUCCESS' ), $sent->email ) );
	}
}