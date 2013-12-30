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
 * JBlesta XML Manifest class
 * @desc		This class handles parsing the XML Manifest for Joomla updates for J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaUpdateXMLManifest extends JObject
{
	/**
	 * 
	 * @var unknown_type
	 */
	private $_info = array();
	
	
	/**
	 * Method to retrieve singleton instances of XML manifests
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $extensionName: the name of the extension to get
	 * @param		string		- $xmlName: path to the XML file
	 * 
	 * @return		array of data from an XML file
	 * @since		2.4.0
	 */
	public function getInfo($extensionName, $xmlName = null )
	{
		if (! array_key_exists( $extensionName, $this->_info ) ) {
			$this->_info[$extensionName] = $this->fetchInfo($extensionName, $xmlName);
		}
		
		return $this->_info[$extensionName];
	}
	
	
	/**
	 * Method to actually get the information together
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $extensionName: the name of the extension to get
	 * @param		string		- $xmlName: path to the XML file
	 * 
	 * @return		array of data from an XML file
	 * @since		2.4.0
	 */
	private function fetchInfo($extensionName, $xmlName)
	{
		$type = strtolower( substr( $extensionName, 0, 3 ) );
		
		switch( $type ) {
			case 'com':
				return $this->getComponentData($extensionName, $xmlName);
				break;
			case 'mod':
				return $this->getModuleData($extensionName, $xmlName);
				break;
			case 'plg':
				return $this->getPluginData($extensionName, $xmlName);
				break;
			case 'fil':
				return $this->getFileData( $extensionName, $xmlName );
				break;
			/*case 'tpl':
				return $this->getTemplateData($extensionName, $xmlName);
				break;
			case 'pkg':
				return $this->getPackageData($extensionName, $xmlName);
				break;
			case 'lib':
				return $this->getPackageData($extensionName, $xmlName);
				break;
			default:
				if(strtolower(substr($extensionName, 0, 4)) == 'file') {
					return $this->getPackageData($extensionName, $xmlName);
				} else {
					return array('version'=>'', 'date'=>'');
				}*/
		}
	}
	
	
	/**
	 * Method to read a component XML data file
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $extensionName: the name of the extension to get
	 * @param		string		- $xmlName: path to the XML file
	 * 
	 * @return		array of data from an XML file
	 * @since		2.4.0
	 */
	private function getComponentData($extensionName, $xmlName)
	{
		$extensionName = strtolower($extensionName);
		$path = JPATH_ADMINISTRATOR . DS . 'components' . DS . $extensionName;
		$altExtensionName = substr($extensionName,4);
		
		jimport('joomla.filesystem.file');
		if( JFile::exists( "$path/$xmlName" ) ) {
			$filename = "$path/$xmlName";
		} elseif( JFile::exists( "$path/$extensionName.xml" ) ) {
			$filename = "$path/$extensionName.xml";
		} elseif( JFile::exists( "$path/$altExtensionName.xml" ) ) {
			$filename = "$path/$altExtensionName.xml";
		} elseif( JFile::exists( "$path/manifest.xml" ) ) {
			$filename = "$path/manifest.xml";
		} else {
			$filename = $this->searchForManifest($path);
			
			if( $filename === false )
				$filename = null;
		}
		
		if( empty( $filename ) ) {
			return array('version' => '', 'date' => '', 'xmlfile' => '');
		}
		
		return $this->xmlparser( $filename );
		
		try {
			$xml = new SimpleXMLElement($filename, LIBXML_NONET, true);
		} catch(Exception $e) {
			return array('version' => '', 'date' => '', 'xmlfile' => '');
		}
		
		if ($xml->getName() != 'extension' && $xml->getName() != 'install') {
			unset($xml);
			return array('version' => '', 'date' => '', 'xmlfile' => '');
		}
		
		$data				= array();
		$data['version']	= $xml->version ? (string) $xml->version : '';
		$data['date']		= $xml->creationDate ? (string) $xml->creationDate : '';
		$data['xmlfile']	= $filename;
		
// 		$xml = & JFactory::getXMLParser('Simple');
// 		if (! $xml->loadFile( $filename ) ) {
// 			unset( $xml );
// 			return array('version' => '', 'date' => '', 'xmlfile' => '');
// 		}
		
// 		if ( ( $xml->document->name() != 'install' ) && ( $xml->document->name() != 'extension' ) ) {
// 			unset($xml);
// 			return array('version' => '', 'date' => '', 'xmlfile' => '');
// 		}
		
// 		$element = & $xml->document->version[0];
// 		$data['version'] = $element ? $element->data() : '';
// 		$element = & $xml->document->creationDate[0];
// 		$data['date'] = $element ? $element->data() : '';
	
// 		$data['xmlfile'] = $filename;
		
		return $data;
	}
	
	
	/**
	 * Method to read a module XML data file
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $extensionName: the name of the extension to get
	 * @param		string		- $xmlName: path to the XML file
	 * 
	 * @return		array of data from an XML file
	 * @since		2.4.0
	 */
	private function getModuleData($extensionName, $xmlName)
	{
		$extensionName		= strtolower( $extensionName );
		$altExtensionName	= substr( $extensionName, 4 );
	
		jimport( 'joomla.filesystem.folder' );
		jimport( 'joomla.filesystem.file' );
		
		$path	= JPATH_SITE . '/modules/' . $extensionName;
		
		if (! JFolder :: exists( $path ) ) {
			$path	= JPATH_ADMINISTRATOR . '/modules/' . $extensionName;
		}
		
		if (! JFolder :: exists( $path ) ) {
			// Joomla! 1.5
			// 1. Check back-end
			$path		= JPATH_ADMINISTRATOR . '/modules';
			$filename	= "$path/$xmlName";
			
			if (! JFile :: exists( $filename ) ) {
				$filename	= "$path/$extensionName.xml";
			}
			
			if (! JFile :: exists( $filename ) ) {
				$filename	= "$path/$altExtensionName.xml";
			}
			
			// 2. Check front-end
			if (! JFile :: exists( $filename ) ) {
				$path		= JPATH_SITE . '/modules';
				$filename	= "$path/$xmlName";
				
				if (! JFile :: exists( $filename ) ) {
					$filename	= "$path/$extensionName.xml";
				}
				
				if (! JFile :: exists( $filename ) ) {
					$filename	= "$path/$altExtensionName.xml";
				}
				
				if (! JFile :: exists( $filename ) ) {
					return array('version' => '', 'date' => '');
				}
			}
		}
		else {
			// Joomla! 1.6
			$filename	= "$path/$xmlName";
			
			if (! JFile :: exists( $filename ) ) {
				$filename	= "$path/$extensionName.xml";
			}
			
			if (! JFile :: exists( $filename ) ) {
				$filename	= "$path/$altExtensionName.xml";
			}
			
			if (! JFile :: exists( $filename ) ) {
				return array('version' => '', 'date' => '');
			}
		}
		
		if ( empty( $filename ) ) {
			return array('version' => '', 'date' => '', 'xmlfile' => '');
		}
		
		return $this->xmlparser( $filename );
		
		$xml	= & JFactory::getXMLParser('Simple');
		
		if (! $xml->loadFile( $filename ) ) {
			unset($xml);
			return array('version' => '', 'date' => '', 'xmlfile' => '');
		}
		
		if ( $xml->document->name() != 'install' ) {
			unset($xml);
			return array('version' => '', 'date' => '', 'xmlfile' => '');
		}
		
		$data				=   array();
		$element			= & $xml->document->version[0];
		$data['version']	=   $element ? $element->data() : '';
		$element			= & $xml->document->creationDate[0];
		$data['date']		=   $element ? $element->data() : '';
		$data['xmlfile']	=   $filename;
		
		return $data;
	}
	
	
	/**
	 * Method to read plugin xml data
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $extensionName: the name of the extension to get
	 * @param		string		- $xmlName: path to the XML file
	 * 
	 * @return		array of data from an XML file
	 * @since		2.4.0
	 */
	private function getPluginData( $extensionName, $xmlName )
	{
		$extensionName		= strtolower( $extensionName );
		$altExtensionName	= substr( $extensionName, 4 );
		$secExtName			= null;
		
		$parts = explode( "_", $altExtensionName );
		if ( count( $parts ) > 1 ) $secExtName = $parts[(count($parts)-1)];
		
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
	
		$base = JPATH_PLUGINS;
	
		// Get a list of directories
		$stack = JFolder::folders( $base, '.', true, true );
		foreach( $stack as $path )
		{
			$filename = "$path/$xmlName";
			if ( JFile::exists( $filename ) ) break;
			$filename = "$path/$extensionName.xml";
			if ( JFile::exists( $filename ) ) break;
			$filename = "$path/$altExtensionName.xml";
			if ( JFile::exists( $filename ) ) break;
			$filename = "$path/$secExtName.xml";
			if ( JFile::exists( $filename ) ) break;
		}
		
		if (! JFile::exists( $filename ) ) {
			return array('version' => '', 'date' => '', 'xmlfile' => '');
		}
		
		return $this->xmlparser( $filename );
		
		$xml = & JFactory::getXMLParser( 'Simple' );
		if (! $xml->loadFile( $filename ) ) {
			unset($xml);
			return array('version' => '', 'date' => '', 'xmlfile' => '');
		}
	
		if ($xml->document->name() != 'install') {
			unset($xml);
			return array('version' => '', 'date' => '', 'xmlfile' => '');
		}
		
		$data = array();
		$element = & $xml->document->version[0];
		$data['version'] = $element ? $element->data() : '';
		$element = & $xml->document->creationDate[0];
		$data['date'] = $element ? $element->data() : '';
		
		$data['xmlfile'] = $filename;
		
		return $data;
	}
	
	
	/**
	 * Method to return file data
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $extensionName: the name of the extension to get
	 * @param		string		- $xmlName: path to the XML file
	 * 
	 * @return		array of data from an XML file
	 * @since		2.4.0
	 */
	private function getFileData( $extensionName, $xmlName )
	{
		// Default data to return
		$data	= array('version' => '', 'date' => '', 'xmlfile' => '');
		
		// If we don't have an extension name get outta here
		if ( empty ( $extensionName ) ) return $data;
		
		$parts	= explode( "_", $extensionName );
		
		switch ( $parts[1] ) :
		case 'blesta' :
			
			$params	= & JblestaParams::getInstance();
			$jcurl	= & JblestaCurl::getInstance();
			$jcurl->setParse( false );
			$jcurl->setAction( 'jblesta', array( 'task' => 'info' ) );
			$response	= $jcurl->loadResult();
			
			if ( $response === false ) return $data;
			else $response = json_decode( $response, true );
			
			$data['version'] = $response['modvers'];
			$data['date']	 = $response['revdate'];
			
			// Cleanup version
			$version	= $response['platver'];
			$parts		= explode( '.', $version );
			array_pop( $parts );
			$version	= implode( '.', $parts );
			$data['targetVersion'] = $version;
			
			break;
		endswitch;
		
		return $data;
	}
	
	
	/**
	 * Method to find a manifest file
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $path: path to the manifest location
	 * 
	 * @return		string of filename or false on unfound
	 * @since		2.4.0
	 */
	private function searchForManifest($path)
	{
		jimport( 'joomla.filesystem.folder' );
		$files = JFolder::files( $path, '\.xml$', false, true );
		if(! empty( $files ) ) foreach ( $files as $filename ) {
			$xml = JFactory::getXMLParser('simple');
			$result = $xml->loadFile($filename);
			if (! $result ) continue;
			if ( ( $xml->document->name() != 'install' ) && ( $xml->document->name() != 'extension' ) && ( $xml->document->name() != 'mosinstall' ) ) continue;
			unset( $xml );
			return $filename;
		}
	
		return false;
	}
	
	
	/**
	 * Method to parse an XML File
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $filename: the full path / name of file to parse
	 * 
	 * @return		array
	 * @since		2.4.8
	 */
	private function xmlparser( $filename = null )
	{
		$data	= array('version' => '', 'date' => '', 'xmlfile' => '');
		
		if ( $filename == null ) return $data;
		 
		try {
			$xml = new SimpleXMLElement($filename, LIBXML_NONET, true);
		} catch(Exception $e) {
			return $data;
		}
		
		if ($xml->getName() != 'extension' && $xml->getName() != 'install') {
			unset($xml);
			return $data;
		}
		
		$data['version']	= $xml->version ? (string) $xml->version : '';
		$data['date']		= $xml->creationDate ? (string) $xml->creationDate : '';
		$data['xmlfile']	= $filename;
		
		return $data;
	}
}