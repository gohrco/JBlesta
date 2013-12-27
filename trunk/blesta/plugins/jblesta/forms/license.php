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
 * Form Definition for the license page
 */
$form	= array(
		'license'	=> array(
				'order'			=> 10,
				'type'			=> 'text',
				'value'			=> null,
				'validation'	=> '',
				'label'			=> 'jblesta.admin.form.config.label.license',
				'description'	=> 'jblesta.admin.form.config.description.license',
		),
		'status' => array(
				'order'			=> 20,
				'type'			=> 'information',
				'value'			=> array(),
				'validation'	=> '',
				'label'			=> 'jblesta.admin.form.config.label.status',
				'description'	=> 'jblesta.admin.form.config.description.status',
				),
		'info'	=> array(
				'order'			=> 40,
				'type'			=> 'information',
				'value'			=> array(),
				'nodesc'		=> true,
				'validation'	=> '',
				'label'			=> 'jblesta.admin.form.config.label.info',
		),
);