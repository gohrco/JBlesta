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

defined('_JEXEC') or die();

/**
 * JBlesta Update Config class
 * @desc		This class handles configuration items for updates for J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaUpdateConfig extends JObject
{
	/**
	 * Stores the CA file location for SSL usage
	 * @var		string
	 */
	protected	$_cacerts				= null;
	
	/**
	 * Stores the currently installed version
	 * @var		string
	 */
	protected	$_currentVersion		= null;
	
	/**
	 * Stores the date of the currently installed release
	 * @var		string
	 */
	protected	$_currentReleaseDate	= null;
	
	/**
	 * Stores the extension name (com_belong, plg_belong_mailchimp etc)
	 * @var		string
	 */
	protected	$_extensionName			= null;
	
	/**
	 * Stores a display title for this extension
	 * @var		string
	 */
	protected	$_extensionTitle		= null;
	
	/**
	 * Stores what type of extension this config is for (component, plugin, files, etc)
	 * @var		string
	 */
	protected 	$_extensionType			= null;
	
	/**
	 * Stores the method of storage to use (database / files)
	 * @var		string
	 */
	protected	$_storage				= null;
	
	/**
	 * Stores the path to the update file (used for files type - WHMCS only)
	 * @var		string
	 */
	protected	$_storagePath			= null;
	
	/**
	 * Stores the url that the extracted update may be found (used for files type - WHMCS only)
	 * @var		string
	 */
	protected	$_storageUrl			= null;
	
	/**
	 * Stores the update site url for this extension
	 * @var		string
	 */
	protected	$_updateUrl				= null;
	
	/**
	 * Stores the username for logging into Go Higher
	 * @var		string
	 */
	protected	$_username				= '';
	
	/**
	 * Stores the password for logging into Go Higher
	 * @var		string
	 */
	protected	$_password				= '';
	
	
	/**
	 * Stores the filename if using a local file
	 * @var		string
	 */
	protected	$_xmlFilename			= null;
	
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $extension: the extension type
	 * @param		array		- $options: an arry of options to set
	 * 
	 * @since		1.0.0
	 */
	public function __construct( $extension = 'com_jblesta', $options = array() )
	{
		parent::__construct();
		
		$this->_cacerts = dirname( dirname( __FILE__ ) ) . DS . 'assets' . DS . 'cacert.pem';
		$this->_extensionName = $extension;
		
		foreach ( $options as $key => $value ) {
			$name = "_$key";
			$this->$name = $value;
		}
		 
		$this->populateExtensionInfo();
		$this->populateAuthorization();
	}
	
	
	/**
	 * Method to create and reuse a singleton instance
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $extension: the extension type or name
	 * @param		array		- $options: any options to pass along
	 * 
	 * @return		JblestaUpdateConfig class object
	 * @since		1.0.0
	 */
	public static function &getInstance( $extension = 'com_jblesta', $options = array() )
	{
		static $instance = array();
		
		if (! isset( $instance[$extension] ) ) {
			$instance[$extension] = new JblestaUpdateConfig( $extension, $options );
		}
		
		return $instance[$extension];
	}
	
	
	/**
	 * Method to pull the extension info into the config object
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	private function populateExtensionInfo()
	{
		require_once dirname(__FILE__).'/xmlmanifest.php';
		$manifest = new JblestaUpdateXMLManifest();
		$data = $manifest->getInfo($this->_extensionName, $this->_xmlFilename);
		if ( empty( $this->_currentVersion ) )	$this->_currentVersion = $data['version'];
		if ( empty( $this->_currentReleaseDate ) ) $this->_currentReleaseDate = $data['date'];
		if ( isset( $data['targetVersion'] ) ) $this->_targetVersion = $data['targetVersion'];
		
	}
	
	
	/**
	 * Method to pull the authorization parameters into the config object
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	private function populateAuthorization()
	{
		jimport( 'joomla.html.parameter' );
		jimport( 'joomla.application.component.helper' );
		
		$params		= & JblestaParams :: getInstance();
		
		$this->_username	= $params->get( 'GHusername', '' );
		$this->_password	= $params->get( 'GHpassword', '' );
	}
	
	
	/**
	 * Method to convert the config object to an array
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		array containing class variables
	 * @since		1.0.0
	 */
	public function toArray()
	{
		$check	= get_class_vars( 'JblestaUpdateConfig' );
		
		$data	= array();
		foreach( $check as $c => $v ) {
			$data[$c] = (! empty( $this->$c ) ? $this->$c : null );
		}
		return $data;
	}
	
	
	/**
	 * Method to apply a CA Certificate for SSL purposes
	 * @access		public
	 * @version		@fileVers@
	 * @param		curl handler	- $ch: contains the curl handler to pass through
	 * 
	 * @return		curl handler
	 * @since		1.0.0
	 */
	public function applyCACert(&$ch)
	{
		if (! empty( $this->_cacerts ) ) {
			if ( file_exists( $this->_cacerts ) ) {
				@curl_setopt( $ch, CURLOPT_CAINFO, $this->_cacerts );
			}
		}
	}
}