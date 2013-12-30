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
 * Form Definition for the log in settings in the settings form
 */
$form	= array(
		'loginenable'		=> array(
				'order'			=> 10,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.loginenable',
				'description'	=> 'jblesta.admin.form.settings.description.loginenable',
				),
		'logouturl'		=> array(
				'order'			=> 30,
				'type'			=> 'text',
				'value'			=> null,
				'validation'	=> '',
				'label'			=> 'jblesta.admin.form.settings.label.logouturlfield',
				'description'	=> 'jblesta.admin.form.settings.description.logouturlfield',
		),
	);
