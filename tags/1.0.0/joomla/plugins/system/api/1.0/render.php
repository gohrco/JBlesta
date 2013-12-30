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

defined('_JEXEC') or die( 'Restricted access' );

/**
 * JBlesta System Plugin API Render
 * @desc		This file handles the retrieval of the Joomla site back to Blesta through our API
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class RenderJblestaAPI extends JblestaAPI
{
	
	/**
	 * Method for executing on the API
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		false
	 * @since		1.0.0
	 */
	public function execute()
	{
		$db		=	dunloader( 'database', true );
		$input	=	dunloader( 'input', true );
		$status	=	$input->getVar( 'isloggedin', false );
		
		// If we should be logged in
		if ( $status ) {
			
			// Rendering fails if the user doesn't exist in Joomla yet
			// See if we have a user first
			if ( JFactory :: getUser()->guest ) {
				$query	=	"SELECT `id` FROM `#__users` WHERE `email` = " . $db->Quote( $input->getVar( 'useremail', null ) ) . " LIMIT 1";
				$db->setQuery( $query );
				$userid	=	$db->loadResult();
			}
			
			// Check the user to see if this is our first run through
			if ( JFactory :: getUser()->guest && $userid ) {
				
				// Grab the user
				$instance	=	JUser::getInstance();
				$instance->load( $userid );
				$instance->set( 'guest', 0 );
				
				// Set the user into the session
				$session	=	JFactory :: getSession();
				$session->set( 'user', $instance );
				
				// Clean up the session
				$app		=	JFactory :: getApplication();
				$app->checkSession();
				
				// Attach this user to the session table
				$query	=	"UPDATE `#__session` SET `guest` = '0', `username` = "
						.	$db->Quote( $instance->get( 'username' ) ) . ", `userid` = "
						.	$db->Quote( $instance->get( 'id' ) ) . " WHERE `session_id` = "
						.	$db->Quote( $session->getId() );
				
				$db->setQuery( $query );
				$db->query();
				
				
				// --------------------------------------------------------------
				// Redirect to ourselves to have the user catch at initialization
				// --------------------------------------------------------------
				$document	=	JFactory :: getDocument();
				$signature	=	(string) plgSystemJblesta_sysm :: generateSignature();
				
				$uri	=	DunUri :: getInstance( 'SERVER', true );
				$uri->setVar( 'apisignature', rawurlencode( $signature ) );
				
				// If curl isnt able to follow redirects then we must not try to set a cookie and redirect, just bail
				if ( ! ini_get('safe_mode') && ! ini_get('open_basedir')) {
					
					// We will do our own redirection thank you very much
					header( 'JwhmcsRequestSignature: ' . rawurlencode( $signature ) );
					header( 'HTTP/1.1 303 See other' );
					header( 'Location: ' . $uri->toString() );
					header( 'Content-Type: text/html; charset=' . $document->getCharset() );
					
					// Close cleanly
					$app->close();
				}
			}
		}
		
		// Attach our render and route handlers to ensure we get fired last
		$dispatcher	=	JDispatcher :: getInstance();
		$dispatcher->register( 'onBeforeRender', 'RenderJblestaAPIPlugin' );
		$dispatcher->register( 'onAfterRoute', 'RenderJblestaAPIPlugin' );
		return false;
	}
}


/**
 * JBlesta System Plugin API Render Plugin Class
 * @desc		This class is attached to the dispatcher object if we are called through the API handler
 *              and have met all the requirements to do so.
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class RenderJblestaAPIPlugin extends JPlugin
{
	/**
	 * System Event Handler: onBeforeRender
	 * @desc		Intercepts the rendering prior to actually outputing to browser
	 * 				and parses the content, encodes it into base64 code and returns
	 * 				a json formatted string
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function onBeforeRender()
	{
		$app		=	JFactory :: getApplication();
		$session	=	JFactory :: getSession();
		$doc		=	JFactory :: getDocument();
		$input		=	dunloader( 'input', true );
		$config		=	dunloader( 'config', 'com_jblesta' );
		
		// Grab the template and build the parameters
		$template	=	$app->getTemplate(true);
		
		$params	=	array(
			'template'	=>	$app->getTemplate(),
			'file'		=>	'index.php',
			'directory'	=>	JPATH_THEMES,
			'params'	=>	$template->params
			);
		
		// ---- BEGIN JWHMCS-9
		//		Some templates are rendering links / js twice
		/* $doc->parse($params); */
		// ---- END JWHMCS-9
		
		// Render the template
		$html = $doc->render( false, $params );
		
		// Perform some initial regexes on the whole data
		if ( $input->getVar( 'lang', false, 'string', 'get' ) && ( $langrev = $input->getVar( 'langrev', false, 'string', 'get' ) ) ) {
			// Find WHMCS URLs and affix the language to them
			$whmcsurl	=	$config->get( 'blestaapiurl', null );
			$whmcsuri	=	DunUri :: getInstance( $whmcsurl, true );
			$whmcsurl	=	preg_quote( $whmcsuri->toString( array( 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment' ) ), '#' );
			$regex		=	'#<a[^>]+([\"\']+)(?P<link>http(?:s|)\://' . $whmcsurl . '[^\1>]*)\1[^>]*>#im';
			
			preg_match_all( $regex, $html, $matches, PREG_SET_ORDER );
			
			foreach ( $matches as $match ) {
				$uri	=	DunUri :: getInstance( $match['link'], true );
				$uri->setVar( 'language', $langrev );
				$repl	=	str_replace( $match['link'], $uri->toString(), $match[0] );
				$html	=	str_replace( $match[0], $repl, $html );
			}
		}
		
		// Lets fix any login forms people insist on using
		$blestaurl	=	$config->get( 'blestaapiurl', null );
		$blestauri	=	DunUri :: getInstance( $blestaurl, true );
		$blestauri->setScheme( 'http' . ( $input->getVar( 'isssl', false ) ? 's' : '' ) );
		
		$regex		=	'#(?><form)[^>]+?action=[\"|\']+(?P<link>[^\"|\']+)[\"|\']+[^>]*>.*?(?></form>)#ims';
		preg_match_all( $regex, $html, $matches, PREG_SET_ORDER );
		foreach ( $matches as $match )
		{
			// Replace log in actions
			if ( preg_match( '#<input[^>]+[\"|\']+com_users[^>]+>#im', $match[0] ) && preg_match( '#<input[^>]+[\"|\']+user\.login[^>]+>#im', $match[0] ) ) {
				$blestauri->setPath( rtrim( $blestauri->getPath(), '/' ) . '/client/login/' );
				$match['fix']	=	str_replace( $match['link'], $blestauri->toString(), $match[0] );
				$html			=	str_replace( $match[0], $match['fix'], $html );
			}
			
			// Replace log out actions
			if ( preg_match( '#<input[^>]+[\"|\']+com_users[^>]+>#im', $match[0] ) && preg_match( '#<input[^>]+[\"|\']+user\.logout[^>]+>#im', $match[0] ) ) {
				$blestauri->setPath( rtrim( $blestauri->getPath(), '/' ) . '/client/logout/' );
				$match['fix']	=	str_replace( $match['link'], $blestauri->toString(), $match[0] );
				$html			=	str_replace( $match[0], $match['fix'], $html );
			}
			
			// Replace Remember Me name
			$html = preg_replace( '#(<input[^>]+[\"|\']+)remember([\"|\']+[^>]+>)#im', '$1remember_me$2', $html );
			$html = preg_replace( '#(?P<formtag><form[^>]+?>)#im', '$1<!--CSRFTAG-->', $html );
			
		}
		
		// Blow em up
		$parts	=	explode( '<jblesta />', $html );
		
		// Backup explosion
		if ( count( $parts ) < 2 ) {
			$parts	=	explode( '<!-- J!Blesta -->', $html );
		}
		
		// Lets see if we have a content header
		$headsig	=	(string) rawurldecode( $input->getVar( 'HTTP_JBLESTAREQUESTSIGNATURE', false, 'STRING', 'server' ) );
		
		// If we are debugging and we aren't coming from Blesta echo the page back out
		if ( $config->get( 'debug' ) && ! $headsig ) {
			$session->destroy();
			$content	=	(string) implode( '', $parts );
			exit( $content );
		}
		
		// Encode the parts 
		$hdr	=	base64_encode( array_shift( $parts ) );
		$ftr	=	base64_encode( array_pop( $parts ) );
		$string	=	json_encode( array( 'result' => 'success', 'htmlheader' => $hdr, 'htmlfooter' => $ftr ) );
		
		// Remove user and session
		$session->destroy();
		exit( $string );
	}
	
	
	/**
	 * System Event Handler: onAfterRoute
	 * @desc		After the system has parsed the route, J!WHMCS goes in and forces
	 * 				it's own component items into place.  This permits us to no longer
	 * 				parse the content for the menu item and makes menu item selection
	 * 				more intuitive
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function onAfterRoute()
	{
		$input	=	dunloader( 'input', true );
		$input->setVar( 'option', 'com_jblesta', 'get', true );
		$input->setVar( 'view', 'default', 'get', true );
	}
}