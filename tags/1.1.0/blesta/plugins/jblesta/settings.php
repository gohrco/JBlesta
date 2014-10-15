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
 * JBlesta Settings Module
 * @desc		This class is used to manage the settings for J!Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaSettingsDunModule extends JblestaAdminDunModule
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
		$this->action = 'settings';
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
			
			$values	=	dunloader( 'config', 'jblesta' )->getValues();
			
			// Deal with language array first
			//$values['languagesettings']	=	json_encode( $input->getVar( 'lang', array(), 'post', 'array' ) );
			
			foreach ( $values as $item => $default ) {
				$key = $item; $value = $input->getVar( $item, $default );
				if ( is_array( $value ) ) $value = implode( '|', $value );
				
				$db->setQuery( "SELECT 1 FROM `jblesta_settings` WHERE `key` = " . $db->Quote( $key ) );
				if ( $db->loadResult() ) {
					$db->setQuery( "UPDATE `jblesta_settings` SET `value` = " . $db->Quote( $value ) . " WHERE `key` = '{$key}'" );
				}
				else {
					$db->setQuery( "INSERT INTO `jblesta_settings` ( `key`, `value` ) VALUES (" . $db->Quote( $key ) . ", " . $db->Quote( $value ) . ")" );
				}
				
				$db->query();
			}
			
			$this->setAlert( 'alert.settings.saved' );
			
			break;
		endswitch;
		
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
		$form	=	dunloader( 'form', true );
		$values	=	dunloader( 'config', 'jblesta' )->getValues( true );
		$fields	=	new stdClass();
		
		// Assign the menu items first
		$menuitems	=	$this->_getMenuitems();
		$form->setOption( 'menuitem', $menuitems, 'jblesta.setting-visual' );
		
		// Cycle through the fields now...
		foreach ( array( 'general', 'user', 'visual', 'login', /*'language',*/ 'advanced' ) as $i ) {
			$form->setValues( $values, 'jblesta.setting-' . $i );
			$fields->$i	= $form->loadForm( 'setting-' . $i, 'jblesta' );
		}
		
		// Assign the language items
		//$ls			=	dunloader( 'languagesettings', 'jblesta' );
		//$lfields	=	$ls->getForm();
		//$deflangs	=	$this->_getLanguageitems();
		//$langitems	=	$this->_getLanguageitems( true );
		/*
		foreach ( $lfields as $n => $v ) {
			$form->addField( $n, $v, 'jblesta.setting-language' );
			if ( $n == 'lang[default]' ) {
				$form->setOption( $n, $deflangs, 'jblesta.setting-language' );
				continue;
			}
			$form->setOption( $n, $langitems, 'jblesta.setting-language' );
		}
		*/
		$fields->language = $form->loadForm( 'setting-language', 'jblesta' );
		
		$data	=	'<form action="addonmodules.php?module=jwhmcs&action=settings&task=save" class="form-horizontal" method="post">'
				.	'	<div class="tabbable tabs-left">'
				.	'		<ul class="nav nav-tabs">'
				.	'			<li class="active"><a href="#general" data-toggle="tab">' . t( 'jblesta.admin.settings.subnav.general' ) . '</a></li>'
				.	'			<li><a href="#user" data-toggle="tab">' . t( 'jblesta.admin.settings.subnav.user' ) . '</a></li>'
				.	'			<li><a href="#visual" data-toggle="tab">' . t( 'jblesta.admin.settings.subnav.visual' ) . '</a></li>'
				.	'			<li><a href="#login" data-toggle="tab">' . t( 'jblesta.admin.settings.subnav.login' ) . '</a></li>'
				//.	'			<li><a href="#language" data-toggle="tab">' . t( 'jblesta.admin.settings.subnav.language' ) . '</a></li>'
				.	'			<li><a href="#advanced" data-toggle="tab">' . t( 'jblesta.admin.settings.subnav.advanced' ) . '</a></li>'
				.	'		</ul>'
				.	'		<div class="tab-content">'
				.	'			<div class="tab-pane active" id="general">'
				.	'				' . $this->renderForm( $fields->general )
				.	'			</div>'
				.	'			<div class="tab-pane" id="user">'
				.	'				' . $this->renderForm( $fields->user )
				.	'			</div>'
				.	'			<div class="tab-pane" id="visual">'
				.	'				' . $this->renderForm( $fields->visual )
				.	'			</div>'
				.	'			<div class="tab-pane" id="login">'
				.	'				' . $this->renderForm( $fields->login )
				.	'			</div>'
				/*.	'			<div class="tab-pane" id="language">'
				.	'				' . $this->renderForm( $fields->language )
				.	'			</div>'
				*/
				.	'			<div class="tab-pane" id="advanced">'
				.	'				' . $this->renderForm( $fields->advanced )
				.	'			</div>'
				.	'		</div>'
				.	'	</div>'
				.	'	<div class="form-actions">'
				.			$form->getButton( 'submit', array( 'class' => 'btn btn-primary span2', 'value' => t( 'jblesta.form.submit' ), 'name' => 'submit' ) )
				.	'		<a href="addonmodules.php?module=jwhmcs&action=default" class="btn btn-inverse pull-right span2">' . t( 'jblesta.form.close' ) . '</a>'
				.	'	</div>'
				.	'<input type="hidden" name="_csrf_token" value="' . $form->Form->getCsrfToken( '' ) . '" />'
				.	'</form>';
		
		return $data;
	}
	
	
	/**
	 * Method to get the language items from Joomla
	 * @access		private
	 * @version		@fileVers@
	 * @param		boolean		- $includedefaultoption: if we should also include the default menu item selection
	 * 
	 * @return		array of object
	 * @since		1.0.0
	 */
	private function _getLanguageitems( $includedefaultoption = false )
	{
		static $items;
		
		if (! is_array( $items ) ) {
			$api	=	dunloader( 'api', 'jblesta' );
			$result	=	$api->languageitems();
			
			if (! $result ) return array();
			
			$data	=	array();
			
			foreach( $result->languageitems as $item ) {
				$data[]	=	(object) array( 'id' => $item->shortcode, 'name' => $item->name );
			}
			
			$items	=	$data;
		}
		
		if ( $includedefaultoption ) {
			$clone	=	$items;
			array_unshift( $clone, (object) array( 'id' => 0, 'name' => t( 'jblesta.admin.settings.usedefaultlanguage' ) ) );
			return $clone;
		}
		
		return $items;
	}
	
	
	/**
	 * Method to get the menu items from Joomla
	 * @access		private
	 * @version		@fileVers@
	 *
	 * @return		array of object
	 * @since		1.0.0
	 */
	private function _getMenuitems()
	{
		$api	=	dunloader( 'api', 'jblesta' );
		$result	=	$api->menuitems();
		
		if (! $result ) return array();
		
		$data	=	array();
		
		foreach( $result->menuitems as $type => $items ) {
			$data[]	=	(object) array( 'group' => $result->menutypes->$type );
			foreach ( $items as $item ) {
				$data[]	=	(object) array( 'id' => $item->id, 'name' => $item->treename );
			}
		}
		
		return $data;
	}
}