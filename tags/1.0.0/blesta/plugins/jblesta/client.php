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
 * Define the J!Blesta version here
 */
if (! defined( 'DUN_MOD_JBLESTA' ) ) define( 'DUN_MOD_JBLESTA', "@fileVers@" );


/**
 * JBlesta Client Module
 * @desc		This class is used to render and manage the jblesta plugin in the frontend of Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */

class JblestaClientDunModule extends BlestaDunModule
{
	/**
	 * Stores what the action we are using
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $action	= 'default';
	
	/**
	 * Stores the alerts to display back
	 * @access		protected
	 * @var			array
	 * @since		1.0.0
	 */
	protected $alerts	= array( 'error' => array(), 'success' => array(), 'info' => array(), 'block' => array() );
	
	/**
	 * Stores any modals to render
	 * @access		protected
	 * @var			array
	 * @since		1.0.0
	 */
	protected $modals	= array();
	
	/**
	 * Stores what the task is for this page
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $task	= 'default';
	
	/**
	 * Stores the type of module this is
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $type	= 'addon';
	
	
	/**
	 * Method to check our registration setting and handle accordingly
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function checkRegistration()
	{
		// Double check us...
		if (! ensure_active( 'user' ) ) return;
		
		$config		=	dunloader( 'config', 'jwhmcs' );
		$method		=	$config->get( 'regmethod' );
		
		// `1` indicates WHMCS registration form
		if ( $method == '1' ) return;
		
		$uri		=	DunUri :: getInstance( $config->get( 'joomlaurl' ), true );
		$uri->setVar( 'option',	'com_users' );
		$uri->setVar( 'view',	'registration' );
		$redirect	=	$uri->toString();
		
		header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		header( 'Cache-Control: no-store, no-cache, must-revalidate' );
		header( 'Cache-Control: post-check=0, pre-check=0', false );
		header( 'Pragma: no-cache' );
		header( 'Location: ' . $redirect );
		exit;
	}
	
	
	/**
	 * Initializes the module
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function initialise()
	{
		static $instance = false;
	
		if (! $instance ) {
			dunloader( 'language', true )->loadLanguage( 'jblesta' );
			dunloader( 'helpers', 'jblesta' );
			
			$instance	= true;
		}
		
		global $task;
		
		if ( $task ) {
			$this->task = $task;
		}
	}
	
	
	/**
	 * Container for handling front end output
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function renderClientOutput()
	{
		$config	=	dunloader( 'config', 'jwhmcs' );
		$input	=	dunloader( 'input', true );
		$debug	=	$config->get( 'debug', false );
		$task	=	$input->getVar( 'task', 'cp' );
		
		if (! $debug ) return;
		
		load_bootstrap( 'jwhmcs' );
		
		$data	=	array(
				'pagetitle'		=>	t( 'jwhmcs.client.breadcrumb.' . $task ),
				'breadcrumb'	=>	array( 'index.php?m=jwhmcs&task=checkinstall' => t( 'jwhmcs.client.breadcrumb.' . $task ) ),
				'templatefile'	=>	'templates/client-' . $task,
				'requirelogin'	=>	false,
				'vars'			=>	array(
						'title'		=>	t( 'jwhmcs.client.pagetitle' ),
						'desc'		=>	t( 'jwhmcs.client.pagedesc.'. $task ),
					),
				);
		
		switch ( $task ) :
		case 'checkinstall' :
			$doc	=	dunloader( 'document', true );
			
			$doc->addScript( get_baseurl( 'jwhmcs' ) . 'assets/syscheck.js' );
			$doc->addScriptDeclaration( 'var ajaxurl = "' . get_baseurl( 'jwhmcs' ) . '";' );
			
			$syschk	=	dunmodule( 'jwhmcs.syscheck' );
			$model	=	$syschk->getModel();
			$rows	=	array();
		
			// Let's build our table
			foreach ( array( 'api', 'files', 'whmcs', 'env' ) as $row ) {
				
				$rows[]	=	'<table class="table-bordered table-striped">';
				$rows[]	=	'	<thead><tr><th colspan="2">' . t( 'jwhmcs.syscheck.tblhdr.' . $row ) . '</th></tr></thead>';
				$rows[]	=	'	<tbody>';
				
				foreach ( $model->$row as $item => $value ) {
					// Skip some
					if ( in_array( $item, array( 'files', 'supported', 'templatesupported' ) ) ) continue;
					
					$rows[]	=	'	<tr>';
					$rows[]	=	'		<td class="span4">' . $syschk->getItem( 'label', $item, $model->$row, $row ) . '</td>';
					$rows[]	=	'		<td class="span3">' . $syschk->getItem( 'value', $item, $model->$row, $row ) . '</td>';
					$rows[]	=	'	</tr>';
				}
				
				$rows[]	=	'</tbody></table><br/><br/>';
			}
			
			$data['vars']['data']	=	implode( "\r\n", $rows );
			
			break;
			
		case 'checkrender' :
			
			$render	=	dunmodule( 'jwhmcs.render' );
			$render->execute();
			$info	=	$render->getItem( 'debug' );
			
			$rows[]	=	'<table class="table-bordered table-striped">';
			$rows[]	=	'	<tbody>';
			
			foreach ( $info as $key => $value ) {
				
				$rows[]	=	'	<tr>';
				
				if ( $key == 'url' ) {
					$value	=	'<textarea class="span6">' . $value . '</textarea>';
				}
				else {
					$value	=	'<code>' . $value . '</code>';
				}
				
				$rows[]	=	'		<td class="span2 pull-right">' . $key . '</td>';
				$rows[]	=	'		<td class="span6">' . $value . '</td>';
				$rows[]	=	'	</tr>';
			}
			
			$rows[]	=	'</tbody></table><br/><br/>';
			
			$data['vars']['data']	=	implode( "\r\n", $rows );
			
			break;
		endswitch;
		
		return $data;
	}
	
}
