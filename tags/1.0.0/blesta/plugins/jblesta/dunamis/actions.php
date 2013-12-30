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
 * JBlesta Actions Library
 * @desc		This class is used to handle action requests from the jblesta plugin
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaDunActions extends DunObject
{
	
	/**
	 * Method to perform preactions on admin side when using ajax request
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function adminajaxpreaction()
	{
		if ( self :: isAdminQuickStatusUpdate() ) {
			return dunmodule( 'jblesta.user' )->clientUpdateStatus();
		}
	}
	
	
	/**
	 * Method to perform preactions on admin side
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function adminpreaction()
	{
		if ( self :: isAdminAddClient() ) {
			return dunmodule( 'jblesta.user' )->clientAdd();
		}
		
		if ( self :: isAdminEditClient() ) {
			return dunmodule( 'jblesta.user' )->clientEdit();
		}
		
		if ( self :: isAdminDeleteClient() ) {
			return dunmodule( 'jblesta.user' )->clientDelete();
		}
	}
	
	
	/**
	 * Method to get the current route
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		array			Contains the array of get routes from the Blesta Router
	 * @since		1.0.0
	 */
	public static function getRoutes()
	{
		static $routes = array();
		
		if ( empty( $routes ) ) {
			$rte	=	Router::routesTo( DunUri :: getInstance( 'SERVER', true )->toString() );
			$routes	=	$rte['get'];
		}
		
		return $routes;
	}
	
	
	/**
	 * Method to determine if we are adding a client in the backend
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public static function isAdminAddClient()
	{
		$routes	=	self :: getRoutes();
		$data	=	false;
		
		if (
		in_array( 'add', $routes ) &&
		in_array( 'admin', $routes ) &&
		in_array( 'clients', $routes ) &&
		! empty( $_POST ) &&
		isset( $_POST['email'] ) &&
		isset( $_POST['username'] )
		)
		{
			$data = true;
		}
		
		return $data;
	}
	
	
	/**
	 * Method to determine if we are editing a client in the backend
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public static function isAdminDeleteClient()
	{
		$routes	=	self :: getRoutes();
		$data	=	false;
	
		if (
		in_array( 'delete', $routes ) &&
		in_array( 'admin', $routes ) &&
		in_array( 'clients', $routes ) 
		)
		{
			$data = true;
		}
	
		return $data;
	}
	
	
	/**
	 * Method to determine if we are editing a client in the backend
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public static function isAdminEditClient()
	{
		$routes	=	self :: getRoutes();
		$data	=	false;
		
		if (
		in_array( 'edit', $routes ) &&
		in_array( 'admin', $routes ) &&
		in_array( 'clients', $routes ) &&
		! empty( $_POST ) &&
		isset( $_POST['email'] ) &&
		isset( $_POST['username'] )
		)
		{
			$data = true;
		}
		
		return $data;
	}
	
	
	/**
	 * Method to determine if we are updating a client status in the backend
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public static function isAdminQuickStatusUpdate()
	{
		$routes	=	self :: getRoutes();
		$data	=	false;
		
		if (
		in_array( 'status', $routes ) &&
		in_array( 'quickupdate', $routes ) &&
		in_array( 'admin', $routes ) &&
		in_array( 'clients', $routes )
		)
		{
			$data = true;
		}
		
		return $data;
	}
	
	
	/**
	 * Method to determine if we are registering as a client
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean			True indicates we are logging in
	 * @since		1.0.0
	 */
	public static function isClientEdit()
	{
		$routes	=	self :: getRoutes();
		$data	=	false;
		
		if (
		in_array( 'edit', $routes ) &&
		in_array( 'main', $routes ) &&
		in_array( 'client', $routes ) &&
		! empty( $_POST ) &&
		isset( $_POST['email'] ) &&
		isset( $_POST['new_password'] ) &&
		is_email( $_POST['email']
		) )
		{
			$data = true;
		}
		
		return $data;
	}
	
	
	/**
	 * Method to determine if we are loggin in as a client
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean			True indicates we are logging in
	 * @since		1.0.0
	 */
	public static function isClientLogin()
	{
		$routes	=	self :: getRoutes();
		$data	=	false;
		
		if (
			in_array( 'login', $routes ) && 
			in_array( 'client', $routes ) &&
			! empty( $_POST ) && 
			isset( $_POST['username'] ) && 
			isset( $_POST['password'] ) && 
			! is_email( $_POST['username']
		) )
		{
			$data = true;
		}
		
		return $data;
	}
	
	
	/**
	 * Method to determine if we are loggin out as a client
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean			True indicates we are logging in
	 * @since		1.0.0
	 */
	public static function isClientLogout()
	{
		$routes	=	self :: getRoutes();
		$data	=	false;
		
		if (
		in_array( 'logout', $routes ) &&
		in_array( 'client', $routes )
		)
		{
			$data = true;
		}
	
		return $data;
	}
	
	
	/**
	 * Method to determine if we are registering as a client
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean			True indicates we are logging in
	 * @since		1.0.0
	 */
	public static function isClientRegister()
	{
		$routes	=	self :: getRoutes();
		$data	=	false;
		
		if (
		in_array( 'signup', $routes ) &&
		in_array( 'main', $routes ) &&
		! empty( $_POST ) &&
		isset( $_POST['email'] ) &&
		isset( $_POST['new_password'] ) &&
		is_email( $_POST['email']
		) )
		{
			$data = true;
		}
		
		return $data;
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
				
			$instance = new self( $options );
		}
		
		return $instance;
	}
	
	
	/**
	 * Called to perform all preactions
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function preaction()
	{
		// Catch Login Attempts
		if ( self :: isClientLogin() ) {
			
			$login	=	dunmodule( 'jblesta.login' );
			
			if (! $login->authenticate() ) {
				return false;
			}
		}
		
		// Catch Logout Attempts
		if ( self :: isClientLogout() ) {
			
			$logout	=	dunmodule( 'jblesta.login' );
				
			if (! $logout->logout() ) {
				return false;
			}
			
		}
		
		// User Registration on front end
		if ( self :: isClientRegister() ) {
			return dunmodule( 'jblesta.user' )->clientAdd();
		}
		
		// User Profile Edits on front end
		if ( self :: isClientEdit() ) {
			return dunmodule( 'jblesta.user' )->clientEdit();
		}
	}
}