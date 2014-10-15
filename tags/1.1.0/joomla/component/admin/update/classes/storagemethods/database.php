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
 * 
 * The methods and routines within this file are based partly upon the work of
 *   Nicholas K. Dionysopoulos / AkeebaBackup.com
 * 
 */

/*-- Security Protocols --*/
defined('_JEXEC') or die();
/*-- Security Protocols --*/


/**
 * JBlesta Database Storage class
 * @desc		This class handles permitting storing the update info in the database for J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaStorageDatabase extends JblestaStorage
{
	/**
	 * Stores the name of the extension we are using
	 * @var		string
	 */
	private static $extension	= null;
	
	/**
	 * Stores the type of extension we are using
	 * @var		string
	 */
	private static $exttype		= null;
	
	/**
	 * Stores the parameter key we are using in the params field
	 * @var		string
	 */
	private static $paramkey	= 'update';
	
	
	/**
	 * Method to load an extension into the storage object
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $config: contains the JblestaUpdateConfig object to use for stettings
	 * 
	 * @since		1.0.0
	 */
	public function load( $config )
	{
		$db		= & JFactory :: getDbo();
		
		// Set the extension to use in the DB
		if ( empty( $config['_extension'] ) )
			self :: $extension = $config['_extensionName'];
		else
			self :: $extension = $config['_extension'];
		
		// Set the extension type to use in the DB
		if ( empty( $config['_extensionType'] ) )
			self :: $exttype = 'component';
		else
			self :: $exttype = $config['_extensionType'];
		
		// Set the parameter key to use in the parameters field
		if ( empty( $config['_paramkey'] ) )
			self :: $paramkey = 'update';
		else
			self :: $paramkey = $config['_paramkey'];
		
		$params		= & JblestaParams :: getInstance();
		$updates	= $params->get( 'allupdates' );
		
		if ( empty( $updates ) ) 
			$updates = array();
		else 
			$updates	= json_decode( $updates, true );
		
		if ( isset( $updates[ self :: $extension ] ) ) 
			$updates	= $updates[ self :: $extension ];
		else
			$updates	= array();
		
		self :: $registry = new JRegistry();
		self :: $registry->loadArray( $updates );
	}
	
	
	/**
	 * Method to save parameters to the database
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function save()
	{
		$params		= & JblestaParams :: getInstance();
		$updates	=   json_decode( $params->get( 'allupdates' ), true );
		$data		=   self :: $registry->toArray();
		$updates[ self :: $extension ] = $data;
		
		$updates	= json_encode( $updates );
		$params->set( 'allupdates', $updates, true, 'updates' );
	}
	
	
	/**
	 * Method to create a commonly used SQL query
	 * @access		private
	 * @version		@fileVers@
	 * @param		boolean		- $save: if we want the save sql
	 * 
	 * @return		string containg SQL
	 * @since		1.0.0
	 */
	private function _createSql( $save = false )
	{
		$db	= & JFactory :: getDbo();
		
		if ( $save ) {
			// ===================
			// SAVE:  Joomla! 2.5+
			if ( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
				$element	= self :: $exttype == 'plugin' ? substr( self :: $extension, 4 ) : self :: $extension;
				$sql		= 'UPDATE ' . $db->nameQuote( '#__extensions' )
							. ' SET ' . $db->nameQuote( 'params' ) . " = '%s'"
							. ' WHERE ' . $db->nameQuote( 'element' ) . ' = ' . $db->Quote( $element )
							. ' AND ' . $db->nameQuote( 'type' ) . ' = ' . $db->Quote( self :: $exttype );
			}
			// ===================
			// SAVE:  Joomla! 1.5
			else {
				switch ( self :: $exttype ) {
					case 'component':
						$sql	= 'UPDATE ' . $db->nameQuote( '#__components' )
								. ' SET ' . $db->nameQuote( 'params' ) . " = '%s'"
								. ' WHERE ' . $db->nameQuote( 'option' ) . '=' . $db->Quote( self :: $extension );
						break;
					case 'plugin' :
						$element	= substr( self :: $extension, 4 );
						$sql	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
								. ' SET ' . $db->nameQuote( 'params' ) . " = '%s'"
								. ' WHERE ' . $db->nameQuote( 'element' ) . '=' . $db->Quote( $element );
						break;
				}
			}
			
		}
		else {
			// ===================
			// LOAD:  Joomla! 2.5+
			if ( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
				$element	= self :: $exttype == 'plugin' ? substr( self :: $extension, 4 ) : self :: $extension;
				$sql = 'SELECT ' . $db->nameQuote( 'params' )
					 . ' FROM ' . $db->nameQuote( '#__extensions' )
					 . ' WHERE ' . $db->nameQuote( 'type' ) . '=' . $db->Quote( self :: $exttype )
					 . ' AND ' . $db->nameQuote( 'element' ) . '=' . $db->Quote( $element );
			}
			// ===================
			// LOAD:  Joomla! 1.5
			else {
				switch ( self :: $exttype ) {
					case 'component':
						$sql = 'SELECT ' . $db->nameQuote( 'params' )
							 . ' FROM ' . $db->nameQuote( '#__components' )
							 . ' WHERE ' . $db->nameQuote( 'option' ) . '=' . $db->Quote( self :: $extension );
						break;
					case 'plugin' :
						$element	= substr( self :: $extension, 4 );
						$sql = 'SELECT ' . $db->nameQuote( 'params' )
							 . ' FROM ' . $db->nameQuote( '#__plugins' )
							 . ' WHERE ' . $db->nameQuote( 'element' ) . '=' . $db->Quote( $element );
						break;
				}
			}
		}
		
		return $sql;
	}
	
	
	/**
	 * Method to repeatedly return the proper extension table for the db
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	private function _extensionTable()
	{
		return version_compare( JVERSION, '1.6.0', 'ge' ) ? '#__extensions' : ( self :: $exttype == 'component' ? '#__components' : '#__plugins' );
	}
}