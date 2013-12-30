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
 * JBlesta Updates Module
 * @desc		This class is used to manage available updates for J!Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaUpdatesDunModule extends JblestaAdminDunModule
{
	/**
	 * Initialise the object
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 * @see			JwhmcsAdminDunModule :: initialise()
	 */
	public function initialise()
	{
		$this->action = 'updates';
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
		
		$data	= $this->buildBody();
		
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
		$doc	=	dunloader( 'document', true );
		$doc->addStylesheet( get_baseurl( 'client' ) . 'plugins/jblesta/assets/updates.css' );
		$doc->addScript( get_baseurl( 'client' ) . 'plugins/jblesta/assets/updates.js' );
		$doc->addScriptDeclaration( "jQuery.ready( checkForUpdates() );" );
		
		$data	=	array();
		$data[]	=	'<div class="span8" style="text-align: center; ">';
		$data[]	=	'<a class="btn" id="btn-updates">';
		$data[]	=	'<div class="ajaxupdate ajaxupdate-init">';
		$data[]	=	'<span id="upd-title"></span>';
		$data[]	=	'<img id="img-updates" class="" />';
		$data[]	=	'<span id="upd-subtitle"></span>';
		$data[]	=	'</div>';
		$data[]	=	'</a>';
		$data[]	=	'</div>';
		$data[]	=	'<input type="hidden" id="btntitle" value="' . t( 'jblesta.updates.checking.title' ) . '" />';
		$data[]	=	'<input type="hidden" id="btnsubtitle" value="' . t( 'jblesta.updates.checking.subtitle' ) . '" />';
		$data[]	=	'<input type="hidden" id="jblestaurl" value="' . get_baseurl( 'jblesta' ) . '" />';
		
		return implode( "\r\n", $data );
	}
}