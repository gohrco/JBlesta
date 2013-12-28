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

require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'blesta_api.php';


/**
 * API Handler
 * @desc		This class wraps the API calls for Blesta for Dunamis
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Com_jblestaDunApi extends DunObject
{
	
	/**
	 * Stores our API object
	 * @access		protected
	 * @var			object
	 * @since		1.0.0
	 */
	protected $api		=	null;
	
	/**
	 * Stores the API user's key
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_apikey	=	null;
	
	/**
	 * Stores the API URL
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_apiurl	=	null;
	
	/**
	 * Stores the API user's username
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_apiuser	=	null;
	
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
	 * Method for creating a client on the connection
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		$user		The assembled data to send to Blesta
	 *
	 * @return		object or false on error
	 * @since		1.0.0
	 */
	public function addclient( $user = array() )
	{
		$call	=	$this->api->post( 'clients', 'add', array( 'vars' => $user ) );
		
		if ( ( $result = $call->response() ) ) return $result;
		else $this->setError( $call->errors() );
		
		return false;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for creating a contact on the connection
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		$user		The assembled data to send to Blesta
	 *
	 * @return		object or false on error
	 * @since		1.0.0
	 */
	public function addcontact( $user = array() )
	{
		$call	=	$this->api->post( 'contacts', 'add', array( 'vars' => $user ) );
	
		if ( ( $result = $call->response() ) ) return $result;
		else $this->setError( $call->errors() );
	
		return false;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for creating a user on the system
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		$user		The assembled data to send to Blesta
	 *
	 * @return		object or false on error
	 * @since		1.0.0
	 */
	public function adduser( $user = array() )
	{
		$call	=	$this->api->post( 'users', 'add', array( 'vars' => $user ) );
		
		if ( ( $result = $call->response() ) ) return $result;
		else $this->setError( $call->errors() );
		
		return false;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for deleting a client on the connection
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		$user		The assembled data to send to Blesta
	 *
	 * @return		object or false on error
	 * @since		1.0.0
	 */
	public function deleteclient( $client_id )
	{
		$call	=	$this->api->delete( 'clients', 'delete', array( 'client_id' => $client_id ) );
		
		if ( ( $result = $call->response() ) ) return $result;
		else $this->setError( $call->errors() );
		
		return false;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for deleting a contact on the connection
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		$user		The assembled data to send to Blesta
	 *
	 * @return		object or false on error
	 * @since		1.0.0
	 */
	public function deletecontact( $contact_id )
	{
		$call	=	$this->api->delete( 'contacts', 'delete', array( 'contact_id' => $contact_id ) );
	
		if ( ( $result = $call->response() ) ) return $result;
		else $this->setError( $call->errors() );
	
		return false;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for deleting a user on the system
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		$user		The assembled data to send to Blesta
	 *
	 * @return		object or false on error
	 * @since		1.0.0
	 */
	public function deleteuser( $user_id )
	{
		$call	=	$this->api->delete( 'users', 'delete', array( 'user_id' => $user_id ) );
		
		if ( ( $result = $call->response() ) ) return $result;
		else $this->setError( $call->errors() );
		
		return false;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for editing a client on the connection
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		$user		The assembled data to send to Blesta
	 *
	 * @return		object or false on error
	 * @since		1.0.0
	 */
	public function editclient( $client_id, $vars )
	{
		$call	=	$this->api->put( 'clients', 'edit', array( 'client_id' => $client_id, 'vars' => $vars ) );
	
		if ( ( $error = $call->errors() ) ) {
			$this->setError( $error );
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for editing a contact on the connection
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		$user		The assembled data to send to Blesta
	 *
	 * @return		object or false on error
	 * @since		1.0.0
	 */
	public function editcontact( $contact_id, $vars )
	{
		$call	=	$this->api->put( 'contacts', 'edit', array( 'contact_id' => $contact_id, 'vars' => $vars ) );
	
		if ( ( $error = $call->errors() ) ) {
			$this->setError( $error );
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for editing a user on the system
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		$user		The assembled data to send to Blesta
	 *
	 * @return		object or false on error
	 * @since		1.0.0
	 */
	public function edituser( $user_id, $vars )
	{
		$call	=	$this->api->put( 'users', 'edit', array( 'user_id' => $user_id, 'vars' => $vars ) );
		
		if ( ( $error = $call->errors() ) ) {
			$this->setError( $error );
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Finds a matching user checking first the client then contact api
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $email: contains the email address to search for
	 * @param		boolean		- $force: permits overriding cache and loading again
	 *
	 * @return		object or false on error
	 * @since		1.0.0
	 */
	public function findmatchinguser( $email = null, $force = false )
	{
		static $emails	=	array();
		
		if ( $email == null ) return false;
		
		// Caching of call
		if ( isset( $emails[$email] ) && ! $force ) {
			return $emails[$email];
		}
		
		if (! isset( $emails[$email] ) || $force ) {
			$emails[$email] = false;
		}
		
		// Check for email or username
		if ( is_email( $email ) ) {
			$found		=	$this->api->get( 'clients', 'search', array( 'query' => $email ) )->response();
		}
		// Search for by username
		else {
			$found		=	$this->api->get( 'users', 'getByUsername', array( 'username' => $email ) )->response();
			
			if ( $found ) {
				$found->user_id	=	$found->id;
				$found			=	array( $found );
			}
		}
		
		if ( $found ) {
			$found	=	$found[0];
		}
		else {
			return false;
		}
		
		$client		=	$this->api->get( 'clients', 'getByUserId', array( 'user_id' => $found->user_id ) )->response();
		
		if (! $client ) {
			return false;
		}
		
		$emails[$email]	=	$client;
		
		return $emails[$email];
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method to get a list of countries
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array of objects|false
	 * @since		1.0.0
	 */
	public function getclientgroups( $company_id )
	{
		$call	=	$this->api->get( 'client_groups', 'getList', array( 'company_id' => $company_id ) );
		
		if ( ( $result = $call->response() ) ) return $result;
		else $this->setError( $call->errors() );
		
		return false;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method to get a list of Blesta companies
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array of objects|false
	 * @since		1.0.0
	 */
	public function getcompanies()
	{
		if (! is_object( $this->api ) ) return false;
		return $this->api->get( 'companies', 'getList', array() )->response();
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method to get a list of countries
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array of objects|false
	 * @since		1.0.0
	 */
	public function getcountries()
	{
		if (! is_object( $this->api ) ) return false;
		return $this->api->get( 'countries', 'getList', array() )->response();
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method to get a specific country
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array of objects|false
	 * @since		1.0.0
	 */
	public function getcountry( $code = 'US' )
	{
		if (! is_object( $this->api ) ) return false;
		return $this->api->get( 'countries', 'get', array( 'code' => $code ) )->response();
	}
	
	
	/**
	 * Method to retrieve an error from the object
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	public function getError()
	{
		if (! empty( $this->_error ) ) {
			return array_pop( $this->_error );
		}
		
		return null;
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		$options		Contains an array of arguments
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = null;
		
		if (! is_object( $instance ) || ( isset( $options['force'] ) && $options['force'] ) ) {
			
			if ( isset( $options['force'] ) ) {
				unset( $options['force'] );
			}
			
			$instance = new Com_jblestaDunApi( $options );
		}
	
		return $instance;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method to get a list of countries
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array of objects|false
	 * @since		1.0.0
	 */
	public function getstate( $country = 'US', $code = 'FL' )
	{
		if (! is_object( $this->api ) ) return false;
		return $this->api->get( 'states', 'get', array( 'country' => $country, 'code' => $code ) )->response();
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method to get a specific country
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array of objects|false
	 * @since		1.0.0
	 */
	public function getstates()
	{
		return $this->api->get( 'states', 'getList', array() )->response();
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method to get a specific order form
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array of objects|false
	 * @since		1.0.0
	 */
	public function getorderform( $order_form_id )
	{
		if (! is_object( $this->api ) ) return false;
		return $this->api->get( 'order.order_forms', 'get', array( 'order_form_id' => $order_form_id ) )->response();
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method to get a list of available order forms
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array of objects|false
	 * @since		1.0.0
	 */
	public function getorderforms( $company_id )
	{
		if (! is_object( $this->api ) ) return false;
		return $this->api->get( 'order.order_forms', 'getAll', array( 'company_id' => $company_id, 'status' => '' ) )->response();
	}
	
	
	/**
	 * Method for determining if we encountered any errors
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function hasErrors()
	{
		// Check local object first
		$state	= empty( $this->_error );
		return $state === false ? true : false;
	}
	
	
	/**
	 * Method to test if the API is enabled
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function isEnabled()
	{
		return (bool) $this->_enabled;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for testing the connection
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function ping()
	{
		if (! is_object( $this->api ) ) return false;
		return $this->api->get( 'companies', 'getall', array() )->response() ? true : false;
	}
	
	
	
	
	/**
	 * Method for setting an error message
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$msg		The message string
	 * @param		boolean		$trans		Translate the string [T/f]
	 *
	 * @return		false always
	 * @since		1.0.0
	 */
	public function setError( $msg, $trans = true )
	{
		if ( is_object( $msg ) ) {
			foreach ( $msg as $k1 => $v1 ) {
				if ( is_object( $msg->$k1 ) ) {
					foreach ( $msg->$k1 as $k2 => $v2 ) {
						$this->_error[]	=	$v2;
					}
				}
			}
			return;
		}
		
		if ( empty( $msg ) ) {
			$msg = 'An unknown error occurred.';
		}
		
		$this->_error[]	=	$msg;
		return false;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for updating an existing client on the connection
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $user: the assembled data to send to WHMCS
	 *
	 * @return		object or false on error
	 * @since		1.0.0
	 */
	public function updateclient( $user = array() )
	{
		_e( $user,1 );
		// Catch errors
		if ( empty( $user ) ) return false;
		
		$client = $this->_call_api( 'updateclient', $user );
		
		return $client->result == 'success' ? (object) $client : false;
	}
	
	
	/**
	 * --------------------------------------------------------------------
	 * API METHOD	as of api version 1.0
	 * --------------------------------------------------------------------
	 * Method for validating a login
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function validatelogin( $username, $password )
	{
		$call	=	$this->api->get( 'users', 'auth', array( 'username' => $username, 'vars' => array( 'username' => $username, 'password' => $password ), 'type' => 'client' ) );
		$result	=	$call->response();
		
		if ( is_bool( $result ) ) return $result;
		else $this->setError( $call->errors() );
		
		return false;
	}
	
	
	/**
	 * Method for calling up the API
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $call: the actual API method on the remote system
	 * @param		array		- $post: any additional post variables
	 * @param		array		- $optns: we can specify curl options in this
	 * @param		bool		- @wantresult: true if we want the result back false if we just want to know it worked
	 *
	 * @return		mixed array or boolean
	 * @since		1.0.0
	 */
	private function _call_api( $call = 'getactivitylog', $post = array(), $optns = array(), $wantresult = true )
	{
		// Last chance to test before epic fails
		if ( empty( $this->_apiuri ) || empty( $this->_apipost ) ) {
			return false;
		}
		
		// Now we should test to ensure it's live
		$uri	=	clone $this->_apiuri;
		$optns	=	array_merge( $this->_apioptions, $optns );
		$post	=	array_merge( $post, $this->_apipost );
		
		$post['action']	=	$call;
		
		// Assemble the API Request
		$this->curl->create( $uri->toString() );
		$this->curl->post( $post, $optns );
		
		// Execute the Curl Call
		$result	=	$this->curl->execute();
		
		// Return result
		if (! $wantresult ) {
			return $this->curl->has_errors() ? false : true;
		}
		
		// Process for returned errors
		$data	= json_decode( $result, false );
		
		if ( $data->result == 'error' ) {
			$this->setError( $data->message, false );
		}
		
		return $data;
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
		$config		=	dunloader( 'config', 'com_jblesta' );
		$apiurl		=	$config->get( 'blestaapiurl', null );
		$apiuser	=	$config->get( 'blestaapiusername', null );
		$apikey		=	$config->get( 'blestaapikey', null );
		
		// We can't do anything if these are empty
		if ( empty( $apiurl ) || empty( $apiuser ) || empty( $apikey ) ) {
			return $this->setError( 'error.apicnxn.' . ( empty( $apiurl ) ? 'nourl' : ( empty( $apiuser ) ? 'nouser' : 'nokey' ) ) );
		}
		
		$uri	=	DunUri :: getInstance( $apiurl, true );
		$uri->setPath( rtrim( $uri->getPath(), '/' ) . '/api/' );
		
		$this->_apiurl	=	$uri->toString();
		$this->_apiuser	=	$apiuser;
		$this->_apikey	=	$apikey;
		
		$this->api	=	new BlestaApi( $this->_apiurl, $this->_apiuser, $this->_apikey );
		
		if (! $this->ping() ) {
			return;
		}
		
		$this->_enabled = true;
		
		return;
	}
}