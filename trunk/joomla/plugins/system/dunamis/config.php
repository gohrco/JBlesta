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
defined('DUNAMIS') OR exit('No direct script access allowed');

jimport( 'plugin.helper' );


/**
 * JBlesta System Plugin Dunamis Configuration
 * @desc		This file enables us to call config settings up through Dunamis
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Jblesta_sysmDunConfig extends JoomlaDunConfig
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
			
			$instance = new self ( $options );
		}
	
		return $instance;
	}
	
	
	/**
	 * Method to gather values for the form to work from
	 * @access		public
	 * @version		@fileVers@
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
		
		$params		=	json_decode( JPluginHelper :: getPlugin( 'system', 'jblesta_sysm' )->params );
		$vars		=	get_object_vars( $this );
		
		foreach ( $params as $k => $v ) {
			
			if ( isset( $vars[$k] ) ) {
				$params[$k] = $vars[$k];
				unset( $vars[$k] );
			}
		}
		
		foreach ( $vars as $k => $v ) {
			$params[$k] = $vars[$k];
		}
		
		return $params;
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
		jimport( 'plugin.helper' );
		$params	=	json_decode( JPluginHelper :: getPlugin( 'system', 'jblesta_sysm' )->params );
		
		foreach ( $params as $k => $v ) {
			
			$this->set( $k, $v );
		}
	}
	
	
	/**
	 * Save method
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function save()
	{
		$table	=	JTable::getInstance( 'extension' );
		$origin	=	$table->find( array( 'element' => 'jblesta_sysm', 'type' => 'plugin', 'folder' => 'system' ) );
		
		if (! $table->load( $origin ) ) {
			return $table->getError();
		}
		
		if (! $table->bind( array( 'params' => $this->getValues() ) ) ) {
			return $table->getError();
		}
		
		if (! $table->check() ) {
			return $table->getError();
		}
		
		if (! $table->store() ) {
			return $table->getError();
		}
		
		return true;
	}
}