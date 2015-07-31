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
 * JBlesta User Module
 * @desc		This class is used to manage user actions for J!Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaUserDunModule extends BlestaDunModule
{
	/**
	 * Method to add a client on Joomla
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function clientAdd()
	{
		// If we are disabled don't run ;-)
		if (! ensure_active( 'user' ) ) {
			return;
		}
		
		$user		=	(array) $this->getClientAddData();
		$api		=	dunloader( 'api', 'jblesta' );
		
		// We cant do validation so ensure we haven't already added the user 
		if ( $api->finduser( $user['email'] ) ) {
			return true;
		}
		
		$result		=	$api->createuser( $user );
		
		if ( $api->hasErrors() ) {
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Method to delete a client user on Joomla
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function clientDelete()
	{
		// If we are disabled don't run ;-)
		if (! ensure_active( 'user' ) ) {
			return;
		}
		
		$user		=	$this->getClientEditData();
		unset( $user['name'], $user['username'], $user['newemail'] );
		
		$api		=	dunloader( 'api', 'jblesta' );
		$result		=	$api->deleteuser( $user );
		
		if ( $api->hasErrors() ) {
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Performs client editing
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function clientEdit()
	{
		// If we are disabled don't run ;-)
		if (! ensure_active( 'user' ) ) {
			return;
		}
		
		// Front end validate user password change
		if (! is_admin() && isset( $_POST ) && isset( $_POST['new_password'] ) && ! empty( $_POST['new_password'] ) ) {
			Loader :: loadModels( $this, array( 'Clients', 'Users' ) );
			Loader :: loadComponents( $this, array( 'Session' ) );
			$client		=	$this->Clients->get( $this->Session->read( "blesta_client_id" ) );
			$validate	=	$this->Users->validatePasswordEquals( $_POST['current_password'], $client->user_id );
			
			if (! $validate ) {
				return false;
			}
		}
		
		$user		=	$this->getClientEditData();
		$api		=	dunloader( 'api', 'jblesta' );
		$result		=	$api->edituser( $user );
		
		if ( $api->hasErrors() ) {
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Method for updating a client's status
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function clientUpdateStatus()
	{
		// If we are disabled don't run ;-)
		if (! ensure_active( 'user' ) ) {
			return false;
		}
		
		$user			=	$this->getClientEditData();
		$client			=	$this->Clients->get( $this->getClientId() );
		$status_types	=	$this->Clients->getStatusTypes();
		$keys			=	array_keys($status_types);
		$num_keys		=	count($keys);
		
		for ( $i=0; $i<$num_keys; $i++ ) {
			if ( $keys[$i] == $client->status ) {
				$index = $keys[($i+1)%$num_keys];
				break;
			}
		}
		
		$user['name']	=	$client->first_name . ' ' . $client->last_name;
		$user['status']	=	( $index != 'active' ? 0 : 1 );
		
		$api		=	dunloader( 'api', 'jblesta' );
		$result		=	$api->edituser( $user );
		
		if ( $api->hasErrors() ) {
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Method for assembling the data to add to Joomla
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		stdClass|false		Object or false if unable to complete request
	 * @since		1.0.0
	 */
	public function getClientAddData()
	{
		if ( empty( $_POST ) ) {
			return false;
		}
		
		$data	=	new stdClass();
		$post	=	(object) $_POST;
			
		$data->name			=	build_name( $post );
		$data->password		=
		$data->password2	=	$post->new_password;
		$data->email		=	$post->email;
		
		if ( $post->username_type == 'email' ) {
			$data->username	=	build_username( $post );
		}
		else {
			if ( $post->username ) {
				$data->username	=	$post->username;
			}
			else {
				return false;
			}
		}
		
		
		return $data;
	}
	
	
	/**
	 * Method for assembling the data to edit on Joomla
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array|false		array or false if unable to complete request
	 * @since		1.0.0
	 */
	public function getClientEditData()
	{
		$data	=	array();
		Loader :: loadModels( $this, array( 'Clients' ) );
		
		$post	=	$_POST;
		$data['name']	=	$post['first_name'] . ' ' . $post['last_name'];
		
		if (! empty( $post['new_password'] ) ) {
			$data['password']	=
			$data['password2']	=	$post['new_password'];
		}
		
		$id		=	$this->getClientId();
		$user	=	$this->Clients->get( $id );
		
		$data['email']	=	$user->email;
		
		if ( $user->email != $post['email'] ) {
			$data['newemail']	=	$post['email'];
		}
		
		if ( $user->username != $post['username'] && ! is_email( $post['username'] ) ) {
			$data['username']	=	$post['username'];
		}
		
		return $data;
	}
	
	
	/**
	 * Common method to get a client ID from the URL routes
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		integer
	 * @since		1.0.0
	 */
	public function getClientId()
	{
		if (! empty( $_POST ) && isset( $_POST['id'] ) ) {
			return (int) $_POST['id'];
		}
		
		$rts	=	JblestaDunActions :: getRoutes();
		$id		=	array_pop( $rts );
			
		if (! is_numeric( $id ) ) {
			$id	=	array_pop( $rts );
		}
		
		if ( is_numeric( $id ) ) {
			return (int) $id;
		}
		
		// Assume the ID is in the session then?
		Loader :: loadComponents( $this, array( 'Session' ) );
		return (int) $this->Session->read( "blesta_client_id" );
	}
	
	
	/**
	 * Initializes the module
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function initialise() { }
	
	
	
}