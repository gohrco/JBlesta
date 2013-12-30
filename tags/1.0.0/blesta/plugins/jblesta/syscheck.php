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
 * System Check Module Class for J!Blesta
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.0.0
 */
class JblestaSyscheckDunModule extends JblestaAdminDunModule
{
	/**
	 * Initialise the object
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function initialise()
	{
		$this->action = 'syscheck';
		parent :: initialise();
	}
	
	
	/**
	 * Method to execute tasks
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function execute()
	{
		// Check license
		if (! dunloader( 'license', 'jblesta' )->isValid() ) {
			$this->setAlert( 'alert.license.invalid', 'block' );
			return;
		}
	}
	
	
	/**
	 * Method to render back the view
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing formatted output
	 * @since		1.0.0
	 */
	public function render( $data = null )
	{
		load_bootstrap( 'jblesta' );
		$doc	=	dunloader( 'document', true );
		$doc->addScript( get_baseurl( 'client' ) . 'plugins/jblesta/assets/syscheck.js' );
		$doc->addScriptDeclaration( 'var ajaxurl = "' . get_baseurl( 'jblesta' ) . '";' );
		
		$model	=	$this->getModel();
		$data	=	array();
		
		// Let's build our table
		foreach ( array( 'api', 'files', 'blesta', 'env' ) as $row ) {
			
			$data[]	=	'<table class="table-bordered table-striped">';
			$data[]	=	'	<thead><tr><th colspan="3">' . t( 'jblesta.syscheck.tblhdr.' . $row ) . '</th></tr></thead>';
			$data[]	=	'	<tbody>';
			
			foreach ( $model->$row as $item => $value ) {
				// Skip some
				if ( in_array( $item, array( 'files', 'supported', 'templatesupported' ) ) ) continue;
				
				$data[]	=	'	<tr>';
				$data[]	=	'		<td class="span2">' . $this->_getLabel( $item, $model->$row, $row ) . '</td>';
				$data[]	=	'		<td class="span2">' . $this->_getValue( $item, $model->$row, $row ) . '</td>';
				$data[]	=	'		<td class="span8">' . $this->_getHelp( $item, $model->$row, $row ) . '</td>';
				$data[]	=	'	</tr>';
			}
			
			$data[]	=	'</tbody></table><br/><br/>';
		}
		
		return parent :: render( implode( "\r\n", $data ) );
	}
	
	
	/**
	 * Method to get an item from our object array
	 * @access		public
	 * @version		@fileVers@
	 * @param		string			What we want to get
	 * @param		string			
	 * @param unknown $items
	 * @param		string			
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function getItem( $what, $item, $items, $row = 'blesta' )
	{
		$method	=	'_get' . ucfirst( $what );
		return $this->$method( $item, $items, $row ); 
	}
	
	
	/**
	 * Method to get the model data
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public function getModel()
	{
		$blesta		=	(object) array(
				'version'			=>	DUN_ENV_VERSION,
				'supported'			=>	is_supported()
				);
		
		// Gather the Environmental variables
		$env		=	(object) array(
				'curl'		=>	function_exists( 'curl_exec' ),
				'iconv'		=>	function_exists( 'iconv' ),
				'mbdetect'	=>	function_exists( 'mb_detect_encoding' ),
				'phpvers'	=>	phpversion(),
				);
		
		// API Information variables
		$config		=	dunloader( 'config', 'jblesta' );
		$api		=	dunloader( 'api', 'jblesta' );
		
		$api		=	(object) array(
				'apiurl'	=>	$config->get( 'joomlaurl', false ) !== false,
				'apifound'	=>	( $error = $api->ping( false ) ) === true ?  true : $error,
				'token'		=>	$config->get( 'logintoken', false ) !== false,
				'tokenauth'	=>	$api->ping() ? true : $api->getError(),
				);
		
		// File Checking Information variables
		$install	=	dunmodule( 'jblesta.install' );
		$files		=	(object) $install->checkFiles();
		
		return (object) array(
				'blesta'	=>	$blesta,
				'env'		=>	$env,
				'api'		=>	$api,
				'files'		=>	$files
		);
	}
	
	
	/**
	 * Method to assemble and create a help text
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $item: the name of the item to create / assemble
	 * @param		object		- $items: the set of items being sent for this group
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	private function _getHelp( $item, $items, $row = 'blesta' )
	{
		$data	=	null;
		
		if ( $row == 'files' ) {
			
			if (! $items->$item->isCurrent() ) {
				$id		=	'help' . preg_replace( '#[\\\\/\.]*#', '', $item );
				$data	=	'<span id="' . $id . '" class="text-error"><strong>' . t( 'jblesta.syscheck.general.attention' ) . '</strong>'
						.	$items->$item->getErrormsg() . '</span>';
			}
			
			return $data;
		}
		
		switch( $item ) :
		case 'version' :
			
			if ( $items->supported ) {
				$data	=	'<span class="label label-success">' . t( 'jblesta.syscheck.general.supported.yes' ) . '</span>';
			}
			else {
				$data	=	'<p class="alert alert-warning"><strong>' . t( 'jblesta.syscheck.general.supported.no' ) . '</strong>'
						.	t( 'jblesta.syscheck.version.help' ) . '</p>';
			}
			
		break;
		
		case 'version' :
				
			if ( version_compare( phpversion(), '5.2', 'ge' ) ) {
				$data	=	'<span class="label label-success">' . t( 'jblesta.syscheck.general.supported.yes' ) . '</span>';
			}
			else {
				$data	=	'<p class="alert alert-warning"><strong>' . t( 'jblesta.syscheck.general.supported.no' ) . '</strong>'
						.	t( 'jblesta.syscheck.phpvers.help' ) . '</p>';
			}

			break;
			
		case 'template' :
			
			if ( $items->templatesupported == 1 ) {
				$data	=	'<span class="label label-success">' . t( 'jblesta.syscheck.general.supported.yes' ) . '</span>';
			}
			else if ( $items->templatesupported == 0 ) {
				$data	=	'<p class="alert alert-danger"><strong>' . t( 'jblesta.syscheck.general.supported.no' ) . '</strong>'
						.	t( 'jblesta.syscheck.template.help' ) . '</p>';
			}
			else {
				$data	=	'<p class="alert alert-info">' . t( 'jblesta.syscheck.template.info' ) . '</p>';
			}
			
			break;
		
		case 'apifound' :
		case 'tokenauth' :
			
			if ( $items->$item !== true ) {
				$data	=	t( 'jblesta.syscheck.' . $item . '.help', $items->$item );
			}
			
			break;
			
		case 'urlproper' :
		case 'curl' :
		case 'iconv' :
		case 'mbdetect' :
		case 'apiurl' :
		case 'token' :
		
			if (! $items->$item ) {
				$data	=	'<p class="alert alert-danger"><strong>' . t( 'jblesta.syscheck.general.attention' ) . '</strong>'
						.	t( 'jblesta.syscheck.' . $item . '.help' ) . '</p>';
			}
			
			break;
		case 'sslenabled' :
			
			if ( $items->sslenabled === false ) {
				$data	=	'<p class="alert alert-danger"><strong>' . t( 'jblesta.syscheck.general.attention' ) . '</strong>'
						.	t( 'jblesta.syscheck.' . $item . '.help' ) . '</p>';
			}
			
			break;
		endswitch;
		
		return $data;
	}
	
	
	/**
	 * Method for getting the label
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $item: the individual item we are getting
	 * @param		object		- $items: contains values for current subset
	 * @param		string		- $row: indicates which subset we are on
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	private function _getLabel( $item, $items, $row = 'blesta' )
	{
		$icon	=	null;
		$g		=	'ok';
		$b		=	'remove';
		
		switch ( $item ) :
		case 'version' :
			
			$icon	=	$items->supported ? $g : $b;
			break;
			
		break;
		
		case 'template' :

			$icon	=	in_array( $items->templatesupported, array( 1, 2 ) ) ? $g : $b;	
			break;
		
		case 'phpvers' :
			
			$icon	=	version_compare( phpversion(), '5.2', 'ge' ) ? $g : $b;
			
			break;
		
		case 'urlproper' :
		case 'curl' :
		case 'iconv' :
		case 'mbdetect' :
		case 'apiurl' :
		case 'token' :
		case 'apifound' :
		case 'tokenauth' :
		
			$icon	=	$items->$item === true ? $g : $b;
				
			break;
		case 'sslenabled' :
			$icon	=	in_array( $items->$item, array( true, null ) )? $g : $b;
			break;
		default :
			
			if ( $row == 'files' ) {
				$icon	=	$items->$item->isCurrent() ? $g : $b;
			}
			
		endswitch;
		
		if ( $icon ) {
			$id		=	'icon' . preg_replace( '#[\\\\/\.]+#', '', $item );
			$icon	=	'<i id="' . $id . '" class="icon icon-' . $icon . ' pull-right"></i> ';
		}
		
		if ( $row == 'files' ) {
			return $icon . $item;
		}
		
		return t( 'jblesta.syscheck.tbldata.' . $row . '.' . $item, $icon );
	}
	
	
	/**
	 * Method to assemble and create a value
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $item: the name of the item to create / assemble
	 * @param		object		- $items: the set of items being sent for this group
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	private function _getValue( $item, $items, $row = 'blesta' )
	{
		$data	=	null;
		
		switch( $item ) :
		case 'version' :
		case 'phpvers' :
			
			$data	=	'<strong>' . $items->$item . '</strong>';
			break;
		
		case 'template' :
			
			$data	=	'<strong>' . ucfirst( $items->$item ) . '</strong>';
			break;
			
		case 'urlproper' :
		case 'curl' :
		case 'iconv' :
		case 'mbdetect' :
		case 'apiurl' :
		case 'token' :
		case 'apifound' :
		case 'tokenauth' :
			
			$data	=	'<span class="badge badge-' . ( $items->$item === true ? 'inverse' : 'important' ) . '">'
					.	t( 'jblesta.syscheck.general.yesno.' . ( $items->$item === true ? 'yes' : 'no' ) )
					.	'</span> ';
			
			break;
		
		case 'sslenabled' :
			
			$data	=	'<span class="badge badge-' . ( in_array( $items->sslenabled, array( true, null ) ) ? 'inverse' : 'important' ) . '">'
					.	t( 'jblesta.syscheck.general.yesno.' . ( $items->sslenabled === true ? 'yes' : 'no' ) )
					.	'</span> ';
			
			break;
		default :
			
			if ( $row == 'files' ) {
				$id		=	preg_replace( '#[\\\\/\.]+#', '', $item );
				$jsid	=	preg_replace( '#[\\\\]+#', '_', $item );
				
				$data	=	'<span id="badge' . $id . '" class="badge badge-' . ( $items->$item->isCurrent() ? 'inverse' : 'important' ) . '">'
						.	t( 'jblesta.syscheck.general.yesno.' . ( $items->$item->isCurrent() ? 'yes' : 'no' ) )
						.	'</span> '
						.	(! $items->$item->isCurrent() && ( $items->$item->getErrorcode() == 4 || $items->$item->getErrorcode() == 2 )
								? '<button id="btn' . $id . '" class="fixfile btn btn-danger btn-mini pull-right" data-filename="' . $item . '" data-refid="' . $id . '">' . t( 'jblesta.syscheck.general.fixit' ) . '</button>'
								: '' );
			}
			
		endswitch;
		
		return $data;
	}
}