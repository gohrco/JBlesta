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
defined( 'JBLESTASYSM_FILEPATH' ) or define( 'JBLESTASYSM_FILEPATH', dirname( __FILE__) . DIRECTORY_SEPARATOR );

jimport( 'dunamis.dunamis' );
jimport( 'joomla.plugin.plugin' );

if ( function_exists( 'get_dunamis' ) ) get_dunamis( 'com_jblesta' );

/**
 * JBlesta System Plugin
 * @desc		This is the system plugin file for Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class plgSystemJblesta_sysm extends JPlugin
{
	
	/**
	 * Property indicating if the plugin should be enabled or not
	 * @access		private
	 * @var			boolean
	 * @since		1.0.0
	 */
	private $_enabled	=	false;
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $subject: The object to observe
	 * @param 		array		- $config: An array that holds the plugin configuration
	 * 
	 * @since		1.0.0
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct( $subject, $config );
		
		$this->loadLanguage();
		
		$app		=	JFactory :: getApplication();
		$user		=	JFactory :: getUser();
		
		// Run through tests
		// -----------------
		// Ensure we have Dunamis installed
		if (! function_exists( 'get_dunamis' ) ) {
			// Not admin don't show error message
			if (! $app->isAdmin() || $user->guest ) return;
			
			// Show error message
			$this->_displayError( 'JBLESTA_SYSM_CONFIG_NODUNAMIS', 'library' );
			return;
		}
		
		get_dunamis( 'com_jblesta' );
		$config	=	dunloader( 'config', 'com_jblesta' );
		
		if (! is_a( $config, 'Com_jblestaDunConfig' ) ) {
			// Not admin or not logged in don't show error message
			if (! $app->isAdmin() || $user->guest ) return;
				
			// Show error message
			$this->_displayError( 'JBLESTA_SYSM_CONFIG_NOJBLESTACONFIG', 'jblestaconfig' );
			return;
		}
		
		// Ensure we are active...
		if (! $config->get( 'enable' ) ) {
			// Not admin or not logged in don't show error message
			if (! $app->isAdmin() || $user->guest ) return;
			
			// Show error message
			$this->_displayError( 'JBLESTA_SYSM_CONFIG_NOTENABLED', 'enable' );
			return;
		}
		
		// Ensure we have a token set
		if (! $config->get( 'token' ) ) {
			// Not admin or not logged in don't show error message
			if (! $app->isAdmin() || $user->guest ) return;
				
			// Show error message
			$this->_displayError( 'JBLESTA_SYSM_CONFIG_NOTOKEN', 'token' );
			return;
		}
		
		// All good, lets go
		$this->_enabled	=	true;
		
		// But before we go...
		if ( $config->get( 'debug' ) ) {
			// Visitors shouldn't be bothered
			if ( $user->guest ) return;
			
			// WARN EVERYONE ELSE THO
			$this->_displayError( 'JBLESTA_SYSM_CONFIG_DEBUGON', 'debug', false );
		}
	}
	
	
	/**
	 * Method to generate a signature for validation
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public static function generateSignature()
	{
		get_dunamis( 'jblesta_sysm' );
		$config	=	dunloader( 'config', 'com_jblesta' );
		$input	=	dunloader( 'input', true );
		
		$method	=	self :: getMethod();
		$token	=	$config->get( 'token' );
		$uri	=	clone DunUri :: getInstance( 'SERVER', true );
		$append	=	null;
		
		// Cleanup language uri redirections :(
		if ( ( $l = $uri->getVar( 'lang', false ) ) ) {
			$path	=	$uri->getPath();
			$path	=	str_replace( '/' . $l . '/', '', $path );
			$uri->setPath( $path );
		}
		
		// When using SEF Rewrite feature in Joomla core, the index.php is stripped out of the URL, so signature must be adjusted
		$isSef		=	self :: _usingSefrewrite();
		
		if ( $isSef && strpos( $uri->getPath(), 'index.php' ) === false ) {
			$path	=	rtrim( $uri->getPath(), '/' ) . '/index.php';
			$uri->setPath( $path );
		}
		
		if ( $method == 'post' ) {
			$post	=	$_POST;
			ksort( $post );
			foreach ( $post as $k => $v ) {
				if ( $k == 'apisignature' ) continue;
				if ( is_array( $v ) ) {
					foreach ( $v as $k2 => $v2 ) {
						$append .= $k.$k2.$v2;
					}
				}
				else {
					$append	.=	$k.$v;
				}
			}
		}
		else if ( $method == 'get' || $method == 'put' ) {
			$uri->delVar( 'apisignature' );
		}
		
		return base64_encode( hash_hmac( 'sha256', rawurldecode( $uri->toString() . $append ), $token, true ) );
	}
	
	
	/**
	 * Method to determine which method we are using to access the API
	 * @static
	 * @access		public
	 * @version		@fileVers@ 
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	public static function getMethod()
	{
		if ( version_compare( JVERSION, '1.7.0', 'ge' ) ) {
			$app	= & JFactory :: getApplication();
			return strtolower( $app->input->getMethod() );
		}
		else {
			return strtolower( JRequest :: getMethod() );
		}
	}
	
	
	/**
	 * onAfterInitialise event
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function onAfterInitialise()
	{
		$app = JFactory::getApplication();
		
		// Update sessions if need be (due to group update potentiality)
		$this->_updateSessions();
		
		// Handle the API requests (true indicates we handled an API call so we shouldn't do anything else - if we are even still here)
		if ( $this->_handleApi() ) {
			return;
		}
		
		// No remember me for admin
		if ( $app->isAdmin() ) {
			return;
		}
		
		// Only for front end logins...
		if ( $this->_handleAutoauth() ) {
			return;
		}
		
		// Only for front end logouts...
		if ( $this->_handleAutologouts() ) {
			return;
		}
		
		return;
	}
	
	
	/**
	 * onAfterRender event
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function onAfterRender()
	{
		// Ensure we can run this
		if (! $this->_enabled ) return false;
		
		/* Yeay Dunamis! */
		get_dunamis( 'com_jblesta' );
		
		// Hand off for the language
		$this->_handleLanguage();
		
		return;
		
	}
	
	
	/**
	 * onAfterRoute event
	 * @access		public
	 * @version		@fileVers@ 
	 *
	 * @since		1.0.0
	 */
	public function onAfterRoute()
	{
		// Ensure we can run this
		if (! $this->_enabled ) return false;
		
		// Initialize
		$config		=	dunloader( 'config', 'com_jblesta' );
		$api		=	dunloader( 'api', 'com_jblesta' );
		$input		=	dunloader( 'input', true );
		$joomla		=   $this->_getJoomlaTasks();
		$app		=	JFactory :: getApplication();
		$user 		=	JFactory :: getUser();
		$option 	=	$input->getVar( 'option' );
		$task   	=   $input->getVar( 'task' );
		$view		=   $input->getVar( 'view' );
		$layout		=   $input->getVar( 'layout' );
		$newlink	=	null;
		
		// Determine if we should run this
		if (! $config->get( 'enableuserbridging' ) ) return false; 
		
		// Registration Method
		$regmethod	=	$config->get( 'regmethod' );
		$orderform	=	$config->get( 'registrationform' );
		
		// ======================================
		// 	REGISTRATION CHECK
		// ======================================
		if (	$option == $joomla->component
			&&	(	$task == $joomla->regtask
				||	$view == $joomla->regview )
			&&	$regmethod == '1'
			&&	$user->get( 'guest' ) 
			&&	$orderform )
		{
			$form	=	$api->getorderform( $orderform );
			
			if ( $form ) {
				$uri		=	DunUri :: getInstance( $config->get( 'blestaapiurl' ), true );
				$uri->setPath( rtrim( $uri->getPath(), '/' ) . '/plugin/order/main/signup/' . $form->label );
				$newlink	=	$uri->toString();
			}
		}
		
		if ( $newlink != null ) {
			$app->redirect( $newlink );
		}
		
		return;
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
		return;
// 		// If disabled...
// 		if (! $this->_enabled ) return true;
		
// 		// Ensure we have a JForm
// 		if (! ( $form instanceof JForm ) ) {
// 			$this->_subject->setError('JERROR_NOT_A_FORM');
// 			return false;
// 		}
		
// 		// Form is 'com_config.component'
// 		if ( ( $name = $form->getName() ) != 'com_config.component' ) {
// 			return true;
// 		}
		
// 		// We must isolate our configuration
// 		$group = $form->getGroup( 'jblestalanguage' );
// 		if (! isset( $group['jform_jblestalanguage_languageenable'] ) ) {
// 			return true;
// 		}
		
// 		// Gather available options from WHMCS
// 		$langoptions	=	$this->_getLanguageChoices( 'whmcs' );
// 		$joomlangs		=	$this->_getLanguageChoices();
		
// 		$cnt	=	0;
// 		$xmlstr	=	'<fieldset name="jblestalanguage" label="LANGUAGE_SETTINGS">'
// 				.	'<field name="languageenable" type="radio" label="COM_JBLESTA_CONFIG_LANGUAGEENABLE_LABEL" description="COM_JBLESTA_CONFIG_LANGUAGEENABLE_DESC" class="inputbox btn-group" default="0">'
// 				.		'<option value="1">JYES</option>'
// 				.		'<option value="0">JNO</option>'
// 				.	'</field>'
// 				.	'<field name="languagemap_default" type="list" label="DEFAULT">' . $langoptions . '</field>';
		
// 		$langoptions	=	'<option value="0">Use Default Language</option>' . $langoptions;
		
// 		foreach ( $joomlangs as $lang ) {
// 			$xmlstr	.=	'<field name="languagemap_' . $lang->code . '" label="' . $lang->name . '" default="0" type="list">'
// 					.		$langoptions
// 					.	'</field>';
// 			$cnt++;
// 		}
		
// 		$xmlstr	.=	'</fieldset>';
// 		$xml	=	simplexml_load_string( $xmlstr );
		
// 		$form->setField( $xml, 'jblestalanguage', true );
		
	}
	
	
	/**
	 * Method to compare signatures
	 * @desc		Used to prevent timing attacks
	 * @access		private
	 * @version		@fileVers@ 
	 * @param		string		- $a: signature 1
	 * @param		string		- $b: signature 2
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	private function _compareSignatures( $a, $b )
	{
		$diff = strlen($a) ^ strlen($b);
		
		for ( $i = 0; $i < strlen($a) && $i < strlen($b); $i++ ) {
			$diff |= ord( $a[$i] ) ^ ord( $b[$i] );
		}
		
		return $diff === 0;
	}
	
	
	/**
	 * Common method for displaying an error message
	 * @access		private
	 * @version		@fileVers@ 
	 * @param		string		- $msg: the message to display
	 *
	 * @since		1.0.0
	 */
	private function _displayError( $msg = null, $task = 'token', $usesess = true )
	{	
		// Translate string first
		$msg		=	JText :: _( $msg );
		$session	=	JFactory :: getSession();
		
		$hasrun		=	$session->get( 'jblesta_sysm.' . $task, false );
		
		if ( $hasrun && $usesess ) {
			return;
		}
		elseif ( $usesess ) {
			$session->set( 'jblesta_sysm.' . $task, true );
		}
		
		if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
			JFactory::getApplication()->enqueueMessage( "{$msg}" );
		}
		else {
			JError::raiseNotice( 100, "{$msg}" );
		}
	}
	
	
	/**
	 * Method for calling up a failed response
	 * @access		private
	 * @version		@fileVers@
	 * @param		mixed		- $message: the message to fail on
	 *
	 * @since		2.5.0
	 */
	private function _fail( $message )
	{
		$string	= json_encode( array( 'result' => 'error', 'error' => $message ) );
		exit( $string );
	}
	
	
	/**
	 * Method for determining the requested API version
	 * @access		private
	 * @version		@fileVers@
	 * @param		md5 string		- $sent: we should be sent an md5 hashed string of the intended version
	 *
	 * @return		string containing found matching hashed version or 1.0 as the default
	 * @since		1.0.0
	 */
	private function _findApiversion( $sent = null )
	{
		$apipath	=	JBLESTASYSM_FILEPATH . 'api' . DIRECTORY_SEPARATOR;
	
		$dh		= opendir( $apipath );
		$data	=	array();
		while( ( $filename = readdir( $dh ) ) !== false ) {
			if ( in_array( $filename, array( '.', '..', 'index.html' ) ) ) continue;
			$data[md5( $filename )]	= $filename;
		}
	
		if ( isset( $data[$sent] ) ) return $data[$sent];
		else return '1.0';
	}
	
	
	/**
	 * Method to assemble Joomla tasks
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		object
	 * @since		1.0.0
	 */
	private function _getJoomlaTasks()
	{
		$data	= array(
				'component'		=>	'com_users',
				'regtask'		=>	'registration',
				'regview'		=>	'registration',
				'edittask'		=>	'profile.edit',
				'editview'		=>	'edit',
				'userview'		=>	'user',
				'formlayout'	=>	'form',
				'resettask'		=>	'reset',
				'resetview'		=>	'reset',
				);
		
		return (object) $data;
	}
	
	
	/**
	 * Method to get either Joomla or WHMCS language options
	 * @access		private
	 * @version		@fileVers@ 
	 * @param		string		- $type: indicates type wanted [joomla|whmcs]
	 *
	 * @return		mixed [array for Joomla|string for WHMCS]
	 * @since		1.0.0
	 */
	private function _getLanguageChoices( $type = 'joomla' )
	{
		return;
// 		get_dunamis( 'com_jblesta' );
		
// 		switch ( $type ) :
// 		case 'joomla' :
			
// 			$db		=	dunloader( 'database', true );
// 			$data	=	array();
			
// 			// ---- BEGIN JWHMCS-26
// 			//		Language Menu in Joomla not displaying correctly
// 			mysql_set_charset( 'utf8' );
// 			// ---- END JWHMCS-26
			
// 			$query	=	"SHOW TABLES LIKE " . $db->Quote( "%languages" );
// 			$db->setQuery( $query );
// 			$result	=	$db->loadResult();
			
// 			if (! $result ) {
// 				return $data;
// 			}
			
// 			$query	=	"SELECT `title` as `name`, `lang_code` as `code`, `sef` as `shortcode` FROM #__languages WHERE `published` <> '-2' ORDER BY name";
// 			$db->setQuery( $query );
// 			$data	=	$db->loadObjectList();
			
// 			break;
// 		case 'whmcs' :
			
// 			$api	=	dunloader( 'api', 'com_jblesta' );
// 			$langs	=	$api->getlanguages();
// 			$data	=	null;
			
// 			foreach ( $langs as $lang ) {
// 				$data	.=	'<option value="' . $lang . '">' . ucfirst( $lang ) . '</option>';
// 			}
			
// 			break;
// 		endswitch;
		
// 		return $data;
	}
	
	
	/**
	 * Handles the calls for the API interface
	 * @access		public
	 * @version		@fileVers@ 
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	private function _handleApi()
	{
		// Ensure we can run this
		if (! $this->_enabled ) return false;
		
		/* Yeay Dunamis! */
		get_dunamis();
		
		// Initialize some fun Dunamis things
		$input	=	dunloader( 'input', true );
		$config	=	dunloader( 'config', 'com_jblesta' );
		
		// Grab the method first
		$method	=	$input->getMethod();
		
		// See if we should do anything
		if (! ( $jblesta =	$input->getVar( 'jblesta', false, $method ) ) ) {
			// If we aren't getting the jwhmcs variable than we should assume this is a normal request
			// and send the user on their way
			return false;
		}
		
		
		// ==============================================================
		//	We have a J!WHMCS request so lets test the signature
		// ==============================================================
		
		// See if we have matching signatures
		$postsig	=	(string) rawurldecode( $input->getVar( 'apisignature', false, 'STRING', $method ) );
		$headsig	=	(string) rawurldecode( $input->getVar( 'HTTP_JBLESTAREQUESTSIGNATURE', false, 'STRING', 'server' ) );
		
		// WARNING - BE SURE DEBUG IS DISABLED IN PRODUCTION!
		if ( $config->get( 'debug', false ) ) {
			$headsig = $postsig;
		}
		
		if ( $this->_compareSignatures( $postsig, $headsig ) !== true ) {
			$this->_fail( JText :: _( 'JBLESTA_SYSM_API_BADSIGNATURE_1' ) );
		}
		
		// Test the signature - randomize head / post sig use
		$_received_signature	=	(string) ( rand( 0, 1 ) == '1' ? $headsig : $postsig );
		$_generatedsignature	=	(string) plgSystemJblesta_sysm :: generateSignature();
		
		// Bail if the signatures dont match
		if ( $this->_compareSignatures( $_received_signature, $_generatedsignature ) !== true ) {
			$this->_fail( JText :: _( 'JBLESTA_SYSM_API_BADSIGNATURE_2' ) );
		}
		
		// Test the timestamp to ensure recent request
		$gmt		=	new DateTime( null, new DateTimeZone('GMT') );
		$current	=	$gmt->format("U");
		$timestamp	=	$input->getVar( 'apitimestamp', 0, $method );
		$timediff	=	( $config->get( 'debug' ) ? 300 : 45 );
		
		// Test the timestamp
		if ( ( $current - $timestamp ) > $timediff ) {
			// The request is older than 2 minutes... something isn't right
			$this->_fail( JText :: _( 'JBLESTA_SYSM_API_OLDREQUEST' ) );
		}
		
		
		// ================================================================
		//	Lets find the base for the API
		// ================================================================
		
		// Take the J!WHMCS Request to get the base loaded
		$parts		=	explode( "/", trim( $jblesta, '/' ) );
		$apiversion	=	array_shift( $parts );
		$apirequest	=	array_shift( $parts );
		
		// Find the api path
		$apipath	=	JBLESTASYSM_FILEPATH . 'api' . DIRECTORY_SEPARATOR;
		
		// Permit possibilities of versioned API
		$apiversion	=	$this->_findApiversion( $apiversion );
		$apipath	.=	$apiversion . DIRECTORY_SEPARATOR;
		
		// Be sure we dont fail ugly - we must have the base
		if (! file_exists(  $apipath . 'base.php' ) ) {
			// If for some reason we don't have the base file for the API for Belong there may
			// have been a problem during installation.
			$this->_fail( sprintf( JText :: _( 'JBLESTA_SYSM_API_BASE_NOPATH' ), $apipath . 'base.php' ) );
		}
		
		// Load the base api file
		@require_once( $apipath . 'base.php' );
		
		$classname	= 'JblestaAPI';
		
		// Be sure we dont fail ugly - we must have the base
		if (! class_exists( $classname ) ) {
			// If for some reason we don't have the base class but was able to find the file something
			// is fishy so bail
			$this->_fail( sprintf( JText :: _( 'JBLESTA_SYSM_API_BASE_NOCLASS' ), $classname ) );
		}
		
		
		
		// =============================================================
		//	Now lets find the actual request
		// =============================================================
		
		// API classname
		$apiclassname	= ucfirst( $apirequest ) . $classname;
		
		// Find the api filename
		// @TODO:  Check for safe mode as file exists may fail otherwise
		if ( file_exists( $apipath . strtolower( $apirequest ) . '.php' ) ) {
			@require_once( $apipath . strtolower( $apirequest ) . '.php' );
		}
		
		// Be sure we dont fail ugly
		if (! class_exists( $apiclassname ) ) {
			$this->_fail( sprintf( 'API Method `%s` is unknown.', $apirequest ) );
		}
		
		// Prevent recursion
		define( 'JBLESTAAPI', true );
		
		// Initialize the class and execute
		$api	=	new $apiclassname();
		$result	=	$api->execute();
		
		return $result;
	}
	
	
	/**
	 * Handles the autoauth routine coming from Blesta
	 * @access		private
	 * @version		@fileVers@ 
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	private function _handleAutoauth()
	{
		// Ensure we can run this
		if (! $this->_enabled ) return false;
		
		/* Yeay Dunamis! */
		get_dunamis( 'jblesta_sysm' );
		
		// Initialize some fun Dunamis things
		$input	=	dunloader( 'input', true );
		$config	=	dunloader( 'config', 'com_jblesta' );
		
		// Be sure we need to do this
		if ( $input->getVar( 'task', false ) != 'autoauth' ) {
			return false;
		}
		
		
		// =============================================================
		//	Build our list of variables
		// =============================================================
		
		$token		=	$config->get( 'token' );
		$timestamp	=	(string) $input->getVar( 'timestamp', null, 'STRING', 'get' );
		$signature	=	(string) $input->getVar( 'signature', null, 'STRING', 'get' );
		$username	=	(string) $input->getVar( 'username', null, 'STRING', 'get');
		$checksign	=	(string) $input->getVar( 'checksign', null, 'STRING', 'get');
		$returnurl	=	(string) $input->getVar( 'returnurl', null, 'STRING', 'get' );
		
		// Be sure we have it all together
		if (! $timestamp || ! $signature || ! $username || ! $checksign || ! $token || ! $returnurl ) {
			return false;
		}
		
		
		// =============================================================
		//	Check our username first
		// =============================================================
		$oursign	=	(string) base64_encode( hash_hmac( 'sha256', $username . $timestamp . $token, $token, true ) );
		
		if ( $this->_compareSignatures( $oursign, $checksign ) !== true ) {
			return false;
		}
		
		
		// =============================================================
		//	Next lets pull the email address for that username
		// =============================================================
		$user		=	JUser :: getInstance( $username );
		
		// Ensure we have a user known by that username
		if (! $user ) {
			return false;
		}
		
		$newsign	=	(string) base64_encode( hash_hmac( 'sha256', $user->get( 'email', false ) . $timestamp . $token, $token, true ) );
		
		if ( $this->_compareSignatures( $newsign, $signature ) !== true ) {
			return false;
		}
		
		
		// =============================================================
		//	Time check
		// =============================================================
		if ( ( time() - $timestamp ) > 120 ) {
			return false;
		}
		
		
		// =============================================================
		//	Alright, let's authorize them
		// =============================================================
		$response	=	new stdClass();
		$response->fullname 	= $user->get( 'name' );
		$response->username		= $user->get( 'username');
		$response->email		= $user->get( 'email' );
		$response->password		= $user->get( 'password' );
		$response->password_clear = null;
		$response->status		= 1;
		$response->error_message = '';
		
		
		// =============================================================
		//	Perform our login magic and return home
		// =============================================================
		$app	=	JFactory :: getApplication();
		JPluginHelper::importPlugin('user');
		$app->triggerEvent( 'onUserLogin', array( (array) $response, array( 'action' => 'core.login.site', 'jblesta' => true ) ) );
		$app->redirect( base64_decode( $returnurl ) );
		return true;
	}
	
	
	/**
	 * Handles the autologout routine coming from Blesta
	 * @access		private
	 * @version		@fileVers@ 
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	private function _handleAutologouts()
	{
		// Ensure we can run this
		if (! $this->_enabled ) return false;
		
		/* Yeay Dunamis! */
		get_dunamis( 'jblesta_sysm' );
		
		// Initialize some fun Dunamis things
		$input	=	dunloader( 'input', true );
		$config	=	dunloader( 'config', 'com_jblesta' );
		
		// Be sure we need to do this
		if ( $input->getVar( 'task', false ) != 'autologout' ) {
			return false;
		}
		
		
		// =============================================================
		//	Build our list of variables
		// =============================================================
		
		$token		=	$config->get( 'token' );
		$timestamp	=	(string) $input->getVar( 'timestamp', null, 'STRING', 'get' );
		$signature	=	(string) $input->getVar( 'signature', null, 'STRING', 'get' );
		$random		=	(string) $input->getVar( 'random', null, 'STRING', 'get');
		$returnurl	=	(string) $input->getVar( 'returnurl', null, 'STRING', 'get' );
		
		// Be sure we have it all together
		if (! $timestamp || ! $signature || ! $random || ! $token || ! $returnurl ) {
			return false;
		}
		
		
		// =============================================================
		//	Check we are valid first
		// =============================================================
		$oursign	=	(string) base64_encode( hash_hmac( 'sha256', $random . $timestamp . $token, $token, true ) );
		
		if ( $this->_compareSignatures( $oursign, $signature ) !== true ) {
			return false;
		}
		
		
		// =============================================================
		//	Time check
		// =============================================================
		if ( ( time() - $timestamp ) > 120 ) {
			return false;
		}
		
		
		// =============================================================
		//	Alright, go ahead and logout
		// =============================================================
		$app	=	JFactory :: getApplication();
		$app->logout( null, array( 'jblesta' => true ) );
		$app->redirect( base64_decode( $returnurl ) );
		return true;
	}
	
	
	/**
	 * Handles our language appending to any Blesta URLs
	 * @access		private
	 * @version		@fileVers@ 
	 * 
	 * @since		1.0.0
	 */
	private function _handleLanguage()
	{
		return;
// 		// Initialize some things
// 		$input	=	dunloader( 'input', true );
// 		$config	=	dunloader( 'config', 'com_jblesta' );
// 		$app	=	JFactory :: getApplication();
		
// 		// Don't run if we are in backend
// 		if( $app->isAdmin() ) {
// 			return true;
// 		}
		
// 		// If we have disabled language translations, disable it here also
// 		if (! $config->get( 'languageenable', false ) ) {
// 			return true;
// 		}
		
// 		$db			=	dunloader( 'database', true );
// 		$html	 	=   JResponse :: getBody();					// Site contents
// 		$langcurr	=	JFactory :: getLanguage()->getTag();	// Current language of the site
		
// 		// Find WHMCS URLs and affix the language to them
// 		$wlang		=	$config->findLanguage( $langcurr );		// Language to use for WHMCS links
// 		$whmcsurl	=	$config->get( 'whmcsurl', null );
// 		$whmcsuri	=	DunUri :: getInstance( $whmcsurl, true );
// 		$whmcsurl	=	preg_quote( $whmcsuri->toString( array( 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment' ) ), '#' );
// 		$regex		=	'#<a[^>]+([\"\']+)(?P<link>http(?:s|)\://' . $whmcsurl . '[^\1>]*)\1[^>]*>#im';
			
// 		preg_match_all( $regex, $html, $matches, PREG_SET_ORDER );
			
// 		foreach ( $matches as $match ) {
// 			$uri	=	DunUri :: getInstance( $match['link'], true );
// 			$uri->setVar( 'language', $wlang );
// 			$repl	=	str_replace( $match['link'], $uri->toString(), $match[0] );
// 			$html	=	str_replace( $match[0], $repl, $html );
// 		}
		
// 		JResponse::setBody( $html );
		
// 		return true;
	}
	
	
	/**
	 * Method to update a session for a logged in user
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	private function _updateSessions()
	{
		return;
// 		// Ensure we can run this
// 		if (! $this->_enabled ) return;
		
// 		// Initiate some items
// 		$session	=	JFactory::getSession();
// 		$instance	=	$session->get('user');
		
// 		// Bail if we aren't logged in
// 		if (! is_a( $instance, 'JUser' ) || $instance->guest ) {
// 			return;
// 		}
		
// 		return;
// 		// ========================================
// 		// @TODO:  INCORPORATE SESSION MODIFICATION
// 		// ========================================
// 		// Load the user from the database
// 		$dbuser		= new Juser( $instance->get( 'id' ) );
// 		$changes	= false;
		
// 		foreach( array( 'email', 'username', 'name' ) as $item ) {
// 			if ( $dbuser->get( $item ) == $instance->get( $item ) ) continue;
// 			$instance->set( $item, $dbuser->get( $item ) );
// 			$changes	= true;
// 		}
		
// 		if ( $changes ) {
// 			$instance->set( 'email', $dbuser->get( 'email' ) );
// 			$session->set( 'user', $instance );
// 		}
	}
	
	
	/**
	 * Method to determine if we are using sef rewrite anywhere
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	private static function _usingSefrewrite()
	{
		$jconfig	=	dunloader( 'config', true );
		
		// Lets test for Joomla core sef first
		if ( $jconfig->get( 'sef_rewrite' ) ) {
			return true;
		}
		
		// Now lets see if sh404sef is installed and set with sef
		$paths	=	array(
				JPATH_ADMINISTRATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sh404sef',
				JPATH_SITE . 'components' . DIRECTORY_SEPARATOR . 'com_sh404sef',
		);
		
		$found = false;
		foreach ( $paths as $path ) {
			if ( is_dir( $path ) ) {
				$found = true;
				break;
			}
		}
		
		if (! $found ) return false;
		
		$sh404	=	JComponentHelper :: getComponent( 'com_sh404sef', true );
		
		if ( $sh404->enabled ) {
			
			if ( JComponentHelper :: getComponent( 'com_sh404sef' )->params->get( 'shRewriteMode' ) === '0' ) {
				return true;
			}
			
			// Old school sh404sef
			$files	=	array( 'sh404seffactory.php', 'shSEFConfig.class.php', 'classes' . DIRECTORY_SEPARATOR . 'config.php' );
			$path	=	JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sh404sef' . DIRECTORY_SEPARATOR;
			
			foreach ( $files as $file ) {
				if ( file_exists( $path . $file ) ) {
					include_once $path . $file;
				}
			}
			
			if ( class_exists( 'Sh404sefFactory' ) ) {
				$shconf	=	Sh404sefFactory :: getConfig();
				
				if ( $shconf->shRewriteMode == '0' ) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	
	
}