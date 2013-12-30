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
 * JBlesta Updates handler
 * @desc		This class is used by Dunamis to handle J!Blesta updates for Joomla
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Com_jblestaDunUpdates extends JoomlaDunUpdates
{
	protected $_exceptions	=	array( 'README.txt' );
	protected $_expires		=	86400; // TTL
	protected $_installpath	=	null;
	protected $_url			=	'https://www.gohigheris.com/updates/jblesta/joomla-package';
	protected $_version		=	'@fileVers@';
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: anything we want to set
	 *
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		$options	=	parent :: __construct( $options );
		$options	=	$this->setProperties( array( 'url', 'installpath', 'exceptions' ), $options );
		
		// Read / find / write any updates we have from the database
		$this->_updateRead();
		$this->_updateFind();
		$this->_updateWrite();
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = array();
		
		$serialize	=	serialize( $options );
		
		if (! isset( $instance[$serialize] ) ) {
			$instance[$serialize]	=	new self ( $options );
		}
		
		return $instance[$serialize];
	}
	
	
	/**
	 * Method for reading an update in
	 * @access		protected
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	protected function _updateRead()
	{
		$config	=	dunloader( 'config', 'com_jblesta' );
		$data	=	$config->get( 'updates', null );
		
		// If the store doesn't exist return false
		if( $data == null || empty( $data ) ) {
			return false;
		}
		
		// Decode the data
		$data	= json_decode( $data );
		$this->setLastrun( $data->lastrun );
		$this->setUpdate( $data->update );
		
		return true;
	}
	
	
	/**
	 * Method for getting a download URL for update
	 * @access		protected
	 * @version		@fileVers@
	 *
	 * @return		false on empty update
	 * @return		string
	 * @since		1.0.0
	 */
	protected function _updateUrl()
	{
		$config	=	dunloader( 'config', 'com_jblesta' );
		$dlid	=	$config->get( 'downloadid', null );
		
		$url	=	parent :: _updateUrl();
		$uri	=	DunUri :: getInstance( $url );
		
		if ( $dlid ) {
			$uri->setVar( 'dlid', $dlid );
		}
		
		return $uri->toString();
	}
	
	
	/**
	 * Method for writing an update out
	 * @access		protected
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	protected function _updateWrite()
	{
		$db			=	dunloader( 'database', true );
		$config		=	dunloader( 'config', 'com_jblesta' );
		
		$update	=	new stdClass();
		$update->lastrun	=	$this->getLastrun();
		$update->update		=	$this->getUpdate();
		
		$data	=	json_encode( $update );
		
		// If the store doesn't exist return false
		if( $data == null || empty( $data ) ) {
			return false;
		}
		
		$config->set( 'updates', $data );
		return $config->save();
	}
}