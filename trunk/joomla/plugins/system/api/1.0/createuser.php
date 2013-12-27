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
 * JBlesta System Plugin API Create User
 * @desc		This file handles the Createuser routine through our API
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class CreateuserJblestaAPI extends JblestaAPI
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
		$user 	=	clone( JFactory :: getUser() );
		$usersConfig	=	JComponentHelper::getParams( 'com_users' );
		$authorize		=	JFactory :: getACL();
		$date			=	JFactory :: getDate();
		$jconfig		=	JFactory :: getConfig();
		$config			=	dunloader( 'config', 'com_jblesta' );
		
		// ===================================================================
		// If user registration is not allowed, error out
		// ===================================================================
		if ($usersConfig->get('allowUserRegistration') == '0') {
			$this->error( JText :: _( 'JBLESTA_SYSM_API_CREATION_FORBIDDEN' ) );
		}
		
		// ===================================================================
		// Build the user array for binding
		// ===================================================================
		$input		=	dunloader( 'input', true );
		$method		=	$input->getMethod();
		$data		=	$input->getVar('data', array(), 'array', $method );
		$newUser	=	array(	
				'name'		=>	$data['name'],
				'username'	=>	$data['username'],
				'email'		=>	$data['email'],
				'password'	=>	$data['password'],
				'password2'	=>	$data['password2'],
				'groups'	=>	( version_compare( DUN_ENV_VERSION, '1.6.0', 'ge' ) ? array() : null )
				);
		
		// ===================================================================
		// Validate the data
		// ===================================================================
		$db->setQuery( "SELECT u.id FROM #__users u WHERE email = " . $db->Quote( $newUser['email'] ) );
		if ( $db->loadResult() ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_CREATEUSER_EMEXISTS' ), $newUser['email'] ) );
		}
		
		if ( empty( $newUser['password'] ) && empty( $newUser['password2'] ) ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_CREATEUSER_NOPASSWD' ), $newUser['email'] ) );
		}
		
		// This checks for usernames that exist and adds a variable to the end
		$db->setQuery( "SELECT 1 FROM #__users u WHERE username LIKE '" . $newUser['username'] . "%'" );
		$rows	=	$db->loadResultArray();
		
		if ( $rows ) {
			$cnt					=	count( $rows );
			$newUser['username']	.=	'.' . $cnt;
		}
		
		$db->setQuery( "SELECT u.id FROM #__users u WHERE username = " . $db->Quote( $newUser['username'] ) );
		if ( $db->loadResult() ) {
			$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_CREATEUSER_USEXISTS' ), $newUser['username'] ) );
		}
		
		
		// ===================================================================
		// Check the data
		// ===================================================================
		if ( empty ( $newUser['password2'] ) ) {
			$newUser['password2'] = $newUser['password'];
		}
		
		// Determine user activation (JWHMCS permits ignoring it)
		$useractivation	=	0;
		if ( $config->get( 'requireactivation', false ) ) {
			$useractivation	=	$usersConfig->get( "useractivation" );
		}
		
		// New user type determination
		$newUsertype	=	$usersConfig->get( 'new_usertype' );
		if ( version_compare( DUN_ENV_VERSION, '1.6.0', 'ge' ) ) {
			$newUsertype	=	(! $newUsertype ? 2 : $newUsertype );
		}
		else {
			$newUsertype	=	(! $newUsertype ? 'Registered' : $newUsertype );
		}
		
		// ===================================================================
		// Joomla! 2.5+ before binding requires some things
		// ===================================================================
		if ( version_compare( DUN_ENV_VERSION, '1.6.0', 'ge' ) ) {
			// Add to bind array
			$newUser['groups'][] = $newUsertype;
			
			// Check if the user needs to activate their account.
			// 1 = self; 2 = admin approval
			if ( ( $useractivation == 1 ) || ( $useractivation == 2 ) ) {
				jimport('joomla.user.helper');
				
				// Yes, 3.0 does things differently but just enough
				if ( version_compare( DUN_ENV_VERSION, '3.0', 'ge' ) ) {
					$newUser['activation']	=	JApplication :: getHash( JUserHelper :: genRandomPassword() );
				}
				else {
					$newUser['activation']	=	JUtility :: getHash (JUserHelper :: genRandomPassword() );
				}
				
				// Both require block to be set
				$newUser['block'] = 1;
			}
		}
		
		// ============================================
		// ------BIND ARRAY----------------------
		// ======================================
		if (! $user->bind( $newUser, 'usertype' ) ) {
			$this->error( JText :: _( $user->getError() ) );
		}
		// ======================================
		// -----------------------------------------
		// ===========================================
		// Joomla 1.5 Handles some stuff after binding
		if ( version_compare( JVERSION, '1.6.0', 'l' ) ) {
			$newUser->set( 'id', 0 );
			$newUser->set( 'usertype', '' );
			$newUser->set( 'gid', $authorize->get_group_id( '', $newUsertype, 'ARO' ) );
			$newUser->set( 'registerDate', $date->toMySQL() );
				
			// Dont send welcome email by default
			if ( $useractivation == '1' ) {
				jimport('joomla.user.helper');
				$newUser->set( 'activation', JUtility :: getHash( JUserHelper :: genRandomPassword() ) );
				$newUser->set( 'block', '1' );
			}
		}
		// ===========================================
		
		// Load the users plugin group.
		JPluginHelper::importPlugin('user');
		
		// ===================================================================
		// Save the user failing on error
		// ===================================================================
		if (! $user->save() ) {
			$this->error( JText :: _( $user->getError() ) );
		}
		
		// ===================================================================
		// Build registration emails to send out
		// ===================================================================
		
		$emaildata				=	$user->getProperties();
		$emaildata['fromname']	=	$jconfig->get( 'fromname' );
		$emaildata['mailfrom']	=	$jconfig->get( 'mailfrom' );
		$emaildata['sitename']	=	$jconfig->get( 'sitename' );
		$emaildata['siteurl']	=	JUri :: base();
		
		// Load the users language file
		$lang	=   JFactory :: getLanguage();
		$lang->load( 'com_users', JPATH_ADMINISTRATOR );
		
		$uri	=	JURI :: getInstance();
		$base	=	$uri->toString( array( 'scheme', 'user', 'pass', 'host', 'port' ) );
		
		switch ( $useractivation ) :
		case '2':
			
			// Set the link to confirm the user email.
			$emaildata['activate']	= $base . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $newUser['activation'], false );
			
			$emailSubject	= JText::sprintf(
				'COM_JBLESTA_EMAIL_ACCOUNT_DETAILS',
				$emaildata['name'],
				$emaildata['sitename']
			);
			
			$emailBody = JText::sprintf(
				'COM_JBLESTA_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY',
				$emaildata['name'],
				$emaildata['sitename'],
				$emaildata['siteurl'].'index.php?option=com_users&task=registration.activate&token=' . $newUser['activation'],
				$emaildata['siteurl'],
				$emaildata['username'],
				$newUser['password']
			);
			
			break;
		
		case '1':
			
			// Set the link to activate the user account.
			$emaildata['activate']	= $base . JRoute :: _( 'index.php?option=com_users&task=registration.activate&token=' . $newUser['activation'], false );
			
			$emailSubject	= JText::sprintf(
					'COM_JBLESTA_EMAIL_ACCOUNT_DETAILS',
					$emaildata['name'],
					$emaildata['sitename']
			);
			
			$emailBody = JText::sprintf(
					'COM_JBLESTA_EMAIL_REGISTERED_WITH_ACTIVATION_BODY',
					$emaildata['name'],
					$emaildata['sitename'],
					$emaildata['siteurl'] . 'index.php?option=com_users&task=registration.activate&token=' . $newUser['activation'],
					$emaildata['siteurl'],
					$emaildata['username'],
					$newUser['password']
			);
				
			break;
		
		case '0':
				
			$emailSubject	= JText::sprintf(
				'COM_JBLESTA_EMAIL_ACCOUNT_DETAILS',
				$emaildata['name'],
				$emaildata['sitename']
			);
		
			$emailBody = JText::sprintf(
				'COM_JBLESTA_EMAIL_REGISTERED_BODY',
				$emaildata['name'],
				$emaildata['sitename'],
				$emaildata['siteurl']
			);
			
			break;
				
		endswitch;	// End Switch
		
		$result	=	$user->getProperties();
		$this->success( $result );
	}
}