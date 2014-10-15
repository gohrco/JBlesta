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
 * Form Definition for the general settings in the settings form
 */
$form	= array(
		'enable'		=> array(
				'order'			=> 10,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.enable',
				'description'	=> 'jblesta.admin.form.settings.description.enable',
				),
 		'debug'		=> array(
 				'order'			=> 20,
 				'type'			=> 'toggleyn',
 				'value'			=> true,
 				'validation'	=> '',
 				'labelon'		=> 'jblesta.form.toggleyn.enabled',
 				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
 				'label'			=> 'jblesta.admin.form.settings.label.debug',
 				'description'	=> 'jblesta.admin.form.settings.description.debug',
 		),
		'joomlaurl'	=> array(
				'order'			=> 30,
				'type'			=> 'text',
				'value'			=> null,
				'validation'	=> '',
				'label'			=> 'jblesta.admin.form.settings.label.joomlaurl',
				'description'	=> 'jblesta.admin.form.settings.description.joomlaurl',
		),
		'logintoken'	=> array(
				'order'			=> 40,
				'type'			=> 'password',
				'value'			=> null,
				'validation'	=> '',
				'label'			=> 'jblesta.admin.form.settings.label.logintoken',
				'description'	=> 'jblesta.admin.form.settings.description.logintoken',
		),
	);