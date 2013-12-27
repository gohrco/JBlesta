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

/*-- Security Protocols --*/
defined( '_JEXEC' ) or die( 'Restricted access' );

/*-- Localscope import --*/
jimport( 'joomla.application.component.view' );


/**
 * JBlesta Link View
 * @desc		This is the view handler for the Link Menu Type of J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JBlestaViewLink extends JBlestaViewExt
{
	/**
	 * Builds the view from the display task for the user
	 * @access		public
	 * @version		@fileVers@
	 * @param 		string		$tpl - presumably a template name never used
	 * 
	 * @since		1.0.0
	 */
	public function display($tpl = null)
	{
		$app		=	JFactory::getApplication();
		$config		=	dunloader( 'config', 'com_jblesta' );
		$params		=	$app->getParams();
		
		$url		=	$params->get( 'blestaapiurl' );
		$location	=	rtrim( $url, '/' ) . '/' . ltrim( base64_decode( $params->get( 'location' ) ), '/' );
		
		//		Languages don't get translated properly when on Joomla and going to WHMCS with language settings enabled
// 		if ( $config->get( 'languageenable' ) ) {
			
// 			$uri = JUri::getInstance();
// 			$jconfig	=	dunloader( 'config', true );
			
// 			if ( $jconfig->get( 'sef_rewrite' ) ) {
// 				$parts	=	explode( '/', ltrim( $uri->getPath(), '/' ) );
// 				$sef	=	array_shift( $parts );
// 			}
// 			else {
// 				$sef	=	$uri->getVar( 'lang', false );
// 			}
				
// 			$langs	=	JLanguageHelper::getLanguages('sef');
// 			if ( isset( $langs[$sef] ) ) {
// 				$mylang	=	$config->findLanguage( $langs[$sef]->lang_code );
		
// 				$locuri	=	DunUri :: getInstance( $location );
// 				$locuri->setVar( 'language', $mylang );
// 				$location	=	$locuri->toString();
// 			}
// 		}
		
		$app->redirect( $location );
		$app->close();
	}
}