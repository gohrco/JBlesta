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
 * JBlesta System Plugin API Validate
 * @desc		This file handles the Validation routine through our API
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class ValidateJblestaAPI extends JblestaAPI
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
		$input		=	dunloader( 'input', true );
		$method		=	$input->getMethod();
		$data		=	$input->getVar('data', array(), 'array', $method );
		
		if ( $data['isnew'] ) {
			
			if ( $this->_checkFor( $data['email'] ) ) {
				$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_VALIDATEEMAIL_NO' ), $data['email'] ) );
			}
			
			if ( isset( $data['username'] ) && ! empty( $data['username'] ) ) {
				if ( $this->_checkFor( $data['username'], 'username' ) ) {
					$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_VALIDATEUSERNAME_NO' ), $data['username'] ) );
				}
			}
		}
		else {
			
			// See if the old / new emails are different
			if ( isset( $data['oldemail'] ) && isset( $data['email'] ) && $data['oldemail'] != $data['email'] ) {
				if ( $this->_checkFor( $data['email'] ) ) {
					$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_VALIDATEEMAIL_NO' ), $data['email'] ) );
				}
			}
			
			$oldusername	=	$this->_checkFor( $data['oldemail'], 'username', 'email' );
			
			if ( isset( $data['username'] ) && $data['username'] != $oldusername ) {
				if ( $this->_checkFor( $data['username'], 'username' ) ) {
					$this->error( sprintf( JText :: _( 'JBLESTA_SYSM_API_VALIDATEUSERNAME_NO' ), $data['username'] ) );
				}
			}
		}
		
		$this->success( JText :: _( 'JBLESTA_SYSM_API_VALIDATE_YES' ) );
	}
	
	
	/**
	 * Method for checking a variable in the table
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $value: the value to check
	 * @param		string		- $item: the item we want to check [username|email]
	 * @param		string		- $by: permits us to look according to a different item
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	private function _checkFor( $value = null, $item = 'email', $by = null )
	{
		$by		=	$by == null ? $item : $by;
		$db		=	dunloader( 'database', true );
		$query	=	"SELECT u." . $item . " FROM `#__users` u WHERE `" . $by . "` = " . $db->Quote( $value );
		$db->setQuery( $query );
		return $db->loadResult();
	}
}