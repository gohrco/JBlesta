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
 * JBlesta Fetch Update class
 * @desc		This class retrieves the update for J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaUpdateFetch extends JObject
{
	/**
	 * Stores the time to live value
	 * @var		integer
	 */
	private $cacheTTL = 24;
	
	
	/**
	 * Method to get update information
	 * @access		public
	 * @version		@fileVers@
	 * @param		boolean		- $force: forcibly update info (dont use cache)
	 * 
	 * @return		array containing updates
	 * @since		1.0.0
	 */
	public function getUpdateInformation( $force = false )
	{
		require_once( 'config.php' );
		require_once( 'storage.php' );
		
		// Get array of updates to check for (run through plugins and add to component / whmcs)
		$pkg	= array();
		$pkg[]	= $this->getUpdateSite( 'com_jblesta' );
		$pkg[]	= $this->getUpdateSite( 'mod_jblestalogin' );
		$pkg[]	= $this->getUpdateSite( 'whmcs' );
		
		// Grab the plugins... 
		JPluginHelper :: importPlugin( 'authentication' );
		JPluginHelper :: importPlugin( 'system' );
		JPluginHelper :: importPlugin( 'user' );
		$dispatcher		= & JDispatcher :: getInstance();
		
		$plugins	= $dispatcher->trigger( 'getUpdateSite', array() );
		if (! empty( $plugins ) ) $pkg = array_merge( $pkg, $plugins );
		
		// Cycle through each update
		$updates	= array();
		foreach ( $pkg as $p ) {
			
			if ( strstr( $p['extensionName'], 'jblesta' ) === false ) continue;
			
			$config		= JblestaUpdateConfig :: getInstance( $p['extensionName'], $p['options'] );
			$storage	= JblestaStorage :: getInstance( $config->get( '_storage' ), $config->toArray() );
			
			$registry	= $storage->getRegistry();
			
			if ( version_compare( JVERSION, '2.5.6', 'ge' ) ) {
				$lastcheck	= $registry->get( 'lastcheck', 0 );
				$cachedata	= $registry->get( 'cachedata', null );
			}
			else {
				$lastcheck	= $registry->getValue( 'lastcheck', 0 );
				$cachedata	= $registry->getValue( 'cachedata', null );
			}
			
			if ( empty( $cachedata ) ) $lastcheck = 0;
			
			$now = time();
			$TTL = $this->cacheTTL * 3600;
			$dif = abs( $now - $lastcheck );
			
			if (! $force && ( $dif <= $TTL ) ) {
				// Use cache
				$available = (object) $cachedata;
			}
			else {
				$available = $this->getUpdateData( $config, $storage, $force );
				$storage->set( 'lastcheck', $now );
				$storage->set( 'cachedata', $available );
				$storage->save();
			}
			
			$updates[$p['extensionName']] = array(
				'config'	=> $config,
				'storage'	=> $storage,
				'update'	=> $available
			);
		}
		
		return $updates;
	}
	
	
	/**
	 * Method to take an update object and find any updates
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $config: JblestaUpdateConfig object containing settings
	 * @param		object		- $storage: JblestaUpdateStorage object containing storage stuff
	 * @param		boolean		- $force: forcibly get new update
	 * 
	 * @return		object
	 * @since		1.0.0
	 */
	public function getUpdateData( $config, $storage, $force = false )
	{
		$data	= (object) array(
					'supported'		=> false,
					'stuck'			=> true,
					'version'		=> '',
					'stability'		=> '',
					'downloadURL'	=> '',
					'hasupdate'		=> false,
					'creds'			=> array( 'username' => null, 'password' => null )
				);
		
		if( $storage->get( 'stuck', 0 ) && ! $force ) return $data;
		
		$data->stuck = false;
		
		require_once( 'download.php' );
		
		$storage->set( 'stuck', 1 );
		$storage->save();
		
		$rawdata	= JblestaDownloadHelper :: downloadAndReturn( $config );
		
		try {
			$xmldata	= simplexml_load_string( $rawdata );
		}
		catch (Exception $e) {
			$data->stuck = true;
			return $data;
		}
		
		if (! is_a( $xmldata, 'SimpleXMLElement' ) ) {
			$data->stuck = true;
			return $data;
		}
		$strdata	= $this->toArray( $xmldata );
		
		$storage->set( 'stuck', 0 );
		$storage->save();
		
		if ( empty( $strdata ) || ( $rawdata === false ) ) return $data;
		
		$update	= $this->findUpdate( $strdata, $config );
		
		// If we couldn't find an update then return nothing much
		if ( $update === false ) return $data;
		
		$data->supported	= true;
		$data->version		= $update['version'];
		$data->stability	= $update['tags']['tag'];
		$data->downloadURL	= $update['downloads']['downloadurl']['value'];
		$data->hasupdate	= true;
		
		return $data;
	}
	
	
	/**
	 * Method to gather non-plugin update site info
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $item: the item to get update site info for
	 * 
	 * @return		array of data
	 * @since		1.0.0
	 */
	public function getUpdateSite( $item = 'com_jblesta' )
	{
		switch ( $item ) :
		case 'com_jblesta' :
			$data	= array(
						'extensionName'				=> 'com_jblesta',
						'options' => array(
								'extensionTitle'	=> 'J!WHMCS Integrator Joomla! Component',
								'storage'			=> 'database',
								'storagePath'		=> null,
								'extensionType'		=> 'component',
								'updateUrl'			=> 'https://www.gohigheris.com/updates/jblesta/component',
								'targetPlatform'	=> 'joomla'
							)
					);
			break;
		case 'whmcs' :
			$data	= array(
						'extensionName'				=> 'file_whmcs_jblesta',
						'options' => array(
								'extensionTitle'	=> 'J!WHMCS Integrator WHMCS Addon Module',
								//'storage'			=> 'file',
								//'storagePath'		=> dirname( dirname( __FILE__ ) ),
								//'storageUrl'		=> JUri :: root(),
								'storage'			=> 'database',
								'storagePath'		=> null,
								'extensionType'		=> 'file',
								'updateUrl'			=> 'https://www.gohigheris.com/updates/jblesta/whmcs',
								'targetPlatform'	=> 'whmcs',
								'targetVersion'		=> '5.0'
						)
				);
				
			break;
		case 'mod_jblestalogin' :
			$data	= array(
					'extensionName'				=> 'mod_jblestalogin',
					'options' => array(
							'extensionTitle'	=> 'J!WHMCS Integrator Add-on Module:  Client Login',
							'storage'			=> 'database',
							'storagePath'		=> null,
							'extensionType'		=> 'module',
							'updateUrl'			=> 'https://www.gohigheris.com/updates/jblesta/modules/login',
							'targetPlatform'	=> 'joomla'
					)
			);
			break;
		endswitch;
		
		return $data;
	}
	
	
	/**
	 * Method to parse returned updates and single out any relevant updates
	 * @access		private
	 * @version		@fileVers@
	 * @param		array		- $data: any update data
	 * @param		object		- $config: JblestaUpdateConfig object containing settings
	 * 
	 * @return		object containing a single update or false on none
	 * @since		1.0.0
	 */
	private function findUpdate( $data, $config )
	{
		if (! isset( $data['update'] ) || ! is_array( $data['update'] ) ) return false;
		
		$jversion = new JVersion;
		
		$element	= $config->get( '_extensionName', null );
		$type		= $config->get( '_extensionType', null );
		$curvers	= $config->get( '_currentVersion', null );
		$platform	= $config->get( '_targetPlatform', 'joomla' );
		$platvers	= $config->get( '_targetVersion', $jversion->RELEASE );
		$mostrecent	= null;
		$usekey		= null;
		
		// Single update returns aren't double nested, catch this!
		if (! is_array( $data['update'][0] ) ) {
			$data['update'] = array( $data['update'] );
		} 
		
		foreach ( $data['update'] as $key => $update ) {
			if ( strpos( $update['version'], 'v' ) !== false ) {
				$update['version'] = $data[$key]['version'] = str_replace( 'v', '', $update['version'] );
			}
			
			if (
					( $element == $update['element'] ) &&
					( $type == $update['type'] ) &&
					( $platform == $update['targetplatform']['name'] ) &&
					( $platvers == $update['targetplatform']['version'] ) &&
					( version_compare( $update['version'], $mostrecent, 'g' ) )
				) {
				$mostrecent = $update['version'];
				$usekey		= $key;
			}
		}
		
		if ( is_null( $usekey ) ) return false;
		
		/* CHANGE THIS BEFORE DONE */
		if ( version_compare( $mostrecent, $config->get( '_currentVersion' ), 'g' ) ) {
			return $data['update'][$usekey];
		}
		else {
			return false;
		}
		
	}
	
	
	/**
	 * Method to convert an XML feed into an array
	 * @access		private
	 * @version		@fileVers@
	 * @param		SimpleXMLElement - $xml: what we are converting
	 * @param		string		- $attributesKey
	 * @param		string		- $childrenKey
	 * @param		string		- $valueKey
	 * @param		boolean		- $recursive: indicates we are recursively deep
	 * 
	 * @return		array containing data
	 * @since		1.0.0
	 */
	private function toArray( SimpleXMLElement $xml, $attributesKey = null, $childrenKey = null, $valueKey = null, $recursive = false )
	{
		if ( $childrenKey && ! is_string( $childrenKey ) ) {
			$childrenKey = '@children';
		}
		
		if ( $attributesKey && ! is_string( $attributesKey ) ) {
			$attributesKey = '@attributes';
		}
		
		if ( $valueKey && ! is_string( $valueKey ) ) {
			$valueKey = '@values';
		}
		
		$return	= array();
		$name	= $xml->getName();
		$_value	= trim((string)$xml);
		
		if ( $_value == '>' ) $_value = '';
		
		if (! strlen( $_value ) ) {
			$_value = null;
		}

		if ( $_value !== null ) {
			if ( $valueKey ) {
				$return[$valueKey] = $_value;
			}
			else {
				$return = $_value;
			}
		}

		$children	= array();
		$first		= true;

		foreach ( $xml->children() as $elementName => $child )
		{
			$value	= $this->toArray( $child, $attributesKey, $childrenKey, $valueKey, true );
			//echo $elementName . ' = ' . print_r($child,1). '<br/>';
				if ( isset( $children[$elementName] ) ) {
					if ( is_array( $children[$elementName] ) ) {
						if ( $first ) {
							$temp	= $children[$elementName];
							unset( $children[$elementName] );
							$children[$elementName][]	= $temp;
							$first	= false;
						}
						$children[$elementName][]	= $value;
					}
					else {
						$children[$elementName]	= array( $children[$elementName], $value );
					}
				}
				else {
					$children[$elementName]	= $value;
				}
			
		}

		if ( $children ) {
			if ( $childrenKey ) {
				$return[$childrenKey] = $children;
			}
			else {
				if (! empty( $return ) ) 
					$return	= @array_merge( (array) $return, $children );
				else
					$return	= $children;
			}
		}
		
		$attributes	= array();
		foreach ( $xml->attributes() as $name => $value )
		{
			$attributes[$name]	= trim($value);
		}
		
		if ( $attributes ) {
			if ( $attributesKey ) {
				$return[$attributesKey] = $attributes;
			}
			else {
				if (! is_array( $return ) ) $return = array( 'value' => $return );
				$return	= @array_merge( $return, $attributes );
			}
		}
		
		return $return;
	}
}