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
 * Configuration handler for J!Blesta
 * @desc		This is used to call up the configuration settings for J!Blesta within Blesta
 * 
 * @package		@packageName@
 * @subpackage	Blesta.dunamis
 * @since		1.0.0
 */
class JblestaDunConfig extends BlestaDunConfig
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function __construct()
	{
		parent :: __construct();
	}
	
	
	/**
	 * Method to get the table settings for a given table
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $table: the table to get
	 *
	 * @return		array
	 * @since		1.0.0
	 */
	public function getConfiguration( $table = 'settings' )
	{
		$module = dunmodule( 'jblesta.install' );
		return $module->getConfiguration( $table );
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
		static $instance = null;
		
		if (! is_object( $instance ) ) {
			$instance = new self( $options );
		}
	
		return $instance;
	}
	
	
	/**
	 * Method to gather values for the form to work from
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		boolean		- $reload: if we need to reload to ensure we have latest
	 * 
	 * @return		array
	 * @since		1.0.0
	 */
	public function getValues( $reload = false )
	{
		// If we reload, then do so
		if ( $reload ) {
			$this->load();
		}
		
		$configs	=	$this->getConfiguration( 'settings' );
		$vars		=	array();
		
		foreach ( $configs as $k => $v ) {
			if ( $this->has( $k ) ) {
				$vars[$k] = $this->get( $k );
			}
		}
		
		// Exclude license stuff
		foreach ( array( 'license', 'localkey' ) as $i ) {
			unset( $vars[$i] );
			unset( $configs[$i] );
		}
		
		foreach ( $configs as $k => $v ) {
			$configs[$k]	= ( isset( $vars[$k] ) ? $vars[$k] : $v );
		}
		
		return $configs;
	}
	
	
	/**
	 * Loader method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function load()
	{
		$db = dunloader( 'database', true );
		$db->setQuery( "SELECT * FROM jblesta_settings" );
		$items	= $db->loadObjectList();
		
		foreach ( $items as $item ) $this->set( $item->key, $item->value );
		
	}
	
	
	/**
	 * Save method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function save()
	{
		$db		=	dunloader( 'database', true );
		$values	=	$this->getValues();
		
		foreach ( $values as $key => $value ) {
			
			$query	=	"UPDATE `mod_jwhmcs_settings` SET `value` = " . $db->Quote( $value ) . " WHERE `key` = " . $db->Quote( $key );
			$db->setQuery( $query );
			$db->query();
		}
		
		return true;
	}
	
	
	/**
	 * Method to get the table values
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $config: which table to get for
	 *
	 * @return		array
	 * @since		1.0.0
	 */
	private function _getTablevalues( $config = 'settings' )
	{
		$data	= array();
		switch ( $config ) :
		case 'settings' :
			$data	= array(
					'license' => null,
					'localkey' => null,
					'updates'	=> null,
						
					// General Settings
					'enable'		=> false,
					'debug'			=> false,
					'joomlaurl'		=> null,
					'logintoken'	=> null,
						
					// User Settings
					'userenable'	=> true,
					'useraddmethod'	=> 4,
					'regmethod'		=> 1,
					'namestyle'		=> 1,
					'userstyle'		=> 1,
					'usernamestyle'	=> 3,
					'usernamefield'	=> null,
						
					// Visual Settings
					'visualenable'		=> true,
					//'jqueryenable'		=> true,
					'customimageurl'	=> 1,
					'imageurl'			=> null,
					'menuitem'			=> null,
					'resetcss'			=> 1,
					'showmyinfo'		=> false,
					//'shownavbar'		=> false,
					//'showfooter'		=> true,
						
					// Language Settings
					'languageenable'	=> false,
					'languagesettings'	=> null,
						
					// Login Settings
					'loginenable'	=> true,
					'logouturl'		=> null,
						
					// Advanced Settings
					'dlid'					=>	null,
					'preservedb'			=>	true,
					'passalonguseragent'	=>	false,
					'parseheadlinebyline'	=>	false,
					'forceapitoget'			=>	false,
			);
			break;
			endswitch;
	
			return $data;
	}
}