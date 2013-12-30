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
 * JBlesta System Plugin API Base
 * @desc		This file is our base API file which all requests build on
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaAPI
{
	
	/**
	 * Method for returning an error
	 * @access		protected
	 * @version		@fileVers@
	 * @param		mixed		- $data: contains data to send back
	 * 
	 * @since		2.0.0
	 */
	protected function error( $data )
	{
		$this->_response( array( 'result' => 'error', 'error' => $data ) );
	}
	
	
	/**
	 * Method for calling a variable from the input handler of Joomla
	 * @access		protected
	 * @version		@fileVers@
	 * @param		string		- $var: the variable we want
	 * @param		mixed		- $default: the default to send back if not found
	 * @param		string		- $filter: what to filter by (cmd|string|array|int...)
	 * @param		string		- $hash: the source hash (get|post|request...)
	 * @param		integer		- $mask: level of cleaning to apply
	 * 
	 * @return		mixed result or default
	 * @since		2.0.0
	 */
	protected function getVar( $var, $default = null, $filter = 'none', $hash = 'default', $mask = 0 )
	{
		if ( version_compare( JVERSION, '1.7.1', 'ge' ) ) {
			$app	= & JFactory :: getApplication();
			$method	=	$app->input->getMethod();
			return $app->input->$method->get( $var, $default, $filter );
		}
		else {
			$value	= JRequest :: getVar( $var, $default, $hash, $filter, $mask );
			// If we are resetting pw on front end, post is empty for some reason
			if ( empty( $value ) && $var == 'post' ) $value = JRequest::get( 'post' );
			return $value;
		}
	}
	
	
	/**
	 * Method for executing on the API
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		2.0.0
	 */
	public function execute() { }
	
	
	/**
	 * Method for returning data successfully
	 * @access		protected
	 * @version		@fileVers@
	 * @param		mixed		- $data: the data to send back
	 * 
	 * @since		2.0.0
	 */
	protected function success( $data )
	{
		$this->_response( array( 'result' => 'success', 'data' => $data ) );
	}
	
	
	/**
	 * Method for sending a response
	 * @access		private
	 * @version		@fileVers@
	 * @param		array		- $data: contains the data to render back to the user
	 * 
	 * @since		2.0.0
	 */
	private function _response( $data )
	{
		$string	= json_encode( $data );
		exit( $string );
	}
}