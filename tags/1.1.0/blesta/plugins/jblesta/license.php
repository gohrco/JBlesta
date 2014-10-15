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
 * JBlesta License Module
 * @desc		This class is used to manage the licensing done for J!Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaLicenseDunModule extends JblestaAdminDunModule
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
		$this->action = 'license';
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
		$db		=	dunloader( 'database', true );
		$input	=	dunloader( 'input', true );
		
		switch ( $this->task ):
		case 'save' :
			
			// Catch missing license
			if (! ( $license = $input->getVar( 'license', false ) ) ) break;
			
			$save = array( 'license' => $license, 'localkey' => null );
			
			foreach ( $save as $key => $value ) {
				$db->setQuery( "UPDATE `jblesta_settings` SET `value` = '{$value}' WHERE `key` = '{$key}'" );
				$db->query();
			}
			
			$this->setAlert( 'alert.license.saved' );
			
			break;
		endswitch;
		
		// Check license
		if (! dunloader( 'license', 'jblesta' )->isValid() ) {
			$this->setAlert( 'alert.license.invalid', 'block' );
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
		$form	=	dunloader( 'form', true );
		$lic	=	dunloader( 'license', 'jblesta' );
		$parts	=	$lic->getItems();
		
		// Set license
		$config	= dunloader( 'config', 'jblesta' );
		$config->refresh();
		$form->setValue( 'license', $config->get( 'license' ), 'jblesta.license' );
		
		// Set status
		if (! array_key_exists( 'supnextdue', $parts ) ) {
			$state = 'important';
		}
		else {
			$state	= ( strtotime( $parts['supnextdue'] ) >= strtotime( date("Ymd") ) ? 'success' : ( $parts['status'] == 'Invalid' ? 'important' : 'warning' ) );
		}
		
		$sttxt	= ( $state == 'success' ? 'Active' : ( $state == 'important' ? 'Invalid License' : 'Expired' ) );
		$form->setValue( 'status', '<span class="label label-' . $state . '"> ' . $sttxt . ' </span>', 'jblesta.license' );
		
		// Set information
		$info	= array();
		if ( $state != 'important' ) {
			$use	= array( 'registeredname', 'companyname', 'regdate', 'supnextdue' );
			foreach ( $use as $i ) {
		
				// Check to see if we have the item
				if (! array_key_exists( $i, $parts ) ) continue;
				$info[]	= ( $i != 'supnextdue' ? t( 'jblesta.admin.form.config.info.' . $i, $parts[$i] ) : t( 'jblesta.admin.form.config.info.supnextdue', $state, $parts[$i] ) );
			}
		}
		else {
			if (! isset( $parts['message'] ) ) {
				$info[]	= t( 'jblesta.admin.form.config.info.invalidkey' );
			}
			else {
				$info[]	= t( 'jblesta.admin.form.config.info.invalidmsg', $parts['message'] );
			}
		}
		
		$form->setValue( 'info', $info, 'jblesta.license' );
		
		// Grab the fields
		$fields = $form->loadForm( 'license', 'jblesta' );
		
		$data	=	'<form action="?action=license&task=save" class="form-horizontal" method="post">'
				.		$this->renderForm( $fields )
				.		'<div class="form-actions">'
				.			$form->getButton( 'submit', array( 'class' => 'btn btn-primary span2', 'value' => t( 'jblesta.form.submit' ), 'name' => 'submit' ) )
				.			'<a href="?action=home" class="btn btn-inverse pull-right span2">' . t( 'jblesta.form.close' ) . '</a>'
				.		'</div>'
				.	'<input type="hidden" name="_csrf_token" value="' . $form->Form->getCsrfToken( '' ) . '" />'
				.	'</form>';
		
		
		return parent :: render( $data );
	}
}