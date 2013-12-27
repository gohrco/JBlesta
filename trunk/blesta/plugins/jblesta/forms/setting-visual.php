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
 * Form Definition for the visual settings in the settings form
 */
$form	= array(
		'visualenable'		=> array(
				'order'			=> 10,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.visualenable',
				'description'	=> 'jblesta.admin.form.settings.description.visualenable',
				),
		/*'jqueryenable'		=> array(
				'order'			=> 15,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.jqueryenable',
				'description'	=> 'jblesta.admin.form.settings.description.jqueryenable',
				),*/
		'customimageurl' => array(
				'order'			=> 20,
				'type'			=> 'togglebtn',
				'value'			=> array( '1' ),
				'validation'	=> '',
				'options'		=> array(
						array( 'id' => '1', 'name' => 'jblesta.customimageurl.optn.joomla' ),
						array( 'id' => '2', 'name' => 'jblesta.customimageurl.optn.custom' ),
				),
				'label'			=> 'jblesta.customimageurl.label',
		),
		'customimageurloptn2'	=> array( 'order'	=> 31, 'class'	=> 'well well-small', 'type'	=> 'wrapo' ),
			'imageurl'		=> array(
					'order'			=> 35,
					'type'			=> 'text',
					'value'			=> null,
					'validation'	=> '',
					'label'			=> 'jblesta.admin.form.settings.label.imageurl',
					'description'	=> 'jblesta.admin.form.settings.description.imageurl',
			),
		'customimageurloptn2c'	=> array( 'order'	=> 39, 'class'	=> 'well well-small', 'type'	=> 'wrapc' ),
		'menuitem'		=> array(
				'order'			=> 50,
				'type'			=> 'dropdown',
				'value'			=> '',
				'validation'	=> '',
				'label'			=> 'jblesta.admin.form.settings.label.menuitem',
				'description'	=> 'jblesta.admin.form.settings.description.menuitem'
		),
		'resetcss' => array(
				'order'			=> 60,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.resetcss',
				'description'	=> 'jblesta.admin.form.settings.description.resetcss',
		),
		'showmyinfo' => array(
				'order'			=> 70,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.showmyinfo',
				'description'	=> 'jblesta.admin.form.settings.description.showmyinfo',
		),/*
		'shownavbar' => array(
				'order'			=> 70,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.shownavbar',
				'description'	=> 'jblesta.admin.form.settings.description.shownavbar',
		),
		'showfooter' => array(
				'order'			=> 80,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.showfooter',
				'description'	=> 'jblesta.admin.form.settings.description.showfooter',
		),*/
	);
