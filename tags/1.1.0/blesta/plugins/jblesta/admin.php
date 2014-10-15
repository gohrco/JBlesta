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

/**
 * Define the J!Blesta version here
 */
if (! defined( 'DUN_MOD_JBLESTA' ) ) define( 'DUN_MOD_JBLESTA', "@fileVers@" );

/**
 * JBlesta Admin Module
 * @desc		This class is used to render and manage the jblesta plugin in the backend of Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaAdminDunModule extends BlestaDunModule
{
	
	/**
	 * Builds the alerts for display
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string containing html formatted output
	 * @since		1.0.0
	 */
	public function buildAlerts()
	{
		$data	= null;
		$check	= array( 'success', 'error', 'block', 'info' );
	
		foreach ( $check as $type ) {
			if ( empty( $this->alerts[$type] ) ) continue;
			$data	.=	'<div class="alert alert-' . $type . '"><h4>' . t( 'jblesta.alert.' . $type ) . '</h4>'
					.	implode( "<br/>", $this->alerts[$type] )
					.	'</div>';
		}
	
		return $data;
	}
	
	
	/**
	 * Builds the navigation menu
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string containing html formatted output
	 * @since		1.0.0
	 */
	public function buildNavigation()
	{
		$uri	=	DunUri :: getInstance( 'SERVER', true );
		$uri->delVars();
		
		$data		=	'<ul class="nav nav-pills">';
		$actions	=	array( 'home', 'syscheck', 'settings', 'license', 'updates' );
		
		// See if we can test the API
		$config		=	dunloader( 'config', 'jblesta' );
		//$apiurl		=	$config->get( 'joomlaurl', null );
		//$token		=	$config->get( 'apitoken', null );
		//$activeapi	=	( $apiurl && $token ? true : false );
	
		foreach( $actions as $item ) {
			$state	=	( $item != 'apicnxn' ? '' : ( $activeapi ? '' : ' disabled' ) );
				
			if ( ( $item == $this->action || ( $item == 'home' && $this->action == 'default' ) ) && in_array( $this->task, array( 'default', 'save' ) ) ) {
				$data .= '<li class="active' . $state . '"><a href="#">' . t( 'jblesta.admin.navbar.' . $item ) . '</a></li>';
			}
			else {
				$uri->setVar( 'action', $item );
				$data .= '<li class="' . $state . '"><a href="' . $uri->toString() . '">' . t( 'jblesta.admin.navbar.' . $item ) . '</a></li>';
			}
		}
	
		$data	.= '</ul>';
		return $data;
	}
	
	
	/**
	 * Builds the title of the page
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string containing html formatted output
	 * @since		1.0.0
	 */
	public function buildTitle()
	{
		$base	=	get_baseurl( 'client' );
		$doc	=	dunloader( 'document', true );
	
		$doc->addStyleDeclaration( 'h1#jblestatitle { padding-left: 60px; background: url(' . $base . 'plugins/jblesta/assets/jblesta-048.png) no-repeat scroll 6px 50% transparent; height: 52px; line-height: 52px; }' );	// Wipes out WHMCS' h1
	
		$data	= '<h1 id="jblestatitle">' . t( 'jblesta.admin.title', t( 'jblesta.admin.subtitle.' . $this->action . '.' . $this->task ) ) . '</h1>';
		return $data;
	}
	
	
	/**
	 * Initialize the module
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function initialise()
	{
		static $instance = false;
		
		if (! $instance ) {
			load_bootstrap( 'jblesta' );
			
			dunloader( 'language', true )->loadLanguage( 'jblesta' );
			dunloader( 'helpers', 'jblesta' );
			
			$instance	= true;
		}
		
		$input	=	dunloader( 'input', true );
		$task	=	$input->getVar( 'task', 'default' );
		
		$this->area	=	'admin';
		$this->task =	$task;
	}
	
	
	/**
	 * Render the module back
	 * @access		public
	 * @version		@fileVers@
	 * @param		string			Contains previously formatted content data
	 * 
	 * @return		string			Contains the final HTML for rendering in the view
	 * @since		1.0.0
	 */
	public function render( $data = null )
	{
		$title	= $this->buildTitle();
		$navbar	= $this->buildNavigation();
		$alerts	= $this->buildAlerts();
		//$modals	= $this->buildModals();
		
		$baseurl = rtrim( get_baseurl( 'jblesta' ), '/' );
		$doc = dunloader( 'document', true );
		
		$doc->addStylesheet( $baseurl . '/css/index?f=admin&t=assets' );
		
		return 		'<div style="float:left;width:100%;">'
					.	'<div id="jblesta">'
					.	'	' . $title
					.	'	' . $navbar
					.	'	' . $alerts
					.	'	' . $data
			//		.	'	' . $modals
					.	'</div>'
					.	'</div>';
	}
	
	
	/**
	 * Common method for rendering fields into a form
	 * @access		protected
	 * @version		@fileVers@
	 * @param		array		- $fields: contains an array of Field objects
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	protected function renderForm( $fields = array(), $options = array() )
	{
		$data	= null;
		$foptn	= ( array_key_exists( 'fields', $options ) ? $options['fields'] : array() );
			
		foreach ( $fields as $field ) {
	
			if ( in_array( $field->get( 'type' ), array( 'wrapo', 'wrapc' ) ) ) {
				$data .= $field->field();
				continue;
			}
	
			$data	.= <<< HTML
<div class="control-group">
	{$field->label( array( 'class' => 'control-label' ) )}
	<div class="controls">
		{$field->field( $foptn )}
		{$field->description( array( 'type' => 'span', 'class' => 'help-block help-inline' ) )}
	</div>
</div>
HTML;
		}
		
		return $data;
	}
	
	
	/**
	 * Method for setting the action to the object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $action: the action to set
	 *
	 * @since		1.0.0
	 */
	public function setAction( $action = 'default' )
	{
		$this->action = $action;
	}
	
	
	/**
	 * Method for setting an alert to the object
	 * @access		protected
	 * @version		@fileVers@
	 * @param		mixed		- $msg: contains an array of items to use for translate or an alert msg string
	 * @param		string		- $type: indicates which type of alert to set to
	 * @param		boolean		- $trans: indicates if we should translate (true default)
	 *
	 * @since		1.0.0
	 */
	protected function setAlert( $msg = array(), $type = 'success', $trans = true )
	{
		// If we are passing an array we are assuming:
		//		first item is string
		//		rest of items are variables to insert
		if ( is_array( $msg ) ) {
			$message = array_shift( $msg );
			$message = 'jblesta.'.$message;
			array_unshift( $msg, $message );
			$this->alerts[$type][] = call_user_func_array('t', $msg );
			return;
		}
	
		if ( $trans ) {
			$msg = t( 'jblesta.' . $msg );
		}
	
		$this->alerts[$type][] = $msg;
	}
	
	
	/**
	 * Method for setting a modal into place
	 * @access		protected
	 * @version		@fileVers@
	 * @param		string		- $id: the id string of the modal
	 * @param		string		- $title: the title to use
	 * @param		string		- $header: the header of the modal
	 * @param		string		- $body: content of the body
	 * @param		string		- $href: the destination URL of the modal on success
	 * @param		string		- $btnlbl: the label to use for the affirming action button
	 * @param		string		- $type: the style of button to use (success|danger|etc)
	 *
	 * @since		1.0.0
	 */
	protected function setModal( $id, $title, $header, $body, $href, $btnlbl, $type = 'danger' )
	{
		$btns	= array(	'<button data-dismiss="modal" class="btn">' . t( 'jblesta.form.close' ). '</button>',
				'<a href="' . $href . '" class="btn btn-' . $type . '">' . $btnlbl . '</a>'
		);
		$this->modals[]	= array(	'id'		=> $id,
				'title'		=> $title,
				'hdr'		=> $header,
				'body'		=> $body,
				'buttons'	=> $btns
		);
	}
	
}