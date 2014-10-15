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
 * 
 * The methods and routines within this file are based partly upon the work of
 *   Nicholas K. Dionysopoulos / AkeebaBackup.com
 * 
 */

/*-- Security Protocols --*/
defined('_JEXEC') or die();
/*-- Security Protocols --*/

/**
 * JBlesta Download Helper class
 * @desc		This class works with the updates to facilitate downloads for J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaDownloadHelper
{
	/**
	 * Stores the recently curled info for testing headers
	 * @var		array
	 */
	public static $curlinfo = null;
	
	
	/**
	 * Method to download from a url and store
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $url: the remote url to download from
	 * @param		string		- $target: the local path to download to
	 * @param		object		- $config: the JblestaUpdateConfig object containing the settings
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public static function download( $url, $target, $config, $creds = array() )
	{
		jimport('joomla.filesystem.file');
		
		if ( JFile :: exists( $target ) ) {
			if (! @unlink( $target ) ) {
				JFile::delete( $target );
			}
		}
		
		$hackPermissions = false;
		$fp = @fopen( $target, 'wb' );
		if ( $fp === false ) {
			// The file can not be opened for writing. Let's try a hack.
			$null	= '';
			if ( JFile :: write( $target, $null ) ) {
				if ( self :: chmod( $target, 511 ) ) {
					$fp = @fopen( $target, 'wb' );
					$hackPermissions = true;
				}
			}
		}
		
		$result = false;
		if ( $fp !== false ) {
			$adapters	= self :: getAdapters();
			$result		= false;
			
			while (! empty( $adapters ) && ( $result === false ) ) {
				// Run the current download method
				$method	= 'get' . strtoupper( array_shift( $adapters ) );
				$result	= self :: $method( $url, $config, $fp, false, $creds );
				
				// Check if we have a download
				if ( $result === true ) {
					// The download is complete, close the file pointer
					@fclose( $fp );
					
					// If the filesize is not at least 1 byte, we consider it failed.
					clearstatcache();
					$filesize = @filesize( $target );
					
					if ( $filesize <= 0 ) {
						$result	= false;
						$fp		= @fopen($target, 'wb');
					}
				}
				else if ( self :: $curlinfo ) {
					$info = self :: $curlinfo;
					self :: $curlinfo = false;
					//echo '<pre>'.print_r($info,1).print_r( $this,1);; die();
					if ( $info['http_code'] == 403 ) {
						JError::raiseWarning('SOME_ERROR_CODE', JText :: _( 'COM_JWHMCS_UPDATES_CREDENTIALS_INCORRECT' ) );
						return false;
					}
				}
			}
			
			// If we have no download, close the file pointer
			if ( $result === false ) {
				@fclose( $fp );
			}
		}
		
		if ( $result === false ) {
			// Delete the target file if it exists
			if ( file_exists( $target ) ) {
				if (! @unlink( $target ) ) {
					JFile :: delete( $target );
				}
			}
			
			// Download and write using JFile::write();
			$result = JFile :: write( $target, self :: downloadAndReturn( $config, $url, $creds ) );
		}
		
		// If it STILL is false then we couldn't do anything so let them know
		if ( $result === false ) {
			JError::raiseWarning('SOME_ERROR_CODE', JText :: _( 'COM_JWHMCS_UPDATES_ERROR_PERMISSIONS' ) );
		}
		
		return $result;
	}
	
	
	/**
	 * Method to download and return the update
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		object		- $config: the JblestaUpdateConfig object containing the settings
	 * @param		string		- $url: the remote url to download from
	 * 
	 * @return		mixed data containing file contents or false on error
	 * @since		1.0.0
	 */
	public static function downloadAndReturn( $config, $url = false, $creds = array() )
	{
		$adapters	= self::getAdapters();
		$result		= false;
		$url		= ( $url !== false ? $url : $config->get( '_updateUrl', null ) );
		
		while (! empty( $adapters ) && ( $result === false ) ) {
			// Run the current download method
			$method = 'get' . strtoupper( array_shift( $adapters ) );
			$result	= self::$method( $url, $config, null, false, $creds );
		}
		
		return $result;
	}
	
	
	/**
	 * Method to get the available adapters
	 * @access		private
	 * @static
	 * @version		@fileVers@
	 * 
	 * @return		array containing available adapters
	 * @since		1.0.0
	 */
	private static function getAdapters()
	{
		$adapters = array();
		if ( self::hasCURL() )	$adapters[] = 'curl';
		if ( self::hasFOPEN() )	$adapters[] = 'fopen';
		return $adapters;
	}
	
	
	/**
	 * Method to curl and return result
	 * @access		private
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $url: the url to retrieve from
	 * @param		object		- $config: the JblestaUpdateConfig object containing the settings
	 * @param		resource	- $fp: presumably a file pointer object?
	 * @param		boolean		- $nofollow: indicates if the curl handler should follow 301, 302, 303 redirects
	 * 
	 * @return		result of curl or false on error
	 * @since		1.0.0
	 */
	private static function &getCURL($url, $config, $fp = null, $nofollow = false, $creds = array() )
	{
		$result = false;
	
		$ch		= curl_init($url);
		$config->applyCACert($ch);
		$creds	= http_build_query( $creds );
		
		if (! @curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 ) && ! $nofollow ) {
			// Safe Mode is enabled. We have to fetch the headers and
			// parse any redirections present in there.
			curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
			curl_setopt( $ch, CURLOPT_FAILONERROR, true );
			curl_setopt( $ch, CURLOPT_HEADER, true );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $creds );
			
			// Get the headers
			$data = curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch);
			
			// Init
			$newURL = $url;
				
			// Parse the headers
			$lines = explode("\n", $data);
			foreach($lines as $line) {
				if(substr($line, 0, 9) == "Location:") {
					$newURL = trim(substr($line,9));
				}
			}
			
			// Download from the new URL
			if ( $url != $newURL ) {
				return self::getCURL($newURL, $config, $fp);
			} else {
				return self::getCURL($newURL, $config, $fp, true);
			}
		} else {
			@curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
		}
		
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $creds );
		// Pretend we are IE7, so that webservers play nice with us
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)');
		
		if ( is_resource( $fp ) ) {
			curl_setopt( $ch, CURLOPT_FILE, $fp );
		}
		
		$data = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		
		self :: $curlinfo = $info;
		return $data;
	}
	
	
	/**
	 * Method to use fopen and return result
	 * @access		private
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $url: the url to retrieve from
	 * @param		object		- $config: the JblestaUpdateConfig object containing the settings
	 * @param		resource	- $fp: presumably a file pointer resource
	 * 
	 * @return		result of fopen or false on error
	 * @since		1.0.0
	 */
	private static function &getFOPEN( $url, $config, $fp = null, $notused = false, $creds = array() )
	{
		$result = false;
		
		// Track errors
		if ( function_exists('ini_set') ) {
			$track_errors = ini_set( 'track_errors', true );
		}
		
		// Open the URL for reading
		if ( function_exists( 'stream_context_create' ) ) {
			// PHP 5+ way (best)
			$strcreds	= http_build_query( $creds );
			$httpopts	= array(	//'user_agent'	=> 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0',
									'method'		=> 'POST',
									'header'		=> "Content-type: application/x-www-form-urlencoded\r\n"
													 . "Content-Length: " . strlen( $strcreds ). "\r\n",
									'content'		=> $strcreds
					);
			
			//$httpopts = Array('user_agent'=>'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)');
			$context = stream_context_create( array( 'http' => $httpopts ) );
			$ih = @fopen($url, 'r', false, $context);
		}
		else {
			// PHP 4 way (actually, it's just a fallback as we can't run Admin Tools in PHP4)
			if( function_exists('ini_set') ) {
				ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)');
			}
			$ih = @fopen($url, 'r');
		}
		
		// If fopen() fails, abort
		if (! is_resource( $ih ) ) {
			return $result;
		}
		
		// Try to download
		$bytes = 0;
		$result = true;
		$return = '';
		while (! feof( $ih ) && $result ) 
		{
			$contents = fread( $ih, 4096 );
			if ( $contents === false ) {
				@fclose( $ih );
				$result = false;
				return $result;
			}
			else {
				$bytes += strlen( $contents );
				if ( is_resource( $fp ) ) {
					$result = @fwrite( $fp, $contents );
				}
				else {
					$return .= $contents;
					unset( $contents );
				}
			}
		}
		
		@fclose( $ih );
		
		if( is_resource( $fp ) ) {
			return $result;
		}
		elseif( $result === true ) {
			return $return;
		}
		else {
			return $result;
		}
	}
	
	
	/**
	 * Method to see if we have curl active
	 * @access		private
	 * @static
	 * 
	 * @return		boolean
	 * @since		1.0.0	
	 */
	private static function hasCURL()
	{
		static $result = null;
		
		if ( is_null( $result ) ) {
			$result = function_exists( 'curl_init' );
		}
		
		return $result;
	}
	
	
	/**
	 * Method to see if we have fopen active
	 * @access		private
	 * @static
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	private static function hasFOPEN()
	{
		static $result = null;
		
		if ( is_null( $result ) ) {
			// If we are not allowed to use ini_get, we assume that URL fopen is disabled.
			if (! function_exists( 'ini_get' ) ) {
				$result = false;
			}
			else {
				$result = ini_get( 'allow_url_fopen' );
			}
		}
		
		return $result;
	}
	
	
	/**
	 * Method to change file permissions
	 * @access		public
	 * @static
	 * @param		string		- $path: path to file or directory to chmod
	 * @param		mixed		- $mode: the setting to chmod to
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public static function chmod( $path, $mode )
	{
		if ( is_string( $mode ) ) {
			$mode = octdec($mode);
			if ( ( $mode < 0600 ) || ( $mode > 0777 ) ) $mode = 0755;
		}
		
		// Initialize variables
		jimport('joomla.client.helper');
		$ftpOptions = JClientHelper :: getCredentials( 'ftp' );
		
		// Check to make sure the path valid and clean
		$path = JPath :: clean( $path );
		
		if ( $ftpOptions['enabled'] == 1 ) {
			// Connect the FTP client
			jimport( 'joomla.client.ftp' );
			$ftp = &JFTP :: getInstance(
					$ftpOptions['host'], $ftpOptions['port'], null,
					$ftpOptions['user'], $ftpOptions['pass']
			);
		}
	
		if ( @chmod( $path, $mode ) ) {
			$ret = true;
		}
		elseif ( $ftpOptions['enabled'] == 1 ) {
			// Translate path and delete
			jimport('joomla.client.ftp');
			$path = JPath :: clean( str_replace( JPATH_ROOT, $ftpOptions['root'], $path ), '/' );
			// FTP connector throws an error
			$ret = $ftp->chmod( $path, $mode );
		}
		else {
			return false;
		}
	}
}