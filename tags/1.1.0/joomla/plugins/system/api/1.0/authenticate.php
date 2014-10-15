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
 * JBlesta System Plugin API Authentication
 * @desc		This file handles the Authentication routine through our API
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class AuthenticateJblestaAPI extends JblestaAPI
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
		jimport('joomla.user.authentication');
		
		$input		=	dunloader( 'input', true );
		$method		=	$input->getMethod();
		$data		=	$input->getVar('data', array(), 'array', $method );
		
		$creds		=	array(
								'username'	=> $data['username'],
								'password'	=> $data['password']
						);
		
		$options	=	array(
								'silent'	=> true,
								'jblesta'	=> true,
						);
		
		$app			=	JFactory :: getApplication();
		$authenticate	=	JAuthentication::getInstance();
		$response		=	$authenticate->authenticate( $creds, $options );
		
		if ( $response->status === JAuthentication :: STATUS_SUCCESS ) {
			
			$authorisations	=	$authenticate->authorise( $response, $options );
			$denied_states	=	array(
					JAuthentication :: STATUS_EXPIRED,
					JAuthentication :: STATUS_DENIED
					);
			
			foreach ( $authorisations as $authorisation ) {
				if ( in_array( $authorisation->status, $denied_states ) ) {
					// Trigger onUserAuthorisationFailure Event.
					$app->triggerEvent( 'onUserAuthorisationFailure', array( (array) $authorisation ) );
					
					switch ($authorisation->status) :
						case JAuthentication :: STATUS_EXPIRED:
							$use	=	'EXPIRED';
							break;
						case JAuthentication :: STATUS_DENIED:
							$use	=	'DENIED';
							break;
						default:
							$use	=	'AUTHORISATION';
							break;
					endswitch;
					
					$this->error( JText :: _( 'JBLESTA_SYSM_API_AUTHENTICATION_NOAUTH_' . $use ) );
				}
			}
			
			$user	=	JUser :: getInstance( $data['username'] );
			$return	=	array(
					'email'		=>	$user->get( 'email', null ),
					'name'		=>	$user->get( 'name', null ),
					'username'	=>	$user->get( 'username', null )
					);
// 			$db	=	dunloader( 'database', true );
// 			$db->setQuery( "SELECT `email` FROM `#__users` WHERE `username` = " . $db->Quote( $data['username'] ) );
			$this->success( $return );
// 			$this->success( array( 'email' => $db->loadResult() ) );
		}
		
		$this->error( JText :: _( 'JBLESTA_SYSM_API_AUTHENTICATION_FAILED' ) );
	}
}