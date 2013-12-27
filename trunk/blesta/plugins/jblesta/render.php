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

defined('DUNAMIS') OR exit('No direct script access allowed');

require_once 'client.php';

/**
 * JBlesta Render Module
 * @desc		This class is used to render the Joomla site through Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaRenderDunModule extends JblestaClientDunModule
{
	private $debugcurl		=	null;		// Contains the info array from the curl call for debugging
	private $debugregex		=	array();
	private $headoutput;
	private $htmlfooter;
	private $htmlheader;
	private $joomlauri;
	private $unicode		=	'u';
	private $usetemplate;
	
	/**
	 * Method to execute tasks
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function execute()
	{
		// Provide instantiation
		static $jblesta = array();
		
		if (! empty( $jblesta ) ) {
			return false;
		}
		
		// Lets establish our default to return just in case
		$jblesta	=	array(
				'enabled'	=>	false,
				'showinfo'	=>	true,
				//'template'	=>	'templates/' . ( isset( $vars['template'] ) ? $vars['template'] : 'default' )
				);
		
		// If we are disabled don't run ;-)
		if (! ensure_active( 'visual' ) ) {
			return false;
		}
		
		$config	=	dunloader( 'config', 'jblesta' );
		$api	=	dunloader( 'api', 'jblesta' );
		$doc	=	dunloader( 'document', true );
		$params	=	$this->_assembleCall();
		$task	=	'Render';
		
		// Make the call
		$call = $api->render( $params );
		
		// Grab for debugging purposes
		$this->debugcurl	=	$api->debug;
		
		if (! $call ) {
			return false;
		}
		
		$call->htmlheader	=	$this->_utf8convert( base64_decode( $call->htmlheader ) );
		$call->htmlfooter	=	$this->_utf8convert( base64_decode( $call->htmlfooter ) );
		
		// Set pieces into place
		$this->setHead( $call );
		$this->setFooter( $call );
		$this->setHeader( $call );
		
		// Do cleanup work
		$regexes	=	$this->_gatherRegex();
		
		foreach( $regexes as $type => $regex ) {
			$this->_cleanup( $regex, $type );
		}
		
		// -------------------------------------------
		// Reset CSS
		if ( $config->get( 'resetcss', 0 ) ) {
			$this->headoutput	.=	"\r\n"
								.	'<link rel="stylesheet" href="' . rtrim( get_baseurl( 'jblesta' ), '/' ) . '/css/index?f=reset&t=assets" type="text/css" />';
		}
		
		// -------------------------------------------
		// Custom CSS
		if ( get_path( 'assets', 'jblesta', 'custom.css' ) ) {
			$this->headoutput	.=	"\r\n"
					.	'<link rel="stylesheet" href="' . rtrim( get_baseurl( 'jblesta' ), '/' ) . '/css/index?f=custom&t=assets" type="text/css" />';
		}
		
		// -------------------------------------------
		// Hide asides (myinfos)
		if (! $config->get( 'showmyinfo', true ) ) {
			$doc->addStyleDeclaration( "#jblestawrapper aside.left_content { display: none; }" );
		}
		
		// -------------------------------------------
		// Gather variables to return to template
		// -------------------------------------------
		$jblesta['enabled']		=	true;											// Are we enabled?
		$jblesta['showinfo']	=	(bool) $config->get( 'showmyinfo', false );
		$jblesta['headoutput']	=	$this->getItem( 'head' );						// Grab the head data?
		$jblesta['templatedir']	=	rtrim( get_baseurl( 'jblesta' ), '/' ) . '/templates/' . get_version() . '/';
		$jblesta['cssdir']		=	rtrim( get_baseurl( 'jblesta' ), '/' ) . '/css/index?f=';
		
		$doc->setVar( 'jblesta', (object) $jblesta );
		return true;
	}
	
	
	/**
	 * Initializes the module
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function initialise()
	{
		$config	=	dunloader( 'config', 'jblesta' );
		$this->joomlauri	=	DunUri :: getInstance( $config->get( 'joomlaurl' ), true );
	}
	
	
	/**
	 * Method to get an item for output
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $item: gets the item we want [head|customcss|footer|header|debug]	
	 * @param		array		- $vars: contains already assembled data from hooks 
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function getItem( $item = 'head', $vars = array() )
	{
		
		switch( $item ) :
		case 'customcss' :
			
			// If we are disabled don't do it
			if (! ensure_active( 'visual' ) ) {
				return null;
			}
			
			$path		=	dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . get_version() . DIRECTORY_SEPARATOR . $this->usetemplate . DIRECTORY_SEPARATOR;
			
			if ( file_exists( $path . 'custom.css' ) ) {
				return	'<link rel="stylesheet" href="' . rtrim( get_systemurl(), '/' ) . '/modules/addons/jwhmcs/templates/' . get_version() . '/' . $this->usetemplate . '/custom.css" type="text/css" />';
			}
			
			return null;
		case 'head' :
			return $this->headoutput;
		case 'footer' :
			
			// Lets check our license
			if (! ensure_active( 'license' ) ) {
				return dunloader( 'license', 'jwhmcs' )->getErrorMsg();
			}
			
			return $this->htmlfooter;
		case 'header' :
			return $this->htmlheader;
		case 'debug' :
			return $this->debugcurl;
		endswitch;
	}
	
	
	/**
	 * Method to set the html footer into place
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $call: our html
	 *
	 * @since		1.0.0
	 */
	public function setFooter( $call )
	{
		$lic	=	dunloader( 'license', 'jblesta' );
		$parts	=	explode( '</body>', $call->htmlfooter );
		$footer	=	array_shift( $parts );
		$footer	=	"\r\n"
				.	'</div>'
				.	( $lic->get( 'branding' ) ? '<p style="font-size: x-small; " align="center"><a href="https://www.gohigheris.com" target="blank" alt="custom joomla blesta integration joomla integration hosting">J!Blesta</a></p>' : null )
				.	"<!-- End setFooter -->"
				.	$footer;
		$this->htmlfooter	=	$footer;
	}
	
	
	/**
	 * Method to set the head in place for later retrieval
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $call: contains the htmlheader / footer
	 * 
	 * @since		1.0.0
	 */
	public function setHead( $call )
	{
		$config		=	dunloader( 'config', 'jblesta' );
		$linebyline	=	$config->get( 'parseheadlinebyline', false );
		$parts		=	explode( '</head>', $call->htmlheader );
		$head		=	array_shift( $parts );
		$newhead	=	array();
		
		// Advanced method - line by line
		if ( $linebyline ) {
			
			$fndhead	=
			$fndhtml	=	false;
			$lines		=	preg_split( '#\n|\r\n#', $head );
			
			foreach( $lines as $line ) {
				if ( strpos( $line, '<head' ) !== false ) {
					$fndhead = true;
					continue;
				}
			
				if ( strpos( $line, '<html' ) !== false ) {
					$fndhtml = true;
					continue;
				}
			
				if (! $fndhtml && ! $fndhead ) continue;
				if ( strpos( $line, '<base' ) !== false ) continue;
				if ( strpos( $line, 'charset' ) !== false ) continue;
				if ( strpos( $line, 'generator' ) !== false ) continue;
				if ( strpos( $line, '</title>' ) !== false ) continue;
				$newhead[]	=	$line;
			}
		}
		else {
			// Lets handle meta tags first
			preg_match_all( '#<meta[^>]*/>#u', $head, $matches );
			
			if ( isset( $matches[0] ) ) {
				foreach ( $matches[0] as $match ) {
					if ( strpos( $match, 'charset' ) !== false ) continue;
					if ( strpos( $match, 'generator' ) !== false ) continue;
			
					$newhead[]	=	$match;
				}
			}
			
			$parts		=	explode( '</title>', $head );
			$newhead[]	=	array_pop( $parts );
		}
		
		$this->headoutput	=	implode( "\r\n", $newhead );
	}
	
	
	/**
	 * Method to set the head in place for later retrieval
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $call: contains the htmlheader / footer
	 *
	 * @since		1.0.0
	 */
	public function setHeader( $call )
	{
		// Find the end head tag first
		$parts		=	explode( '</head>', $call->htmlheader );
		$body		=	array_pop( $parts );
		$body		.=	"\r\n"
					.	'<!-- Begin setHeader -->'
					.	'<div id="jblestawrapper">';
		$this->htmlheader =	$body;
	}
	
	
	/**
	 * Performs on the fly swap for custom head links in structure files
	 * @access		public
	 * @version		@fileVers@
	 * @param		string			An HTML string containing a link to the intended css file
	 *
	 * @return		string			A swapped out string containing our location, or the original location or null if no string passed to us
	 * @since		1.0.0
	 */
	public function swapItem( &$string )
	{
		if (! isset( $string ) ) return null;
		
		if ( preg_match( '#<link[^>]+href=[\"|\']+([^\"|\']+)[^>]+>#im', $string, $matches ) ) {
			$pathdata	=	pathinfo( $matches[1] );
			$relative	=	array_pop( explode( 'plugins', $pathdata['dirname'] ) );
			
			if ( DunHelper :: readFile( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'templates/' .  get_version() . str_replace( '/', DIRECTORY_SEPARATOR, $relative ) . DIRECTORY_SEPARATOR . $pathdata['basename'] ) ) {
				//$newurl	=	rtrim( get_baseurl( 'jblesta' ), '/' ) . '/templates/' . get_version() . $relative . '/' . $pathdata['basename'];
				$newurl	=	rtrim( get_baseurl( 'jblesta' ), '/' ) . '/css/index?f=' . $pathdata['filename'] . '&d=' . $relative;
				$string	=	str_replace( $matches[1], $newurl, $string ); 
			}
		}
		
		return $string;
	}
	
	
	/**
	 * Method to assemble the parameters for the render call
	 * @access		private
	 * @version		@fileVers@
	 * @param		array		- $vars: contains the variables we were passed in the ClientAreaPage hook
	 *
	 * @return		array
	 * @since		1.0.0
	 */
	private function _assembleCall()
	{
		// Initialize
		$data	=	array();
		$config	=	dunloader( 'config', 'jblesta' );
		$email	=	$this->_extract_email();
		
		// Set the menu item
		$data['Itemid']		=	$config->get( 'menuitem' );
		$data['isssl']		=	is_ssl();
		
		// If we have a logged in client then grab the variables there
		if ( $email ) {
			$data['useremail']	=	$email;
			$data['isloggedin']	=	true;
		}
		
		// Language time
		/*if ( $config->get( 'languageenable', false ) ) {
			
			// Determine which language to get
			if ( isset( $vars['language'] ) ) {
				// If we have a language set, then lets tell Joomla
				$language			=	$vars['language'];
				$data['langrev']	=	$language;	// Used by Joomla regexes to indicate WHMCS language for links / actions
			}
			else {
				$language			=	'default';
			}
			
			$ls				=	dunloader( 'languagesettings', 'jwhmcs' );
			$data['lang']	=	$ls->getLanguagesetting( $language );
		}*/
		
		return $data;
	}
	
	
	/**
	 * Method to consistently build the URL 
	 * @access		private
	 * @version		@fileVers@
	 * @param		DunUri			A DunUri object containing our parsed URL
	 * 
	 * @return		string			Contains the complete URL
	 * @since		1.0.0
	 */
	private function _buildUrl( $uri )
	{
		$scheme = $uri->getScheme();
	
		if (! is_null( $scheme ) ) {
			if ( ( $scheme == 'javascript' ) && ( ( $uri->getPath() == "/;" )  || ( $uri->getPath() == ";" ) ) ) return 'javascript:;';
			if ( ( $scheme == 'javascript' ) && (! is_null( $uri->getPath() ) ) ) return 'javascript:' . ltrim( $uri->getPath(),'/' );
		}
	
		return $uri->toString();
	}
	
	
	/**
	 * Method to check for duplicate paths between two URLs
	 * @access		private
	 * @version		@fileVers@
	 * @param		string			Contains our original path we want to compare against
	 * @param		string			Contains our new path we want to compre
	 * 
	 * @return		string			Containing a blended URL
	 * @since		1.0.0
	 */
	private function _checkDuplicatePaths( $orig, $new )
	{
		// The original path is coming out of the template
		// The new path is held in the needle
	
		$npath = explode('/', trim($new, '/'));
		$upath = explode('/', trim($orig, '/'));
		
		$start = false;
		// Take the first path item from original and check for existance in new path
		if (in_array($upath[0], $npath) ) {
			$start = array_search($upath[0], $npath);
		}
	
		// We know that we found the first item in the new path, now compare the rest of the path to see if it matches
		if ($start !== false) {
			$chop = true;
			for ($i=0; $i<count($npath); $i++) {
				if ($npath[$start+$i] != $upath[$i]) {
					$chop = false;
					break;
				}
			}
			if ($chop) {
				array_splice($npath, $start);
			}
		}
	
		// Reassemble the needle now and return
		return '/' . implode('/', $npath).'/'.ltrim($orig, '/');
	}
	
	
	/**
	 * Method to cycle through our HTML items and clean them up applying regexes etc
	 * @access		private
	 * @version		@fileVers@
	 * @param		stdClass		An object containing our regular expression
	 * @param		string			Not sure this is used..
	 *
	 * @since		1.0.0
	 */
	private function _cleanup( $regex, $type )
	{
		$check		=	array( 'headoutput', 'htmlheader', 'htmlfooter' );
		
		foreach ( $check as $item ) {
			
			$actions	=	array();
			$matches	=	array();
			
			preg_match_all( $regex->search, $this->$item, $matches, PREG_SET_ORDER);
			
			foreach( $matches as $match ) {
				$actions[]	=	$this->_parsedata( $match, $regex->replace, $regex->replaceall, $regex->noprepend, $regex->scheme );
			}
			
			foreach ( $actions as $action ) {
				$this->$item = str_replace( $action->find, $action->replace, $this->$item );
			}
		}
	}
	
	
	/**
	 * Method for extracting the correct email address for a logged in user
	 * @access		private
	 * @version		@fileVers@
	 * @param		array		- $vars: variables we are passed
	 *
	 * @return		string or false on not loggedin
	 * @since		1.0.0
	 */
	private function _extract_email()
	{
		if (! isset( $_SESSION['blesta_client_id'] ) ) {
			return false;
		}
		
		Loader :: loadModels( $this, array( 'clients' ) );
		$client_id	=	$_SESSION['blesta_client_id'];
		
		$client	=	$this->Clients->get( $_SESSION['blesta_client_id'] );
		
		if (! isset( $client->email ) ) {
			return false;
		}
		
		return $client->email;
	}
	
	
	/**
	 * Gather the regular expressions
	 * @access		private
	 * @version		@fileVers@
	 *
	 * @return		array of objects
	 * @since		1.0.0
	 */
	private function _gatherRegex()
	{
		// We need this for the CSRF token
		Loader :: loadHelpers( $this, array( "Form" ) );
		
		$config		=	dunloader( 'config', 'jwhmcs' );
		$data		=	array();
		
		/* LINKs */
		$data['links']	=	(object) array(
				'search'		=>	'/(?P<front><link[^>]+?href=\"?\'?)\/?(?P<link>[^>\"\']+)(?P<back>[^>]*?\/?>)/sm' . $this->unicode,
				'replace'		=>	$this->_getReplacementurl( 'imgurl' ),
				'replaceall'	=>	false,
				'noprepend'		=>	true,
				'scheme'		=>	true
		);
		
		/* HREFs */
		$data['hrefs']	=	(object) array(
				'search'		=>	'/(?P<front><a.+?href=\'?\"?)\/?(?P<link>[^>\"\']+)(?P<back>\"?\'?.*?>)/sm' . $this->unicode,
				'replace'		=>	$this->_getReplacementurl( 'joomlaurl' ),
				'replaceall'	=>	false,
				'noprepend'		=>	false,
				'scheme'		=>	true
		);
		
		/* SCRIPTS */
		$data['scripts']	=	(object) array(
				'search'		=>	'/(?P<front><script[^>]+?src=[\"\'])\/?(?P<link>[^\/]+[^>\"\']+)(?P<back>\'?\"?.*?>)/sm' . $this->unicode,
				'replace'		=>	$this->_getReplacementurl( 'imgurl' ),
				'replaceall'	=>	false,
				'noprepend'		=>	true,
				'scheme'		=>	true
		);
		
		/* IMAGES */
		$data['images']	=	(object) array(
				'search'		=>	'/(?P<front><img[^>]+?src=[\"|\']?)\/?(?P<link>[^>\"\']+)(?P<back>.*?>)/sm' . $this->unicode,
				'replace'		=>	$this->_getReplacementurl( 'imgurl' ),
				'replaceall'	=>	false,
				'noprepend'		=>	true,
				'scheme'		=>	true
		);
		
		/* STYLE */
		$data['style']	=	(object) array(
				'search'		=>	'/(?P<front>style=\"?\'?[^>]+?url\(\"?\'?)\/?(?P<link>[^\)]+\..{3})(?P<back>\"?\'?\);?[^>]*>)/sm' . $this->unicode,
				'replace'		=>	$this->_getReplacementurl( 'imgurl' ),
				'replaceall'	=>	false,
				'noprepend'		=>	true,
				'scheme'		=>	true
		);
		
		/* STYLE TAGS */
		$data['styletags']	=	(object) array(
				'search'		=>	'/(?P<front>{[\w\s]*[^}]*background[-\w]*:[^\)]*url\(\"?\'?)\/?(?P<link>[^\)]+\..{3})(?P<back>\"?\'?\)[^}]*})/sm' . $this->unicode,
				'replace'		=>	$this->_getReplacementurl( 'imgurl' ),
				'replaceall'	=>	false,
				'noprepend'		=>	true,
				'scheme'		=>	true
		);
		
		/* MOUSEOUTS */
		$data['mouseouts']	=	(object) array(
				'search'		=>	'/(?P<front>onmouse.+?=\"?\'?javascript:this.src=\"?\'?)(?P<link>https?:\/\/[^>\'\" ]+)(?P<back>\'?\"?[^>]*?)/sm' . $this->unicode,
				'replace'		=>	$this->_getReplacementurl( 'imgurl' ),
				'replaceall'	=>	false,
				'noprepend'		=>	true,
				'scheme'		=>	true
		);
		
		/* MOUSEOUTS */
		$data['styleurls']	=	(object) array(
				'search'		=>	'#(?P<front><style>[^>]*@import url\()(?P<link>[^\)]*)(?P<back>\))#ism' . $this->unicode,
				'replace'		=>	$this->_getReplacementurl( 'imgurl' ),
				'replaceall'	=>	false,
				'noprepend'		=>	true,
				'scheme'		=>	true
		);
		
		/* TMPL URLS */
		$data['templateurls']	=	(object) array(
				'search'		=>	'#(?P<front>url\(\')(?P<link>[^\']*)(?P<back>\'\))#i' . $this->unicode,
				'replace'		=>	$this->_getReplacementurl( 'imgurl' ),
				'replaceall'	=>	false,
				'noprepend'		=>	true,
				'scheme'		=>	true
		);
		
		/* Windows DOM Asset Images */
		$data['windomassets']	=	(object) array(
				'search'		=>	'/(?P<front>{[\w\s]*[^}]*[^\)]*image\(\"?\'?)\/?(?P<link>[^\)]+\..{3})(?P<back>\"?\'?\)[^}]*})/i' . $this->unicode,
				'replace'		=>	$this->_getReplacementurl( 'imgurl' ),
				'replaceall'	=>	false,
				'noprepend'		=>	true,
				'scheme'		=>	true
		);
		
		/* In-line style declarations */
		$data['inlinestyle']	=	(object) array(
				'search'		=>	'/(?P<front>{\"?\'?[^}]+?url\(\"?\'?)\/?(?P<link>[^\)]+\..{3})(?P<back>\"?\'?\);?[^}]*})/i' . $this->unicode,
				'replace'		=>	$this->_getReplacementurl( 'imgurl' ),
				'replaceall'	=>	false,
				'noprepend'		=>	true,
				'scheme'		=>	true
		);
		
		/* CSRF Token Insertions */
		$data['csrftokens']		=	(object) array(
				'search'		=>	'/<\!--CSRFTAG-->/im',
				'replace'		=>	'<input type="hidden" name="_csrf_token" value="' . $this->Form->getCsrfToken( '' ) . '" />',
				'replaceall'	=>	true,
				'noprepend'		=>	false,
				'scheme'		=>	false,
		);
		
		return $data;
	}
	
	
	/**
	 * Method for getting a replacement URL for use in regexes
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $type: what we want [imgurl|joomlaurl]
	 *
	 * @return		string of URL
	 * @since		1.0.0
	 */
	private function _getReplacementurl( $type )
	{
		$config	=	dunloader( 'config', 'jblesta' );
		$ssl	=	is_ssl();
		$url	=	null;
		
		switch ( $type ) :
		case 'imgurl' :
			$tmp	=	$config->get( 'customimageurl', '0' ) == '1' ? $config->get( 'joomlaurl' ) : $config->get( 'imageurl' );
			$uri	=	DunUri :: getInstance( $tmp, true );
			$uri->setScheme( 'http' . ( $ssl ? 's' : '' ) );
			$url	=	$uri->toString();
			break;
		case 'joomlaurl' :
			$url	=	$config->get( 'joomlaurl' );
			break;
		endswitch;
		
		return $url;
	}
	
	
	/**
	 * Parses through the data sent
	 * @access		private
	 * @version		@fileVers@
	 * @param		array			Contains the parts of the regex that were found
	 * @param		string			Contains our replacement piece
	 * @param		boolean			Replace all the found item with the replacement [t|F]
	 * @param		boolean			Prepend the scheme / hostname of our replacement if not found [t|F]
	 * @param		boolean			Forcibly change the scheme to the replacement scheme [t|F]
	 * 
	 * @return		stdClass		Contains our completed data for use
	 * @since		1.0.0
	 */
	private function _parsedata( $match, $replace, $replaceall = false, $noprepend = false, $scheme = false )
	{
		$data	=	new stdClass();
		$data->find		=	$match[0];
		$data->replace	=	null;
		
		if ( $replaceall ) {
			$data->replace	=	$match['front'] . $replace . $match['back'];
			return $data;
		}
		
		$founduri	=	DunUri :: getInstance( $match['link'], true );
		$replaceuri	=	DunUri :: getInstance( $replace, true );
		
		if ( $founduri->isFragment() ) {
			$data->replace	=	$match[0];
			return $data;
		}
		
		if ( $founduri->getPath() ) {
			$founduri->setPath( '/' . ltrim( $founduri->getPath(), '/' ) );
		}
		
		// If we must replace the scheme 
		if ( $noprepend ) {
			
			// Host found
			if ( $founduri->getHost() ) {
				
				// See if the found host is the same as our joomla host 
				if ( $this->joomlauri->getHost() == $founduri->getHost() ) {
					$founduri->setPath( $this->_checkDuplicatePaths( $founduri->getPath(), $replaceuri->getPath() ) );
					$founduri->setHost( $replaceuri->getHost() );
				}
			}
			// No host found
			else {
				$founduri->setPath( $this->_checkDuplicatePaths( $founduri->getPath(), $replaceuri->getPath() ) );
				$founduri->setHost( $replaceuri->getHost() );
			}
			
			// Be sure the scheme is set
			$founduri->setScheme( $replaceuri->getScheme() );
			$fullurl	=	$this->_buildUrl( $founduri );
			$data->replace	=	$match['front'] . $fullurl . $match['back'];
			return $data;
		}
		
		if ( $founduri->getScheme() ) {
			if ( $scheme ) {
				$founduri->setScheme( $replaceuri->getScheme() );
			}
			
			$fullurl	=	$this->_buildUrl( $founduri );
			$data->replace	=	$match['front'] . $fullurl . $match['back'];
			return $data;
		}
		else {
			$founduri->setScheme( $replaceuri->getScheme() );
			$founduri->setHost( $replaceuri->getHost() );
		}
		
		if ( ( $replaceuri->getPath() ) && ( $founduri->getPath() ) ) {
			$founduri->setPath( $this->_checkDuplicatePaths( $founduri->getPath(), $replaceuri->getPath() ) );
		}
		
		$fullurl	=	$this->_buildUrl( $founduri );
		$data->replace	=	$match['front'] . $fullurl . $match['back'];
		return $data;
	}
	
	
	/**
	 * Method to check for utf8 encoding (faster than regex)
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $Str: what we are checking
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	private function _utf8check( $Str )
	{
		for ($i=0; $i<strlen($Str); $i++)
		{
		if ( ord($Str[$i]) < 0x80 ) continue; # 0bbbbbbb
		elseif ( (ord($Str[$i]) & 0xE0) == 0xC0 ) $n=1; # 110bbbbb
		elseif ( (ord($Str[$i]) & 0xF0) == 0xE0 ) $n=2; # 1110bbbb
		elseif ( (ord($Str[$i]) & 0xF8) == 0xF0 ) $n=3; # 11110bbb
		elseif ( (ord($Str[$i]) & 0xFC) == 0xF8 ) $n=4; # 111110bb
		elseif ( (ord($Str[$i]) & 0xFE) == 0xFC ) $n=5; # 1111110b
		else return false; # Does not match any model
		
		for ( $j=0; $j<$n; $j++ )
		{ # n bytes matching 10bbbbbb follow ?
			if ( (++$i == strlen($Str)) || ((ord($Str[$i]) & 0xC0) != 0x80) )
			return false;
		}
		}
		return true;
	}
	
	
	/**
	 * Method to convert a string to UTF-8
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $string: what we want to convert
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	private function _utf8convert( $string )
	{
		// Test the string to see if it isn't utf-8
		if ( $this->_utf8check( $string ) ) {
			return $string;
		}
		
		if (! function_exists( 'mb_detect_encoding' ) ) {
			// @TODO: Log an error somehow
			$this->unicode = null;
			return string;
		}
		
		$encoding	=	mb_detect_encoding( $string, 'auto', true );
		if (! $encoding ) {
			// @TODO: Log an error somehow
			$this->unicode = null;
			return $string;
		}
		
		if (! function_exists( 'iconv' ) ) {
			// @TODO: Log an error somehow
			$this->unicode = null;
			return $string;
		}
		
		$result	=	iconv( strtoupper( $encoding ), 'UTF-8//TRANSLIT', $string );
		if (! $result ) {
			// @TODO: Log an error somehow
			$this->unicode = null;
			return $string;
		}
		
		return $result;
	}
}