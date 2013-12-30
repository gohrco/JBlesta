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
 * JBlesta Configuration Class
 * @desc		This class is used by Dunamis to retrieve and handle configuration values for J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Com_jblestaDunConfig extends JoomlaDunConfig
{
	protected $_map	=	array();
	
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
	 * Method to find the appropriate language to use
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $joomlang: contains a Joomla language string (ie en-GB, es-ES etc or default)
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	public function findLanguage( $joomlang = 'default' )
	{
		if ( isset( $this->_map[$joomlang] ) && $this->_map[$joomlang] != '0' ) {
			return $this->_map[$joomlang];
		}
		
		if ( isset( $this->_map[$joomlang] ) && $this->_map[$joomlang] == '0' ) {
			return $this->_map['default'];
		}
		
		return $this->_map[$joomlang];
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
			
			$instance = new Com_jblestaDunConfig( $options );
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
		
		$params		=	JComponentHelper :: getParams( 'com_jblesta' )->toArray();
		$vars		=	get_object_vars( $this );
		
		foreach ( $params as $k => $v ) {
			
			// Let's handle our language values
			if ( $k == 'jwhmcslanguage' ) {
				$params[$k] = $this->_getLanguagevalues( $v );
				unset( $vars[$k] );
				continue;
			}
			
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
		$params	=	JComponentHelper :: getParams( 'com_jblesta' )->toArray();
		
		foreach ( $params as $k => $v ) {
			
			// Handle languages
			if ( $k == 'jwhmcslanguage' ) {
				$this->_loadLanguages( $v );
				continue;
			}
			
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
		$origin	=	$table->find( array( 'name' => 'com_jblesta', 'type' => 'component' ) );
		
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
	
	
	/**
	 * Method to get the language values when requesting to getValues
	 * @access		private
	 * @version		@fileVers@
	 * @param		array		- $values: the values we have already retrieved
	 *
	 * @return		array
	 * @since		1.0.0
	 */
	private function _getLanguagevalues( $values )
	{
		$params	=	array();
		$params['languageenable']	=	$values['languageenable'];
		unset( $values['languageenable'] );
	
		foreach ( $values as $k => $v ) {
			$k2 = str_replace( 'languagemap_', '', $k );
			$params[$k]	=	$this->_map[$k2];
		}
	
		return $params;
	}
	
	
	/**
	 * Method to load the language array map up
	 * @access		private
	 * @version		@fileVers@
	 * @param		array		- $values: our values from the database
	 * 
	 * @since		1.0.0
	 */
	private function _loadLanguages( $values )
	{
		if ( empty( $values ) || ! is_array( $values ) ) {
			return;
		}
		
		$this->set( 'languageenable', $values['languageenable'] );
		unset( $values['languageenable'] );
		
		foreach ( $values as $k => $v ) {
			$k = str_replace( 'languagemap_', '', $k );
			$this->_map[$k]	=	$v;
		}
	}
}