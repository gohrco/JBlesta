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
 * Form Definition for the language settings in the settings form (not implemented yet)
 */
$form	= array(
		'languageenable'		=> array(
				'order'			=> 10,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.languageenable',
				'description'	=> 'jblesta.admin.form.settings.description.languageenable',
		),
);