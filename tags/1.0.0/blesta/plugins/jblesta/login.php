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

defined('DUNAMIS') OR exit('No direct script access allowed');


/**
 * Login handler for J!Blesta
 * @desc		This is used to handle logins from Blesta going to Joomla
 * 
 * @package		@packageName@
 * @subpackage	Blesta
 * @since		1.0.0
 */
class JblestaLoginDunModule extends BlestaDunModule
{
	private $_creds		=	array(
			'authtype'	=>	null,
			'username'	=>	null,
			'email'		=>	null );
	
	/**
	 * Authenticate credentials against Joomla
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function authenticate()
	{
		// We are actually providing our own login routine... ?
		$config	=	dunloader( 'config', 'jblesta' );
		$input	=	dunloader( 'input', true );
		$api	=	dunloader( 'api', 'jblesta' );
		
		// If we are disabled don't run ;-)
		if (! ensure_active( 'login' ) ) {
			return false;
		}
		
		// Load up Blesta stuff
		Loader :: loadComponents( $this, array( 'Session' ) );
		Loader :: loadModels( $this, array( 'Users', 'Clients', 'Contacts', 'ClientGroups' ) );
		
		$username	=	$input->getVar( 'username', null );
		$password	=	$input->getVar( 'password', null );
		
		// First lets try to authenticate against Joomla
		$auth	=	$api->authenticate( array( 'username' => $username, 'password' => $password ) );
		
		// If we fail to authenticate try Blesta...
		if ( $api->hasErrors() || ! $auth || ( is_object( $auth ) && ! isset( $auth->email ) ) ) {
			
			$auth	=	$this->Users->auth( $username, array( 'password' => $password ), 'client' );
			
			$this->_creds['authtype']	=	'blesta';
		}
		else {
			$this->_creds['authtype']	=	'joomla';
		}
		
		// If we still don't log in then that is a problem
		if (! $auth ) {
			return false;
		}
		
		// ========================================
		// User has authenticated against something
		// ========================================
		
		$this->_creds['username']	=	$username;
		
		// If we authenticate against Joomla, find our Blesta user
		if ( $this->_creds['authtype'] == 'joomla' ) {
			
			// We know our email address
			$this->_creds['email']		=	$auth->email;
			
			// Try to find our Blesta user by username first
			if ( ( $user = $this->Users->getByUsername( $this->_creds['username'] ) ) ) {
				$found	=	true;
			}
			// Can't find it that way, so using the email address
			else if ( ( $user = $this->Users->getByUsername( $auth->email ) ) ) {
				$found	=	true;
			}
			// If we couldn't find then lets see if we can create them
			else {
				// Check our settings first
				if (! in_array( $config->get( 'useraddmethod', 0 ), array( '2', '4' ) ) ) {
					return false;
				}
				
				// Grab our Joomla user
				if (! ( $juser = $api->finduser( $this->_creds['email'] ) ) ) {
					// How this could happen is unknown
					return false;
				}
				
				// Build our user's name
				$parts		=	explode( " ", $juser->name );
				$fname		=	array_shift( $parts );
				$lname		=	(! empty( $parts ) ? implode( " ", $parts ) : '__' );

				// We have to pad the password to get aroudn Blesta limitation
				while ( strlen( $password ) < 6 ) {
					$password .= 'x';
				}
				
				// Our user's array
				$vars	=	array(
						'username'			=>	$this->_creds['username'],
						'new_password'		=>	$password,
						'confirm_password'	=>	$password,
						'client_group_id'	=>	$this->ClientGroups->getDefault( Configure :: get( "Blesta.company_id" ) )->id,
						'first_name'		=>	$fname,
						'last_name'			=>	$lname,
						'email'				=>	$this->_creds['email'],
						'settings' 			=>	array( 'username_type' => ( is_email( $this->_creds['username'] ) ? 'email' : 'username' ) )
				);
					
				$this->Clients->create( $vars );
				
				$user		=	$this->Users->getByUsername( $this->_creds['username'] );
				
				// Something happened trying to create the user - bail
				if (! $user ) {
					return false;
				}
			}
			
			// -----------------------------------------------------------------
			// Authenticated Joomla user matched up to Blesta user at this point
			// -----------------------------------------------------------------
		}
		// Lets match up our authenticated Blesta user to a Joomla user now
		else if ( $this->_creds['authtype'] == 'blesta' ) {
			
			// Get our user / client
			if (! ( $user = $this->Users->getByUsername( $username ) ) ) {
				// Should not be possible, but just in case
				return false;
			}
			
			if (! ( $client = $this->Clients->getByUserId( $user->id ) ) ) {
				// Again, shouldn't be possible
				return false;
			}
			
			$this->_creds['email']	=	$client->email;
			
			// Try to find our Joomla user now
			if ( ( $user = $api->finduser( $this->_creds['email'] ) ) ) {
				$found	=	true;
			}
			// If we couldn't find then lets see if we can create them in Joomla
			else {
				// Check our settings first
				if (! in_array( $config->get( 'useraddmethod', 0 ), array( '1', '4' ) ) ) {
					return false;
				}
				
				// Build our data for Joomla
				$data				=	new stdClass();
				$data->name			=	build_name( $client );
				$data->password		=
				$data->password2	=	$password;
				$data->email		=	$client->email;
				
				if ( $client->username_type == 'email' ) {
					$data->username	=	build_username( $client );
				}
				else {
					if ( $client->username ) {
						$data->username	=	$client->username;
					}
					else {
						return false;
					}
				}
				
				if (! ( $result = $api->createuser( $data ) ) ) {
					return false;
				}
			}
			
			// -----------------------------------------------------------------
			// Authenticated Blesta user matched up to Joomla user at this point
			// -----------------------------------------------------------------
		}
		
		
		// =======================
		// Login Magic Starts Here
		// =======================
		
		
		// We should have a user now so log them in
		// Log us in captain
		$_POST['username'] = $this->_creds['username'];
		$this->Users->login( $this->Session, $_POST );
			
		if ( $this->Session->read( "blesta_id" ) ) {
				
			$client	=	$this->Clients->getByUserId ($this->Session->read( "blesta_id" ) );
				
			// How can this happen?
			if (! $client ) {
				$this->Session->clear();
				return false;
			}
				
			$this->Session->write( "blesta_company_id", Configure :: get( "Blesta.company_id" ) );
			$this->Session->write( "blesta_client_id", $client->id );
		}
		else {
			$this->Session->clear();
			return false;
		}
		
		if (! ( $redirect = $this->_generateLoginurl() ) ) {
			return false;
		}
		
		header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		header( 'Cache-Control: no-store, no-cache, must-revalidate' );
		header( 'Cache-Control: post-check=0, pre-check=0', false );
		header( 'Pragma: no-cache' );
		header( 'Location: ' . $redirect );
		exit;
	}
	
	
	/**
	 * Initializes the module
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function initialise() { }
	
	
	/**
	 * Method to log the user out of WHMCS
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function logout()
	{
		// If we are disabled don't run ;-)
		if (! ensure_active( 'login' ) ) {
			return false;
		}
		
		Loader :: loadComponents( $this, array( 'Session' ) );
		
		$this->Session->clear();
		
		$input		=	dunloader( 'input', true );
		$returnurl	=	$this->_getReturnurl( 'logout' );
		
		// Gather necessary parts
		$config		=	dunloader( 'config', 'jblesta' );
		$token		=	$config->get( 'logintoken', null );
		$jurl		=	$config->get( 'joomlaurl', null );
		
		// Establish the timestamp and build the signature
		$timestamp	=	time();
		$random		=	random_string();
		$signature	=	base64_encode( hash_hmac( 'sha256', $random . $timestamp . $token, $token, true ) );
		
		$juri	=	DunUri :: getInstance( $jurl, true );
		$juri->setVar( 'timestamp',	$timestamp );
		$juri->setVar( 'random',	$random );
		$juri->setVar( 'signature',	$signature );
		$juri->setVar( 'task',		'autologout' );
		$juri->setVar( 'returnurl',	$returnurl );
		
		$redirect	=	$juri->toString();
		
		header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		header( 'Cache-Control: no-store, no-cache, must-revalidate' );
		header( 'Cache-Control: post-check=0, pre-check=0', false );
		header( 'Pragma: no-cache' );
		header( 'Location: ' . $redirect );
		exit;
	}
	
	
	/**
	 * Method to find a username given only the email in the credential array
	 * @access		private
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	private function _findUsername()
	{
		$api	=	dunloader( 'api', 'jblesta' );
		$user	=	$api->finduser( $this->_creds['email'] ) ;
		
		if ( $api->hasErrors() ) {
			return false;
		}
		
		return $user->username;
	}
	
	
	/**
	 * Method for generating the entire login URL to go over to Joomla with
	 * @access		private
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	private function _generateLoginurl( $task = 'login' )
	{
		$api	=	dunloader( 'api', 'jblesta' );
		$input	=	dunloader( 'input', true );
		
		if ( $this->_creds['username'] == null ) {
			
			// Find the username
			if (! ( $username = $this->_findUsername() ) ) {
				_e( 'hi there', 1 );
				// No username found so lets see if we can create them
				$wuser		=	$wapi->finduserdetails( $this->_creds['email'], 'email' );
				$iscontact	=	( isset( $wuser->subaccount ) && $wuser->subaccount ? true : false ); 
				
				// Build the user
				$user		=	convert_user( $wuser, array(), true, 'to', ( $iscontact ? 'contact' : 'client' ) );
				
				$user['password']	=	$input->getVar( 'password', false );
				$user['password2']	=	$input->getVar( 'password', false );
				
				if (! ( $result = $api->createuser( $user ) ) ) {
					return false;
				}
				
				if (! $iscontact ) {
					store_username( $wuser->userid, $result->username );
				}
				
				$username = $result->username;	
			}
			
			$this->_creds['username']	=	$username;
		}
		
		// Lets build our return URL
		$returnurl	=	$this->_getReturnurl( $task );
		
		// Gather necessary parts
		$config		=	dunloader( 'config', 'jblesta' );
		$token		=	$config->get( 'logintoken', null );
		$jurl		=	$config->get( 'joomlaurl', null );
		
		// Establish the timestamp and build the signature
		$timestamp	=	time();
		$signature	=	base64_encode( hash_hmac( 'sha256', $this->_creds['email'] . $timestamp . $token, $token, true ) );
		$checksign	=	base64_encode( hash_hmac( 'sha256', $this->_creds['username'] . $timestamp . $token, $token, true ) );
		
		$juri	=	DunUri :: getInstance( $jurl, true );
		$juri->setVar( 'timestamp',	$timestamp );
		$juri->setVar( 'signature',	$signature );
		$juri->setVar( 'checksign',	$checksign );
		$juri->setVar( 'username',	$this->_creds['username'] );
		$juri->setVar( 'task',		'autoauth' );
		$juri->setVar( 'returnurl',	$returnurl );
		
		if ( $task == 'useraddlogin' ) {
			$juri->setVar( 'subtask', 'adduser' );
			$juri->setVar( 'password2', $input->getVar( 'password', null ) );
		}
		
		return $juri->toString();
	}
	
	
	/**
	 * Method for building the proper return URL for login purposes 
	 * @access		private
	 * @version		@fileVers@
	 * @param		string			Indicates we want the login URL
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	private function _getReturnurl( $task = 'login' )
	{
		$gotouri	=	DunUri :: getInstance( get_baseurl( 'client' ), true );
		
		switch ( $task ) {
			case 'login':
				
				Loader :: loadComponents( $this, array( 'Session' ) );
				
				// Detect if we should forward after logging in and do so
				if ( isset( $_POST['forward_to'] ) ) {
					$forward_to = $_POST['forward_to'];
				}
				else {
					$forward_to = $this->Session->read( "blesta_forward_to" );
				}
				
				$this->Session->clear( "blesta_forward_to" );
				
				if (! $forward_to ) {
					$forward_to = get_baseurl( 'client' );
				}
				
				$gotouri	=	DunUri :: getInstance( $forward_to, true );
				
				break;
				
			case 'logout' :
				
				$gotouri->setPath( $gotouri->getPath( 'client') );
				
				break;

			// Because WHMCS logs in at user add, we need to return to WHMCS with an autoauth URL to log in with
			case 'useraddlogin' :
				
				global $gotourl;
				
				if ( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] ) {
					$gotourl	=	$_SERVER['HTTP_REFERER'];
				}
				else {
					$gotourl	=	rtrim( $gotouri->toString( array( 'path' ) ), '/' ) . '/clientarea.php';
				}
				
				$gmt		=	new DateTime( null, new DateTimeZone('GMT') );
				$token		=	$jcfg->get( 'apitoken' );
				$email		=	$this->_creds['email'];
				$timestamp	=	$gmt->format("U");
				$hash		=	sha1( $email . $timestamp . $token );
				$return		=	$this->_getReturnurl();
				
				// Create our own hash for logging in
				$gotouri	=	DunUri :: getInstance( $sysurl, true );
				$gotouri->setPath( rtrim( $gotouri->getPath(), '/' ) . '/dologin.php' );
				$gotouri->setVar( 'email', $email );
				$gotouri->setVar( 'timestamp', $timestamp );
				$gotouri->setVar( 'hash', $hash );
				$gotouri->setVar( 'goto', urlencode( 'clientarea.php' ) );
				$gotouri->setVar( 'jwhmcs', $return );
				
				break;
		}
		
		return base64_encode( $gotouri->toString() );
	}
}