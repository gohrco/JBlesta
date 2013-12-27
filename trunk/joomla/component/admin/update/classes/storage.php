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
 * JBlesta Storage class
 * @desc		This class stores updates for J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaStorage
{
	/**
	 * Stores the registry that gets used for storage
	 * @var		object
	 */
	public static $registry = null;
	
	
	/**
	 * Method to return a single instance of the storage object
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $type: contains the type of storage we are using (file or database)
	 * @param		object		- $config: JblestaUpdateConfig containing settings
	 * 
	 * @return		instance of JblestaStorage object
	 * @since		1.0.0
	 */
	public static function getInstance( $type, $config )
	{
		static $instances = array();
		
		$sig = md5( $type . serialize( $config ) );
		
		if (! array_key_exists( $sig, $instances ) ) {
			require_once dirname(__FILE__) . DS . 'storagemethods' . DS . strtolower( $type ) . '.php';
			$className		= 'JblestaStorage' . ucfirst( $type );
			$object			= new $className( $config );
			$object->load( $config );
			
			$newRegistry	= clone( self::$registry );
			$object->setRegistry( $newRegistry );
			
			$instances[$sig] = $object;
		}
		return $instances[$sig];
	}
	
	
	/**
	 * Method to return the registry
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		object
	 * @since		1.0.0
	 */
	public function getRegistry()
	{
		return self :: $registry;
	}
	
	
	/**
	 * Method to set the registry
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $registry: registry object
	 * 
	 * @since		1.0.0
	 */
	public function setRegistry( $registry )
	{
		self :: $registry = $registry;
	}
	
	
	/**
	 * Method to set a key / value pair in the registry
	 * @access		public
	 * @final
	 * @version		@fileVers@
	 * @param		string		- $key: contains the name of the setting
	 * @param		mixed		- $value: contains the value of the setting
	 * 
	 * @since		1.0.0
	 */
	public final function set( $key, $value )
	{
// 		if ( $key == 'cachedata' ) {
// 			if(function_exists('json_encode') && function_exists('json_decode')) {
// 				$value = json_encode($value);
// 			} elseif(function_exists('base64_encode') && function_exists('base64_decode')) {
// 				$value = base64_encode(serialize($value));
// 			} else {
// 				$value = serialize($value);
// 			}
// 		}
		
		if ( version_compare( JVERSION, '2.5.6', 'ge' ) ) {
			self::$registry->set( $key, $value );
		}
		else {
			self::$registry->setValue( $key, $value );
		}
	}
	
	
	/**
	 * Method to get a key from the registry
	 * @access		public
	 * @final
	 * @version		@fileVers@
	 * @param		string		- $key: the name of the setting to get
	 * @param		mixed		- $default: the default setting to use if not set
	 * 
	 * @return		mixed
	 * @since		1.0.0
	 */
	public final function get($key, $default)
	{
		if ( version_compare( JVERSION, '2.5.6', 'ge' ) ) {
			return self::$registry->get( $key, $default );
		}
		
		$value = self::$registry->getValue( $key, $default );
// 		if($key == 'cachedata') {
// 			if(function_exists('json_encode') && function_exists('json_decode')) {
// 				$value = json_decode($value);
// 			} elseif(function_exists('base64_encode') && function_exists('base64_decode')) {
// 				$value = unserialize(base64_decode($value));
// 			} else {
// 				$value = unserialize($value);
// 			}
// 		}
		return $value;
	}
}