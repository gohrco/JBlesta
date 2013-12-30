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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
defined('DUNAMIS') OR exit('No direct script access allowed');


/**
 * JBlesta User Plugin User Plugin Update Handler
 * @desc		This file is called up through the Dunamis Framework to check for updates for the plugin
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */

class Jblesta_userDunUpdates extends JoomlaDunUpdates
{
	protected $_enabled		=	false;							// We declare this after completing tests on construct
	protected $_exceptions	=	array( 'README.txt' );
	protected $_expires		=	86400; // TTL
	protected $_installpath	=	null;
	protected $_url			=	'https://www.gohigheris.com/updates/jblesta/plugin-user';
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
		
		// Ensure we have com_jblesta installed
		if ( get_dunamis( 'com_jblesta' ) ) {
			$this->setEnabled( true );
		}
		
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
		// Ensure we are enabled
		if (! $this->getEnabled() ) {
			return;
		}
		
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
		// Ensure we are enabled
		if (! $this->getEnabled() ) {
			return;
		}
		
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
		// Ensure we are enabled
		if (! $this->getEnabled() ) {
			return;
		}
		
		$db		=	dunloader( 'database', true );
		
		$update	=	new stdClass();
		$update->lastrun	=	$this->getLastrun();
		$update->update		=	$this->getUpdate();
		
		$data	=	json_encode( $update );
		
		$db->setQuery( "UPDATE `mod_jblesta_settings` SET `value` = " . $db->Quote( $data, false ) . " WHERE `key` = 'updates'" );
		return (bool) $db->query();
	}
}