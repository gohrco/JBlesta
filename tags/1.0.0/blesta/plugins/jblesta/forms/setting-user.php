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
 * Form Definition for the user settings in the settings form
 */
$form	= array(
		'userenable'		=> array(
				'order'			=> 10,
				'type'			=> 'toggleyn',
				'value'			=> true,
				'validation'	=> '',
				'labelon'		=> 'jblesta.form.toggleyn.enabled',
				'labeloff'		=> 'jblesta.form.toggleyn.disabled',
				'label'			=> 'jblesta.admin.form.settings.label.userenable',
				'description'	=> 'jblesta.admin.form.settings.description.userenable',
				),
		'useraddmethod'		=> array(
				'order'			=> 20,
				'type'			=> 'dropdown',
				'value'			=> '',
				'validation'	=> '',
				'options'		=> array(
						array( 'id' => 0, 'name' => 'jblesta.useraddmethod.0.none' ),
						array( 'id' => 1, 'name' => 'jblesta.useraddmethod.1.jonly' ),
						array( 'id' => 2, 'name' => 'jblesta.useraddmethod.2.wonly' ),
						array( 'id' => 4, 'name' => 'jblesta.useraddmethod.4.both' ),
				),
				'label'			=> 'jblesta.admin.form.settings.label.useraddmethod',
				'description'	=> 'jblesta.admin.form.settings.description.useraddmethod'
		),/*
		'regmethod'		=> array(
				'order'			=> 25,
				'type'			=> 'dropdown',
				'value'			=> '',
				'validation'	=> '',
				'options'		=> array(
						array( 'id' => 0, 'name' => 'jblesta.regmethod.0.joomla' ),
						array( 'id' => 1, 'name' => 'jblesta.regmethod.1.blesta' ),
				),
				'label'			=> 'jblesta.admin.form.settings.label.regmethod',
				'description'	=> 'jblesta.admin.form.settings.description.regmethod'
		),*/
		'namestyle'		=> array(
				'order'			=> 30,
				'type'			=> 'dropdown',
				'value'			=> '',
				'validation'	=> '',
				'options'		=> array(
						array( 'id' => 1, 'name' => 'jblesta.namestyle.1.firstlast' ),
						array( 'id' => 2, 'name' => 'jblesta.namestyle.2.firstlastco' ),
						array( 'id' => 3, 'name' => 'jblesta.namestyle.3.lastfirst' ),
						array( 'id' => 4, 'name' => 'jblesta.namestyle.4.lastfirstco' ),
				),
				'label'			=> 'jblesta.admin.form.settings.label.namestyle',
				'description'	=> 'jblesta.admin.form.settings.description.namestyle'
		),/*
		'userstyle' => array(
				'order'			=> 40,
				'type'			=> 'togglebtn',
				'value'			=> array( '1' ),
				'validation'	=> '',
				'options'		=> array(
						array( 'id' => '1', 'name' => 'jblesta.userstyle.optn.create' ),
						array( 'id' => '2', 'name' => 'jblesta.userstyle.optn.field' ),
				),
				'label'			=> 'jblesta.userstyle.label',
		),
		'userstyleoptn1'	=> array( 'order'	=> 41, 'class'	=> 'well well-small', 'type'	=> 'wrapo' ),*/
			'usernamestyle'		=> array(
					'order'			=> 45,
					'type'			=> 'dropdown',
					'value'			=> '',
					'validation'	=> '',
					'options'		=> array(
							array( 'id' => 1, 'name' => 'jblesta.usernamestyle.1.firstlast' ),
							array( 'id' => 2, 'name' => 'jblesta.usernamestyle.2.lastfirst' ),
							array( 'id' => 3, 'name' => 'jblesta.usernamestyle.3.random' ),
							array( 'id' => 4, 'name' => 'jblesta.usernamestyle.4.flast' ),
							array( 'id' => 5, 'name' => 'jblesta.usernamestyle.5.firstl' ),
							array( 'id' => 6, 'name' => 'jblesta.usernamestyle.6.firstname' ),
							array( 'id' => 7, 'name' => 'jblesta.usernamestyle.7.lastname' ),
							array( 'id' => 8, 'name' => 'jblesta.usernamestyle.8.email' ),
					),
					'label'			=> 'jblesta.admin.form.settings.label.usernamestyle',
					'description'	=> 'jblesta.admin.form.settings.description.usernamestyle'
			),/*
		'userstyleoptn1c'	=> array( 'order'	=> 49, 'type'	=> 'wrapc' ),
		'userstyleoptn2'	=> array( 'order'	=> 511, 'class'	=> 'well well-small', 'type'	=> 'wrapo' ),
			'usernamefield'		=> array(
					'order'			=> 55,
					'type'			=> 'text',
					'value'			=> null,
					'validation'	=> '',
					'label'			=> 'jblesta.admin.form.settings.label.usernamefield',
					'description'	=> 'jblesta.admin.form.settings.description.usernamefield',
			),
		'userstyleoptn2c'	=> array( 'order'	=> 59, 'type'	=> 'wrapc' ),*/
	);
