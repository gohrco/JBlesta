<?php
/**
 * -------------------------------------------
 * @packageName@
 * -------------------------------------------
 * @package         @packageName@
 * @subpackage		Joomla
 * @version         @fileVers@
 *
 * @author          @packageAuth@
 * @link            @packageLink@
 * @copyright       @packageCopy@
 * @license         @packageLice@
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
define( 'JBLESTA_VERS', '@fileVers@' );

// Define the DS shortcut
if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
	if (! defined( 'DS' ) ) define( 'DS', DIRECTORY_SEPARATOR );
}


// -------------------------------------------------------
// Ensure we have Dunamis and it's loaded
if (! function_exists( 'get_dunamis' ) ) {
	$path	= dirname( dirname( dirname(__FILE__) ) ) . DS . 'libraries' . DS . 'dunamis' . DS . 'dunamis.php';
	if ( file_exists( $path ) ) require_once( $path );
}

if (! function_exists( 'get_dunamis' ) ) {
	// EPIC FAILURE HERE
	return;
}

get_dunamis( 'com_jblesta' );

// -------------------------------------------------------
// Load up files
foreach ( array( 'legacy', 'helper', 'toolbar' ) as $item ) {
	$path	=	JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jblesta' . DS . 'jblesta.' . $item . '.php';
	if ( @file_exists( $path ) ) {
		require_once( $path );
	}
}

$path = dirname( __FILE__ ) . DS . 'controller.php';
require_once( $path );

// Create the controller class
$classname	= 'JblestaController';
$controller	= new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();