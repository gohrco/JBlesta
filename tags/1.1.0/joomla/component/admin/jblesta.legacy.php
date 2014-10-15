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

if ( version_compare( JVERSION, '3.0', 'ge' ) )
{
	if (! class_exists( 'JblestaControllerExt' ) ) {
		class JblestaControllerExt extends JControllerLegacy {}
	}
	if (! class_exists( 'JblestaControllerForm' ) ) {
		class JblestaControllerForm extends JControllerForm {}
	}
	if (! class_exists( 'JblestaModelExt' ) ) {
		class JblestaModelExt extends JModelLegacy {}
	}
	if (! class_exists( 'JblestaViewExt' ) ) {
		class JblestaViewExt extends JViewLegacy {}
	}
}
else if ( version_compare( JVERSION, '1.6', 'ge' ) )
{
	jimport('joomla.application.component.controller');
	jimport('joomla.application.component.controllerform');
	jimport('joomla.application.component.model');

	// Good ol' Joomla changing things up mid-stream
	if ( version_compare( JVERSION, '2.5.5', 'ge' ) ) {
		jimport( 'cms.view.legacy' );
		if (! class_exists( 'JblestaViewExt' ) ) {
			class JblestaViewExt extends JViewLegacy {}
		}
	} else {
		jimport( 'joomla.application.component.view' );
		if (! class_exists( 'JblestaViewExt' ) ) {
			class JblestaViewExt extends JView {}
		}
	}

	if (! class_exists( 'JblestaControllerExt' ) ) {
		class JblestaControllerExt extends JController {}
	}
	if (! class_exists( 'JblestaControllerForm' ) ) {
		class JblestaControllerForm extends JControllerForm {}
	}
	if (! class_exists( 'JblestaModelExt' ) ) {
		class JblestaModelExt extends JModel {}
	}
}
else
{
	jimport('joomla.application.component.controller');
	jimport('joomla.application.component.model');
	jimport( 'joomla.application.component.view' );

	if (! class_exists( 'JblestaControllerExt' ) ) {
		class JblestaControllerExt extends JController {}
	}
	if (! class_exists( 'JblestaControllerForm' ) ) {
		class JblestaControllerForm extends JController {}
	}
	if (! class_exists( 'JblestaModelExt' ) ) {
		class JblestaModelExt extends JModel {}
	}
	if (! class_exists( 'JblestaViewExt' ) ) {
		class JblestaViewExt extends JView {}
	}
}