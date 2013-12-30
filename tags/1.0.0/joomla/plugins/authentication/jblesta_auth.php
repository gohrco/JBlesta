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


// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'dunamis.dunamis' );
jimport( 'joomla.plugin.plugin' );
jimport( 'joomla.application.component.helper' );

$path	= JPATH_ADMINISTRATOR . '/components/com_jblesta/jblesta.helper.php';
if ( file_exists( $path ) ) require_once( $path );

/**
 * JBlesta Authentication Plugin
 * @desc		This class is used to authenticate our user against Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class plgAuthenticationJblesta_auth extends JPlugin
{
	/**
	 * Indicates we are enabling the authentication plugin
	 * @access		private
	 * @since		1.0.0
	 * @var			boolean
	 */
	private $_enabled	=	false;
	
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		unknown_type	$subject
	 * @param		unknown_type	$config
	 * 
	 * @since		1.0.0
	 */
	public function __construct(& $subject, $config)
	{
		parent :: __construct( $subject, $config );
		
		$this->loadLanguage();
		
		$app		=	JFactory :: getApplication();
		
		// Run through tests
		// -----------------
		// Ensure we have Dunamis installed
		if (! function_exists( 'get_dunamis' ) ) {
			return;
		}
		
		get_dunamis( 'com_jblesta' );
		$api	=	dunloader( 'api', 'com_jblesta' );
		
		// Ensure we can actually reach our Blesta
		if (! $api->ping() ) {
			return;
		}
		
		// All good, lets go
		$this->_enabled	=	true;
	}
	
	
	/**
	 * Authenticate the user against Joomla or WHMCS
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		The credentials array we are passed
	 * @param		array		Options array we are passed
	 * @param		object		Response Object
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function onUserAuthenticate( $credentials, $options, $response )
	{
		// Ensure we can run this
		if (! $this->_enabled ) {
			return;
		}
		
		// Don't auth against W if we are coming from W
		if ( isset( $options['jblesta'] ) && $options['jblesta'] ) {
			return;
		}
		
		/* Double check against API constant */
		if ( defined( 'JBLESTAAPI' ) ) {
			return;
		}
		
		/* Load Dunamis */
		get_dunamis( 'com_jblesta' );
		
		/* Establish the API */
		$config	=	dunloader( 'config', 'com_jblesta' );
		$api	=	dunloader( 'api', 'com_jblesta' );
		$hlps	=	dunloader( 'helpers', 'com_jblesta' );
		
		/* Set some vars and check username is email */
		$username	=	$credentials['username'];
		$password	=	$credentials['password'];
		
		if ( empty( $password ) ) {
			return false;
		}
		
		/* We have an email and password so lets validate them */
		if (! $api->validatelogin( $username, $password ) ) {
			return false;
		}
		
		
		/* -------------------------------------------------- *\
		 * User is now validated against Blesta if still here *
		 * -------------------------------------------------- */
		
		/* Locate the Joomla user if they exist */
		$isemail	=	is_email( $username );
		$juser		=	$this->_getJoomlauser( $username, ( $isemail ? 'email' : 'username' ) );
		
		/* We found a user so bind to response and go home */
		if ( $juser ) {
			$response->fullname 		= $juser->name;
			$response->username			= $juser->username;
			$response->email			= $juser->email;
			$response->password			= $juser->password;
			$response->password_clear	= $credentials['password'];
			$response->status			= 1;
			$response->error_message	= '';
			return true;
		}
		
		
		/* ------------------------------------------------- *\
		 * No matching user in Joomla if we are still here   *
		 * ------------------------------------------------- */
		
		$method	=	$config->get( 'useraddmethod' );
		
		/* Verify we are permitted to create the user in Joomla */
		if (! in_array( $method, array( '1', '4' ) ) ) {
			return false;
		}
		
		/* Lets build the registration object here */
		$params			=	JComponentHelper :: getParams( 'com_users' );
		$useractivation	=	$params->get( 'useractivation' );
		$sendpassword	=	$params->get( 'sendpassword', 1 );
		$user			=	new JUser;
		$data			=	array();
		$buser			=	$api->findmatchinguser( $credentials['username'] );
		
		/* Prepare the data for the user object */
		$data['name']		=	$this->_build_fullname( $credentials );
		$data['username']	=	$this->_build_username( $credentials );
		$data['email']		=	$buser->email;
		$data['password']	=	$credentials['password'];
		
		/* Set J2.5 new user type if not in config file and add to bind array */
		if (! $newUsertype ) {
			$newUsertype = 2;
		}
		
		$data['groups'][] = $newUsertype;
			
		/* Check if the user needs to activate their account.
		 * 1 = self; 2 = admin approval
		 */
		if ( ( $useractivation == 1 ) || ( $useractivation == 2 ) ) {
			jimport('joomla.user.helper');
		
			// Yes, 3.0 does things differently but just enough
			if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
				$data['activation']	= JApplication :: getHash( JUserHelper :: genRandomPassword() );
			}
			else {
				$data['activation'] = JUtility::getHash(JUserHelper::genRandomPassword());
			}
			
			$data['block'] = 1;
		}
		
		/* Prevent Recursion in User Plugin */
		define( 'JBLESTAAUTH', true );
		
		/* Bind the data */
		if (! $user->bind( $data ) ) {
			return false;
		}
		
		/* Load the users plugin group */
		JPluginHelper :: importPlugin( 'user' );
		
		/* Store the data */
		if (! $user->save() ) {
			return false;
		}
		
		$response->fullname 		=	$user->name;
		$response->username			=	$user->username;
		$response->email			=	$user->email;
		$response->password			=	$user->password;
		$response->password_clear	=	$credentials['password'];
		$response->status			=	1;
		$response->error_message	=	'';
		return true;
	}
	
	
	/**
	 * Method for building a fullname for the user object
	 * @access		private
	 * @version		@fileVers@
	 * @param		array		The credentials we were passed
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	private function _build_fullname( $credentials )
	{
		$api	=	dunloader( 'api', 'com_jblesta' );
		$user	=	$api->findmatchinguser( $credentials['username'] );
		$name	=	build_fullname( $user );
		return $name;
	}
	
	
	
	/**
	 * Method for building the username for the user object
	 * @access		private
	 * @version		@fileVers@
	 * @param		array		The credentials we were passed
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	private function _build_username( $credentials )
	{
		$config	=	dunloader( 'config', 'com_jblesta' );
		$api	=	dunloader( 'api', 'com_jblesta' );
		
		// If we are using a username on Blesta use it in Joomla!
		if (! is_email( $credentials['username'] ) ) {
			return (string) $credentials['username'];
		}
		
		$user		=	$api->findmatchinguser( $credentials['username'] );
		$username	=	build_username( $user );
		
		return (string) $username;
	}
	
	
	/**
	 * Grabs the Joomla user data
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		Username or email we are searching for
	 * @param		string		Indicates how we should get the user
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	private function _getJoomlauser($method, $by = 'username')
	{
		$db = & JFactory::getDBO();
	
		$query	= "SELECT a.* FROM `#__users` AS a WHERE {$by}={$db->Quote($method)}";
		$db->setQuery($query);
		return $db->loadObject();
	}
}