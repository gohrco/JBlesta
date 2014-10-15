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
 * Form Definition for the advanced settings in the settings form
 */
$form	= array(
		'dlid'	=> array(
				'order'			=> 5,
				'type'			=> 'text',
				'value'			=> null,
				'validation'	=> '',
				'label'			=> 'jblesta.admin.form.settings.label.dlid',
				'description'	=> 'jblesta.admin.form.settings.description.dlid',
		),
		'preservedb'		=> array(
				'order'			=> 10,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.preservedb',
				'description'	=> 'jblesta.admin.form.settings.description.preservedb',
		),
		'passalonguseragent'		=> array(
				'order'			=> 20,
				'type'			=> 'toggleyn',
				'value'			=> false,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.passalonguseragent',
				'description'	=> 'jblesta.admin.form.settings.description.passalonguseragent',
		),
		'parseheadlinebyline'		=> array(
				'order'			=> 30,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.parseheadlinebyline',
				'description'	=> 'jblesta.admin.form.settings.description.parseheadlinebyline',
		),
		'forceapitoget'		=> array(
				'order'			=> 40,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.forceapitoget',
				'description'	=> 'jblesta.admin.form.settings.description.forceapitoget',
		),
	);
