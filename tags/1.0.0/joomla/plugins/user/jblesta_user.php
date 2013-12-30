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

jimport( 'joomla.application.helper' );
jimport( 'joomla.application.router' );
jimport( 'joomla.application.component.helper' );
jimport( 'joomla.environment.uri' );
jimport( 'joomla.plugin.plugin' );
jimport( 'dunamis.dunamis' );

if ( function_exists( 'get_dunamis' ) ) get_dunamis( 'com_jblesta' );


/**
 * JBlesta User Plugin
 * @desc		This is the user plugin file for Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class plgUserJblesta_user extends JPlugin
{
	
	/**
	 * Stores the client fields we are using from Blesta
	 * @access		private
	 * @since		1.0.0
	 * @var			array
	 */
	private $_clientfields	=	array(
			'company'			=> false,
			'address1'			=> true,
			'address2'			=> false,
			'city'				=> true,
			'state'				=> true,
			'zip'				=> true,
			'country'			=> true,
			'client_id'			=> false,
			'user_id'			=> false,
			'contact_id'		=> false,
			'client_group_id'	=> false,
				);
	
	/**
	 * Indicates we are enabling the user plugin
	 * @access		private
	 * @since		1.0.0
	 * @var			boolean
	 */
	private $_enabled	=	false;
	
	/**
	 * Indicates the user plugin should redirect
	 * @access		public
	 * @since		1.0.0
	 * @var			boolean
	 */
	public $redirect	= true;
	
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
		parent::__construct($subject, $config);
		
		$app	=	JFactory :: getApplication();
		$this->loadLanguage();
		$this->loadLanguage( 'com_jblesta' );
		JFormHelper :: addFieldPath( dirname( __FILE__ ) . '/fields' );
		
		// ==============================================================
		// Run through tests
		// ==============================================================
		// Prevent recursion
		if ( defined( "JBLESTAAPI" ) ) {
			return;
		}
		
		// Ensure we have a token set
		if (! function_exists( 'get_dunamis' ) ) {
			// Not admin or not logged in don't show error message
			if (! $app->isAdmin() || $user->guest ) return;
			
			// Show error message
			$this->_displayError( 'JBLESTA_USER_CONFIG_NODUNAMIS', 'library' );
			return;
		}
		
		get_dunamis( 'com_jblesta' );
		
		if (! $this->_testApi() ) {
			// Not admin don't show error message
			if (! $app->isAdmin() || $user->guest ) return;
			
			$api	=	dunloader( 'api', 'com_jblesta' );
			$error	=	JText :: _( 'COM_JBLESTA_API_' . strtoupper( $api->getError() ) );
			
			// Show error message
			$this->_displayError( array( 'JBLESTA_USER_CONFIG_APIERROR', $error ), 'api' );
			return;
		}
		
		$config	=	dunloader( 'config', 'com_jblesta' );
		
		if (! $config->get( 'enable', false ) ) {
			// Not admin don't show error message
			if (! $app->isAdmin() || $user->guest ) return;
				
			// Show error message
			$this->_displayError( 'JBLESTA_USER_CONFIG_PRODDISABLED', 'globaldisable' );
			return;
		}
		
		if (! $config->get( 'enableuserbridging', false ) ) {
			// Not admin don't show error message
			if (! $app->isAdmin() || $user->guest ) return;
			
			// Show error message
			$this->_displayError( 'JBLESTA_USER_CONFIG_USERDISABLED', 'userdisable' );
			return;
		}
		
		// All good, lets go
		$this->_enabled	=	true;
	}
	
	
	/**
	 * onContentPrepareData event
	 * @access		public
	 * @version		@fileVers@
	 * @param		string			- $context: string
	 * @param		JUser object	- $data: the already assembled user
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function onContentPrepareData( $context, $data )
	{
		// If disabled...
		if (! $this->_enabled ) return true;
		
		// Check we are manipulating a valid form.
		if (! in_array( $context, array( 'com_users.profile', 'com_users.user', 'com_users.registration', 'com_admin.profile' ) ) ) {
			return true;
		}
		
		// We need to have an object
		if (! is_object( $data ) ) {
			return true;
		}
		
		// If we are a new user
		if (! isset( $data->email ) || empty( $data->email ) ) {
			return true;
		}
		
		// Initialize some things
		$api	=	dunloader( 'api', 'com_jblesta' );
		
		// Grab the user
		if (! ( $client = $api->findmatchinguser( $data->email ) ) ) {
			$error	=	JText :: _( 'JBLESTA_API_FINDMATCHINGUSER_NOTFOUND', $data->email );
			//$this->_displayError( array( 'JBLESTA_USER_CONFIG_APIERROR', $error ), 'getclientsdetails', false );
			return true;
		}
		
		if (! isset( $data->client ) ) {
			$data->client	=	array();
		}
		
		// Cycle through the client fields and assign to object
		foreach ( $this->_clientfields as $field => $required )
		{
			if ( $field == 'client_id' ) {
				$data->client['client_id'] = $client->id;
				continue;
			}
			
			$data->client[$field]	=	$client->$field;
		}
	}
	
	
	/**
	 * onContentPrepareForm event
	 * @access		public
	 * @version		@fileVers@
	 * @param		JForm object	- $form: the form being assembled
	 * @param		JUser object	- $data: the already assembled user
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function onContentPrepareForm( $form, $data )
	{
		// If disabled...
		if (! $this->_enabled ) return true;
		
		// Ensure we have a JForm
		if (! ( $form instanceof JForm ) ) {
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}
		
		// Check we are manipulating a valid form.
		$name = $form->getName();
		if (! in_array( $name, array( 'com_users.profile', 'com_users.user', 'com_users.registration', 'com_admin.profile' ) ) ) {
			return true;
		}
		
		// Add the registration fields to the form.
		JForm::addFieldPath( JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_jblesta' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'fields' );
		JForm::addFormPath( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'forms' );
		$form->loadFile( 'client', false );
		
		foreach ( $this->_clientfields as $field => $required ) {
			// Handle registration form requirements
			if ( in_array( $name, array( 'com_users.profile', 'com_users.registration' ) ) ) {
				if ( $required ) {
					$form->setFieldAttribute( $field, 'required', 'required', 'client' );
				}
			}
		}
		
		// See if we have data and bail if not before removing type/id (preprocessSave then?)
		if ( empty( $data ) ) {
			return;
		}
		
		// See if this is a new user - no client then
		if (! isset( $data->client ) && in_array( $name, array( 'com_users.registration', 'com_users.user' ) ) ) {
			$form->removeField('client_id', 'client');
			$form->removeField('user_id', 'client');
			$form->removeField('contact_id', 'client');
		}
	}
	
	
	/**
	 * Event triggered prior to saving a user
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $olduser: the old user details
	 * @param		boolean		- $isNew: indicates this is a new user
	 * @param		object		- $newuser: the new user details
	 *
	 * @since		1.0.0
	 */
	public function onUserBeforeSave( $olduser, $isNew, $newuser )
	{
		// If disabled...
		if (! $this->_enabled ) return true;
		
		// See if no changes were made that affect WHMCS
		if (! $isNew && $olduser['email'] == $newuser['email'] ) {
			return true;
		}
		
		/* Check for recursion from System > API Methods */
		if ( defined( 'JBLESTAAPI' ) ) {
			return;
		}
		
		/* Check for recursion from Authentication > Creating New User */
		if ( defined( 'JBLESTAAUTH' ) ) {
			return true;
		}
		
		$api	=	dunloader( 'api', 'com_jblesta' );
		
		// Can't find client or contact... so must be good
		if (! $client = $api->findmatchinguser( $newuser['email'] ) ) {
			return true;
		}
		
		// At this point the new user's email address is not permitted so we must throw an error and bail
		$this->_displayError( array( 'JBLESTA_USER_VALIDATION_FAILED', $newuser['email'] ), 'uservalidation', false );
		return false;
	}
	
	
	/**
	 * Event triggered after a user is stored in Joomla!
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $user: the user array 
	 * @param		boolean		- $isNew: true|false
	 * @param		boolean		- $result: the result so far
	 * @param		JErrorObject	$error: an error object
	 *
	 * @since		1.0.0
	 */
	public function onUserAfterSave( $data, $isNew, $result, $error )
	{
		// If disabled...
		if (! $this->_enabled ) return true;
		
		/* Check for recursion from System > API Methods */
		if ( defined( 'JBLESTAAPI' ) ) {
			return;
		}
		
		/* Check for recursion from Authentication > Creating New User */
		if ( defined( 'JBLESTAAUTH' ) ) {
			return true;
		}
		
		$api		=	dunloader( 'api', 'com_jblesta' );
		$config		=	dunloader( 'config', 'com_jblesta' );
		$input		=	dunloader( 'input', true );
		
		$task		=	'update';
		$client		=	JArrayHelper :: getValue( $data, 'client', array(), 'array' );
		
		// See if we are adding or updating user
		if ( $isNew || (! isset( $client['user_id'] ) && ! isset( $client['id'] ) && ! isset( $client['contact_id'] ) && in_array( $config->get( 'useraddmethod', '4' ), array( '2', '4' ) ) ) ) {
			$task	=	'create';
		}
		else if ( ! $isNew && ! isset( $client['user_id'] ) && ! isset( $client['id'] ) && ! isset( $client['contact_id'] ) && ! in_array( $config->get( 'useraddmethod', '4' ), array( '2', '4' ) ) ) {
			// We don't want to add users when updating an account so bail
			return true;
		}
		
		
		// ============================================================================
		// Assemble one array of values first
		// ============================================================================
		
		
		$fullname	=	JArrayHelper :: getValue( $data, 'name', null, 'string' );
		
		// Split the full name to create first / last name and grab email
		$parts	=	explode( " ", $fullname );
		$client['first_name']	=	array_shift( $parts );
		$client['last_name']		=	(! empty( $parts ) ? implode( " ", $parts ) : ' ' );
		$client['username']		=	$data['username'];
		$client['email']		=	$data['email'];
		
		// Catch Enable / Disable toggles
		if (! $isNew && ! isset( $client['user_id'] ) )
		{
			$exists = $api->findmatchinguser( $client['email'] );
			
			if ( $exists )
			{
				$task = 'update';
				$client['user_id']		=	$exists->user_id;
				$client['contact_id']	=	$exists->contact_id;
				$client['client_id']	=	$exists->id;
				//unset( $client['email'], $client['firstname'], $client['lastname'] );
			}
		}
		
		// Blocks
		if ( $data['block'] == '1' ) {
			$client['status']	=	'inactive';
		}
		else {
			$client['status']	=	'active';
		}
		
		// API CALLS FOR DETAILS
		$state				=	$api->getstate( $client['country'], $client['state'] );
		$client['state']	=	$state->code;
		$country			=	$api->getcountry( $client['country'] );
		$client['country']	=	$country->alpha3;
		
		
		// -----------------
		// PASSWORD HANDLING
		// -----------------
		if ( $isNew && isset( $data['password_clear'] ) && ! empty( $data['password_clear'] ) ) {
			$client['new_password']		=	$data['password_clear'];
		}
		else if ( $isNew || (! $isNew && $task == 'create' ) ) {
			$client['new_password']		=	JApplication :: getHash( mt_rand() );
		}
		// Backend edit check
		else if ( is_admin() ) {
			// Grab the form data from input handler
			$jform	=	$input->getVar( 'jform', array(), 'array' );
			
			// If we set the password in the form then we should update it
			if ( isset( $jform['password'] ) && ! empty( $jform['password'] ) ) {
				$client['new_password']		=	$jform['password'];
			}
		}
		// Front End is slightly different
		else {
			$jform	=	$input->getVar( 'jform', array(), 'array' );
				
			// If we set the password in the form then we should update it
			if ( isset( $jform['password1'] ) && ! empty( $jform['password1'] ) ) {
				$client['new_password']	=	$jform['password1'];
			}
		}
		
		if ( isset( $client['new_password'] ) ) {
			$client['confirm_password']	=	$client['new_password'];
		}
		// ----------------
		// END PASSWORD GET
		// ----------------
		
		
		// ============================================================================
		// Creating a new client
		// ============================================================================
		
		
		if ( $task == 'create' )
		{
			// Create our user first
			$result = $api->adduser( $client );
			
			if (! $result ) {
				$this->_displayError( array( 'JBLESTA_USER_CONFIG_APIERROR', $api->getError() ), 'adduser', false );
				return false;
			}
			
			$client['user_id']	=	$result;
			
			// Create our client next
			$result	=	$api->addclient( $client );
			
			if (! $result ) {
				// We must roll back by deleting the user
				$api->deleteuser( $client['user_id'] );
				
				$this->_displayError( array( 'JBLESTA_USER_CONFIG_APIERROR', $api->getError() ), 'adduser', false );
				return false;
			}
			
			$client['client_id']	=	$result;
			
			// Create our contact finally
			$result	=	$api->addcontact( $client );
			
			if (! $result ) {
				// We must roll back the client and user now
				$api->deleteclient( $client['client_id'] );
				$api->deleteuser( $client['user_id'] );
				
				$this->_displayError( array( 'JBLESTA_USER_CONFIG_APIERROR', $api->getError() ), 'adduser', false );
				return false;
			}
			
			return true;
		}
		
		// ============================================================================
		// Editing an existing client
		// ============================================================================
		
		// Edit our user first
		$result = $api->edituser( $client['user_id'], $client );
		
		if (! $result ) {
			$this->_displayError( array( 'JBLESTA_USER_CONFIG_APIERROR', $api->getError() ), 'adduser', false );
			return false;
		}
		
		// Edit our client next
		$result	= $api->editclient( $client['client_id'], $client );
		
		if (! $result ) {
			$this->_displayError( array( 'JBLESTA_USER_CONFIG_APIERROR', $api->getError() ), 'adduser', false );
			return false;
		}
		
		// Edit our contact next
		$result	= $api->editcontact( $client['contact_id'], $client );
		
		if (! $result ) {
			$this->_displayError( array( 'JBLESTA_USER_CONFIG_APIERROR', $api->getError() ), 'adduser', false );
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Event triggered prior to deletion of a user in Joomla!
	 * @access		public
	 * @version		@fileVers@
	 * @param		JUser Object	$user
	 * 
	 * @since		1.0.0
	 */
	public function onUserBeforeDelete($user)
	{
		// If disabled...
		if (! $this->_enabled ) return true;
	}
	
	
	
	/**
	 * Event triggered after deletion of a user in Joomla!
	 * @access		public
	 * @version		@fileVers@
	 * @param		array			$user
	 * @param		boolean			$succes
	 * @param		JErrorObject	$msg
	 * 
	 * @since		1.0.0
	 */
	public function onUserAfterDelete($user, $succes, $msg)
	{
		// If disabled...
		if (! $this->_enabled ) return true;
		
		$post	=	array();
		$config	=	dunloader( 'config', 'com_jblesta' );
		$api	=	dunloader( 'api', 'com_jblesta' );
		
		// If we do nothing, then get outta here
		if ( ( $userdeletemethod = $config->get( 'userdeletemethod' ) ) == '0' ) {
			return;
		}
		
		// Find the user
		$client	=	$api->findmatchinguser( $user['email'] );
		$client->client_id	=	$client->id;
		
		// We want to simply close / unsubaccount the account
		if ( $userdeletemethod == '1' ) {
			$result	=	$api->editclient( $client->client_id, array( 'status' => 'inactive' ) );
		}
		// Physically delete the client / contact
		else if ( $userdeletemethod == '2' ) {
			$result	=	$api->deleteclient( $client->client_id );
		}
		
		// If we failed over on WHMCS, then throw an error, but its too late here
		if (! $result ) {
			$this->_displayError( array( 'JBLESTA_USER_CONFIG_APIERROR', $api->getError() ), 'deleteclient', false );
		}
		
		return;
	}

	
	/**
	 * Event triggered at user login
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $user: contains the user array
	 * @param		array		- $options: contains options
	 * 
	 * @since		1.0.0
	 */
	public function onUserLogin($user, $options)
	{
		// Ensure we can run this
		if (! $this->_enabled ) {
			return;
		}
		
		if ( JFactory::getApplication()->isAdmin() ) {
			return; // Dont run in admin
		}
		
		// Don't auth against W if we are coming from W
		if ( isset( $options['jblesta'] ) && $options['jblesta'] ) {
			return;
		}
		
		// Handle Remember Me
		$this->_handleRememberme( $user, $options );
		
		// Initialize Login to Blesta
		$api		=	dunloader( 'api', 'com_jblesta' );
		$app		=	JFactory::getApplication();
		$config		=	dunloader( 'config', 'com_jblesta' );
		$gmt		=	new DateTime( null, new DateTimeZone('GMT') );
		$buser		=	$api->findmatchinguser( $user['email'] );
		
		// Build our hash
		$key	=	$config->get( 'token', null );
		$t		=	time();
		$u		=	$buser->username;
		
		// Clean up the return url... just in case
		if ( isset( $options['return'] ) && $options['return'] && DunUri :: isInternal( $options['return'] ) ) {
			$return_uri	=	DunUri :: getInstance( JRoute :: _( $options['return'] ) );
			$server_uri	=	DunUri :: getInstance();
			$return_uri->setScheme( $server_uri->getScheme() );
			$return_uri->setHost( $server_uri->getHost() );
			$options['return']	=	$return_uri->toString();
		}
		
		$r		=	$options['return'];
		$h		=	hash_hmac( "sha256", $t . $u . $r, $key );
		
		// Create our login URL
		$url	=	$config->get( 'blestaapiurl' );
		$uri	=	DunUri :: getInstance( $url, true );
		$uri->setPath( rtrim( $uri->getPath(), '/' ) . '/plugin/jblesta/login/' );
		$uri->setVar( 'u', $u );
		$uri->setVar( 't', $t );
		$uri->setVar( 'r', $r );
		$uri->setVar( 'h', $h );
		
		$app->redirect( $uri->toString() );
		$app->close();
		
		return true;
	}

	
	/**
	 * Event triggered on user logout
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $user: logged out user array
	 * 
	 * @since		1.0.0
	 */
	public function onUserLogout( $user, $options = array() )
	{
		// Ensure we can run this
		if (! $this->_enabled ) {
			return;
		}
		
		if ( JFactory::getApplication()->isAdmin() ) {
			return; // Dont run in admin
		}
		
		// Don't logout from W if we are coming from W
		if ( isset( $options['jblesta'] ) && $options['jblesta'] ) {
			return;
		}
		
		$this->_handleRemembermenot();
		
		// Initialize
		$app		=	JFactory::getApplication();
		$config		=	dunloader( 'config', 'com_jblesta' );
		$input		=	dunloader( 'input', true );
		
		$return_uri	=	DunUri :: getInstance( JRoute :: _( base64_decode( $input->getVar( 'return', null ) ) ) );
		$server_uri	=	DunUri :: getInstance();
		
		$return_uri->setScheme( $server_uri->getScheme() );
		$return_uri->setHost( $server_uri->getHost() );
		
		$url	=	$config->get( 'blestaapiurl' );
		$uri	=	DunUri :: getInstance( $url, true );
		$uri->setPath( rtrim( $uri->getPath(), '/' )  . '/plugin/jblesta/logout/' );
		$uri->setVar( 'jblesta', base64_encode( $return_uri->toString() ) );
		
		$app->redirect( $uri->toString() );
		$app->close();
		return true;
	}
	
	
	/**
	 * Method to create a hash
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $seed: a seed for the md5er
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	public static function createHash( $seed )
	{
		return md5( JFactory::getConfig()->get('secret') . $seed );
	}
	
	
	/**
	 * Method to determine if we are using ssl
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public static function isSslconnection()
	{
		return ( ( isset( $_SERVER['HTTPS'] ) && ( $_SERVER['HTTPS'] == 'on' ) ) || getenv( 'SSL_PROTOCOL_VERSION' ) );
	}
	
	
	/**
	 * Common method for displaying an error message
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $msg: the message to display
	 * @param		string		- $task: the task we are calling from
	 * @param		boolean		- $usesession: indicates we should check / store in session
	 *
	 * @since		1.0.0
	 */
	private function _displayError( $msg = null, $task = 'framework', $usesession = true )
	{
		// Translate string first
		if ( is_array( $msg ) ) {
			$string	=	JText :: _( array_shift( $msg ) );
			array_unshift( $msg, $string );
			$msg	=	call_user_func_array( 'sprintf', $msg );
		}
		else {
			$msg		=	JText :: _( $msg );
		}
		
		// If we want to use the session do so
		if ( $usesession ) {
			$session	=	JFactory :: getSession();
			$hasrun		=	$session->get( 'jblesta_user.' . $task, false );
			
			if ( $hasrun ) {
				return;
			}
			else {
				$session->set( 'jblesta_user.' . $task, true );
			}
		}
		
		// Provide means to only show error one time
		static $instance = array();
		
		if ( isset( $instance[$task] ) ) {
			return;
		}
		
		$instance[$task]	=	true;
		
		// Get to the error message
		if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
			JFactory::getApplication()->enqueueMessage( "{$msg}" );
		}
		else {
			JError::raiseNotice( 100, "{$msg}" );
		}
	}
	
	
	/**
	 * Method for handling the Remember me being set on login form
	 * @access		private
	 * @version		@fileVers@
	 * @param		array		- $user: user data 
	 * @param		array		- $options: options sent
	 *
	 * @since		1.0.0
	 */
	private function _handleRememberme( $user, $options = array() )
	{
		$config	=	dunloader( 'config', true );
		$input	=	dunloader( 'input', true );
		
		if (! isset( $options['remember'] ) || ! $options['remember'] ) {
			return;
		}
		
		$credentials				= array(
				'username'	=>	$input->getVar( 'username', null ),
				'password'	=>	$input->getVar( 'password', null )
				);
		
		jimport('joomla.utilities.simplecrypt');
		
		if ( version_compare( JVERSION, '2.5.6', 'ge' ) ) {
			$privateKey	=	self :: createHash( @$_SERVER['HTTP_USER_AGENT'] );
			$key		=	new JCryptKey( 'simple', $privateKey, $privateKey );
			$crypt		=	new JCrypt( new JCryptCipherSimple, $key );
			$rcookie	=	$crypt->encrypt( json_encode( $credentials ) );
			$lifetime	=	time() + 365 * 24 * 60 * 60;
			
			// Use domain and path set in config for cookie if it exists.
			$cookie_domain	=	$config->get( 'cookie_domain', '' );
			$cookie_path	=	$config->get( 'cookie_path', '/' );
			$secure			=	self :: isSslconnection();
			setcookie( self :: createHash( 'JLOGIN_REMEMBER' ), $rcookie, $lifetime, $cookie_path, $cookie_domain, $secure, true );
		}
		else {
			
			// Create the encryption key, apply extra hardening using the user agent string.
			$key			=	self :: createHash( @$_SERVER['HTTP_USER_AGENT'] );
			$crypt			=	new JSimpleCrypt( $key );
			$rcookie		=	$crypt->encrypt( serialize( $credentials ) );
			$lifetime		=	time() + 365 * 24 * 60 * 60;
			
			// Use domain and path set in config for cookie if it exists.
			$cookie_domain	=	$config->get( 'cookie_domain', '' );
			$cookie_path	=	$config->get( 'cookie_path', '/' );
			setcookie( self :: createHash( 'JLOGIN_REMEMBER' ), $rcookie, $lifetime, $cookie_path, $cookie_domain );
		}
	}
	
	
	/**
	 * Method to kill the remember me cookie
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		true
	 * @since		1.0.0
	 */
	private function _handleRemembermenot()
	{
		$config			=	dunloader( 'config', true );
		$cookie_domain	=	$config->get( 'cookie_domain', '' );
		$cookie_path	=	$config->get( 'cookie_path', '/' );
		
		setcookie( self :: createHash( 'JLOGIN_REMEMBER' ), false, time() - 86400, $cookie_path, $cookie_domain );
		
		return true;
	}
	
	
	/**
	 * Provide means to test the API one time
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	private function _testApi()
	{
		$session	=	JFactory :: getSession();
		$isvalid	=	$session->get( 'jblesta_user.apicheck', false );
		
		if ( $isvalid ) return true;
		
		$api		=	dunloader( 'api', 'com_jblesta' );
		$isvalid	=	$api->ping();
		
		if ( $isvalid ) {
			$session->set( 'jblesta_user.apicheck', true );
		}
		
		return (bool) $isvalid;
	}
}