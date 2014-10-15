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

// Define the DS shortcut (3.0 dropped?)
if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
	if (! defined( 'DS' ) ) define( 'DS', DIRECTORY_SEPARATOR );
}


/**
 * JBlesta Helper class
 * @desc		This class stores some helpful methods for J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaHelper
{
	
	/**
	 * Handles inclusion of media items into views
	 * @access	public
	 * @version	@fileVers@
	 * @param	string		$media - contains filename/type
	 *
	 * @since	2.4.0
	 */
	public function addMedia( $media = null )
	{
		if ( $media == null ) return;
	
		list( $filename, $type ) = explode( "/", $media );
	
		switch ( $type ):
		case 'css':
			if ( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
			JHtml::stylesheet( "com_jblesta/{$filename}.css", array(), true );
			}
			else {
				$uri	= new Juri();
				//$path	= rtrim( $uri->toString(), '/' ) . '/media/com_jwhmcs/css/';
				$path	= 'media/com_jblesta/css/';
				JHtml::stylesheet( "{$filename}.css", $path, array() );
			}
			break;
		case 'javascript':
		case 'js':
			if ( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
				JHTML::script("com_jblesta/{$filename}.js", array(), true );
			}
			else {
				$uri	= new Juri();
				//$path	= rtrim( $uri->toString(), '/' ) . '/media/com_jwhmcs/js/';
				$path	= 'media/com_jblesta/js/';
				JHTML::script( "{$filename}.js", $path, array() );
			}
			break;
		endswitch;
	}
	
	
	/**
	 * Builds an array of countries for use in a select option box
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.4.0		- May 2012: added options return array
	 * @param		boolean		- $options: indicates we want option arrays back
	 * 
	 * @return		array
	 * @since		1.5.0
	 */
	public function buildCountries( $options = false )
	{
		$countries = array('AF' => 'Afghanistan', 'AX' => 'Aland Islands', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua And Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia', 'BA' => 'Bosnia And Herzegovina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island', 'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island', 'CC' => 'Cocos (Keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo', 'CD' => 'Congo, Democratic Republic', 'CK' => 'Cook Islands', 'CR' => 'Costa Rica', 'CI' => 'Cote D\'Ivoire', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FK' => 'Falkland Islands (Malvinas)', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'TF' => 'French Southern Territories', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GG' => 'Guernsey', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HM' => 'Heard Island & Mcdonald Islands', 'VA' => 'Holy See (Vatican City State)', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran, Islamic Republic Of', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IM' => 'Isle Of Man', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JE' => 'Jersey', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KR' => 'Korea', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Lao People\'s Democratic Republic', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libyan Arab Jamahiriya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'Macedonia', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia, Federated States Of', 'MD' => 'Moldova', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MS' => 'Montserrat', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'AN' => 'Netherlands Antilles', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestinian Territory, Occupied', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania', 'RU' => 'Russian Federation', 'RW' => 'Rwanda', 'BL' => 'Saint Barthelemy', 'SH' => 'Saint Helena', 'KN' => 'Saint Kitts And Nevis', 'LC' => 'Saint Lucia', 'MF' => 'Saint Martin', 'PM' => 'Saint Pierre And Miquelon', 'VC' => 'Saint Vincent And Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome And Principe', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'GS' => 'South Georgia And Sandwich Isl.', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard And Jan Mayen', 'SZ' => 'Swaziland', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad And Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks And Caicos Islands', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States', 'UM' => 'United States Outlying Islands', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela', 'VN' => 'Viet Nam', 'VG' => 'Virgin Islands, British', 'VI' => 'Virgin Islands, U.S.', 'WF' => 'Wallis And Futuna', 'EH' => 'Western Sahara', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe');
		
		if (! $options ) return $countries;
		
		$data	= array();
		foreach ( $countries as $key => $value ) {
			$data[]	= array( 'value' => $key, 'text' => $value );
		}
		return $data;
	}
	
	
	/**
	 * Checks to see if we are on a specific location
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $check: the 'page' to check
	 * 
	 * @return		boolean
	 * @since		2.4.5
	 */
	public function checkRoute( $check = 'pwreset' )
	{
		$app	= & JFactory :: getApplication();
		$router	= & $app->getRouter();
		$option	=   $router->getVar( 'option' );
		$view	=	$router->getVar( 'view' );
		$task	=   $router->getVar( 'task' );
		$data	=   false;
		
		switch( $check ):
		
		// The Default rendering pages in Joomla for J!WHMCS
		case 'render' :
			
			if (	( $option == 'com_jblesta' ) &&
					( $view == 'default' )
			) $data = true;
		
			break;
		
		// Password Reset Page in Joomla!
		case 'pwreset' :
			
			$isLegacy	= version_compare( JVERSION, '1.6.0', 'lt' );
			
			if (	( $option == ( $isLegacy ? 'com_user' : 'com_users' ) ) &&
					( $task == ( $isLegacy ? 'requestreset' : 'reset.request' ) )
			) $data = true;
			
			break;
		endswitch;
		
		return $data;
	}
	
	
	/**
	 * Method to check a token across Joomla versions
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		2.4.0
	 */
	public function checkToken()
	{
		if ( version_compare( JVERSION, '2.5.4', 'ge' ) ) {
			jimport( 'joomla.session.session' );
			return JSession :: checkToken();
		}
		else {
			return JRequest :: checkToken();
		}
	}
	
	
	/**
	 * Encodes a password for either Joomla or WHMCS and returns the hash
	 * @access	public
	 * @version	2.3.0
	 * @param 	string		$for:  whmcs || joomla
	 * @param	string		$encoded - contains the encoded password to retrieve salt with
	 * @param	string		$clear - contains the clear text password to encode
	 * 
	 * @return	String containing encoded password for comparison
	 * @since	2.1.0
	 */
	public function encodePassword( $for = "whmcs", $encoded = null, $clear = null )
	{
		if ( $encoded == null || $clear == null ) return;
		
		$data	= false;
		$pwexp	= explode(':', $encoded);
		
		switch ( $for ):
		case 'whmcs':
			
			$data	= md5($pwexp[1].$clear).':'.$pwexp[1];
			break;
			
		case 'joomla':
			
			if ( count( $pwexp ) > 1 ) {
				$salt		= $pwexp[1];
				$password	= JUserHelper::getCryptedPassword( $clear, $salt );
				$data		= $password . ":" . $salt;
			}
			else {
				$data		= JUserHelper::getCryptedPassword( $clear );
			}
			break;
			
		endswitch;
		
		return $data;
	}
	
	
	/**
	 * Provides single instance of version logic for retrieving variable
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $var: the variable sought
	 * @param		mixed		- $default: if not set return this
	 * @param		string		- $filter: variable filter
	 * @param		string		- $hash: where the variable should come from
	 * $param		integer		- $mask: an optional mask for Joomla
	 *
	 * @return		value of variable or default
	 * @since		2.4.0
	 */
	public function get( $var, $default = null, $filter = 'none', $hash = 'default', $mask = 0 )
	{
		if ( version_compare( JVERSION, '1.7.1', 'ge' ) ) {
			$app	= & JFactory :: getApplication();
			return $app->input->get( $var, $default, $filter );
		}
		else {
			$value	= JRequest :: getVar( $var, $default, $hash, $filter, $mask );
			// If we are resetting pw on front end, post is empty for some reason
			if ( empty( $value ) && $var == 'post' ) $value = JRequest::get( 'post' );
			return $value;
		}
	}
	
	
	/**
	 * Gets actions that are permitted for a user to perform
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		JObject containing action sets
	 * @since		1.00
	 */
	public function getActions()
	{
		$user		= JFactory::getUser();
		$result		= new JObject;
		
		$assetName	= "com_jblesta";
		$actions	= array(	'core.admin',
								'core.manage',
								'core.create',
								'core.edit',
								'core.delete'
		);
		
		foreach ($actions as $action) {
			if ( version_compare( JVERSION, '1.6.0', 'ge' ) )
				$result->set($action,        $user->authorise($action, $assetName));
			else
				$result->set( $action, true );
			
		}
		
		return $result;
	}
	
	
	/**
	 * Gets variable with cmd filter
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $var: variable name
	 * @param		mixed		- $default: value to use if not set
	 * @param		string		- $hash: where to get the variable from
	 * 
	 * @return		mixed value of variable or default
	 * @since		2.4.0
	 */
	public function getCmd( $var, $default = null, $hash = 'default' )
	{
		return self :: get( $var, $default, $hash, 'cmd' );
	}
	
	
	public function getMethod( $name = 'POST' )
	{
		if ( version_compare( JVERSION, '1.7.1', 'ge' ) ) {
			$app	= & JFactory :: getApplication();
			$data	= $app->input->$name;
			$data	= $data->getArray( array( 'data' ) );
		}
		else {
			
		}
		//echo '<pre>'.print_r($data,1) . '</pre>';
		return $data;
	}
	
	
	/**
	 * Retrieves a set of variables for the session based upon passed token
	 * @access	public
	 * @version	2.3.0
	 * @param 	string		$token - contains the token to search by
	 * 
	 * @return	Array containing variables retrieved or false on error
	 * @since	2.0.0
	 */
	public function getSession( $token )
	{
		$db		= & JFactory::getDBO();
		$query	= "SELECT `value` FROM #__jwhmcs_sess WHERE token={$db->quote($token)}";
		$db->setQuery($query);
		
		if (! ( $result = $db->loadResult() ) ) {
			return false;
		}
		
		$tmp	= preg_split('/\n/', $result);
		$data	= array();
		
		foreach ($tmp as $t) {
			$var = explode('=', $t);
			$k = $var[0];
			array_shift( $var );
			$data[$k] = implode("=", $var);
			unset($var, $k);
		}
		
		$query = 'DELETE FROM #__jwhmcs_sess WHERE token="'.$token.'"';
		$db->setQuery($query);
		$res = $db->query();
		
		return $data;
	}
	
	
	/**
	 * Retrieves a WHMCS client or contact
	 * @access	public
	 * @version	2.3.0
	 * @param	mixed		$method - can be an email address or an integer representing the whmcs id / contact id
	 * @param	string		$by:	email || id
	 * @param	string		$type:  client || contact
	 * 
	 * @return	Array containing the user data from WHMCS or false on error or failure
	 * @since   2.0.0
	 */
	public function getWhmcsUser($method, $by = 'email', $type = 'client' )
	{
		$db		= & JFactory::getDBO();
		$jcurl	= & JwhmcsCurl::getInstance();
		$params	= & JwhmcsParams::getInstance();
		
		switch($type):
		case 'client':
			if ($by == 'email') {
				$jcurl->setAction('getclientsdatabyemail', array('email' => $method));
			}
			else {
				$jcurl->setAction('getclientsdata', array('clientid' => $method));
			}
		
			$whmcs	= $jcurl->loadResult();
			
			// WHMCS v421:  Now receive array of array -- need to test for it
			if ( isset($whmcs[0]['result']) ) $whmcs = $whmcs[0];
			
			if (( isset($whmcs['result'])) && ($whmcs['result'] == 'success')) {
				$whmcs['xref_type'] = 'client';
				$ret = $whmcs;
			}
			else {
				$ret = false;
			}
			
			break;
		case 'contact':
			
			$jcurl->setAction('jwhmcsgetcontact', array("get" => "$by=$method"));
			$whmcs = $jcurl->loadResult();
			
			if ($whmcs['result'] == 'success') {
				$whmcs['userid'] = $whmcs['id'];
				$whmcs['xref_type'] = 'contact';
				$ret = $whmcs;
			}
			else {
				$ret = false;
			}
			break;
		endswitch;
		
		return $ret;
	}
	
	
	/**
	 * Checks a hash that is passed along for security purposes
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		2.4.6
	 */
	public function hashCheck()
	{
		$params		= & JwhmcsParams :: getInstance();
		$signature	=   JwhmcsHelper :: get( 'signature' );
		$salt		=   JwhmcsHelper :: get( 'salt' );
		$secret		=   $params->get( 'Secret' );
		$generated	=   base64_encode( hash_hmac( 'sha256', $salt, $secret, true ) );
		
		return $generated == $signature;
	}
	
	
	/**
	 * Determines if a username is actually an email address
	 * @access	public
	 * @version	2.3.0
	 * @param 	string		$username - Contains suspect username
	 * 
	 * @return	True if email, false if not
	 * @since	2.0.0
	 */
	public function isEmail( $username )
	{
		$pattern = "/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,5}\b/i";
		$match = preg_match( $pattern, $username );
		
		return ( $match > 0 );
	}
	
	
	/**
	 * Handles the redirection of the application across versions
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $url: the fully qualified URL to go to
	 * 
	 * @return		true (J!2.5+)
	 * @since		2.4.12
	 */
	public function redirect( $url )
	{
		$app	= & JFactory::getApplication();
		
		// Joomla! 2.5+ we grab the controller to redirect
		if ( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
			include_once( JPATH_SITE . DS . 'components' . DS . 'com_jwhmcs' . DS . 'controller.php' );
			$controller = & JwhmcsController :: getInstance( 'Jwhmcs' );
				
			if ( $controller->getName() == 'users' ) {
				$app->setUserState('users.login.form.return', $url );
			}
			else {
				$controller->setRedirect( $url );
			}
			return true;
		}
		// Joomla! 1.5 - just go already
		else {
			$app->redirect( $url );
			$app->close();
		}
	}
	
	
	/**
	 * Sends an email to a newly registered user
	 * @access	public
	 * @version	2.3.0
	 * @param	object		$user - JUser object
	 * @param	string		$password - the clear text password to send in the email
	 * 
	 * @since	2.3.0
	 */
	public function sendMail($from, $fromname, $recipient, $subject, $body, $mode = 0, $cc = null, $bcc = null, $attachment = null, $replyto = null, $replytoname = null )
	{
		if ( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
			$mail = JFactory::getMailer();
			$mail->sendMail( $from, $fromname, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyto, $replytoname);
			return;
		}
		else {
			JUtility::sendMail( $from, $fromname, $recipient, $subject, $body);
			return;
		}
	}
	
	
	/**
	 * Common Setter function
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $name: name of variable to set
	 * @param		mixed		- $value: value to set
	 * @param		string		- $hash: (<J1.7) where to set variable
	 * @param		bool		- $overwrite: (<J1.7) overwrite or note
	 *
	 * @return		mixed previous or null if not previously set
	 * @since		2.4.0
	 */
	public function set( $name, $value, $hash = 'method', $overwrite = true )
	{
		if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
			$app	= & JFactory :: getApplication();
			$prev	=   $app->input->get( $name, $value );
			$app->input->set( $name, $value );
			return $prev;
		}
		else if ( version_compare( JVERSION, '1.7.1', 'ge' ) ) {
			$app	= & JFactory :: getApplication();
			$prev	=   $app->get( $name );
			$app->input->set( $name, $value );
			return $prev;
		}
		else {
			return JRequest :: setVar( $name, $value, $hash, $overwrite );
		}
	}
	
	
	/**
	 * Stores the session to the database returning an identifying token
	 * @access	public
	 * @version	2.3.0
	 * @param	array		$values - an associative array containing values to store
	 * 
	 * @return	String containing token to identify with
	 * @since	2.0.0
	 */
	public function storeSession($values = null)
	{
		$db =& JFactory::getDBO();
		
		// Create a new token
		if ( version_compare( JVERSION, '2.5.6', 'ge' ) ) {
			$token = JSession :: getFormToken( true );
		}
		else {
			$token = JUtility::getToken( true );
		}
		
		if (!is_null($values)) {
			foreach ($values as $k => $v) {
				$val[] = $k.'='.$v;
			}
			$value = implode("\n", $val);
		}
		else {
			$value = null;
		}
		
		// Store UID, UEM and UPW in database for retrieval
		$query = 'INSERT INTO `#__jwhmcs_sess` (`token`, `value`) '
					.'VALUES ("'.$token.'", "'.$value.'")';
		$db->setQuery($query);
		$db->query();
		
		return $token;
	}
}


