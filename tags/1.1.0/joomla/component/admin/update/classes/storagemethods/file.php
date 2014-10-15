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
 * JBlesta File Storage class
 * @desc		This class handles storing update info in files for J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaStorageFile extends JblestaStorage
{
	/**
	 * Stores the filename of the storage item
	 * @var		string
	 */
	private static $filename = null;
	
	/**
	 * Stores the path to the storage item
	 * @var		string
	 */
	private static $filepath = null;
	
	
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
		$path	= $config['_storagePath'];
		$filename	= $config['_storagePath'] . DS . $config['_extensionName'] . ".updates.ini";
		var_dump( $filename );
		self :: $filename = $filename;
		
		jimport('joomla.registry.registry');
		self :: $registry = new JRegistry();
		
		jimport('joomla.filesystem.file');
		
		if ( JFile :: exists( self :: $filename ) ) {
			$data = json_decode( JFile :: read( self :: $filename ), 1 );
			self :: $registry->loadArray( $data );
		}
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
		jimport( 'joomla.filesystem.file' );
		$data = json_encode( self :: $registry->toArray() );
		JFile::write( self :: $filename, $data );
	}
}