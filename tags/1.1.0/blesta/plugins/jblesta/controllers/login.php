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


/**
 * JBlesta Main Controller
 * @desc		This class is called up directly when logging in from Joomla
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Login extends JblestaController
{
	
	/**
	 * Method to process our login token method from Joomla 
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		false			False on failure or redirect to landing page
	 * @since		1.0.0
	 */
	public function index()
	{
		// Initialize Dunamis!
		$this->init();
		
		$config		=	dunloader( 'config', 'jblesta' );
		
		$hash		=	isset( $this->get['h'] )	?	$this->get['h']	:	null;
		$username	=	isset( $this->get['u'] )	?	$this->get['u']	:	null;
		$time		=	isset( $this->get['t'] )	?	$this->get['t']	:	null;
		$uri		=	isset( $this->get['r'] )	?	$this->get['r']	:	null;
		$key		=	$config->get( 'logintoken', null );
		
		if (! $key ) {
			return false;
		}
		
		if ( $hash == $this->Companies->systemHash( $time . $username . $uri, $key, "sha256" ) && $time >= strtotime( "-5 min" ) ) {
			return $this->processSharedLogin( $username, $uri );
		}
		
		return false;
	}
	
	
	/**
	 * Processes the login for J!Blesta
	 * @access		public
	 * @version		@fileVers@
	 * @param		string			Contains the username
	 * @param		string			Contains the landing URL if set
	 * 
	 * @return		false|redirect	False on failure, redirect on success
	 * @since		1.0.0
	 */
	private function processSharedLogin( $username, $uri )
	{
		$this->uses( array( "Clients", "Users", "Logs" ) );
		$user	=	$this->Users->getByUsername( $username );
		
		if ( $user && $user->two_factor_mode == 'none' ) {
			$client	=	$this->Clients->getByUserId( $user->id );
			
			if ( $client ) {
				$this->Session->write( "blesta_id", $user->id );
				$this->Session->write( "blesta_company_id", $this->company_id );
				$this->Session->write( "blesta_client_id", $client->id );
				
				// Log this user
				$log = array(
					'user_id' => $user->id,
					'ip_address' => isset($_SESSION['REMOTE_ADDR']) ? $_SESSION['REMOTE_ADDR'] : "",
					'company_id' => $this->company_id,
					'result' => "success"
				);
				
				$this->Logs->addUser( $log );
				
				return $this->returnResponse( $uri );
			}
		}
		return false;
	}
	
	
	/**
	 * Method for redirecting out
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @param		string			The intended destination
	 * @since		1.0.0
	 */
	private function returnResponse( $uri )
	{
		if ( $uri == null ) {
			$this->redirect( $this->client_uri );
		}
		
		$this->redirect( $uri );
	}
}
?>