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
 * API handler for J!Blesta
 * @desc		This is used to call up Joomla from within Blesta
 * 
 * @package		@packageName@
 * @subpackage	Blesta.dunamis
 * @since		1.0.0
 */
class JblestaDunApi extends DunObject
{
	/**
	 * Holds the curl handler
	 * @access		protected
	 * @var			Object
	 * @since		1.0.0
	 */
	protected $curl		=	null;
	
	/**
	 * Holds the curl info for debugging purposes
	 * @access		public
	 * @var			array
	 * @since		2.5.3
	 */
	public $debug		= array();
	
	/**
	 * Stores the joomla options for the API
	 * @access		private
	 * @var			array
	 * @since		1.0.0
	 */
	private $_apioptions	= array();
	
	/**
	 * Stores the variables to post each time through the API
	 * @access		private
	 * @var			array
	 * @since		1.0.0
	 */
	private $_apipost	= array();
	
	/**
	 * Stores the timestamp generated for this set of calls
	 * @access		private
	 * @var			Unix Timestampe
	 * @since		1.0.0
	 */
	private $_apitimestamp	= null;
	
	/**
	 * Stores the secret token being used
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_apitoken	= null;
	
	/**
	 * Stores the uri for the API
	 * @access		private
	 * @var			DunUri Object
	 * @since		1.0.0
	 */
	private $_apiuri		= null;
	
	/**
	 * Indicates which version of the Joomla API we want to call up
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_apiversion = '@shortVers@';
	
	/**
	 * Indicates we are enabled or disabled
	 * @access		private
	 * @var			boolean
	 * @since		1.0.0
	 */
	private $_enabled		=	false;
	
	/**
	 * Stores any errors we encounter
	 * @access		private
	 * @var			array
	 * @since		1.0.0
	 */
	private $_error			=	array();
	
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function __construct()
	{
		parent :: __construct();
		
		$this->_load();
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for authenticating a user against Joomla!
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $post: contains username / password to test
	 *
	 * @return		array|false			If successful returns an array of data false on failure
	 * @since		1.0.0
	 */
	public function authenticate( $post )
	{
		$data	=	array( 'data' => $post );
		$call	=	$this->_call_api( 'post', 'Authenticate', $data );
		
		if (! $call || ! is_object( $call ) || $call->result != 'success' ) {
			if (! is_object( $call ) || ( is_object( $call ) && isset( $call->message ) ) ) {
				$this->setError( 'An unknown API error occurred.' );
			}
			
			return false;
		}
		
		return $call->data;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for creating the user on Joomla
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function createuser( $user )
	{
		$data	=	array( 'data' => $user );
		$result	=	$this->_call_api( 'post', 'Createuser', $data );
		
		if (! $result || ! is_object( $result ) || $result->result != 'success' ) {
			return false;
		}
		
		return $result->data;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for deleting the user on Joomla
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function deleteuser( $user )
	{
		$data	=	array( 'data' => $user );
		$result	=	$this->_call_api( 'post', 'Deleteuser', $data );
		
		if (! $result || ! is_object( $result ) || $result->result != 'success' ) {
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for editing the user on Joomla
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function edituser( $user )
	{
		$data	=	array( 'data' => $user );
		$result	=	$this->_call_api( 'post', 'Edituser', $data );
		
		if (! $result || ! is_object( $result ) || $result->result != 'success' ) {
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for finding a username on Joomla
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function finduser( $email )
	{
		$data	=	array( 'find' => $email );
		$result	=	$this->_call_api( 'get', 'Finduser', $data );
		
		if (! $result || ! is_object( $result ) || $result->result != 'success' ) {
			return false;
		}
		
		return $result->data;
	}
	
	
	/**
	 * Method to retrieve an error from the object
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	public function getError()
	{
		if (! empty( $this->_error ) ) {
			return array_pop( $this->_error );
		}
		
		$config	=	dunloader( 'config', 'jblesta' );
		$debug	=	$config->get( 'debug', false );
		
		$error	=	$this->curl->has_errors();
		
		// If we have debug on, lets return the curl error raw 
		if ( $debug ) return $error;
		
		$error	=	preg_replace( '#\[[^\]]*\]#i', '', $error );
		return $error;
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		Contains an array of arguments
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = null;
		
		if (! is_object( $instance ) ) {
			
			$instance = new JblestaDunApi( $options );
		}
	
		return $instance;
	}
	
	
	/**
	 * Method for determining if we encountered any errors
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function hasErrors()
	{
		// Check local object first
		$state	= empty( $this->_error );
		if ( $state === false ) return true;
		
		$state	=	$this->curl->has_errors();
		return $state ? true : false;
	}
	
	
	/**
	 * Method for determining if the API is enabled
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function isEnabled()
	{
		return $this->_enabled == true;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 2.5
	 * --------------------------------------------------------------------
	 * Method for retrieving the languages from Joomla!
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * 
	 * @return		array
	 * @since		1.0.0
	 */
	public function languageitems()
	{
		$call	=	$this->_call_api( 'get', 'Languageitems' );
		
		if ( (! $call || ! is_object( $call ) || $call->result != 'success' ) ) {
			return array();
		}
		
		// ---- BEGIN JWHMCS-28
		//		Language dropdown selection on WHMCS is not displaying correctly
		$call->data->languageitems =	unserialize( base64_decode( $call->data->languageitems ) );
		
		foreach ( $call->data->languageitems as $lt => $item ) {
			$call->data->languageitems[$lt]->name	=	( is_utf8( $item->name ) ? $item->name : utf8_encode( $item->name ) );
		}
		// ---- END JWHMCS-28
		
		return ( (! $call || ! is_object( $call ) || $call->result != 'success' ) ? array() : $call->data );
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 2.5
	 * --------------------------------------------------------------------
	 * Method for testing the connection
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function menuitems()
	{
		$call	=	$this->_call_api( 'get', 'Menuitems' );
		
		if (  (! $call || ! is_object( $call ) || $call->result != 'success' ) ) {
			return array();
		}
		
		// Menu items with non-utf8 characters arent being displayed in settings
		$call->data->menuitems	=	unserialize( base64_decode( $call->data->menuitems ) );
		$call->data->menutypes	=	unserialize( base64_decode( $call->data->menutypes ) );
		
		foreach ( $call->data->menuitems as $mt => $items ) {
			foreach ( $items as $cnt => $item ) {
				// Accomodate the possibility the string is already utf8
				$call->data->menuitems[$mt][$cnt]->name		=	( is_utf8( $item->name ) ? $item->name : utf8_encode( $item->name ) );
				$call->data->menuitems[$mt][$cnt]->title	=	( is_utf8( $item->title ) ? $item->title : utf8_encode( $item->title ) );
				$call->data->menuitems[$mt][$cnt]->treename	=	( is_utf8( $item->treename ) ? $item->treename : utf8_encode( $item->treename ) );
			}
		}
		
		$call->data->menutypes	=	(object) $call->data->menutypes;
		foreach ( $call->data->menutypes as $mt => $item ) {
			$call->data->menutypes->$mt	=	( is_utf8( $item ) ? $item : utf8_encode( $item ) );
		}
		
		return $call->data;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 2.5
	 * --------------------------------------------------------------------
	 * Method for testing the connection
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		boolean		- $auth: if we are testing for the authentication then true 
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function ping( $auth = true )
	{
		static	$instance = array();
		$find	=	$auth ? 1 : 0;
		
		if (! isset( $instance[$find] ) ) {
			if ( $auth ) {
				$ping	=	$this->_call_api( 'get', 'Verify' );
				$instance[1]	=	( (! $ping || ! is_object( $ping ) || $ping->result != 'success' ) ? false : true );
			}
			else {
				$ping	=	$this->_call_api( 'get', 'Verify', array(), array(), false );
				$instance[0]	=	$ping ? true : $this->curl->has_errors();
			}
		}
		
		return $instance[$find];
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 2.5
	 * --------------------------------------------------------------------
	 * Method for retrieving the site from Joomla
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $params: a set of parameters to pass along
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public function render( $params = array() )
	{
		//$wapi		=	dunloader( 'whmcsapi', 'jblesta' );
		$input		=	dunloader( 'input', true );
		$config		=	dunloader( 'config', 'jblesta' );
		
		// Build our options array to pass along
		if ( $config->get( 'passalonguseragent' ) ) {
			$options	=	array( 'USERAGENT' => $input->getVar( 'HTTP_USER_AGENT', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13', 'server' ) );
		}
		else {
			$options	=	array( 'USERAGENT' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13', 'server');
		}
		
		$result		=	$this->_call_api( 'get', 'render', $params, $options );
		
		if (! $result || ! is_object( $result ) || $result->result != 'success' ) {
			//$wapi->log( 'API: render', $result, $result->error, 'error', 'Failed call to Joomla API' );
			return false;
		}
		
		//$wapi->log( 'API: render', 'Rendering', "Successfully retrieved site from Joomla API", 'log', 'Successful call to Joomla API' );
		return $result;
	}
	
	
	/**
	 * Method for setting an error message
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $msg: the message string
	 * @param		boolean		- $trans: translate the string [T/f]
	 *
	 * @return		false always
	 * @since		1.0.0
	 */
	public function setError( $msg, $trans = true )
	{
		$this->_error[]	=	( $trans ? t( 'jblesta.' . $msg ) : $msg );
		return false;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 2.5
	 * --------------------------------------------------------------------
	 * Method for validating a user
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $user: contains the information to validate
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function validate( $user = array() )
	{
		$data		=	array( 'data' => $user );
		$validate	=	$this->_call_api( 'post', 'Validate', $data );
		
		return ( (! $validate || ! is_object( $validate ) || $validate->result != 'success' ) ? false : true );
	}
	
	
	/**
	 * Method for calling up the API
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $method: get|put|post...
	 * @param		string		- $call: the actual API method on the remote system
	 * @param		array		- $post: any additional post variables
	 * @param		array		- $optns: we can specify curl options in this
	 * @param		bool		- @wantresult: true if we want the result back false if we just want to know it worked
	 *
	 * @return		mixed array or boolean
	 * @since		1.0.0
	 */
	private function _call_api( $method = 'post', $call = '/Ping', $post = array(), $optns = array(), $wantresult = true )
	{
		// Last chance to test before epic fails
		if ( empty( $this->_apiuri ) || empty( $this->_apitoken ) ) {
			return false;
		}
		
		// Now we should test to ensure it's live
		$uri	=	clone $this->_apiuri;
		$optns	=	array_merge( $this->_apioptions, $optns );
		$post	=	array_merge( $this->_apipost, $post );
		$call	=	"/{$this->_apiversion}/" . trim( $call, "/" );
		
		// Lets allow forcing everything to get if we need to
		$config	=	dunloader( 'config', 'jblesta' );
		
		if ( $config->get( 'forceapitoget', false ) ) {
			$method	=	'get';
		}
		
		// Put methods require the e in the URL
		if ( in_array( $method, array( 'put', 'get' ) ) ) {
			$uri->setVar( 'jblesta', $call );
			$uri->setVar( 'apitimestamp', $post['apitimestamp'] );
			unset( $post['apitimestamp'] );
			foreach ( $post as $k => $v ) $uri->setVar( $k, $v );
		}
		else {
			$post['jblesta']		= $call;
		}
	
		// Generate the signature
		$sign	=	$this->_generateSignature( $method, $uri, $post );
		
		// include the signature in the method variable and the header
		if ( in_array( $method, array( 'put', 'get' ) ) ) {
			$uri->setVar( 'apisignature', rawurlencode( $sign ) );
		}
		else {
			$post['apisignature']	= rawurlencode( $sign );
		}
		
		// Assemble the API Request
		$this->curl->create( $uri->toString() );
		$this->curl->http_header( 'JblestaRequestSignature', rawurlencode( $sign ) );
		
		if ( $method == 'get' ) {
			$this->curl->http_method( 'get' );
			$this->curl->options( $optns );
		}
		else {
			$this->curl->$method( $post, $optns );
		}
		
		// Execute the Curl Call
		$result	=	$this->curl->execute();
		
		// Debug handling
		if ( dunloader( 'config', 'jblesta' )->get( 'debug', false ) ) {
			$this->debug	=	(object) $this->curl->info;
		}
		
		// Return result
		if (! $wantresult ) {
			return $this->curl->has_errors() ? false : true;
		}
		
		// ---- BEGIN JWHMCS-23
		//		Cleanup string just in case
		$result	=	$this->_cleanupJson( $result );
		// ---- END JWHMCS-23
		
		// Process for returned errors
		$data	= json_decode( $result, false );
		
		if ( $data->result == 'error' ) {
			$this->setError( $data->error, false );
		}
		
		return $data;
	}
	
	
	/**
	 * Method to cleanup the Json string for PHP just in case Joomla left us a surprise
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $string: what we are starting with
	 *
	 * @return		string cleaned up
	 * @since		2.5.4
	 */
	private function _cleanupJson( $string )
	{
		// Strip off anything before the first curly bracket
		$string	=	preg_replace( "#^[^{]*#im", "", $string );
		
		return $string;
	}
	
	
	/**
	 * Method for generating the signature request
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $method: method used (get|post|put...)
	 *
	 * @return		string containing hash
	 * @since		1.0.0
	 */
	private function _generateSignature( $method, $uri, $post = array() )
	{
		$token	=	$this->_apitoken;
		$string	=	$uri->toString();
		
		if ( $method != 'get' && $method != 'put' ) {
			ksort( $post );
			
			foreach ( $post as $k => $v ) {
				if ( is_array( $v ) || is_object( $v ) ) {
					foreach ( $v as $k2 => $v2 ) {
						$append .= $k.$k2.$v2;
					}
				}
				else {
					$append	.= $k.$v;
				}
			}
		}
		
		$hash	=	base64_encode( hash_hmac( 'sha256', rawurldecode( $string . $append ), $token, true ) );
		return $hash;
	}
	
	
	/**
	 * Loads the API and enables if checks out
	 * @access		private
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	private function _load()
	{
		// MD5 the version first
		$this->_apiversion	= md5( $this->_apiversion );
		
		$config		=	dunloader( 'config', 'jblesta' );
		$apiurl		=	$config->get( 'joomlaurl', null );
		$apitoken	=	$config->get( 'logintoken', null );
		
		// We can't do anything if these are empty
		if ( empty( $apiurl ) || empty( $apitoken ) ) {
			return $this->setError( 'error.apicnxn.' . ( empty( $apiurl ) ? 'nourl' : 'notoken' ) );
		}
		
		// Test for index.php
		if ( strpos( $apiurl, 'index.php' ) === false ) {
			$apiurl	= rtrim( $apiurl, '/' ) . '/index.php';
		}
		
		$this->curl				=	dunloader( 'curl', false );
		$this->_apiuri			=	new DunUri( $apiurl );
		$gmt					=	new DateTime( null, new DateTimeZone('GMT') );
		$this->_apitimestamp	=	$gmt->format( "U" );
		$this->_apitoken		=	$apitoken;
		
		// This gets used every time
		$this->_apipost	=   array(	'apitimestamp'	=> $this->_apitimestamp );
		$this->_apioptions	= array(	'HEADER'			=> false,
										'RETURNTRANSFER'	=> true,
										'SSL_VERIFYPEER'	=> false,
										'SSL_VERIFYHOST'	=> false,
										'CONNECTTIMEOUT'	=> 2,
										'FORBID_REUSE'		=> true,
										'FRESH_CONNECT'		=> true,
										'HTTP_VERSION'		=> CURL_HTTP_VERSION_1_1,
										'HTTPHEADER'		=> array(),
										'COOKIEFILE'		=> "",
										'COOKIEJAR'			=> "",
										'COOKIESESSION'		=> true,
										
		);
		
		if (! $this->ping() ) {
			return;
		}
		
		$this->_enabled = true;
		
		return;
	}
}