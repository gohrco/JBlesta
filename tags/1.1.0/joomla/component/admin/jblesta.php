<?php
/**
 * -------------------------------------------
 * @packageName@
 * -------------------------------------------
 * @package         @packageName@
 * @subpackage      Joomla
 * @version         @fileVers@
 *
 * @author          @packageAuth@
 * @link            @packageLink@
 * @copyright       @packageCopy@
 * @license         @packageLice@
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
define( 'JBLESTA_VERS', '@fileVers@' );

jimport( 'dunamis.dunamis' );

// Define the DS shortcut
if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
	if (! defined( 'DS' ) ) define( 'DS', DIRECTORY_SEPARATOR );
}

// Access check.
if ( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
	if (! JFactory::getUser()->authorise( 'core.manage', 'com_jblesta' ) ) {
		return JError::raiseWarning( 404, JText::_( 'JERROR_ALERTNOAUTHOR' ) );
	}
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


if( $controller = JRequest::getWord( 'controller', 'default' ) ) {
	$path = JPATH_COMPONENT . DS . 'controllers' . DS . $controller . '.php';
	if ( @file_exists( $path ) ) {
		require_once $path;
	}
	else {
		$path = JPATH_COMPONENT . DS . 'controllers' . DS . 'default.php';
		require_once $path;
		$controller = 'default';
	}
}

// Create the controller class
$classname	= 'JblestaController' . ucfirst( $controller );
$controller	= new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();