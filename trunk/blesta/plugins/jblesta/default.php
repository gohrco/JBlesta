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
 * JBlesta Default Admin Module
 * @desc		This class is used to render and manage the jblesta plugin in the backend of Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaDefaultDunModule extends JblestaAdminDunModule
{
	/**
	 * Initialise the object
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 * @see			JblestaAdminDunModule :: initialise()
	 */
	public function initialise()
	{
		$this->action = 'default';
		parent :: initialise();
	}
	
	
	/**
	 * Method to execute tasks
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $task: if we are passing a specific task to do
	 * 
	 * @since		1.0.0
	 */
	public function execute()
	{
		
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
		$widgets	=	implode( "", $this->_getWidgets() );
		$data		=	'<div class="row">'
					.	'	<div class="well span8">'
					.	'		' . t( 'jblesta.admin.default.body' )
					.	'	</div>'
					.	'	<div class="span4">'
					.	'		' . $widgets
					.	'	</div>'
					.	'</div>';
		
		
		return parent :: render( $data );
	}
	
	
	/**
	 * Builds the body of the action
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string containing html formatted output
	 * @since		1.0.0
	 */
	public function buildBody()
	{
		
	}
	
	
	
	/**
	 * Method for getting the widgets for the dashboard
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $widget: contains the widget to retrieve
	 *
	 * @return		html formatted string
	 * @since		1.0.0
	 */
	private function _getWidgets( $widget = 'all' )
	{
		return array();
		// Loop through for all of them
		if ( $widget == 'all' ) {
			$data	=	array();
			
			foreach ( array( 'apicnxn', 'filecheck', 'updates', 'license', 'likeus' /*'status', * 'updates', 'license', 'likeus'*/ ) as $widg ) {
				$data[$widg]	= $this->_getWidgets( $widg );
			}
			
			return $data;
		}
		
		// We are asking for a specific one...
		$data			=	null;
		$result			=	(object) array( 'status' => null, 'header' => null, 'body' => null );
		$result->header	=	t( 'jwhmcs.admin.widget.' . $widget . '.header');
		
		switch ( $widget ) {
			case 'apicnxn' :
				
				$api	=	dunloader( 'api', 'jwhmcs' );
				
				if (! $api->ping() ) {
					$result->status	=	'-danger';
					$result->body	=	t( 'jwhmcs.admin.widget.apicnxn.body.error', $api->getError() );
				}
				else {
					$result->status	=	'-success';
					$result->body	=	t( 'jwhmcs.admin.widget.apicnxn.body.success' );
				}
				
				break;
			case 'filecheck' :
				$wconfig	=	dunloader( 'config', true );
				$install	=	dunmodule( 'jwhmcs.install' );
				$tpl		=	strtolower( $wconfig->get( 'Template' ) );
				$files		=	(object) $install->checkFiles( $tpl . DIRECTORY_SEPARATOR );
				
				$result->status	=	'-success';
				$result->body	=	t( 'jwhmcs.admin.widget.filecheck.body.success' );
				
				foreach ( $files as $file ) {
					if (! $file->current && ( $file->code == 4 || $file->code == 2 ) ) {
						$result->status	=	'';
						$result->body	=	t( 'jwhmcs.admin.widget.filecheck.body.alert' );
						break;
					}
				}
				
				break;
			case 'updates' :
				$updates	=	dunloader( 'updates', 'jwhmcs' );
				$version	=	$updates->updatesExist();
				$error		=	$updates->hasError();
				
				if ( $version ) {
					$result->status = '';
					$result->body	= t( 'jwhmcs.admin.widget.updates.body.exist', $version );
				}
				else if ( $error ) {
					$result->status = '-danger';
					$result->body	= t( 'jwhmcs.admin.widget.updates.body.error', $updates->getError() );
				}
				else {
					$result->status = '-success';
					$result->body	= t( 'jwhmcs.admin.widget.updates.body.none' );
				}
	
				break;
			case 'license':
				$license	= dunloader( 'license', 'jwhmcs' );
				$isvalid	= $license->isValid();
	
				if ( $isvalid ) {
					if ( $license->isCurrent() ) {
						$result->status = '-success';
						$result->body	=	t( 'jwhmcs.admin.widget.license.body.success' );
					}
					else {
						$result->status = '';
						$result->body	=	t( 'jwhmcs.admin.widget.license.body.alert', $license->get( 'supnextdue' ) );
					}
				}
				else {
					$result->status	=	'-danger';
					$result->body	=	t( 'jwhmcs.admin.widget.license.body.danger' );
				}
				break;
			case 'likeus' :
				$result->status	=	'-info';
				$result->body	=	t( 'jwhmcs.admin.widget.likeus.body' );
				break;
		}
	
		$data	=	'<div class="well well-small alert' . $result->status . '">'
				.	'	<h3>' . $result->header . '</h3>'
				.	'	' . $result->body
				.	'</div>';
	
		return $data;
	}
}