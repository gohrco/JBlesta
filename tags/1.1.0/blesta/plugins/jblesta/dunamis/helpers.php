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


/**
 * Function for building a name based on J!Blesta settings
 * @version		@fileVers@
 * @param		stdClass			Preassembled post or user data
 *
 * @return		string
 * @since		1.0.0
 */
if (! function_exists( 'build_name' ) ) {
	function build_name( $user )
	{
		$config	=	dunloader( 'config', 'jblesta' );
		$manner	=	$config->get( 'namestyle', '1' );
		$name	=	null;

		switch ( $manner ) :
		// Create the name as Firstname Lastname (Companyname)
		case '2' :
			$name	=	( isset( $user->company ) && ! empty( $user->company ) ? " ({$user->company})" : null );
		// Create the name as Firstname Lastname
		default:
		case '1' :
			$name	=	"{$user->first_name} {$user->last_name}" . $name;
		break;
		// Create the name as Lastname, Firstname (Companyname)
		case '4' :
			$name	=	( isset( $user->company ) && ! empty( $user->company ) ? " ({$user->company})" : null );
			// Create the name as Lastname, Firstname
		case '3' :
			$name	=	"{$user->last_name}, {$user->first_name}" . $name;
			break;
		
		endswitch;

		return $name;
	}
}


/**
 * Function for building a username based on J!Blesta settings
 * @version		@fileVers@
 * @param		stdClass			Preassembled post or user data
 *
 * @return		string
 * @since		1.0.0
 */
if (! function_exists( 'build_username' ) ) {
	function build_username( $user )
	{
		$config	=	dunloader( 'config', 'jblesta' );
		$manner	=	$config->get( 'usernamestyle', '3' );
		$name	=	null;
		
		switch ( $manner ) :
		// Create the username as `firstname.lastname`
		case '1' :
			$name	=	"{$user->first_name}.{$user->last_name}";
		break;
		// Create the username as `lastname.firstname`
		case '2' :
			$name	=	"{$user->last_name}.{$user->first_name}";
			break;
			// Create the username as `random`
		default :
		case '3' :
			for ($i=0; $i<12; $i++) {
				$d = rand(1,30)%2;
				$name	.=	( $d ? chr(rand(65,90)) : chr(rand(48,57)));
			}
			$name	=	ucfirst(strtolower( $name ) );
			break;
			// Create the username as `f.lastname`
		case '4' :
			$name	=	substr($user->first_name, 0, 1).".{$user->last_name}";
			break;
			// Create the username as `firstname.l`
		case '5' :
			$name	=	"{$user->first_name}.".substr($user->last_name, 0, 1);
			break;
			// Create the username as `firstname`
		case '6' :
			$name	=	"{$user->first_name}";
			break;
			// Create the username as `lastname`
		case '7' :
			$name	=	"{$user->last_name}";
			break;
			// Create the username as their email address
		case '8' :
			$name	=	"{$user->email}";
			break;
			endswitch;

		return $name;
	}
}


/**
 * Common method for determining if we should perform a given task
 * @version		@fileVers@
 * @param		string			The type of activity we are checking for [user|visual]
 *
 * @return		boolean
 * @since		1.0.0
 */
if (! function_exists( 'ensure_active' ) ) {
	function ensure_active( $type = 'user' )
	{
		$license	=	dunloader( 'license', 'jblesta' );
		$config		=	dunloader( 'config', 'jblesta' );
		$input		=	dunloader( 'input', true );
		
		// Check our license first..
		if (! $license->isValid() ) {
			return false;
		}

		if ( $type == 'user' ) {
			// If we are disabled don't run ;-)
			if (! $config->get( 'enable', false ) || ! $config->get( 'userenable', false ) ) {
				return false;
			}
			return true;
		}
		else if ( $type == 'visual' ) {
			// If we are disabled don't run ;-)
			if (! $config->get( 'enable', false ) || ! $config->get( 'visualenable', false ) ) {
				return false;
			}
			
			if ( $input->getVar( 'jblesta', false, 'get', 'string' ) == 'No' ) {
				return false;
			}
			
			return true;
		}
		else if ( $type == 'login' ) {
			// If we are disabled don't run ;-)
			if (! $config->get( 'enable', false ) || ! $config->get( 'loginenable', false ) ) {
				return false;
			}
			return true;
		}
		else if ( $type == 'license' ) {
			// If we passed our valid test earlier, we must be true
			return true;
		}

		return false;
	}
}


/**
 * Function to get the short version number
 * @version		@fileVers@
 * 
 * @return		string
 * @since		1.0.0
 */
if (! function_exists( 'get_version' ) ) {
	function get_version()
	{
		static $version = null;
		
		if ( $version == null ) {
			$curversion	=	substr( DUN_ENV_VERSION, 0, 3 );
			
			$path	=	dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR
					.	'templates' . DIRECTORY_SEPARATOR;
			
			if ( is_dir( $path . $curversion ) ) {
				$version	=	$curversion;
			}
			else {
				$dh		=	opendir( $path );
				$dirs	=	array();
				while ( false !== ( $file = readdir( $dh ) ) ) {
					if ( in_array( $file, array( '.', '..' ) ) ) continue;
					if (! is_dir( $path . DIRECTORY_SEPARATOR . $file ) ) continue;
					$dirs[]	=	$file;
				}
				rsort( $dirs );
				$version	=	array_shift( $dirs );
			}
		}
		
		return $version;
	}
}


/**
 * Function for determining if the version of the environment is supported
 * @version		@fileVers@
 * 
 * @return		boolean
 * @since		1.0.0
 */
if (! function_exists( 'is_supported' ) ) {
	function is_supported()
	{
		$curversion	=	substr( DUN_ENV_VERSION, 0, 3 );
		return $curversion == get_version();
	}
}


/**
 * Function to test to see if a string is UTF8 or not
 * @version		@fileVers@
 * @param		string			The string we are testing
 *
 * @return		boolean
 * @since		1.0.0
 */
if (! function_exists( 'is_utf8' ) ) {
	function is_utf8( $Str )
	{
		for ($i=0; $i<strlen($Str); $i++) {
			if ( ord($Str[$i]) < 0x80 ) continue;			# 0bbbbbbb
			elseif ( (ord($Str[$i]) & 0xE0) == 0xC0 ) $n=1; # 110bbbbb
			elseif ( (ord($Str[$i]) & 0xF0) == 0xE0 ) $n=2; # 1110bbbb
			elseif ( (ord($Str[$i]) & 0xF8) == 0xF0 ) $n=3; # 11110bbb
			elseif ( (ord($Str[$i]) & 0xFC) == 0xF8 ) $n=4; # 111110bb
			elseif ( (ord($Str[$i]) & 0xFE) == 0xFC ) $n=5; # 1111110b
			else return false; # Does not match any model

			for ( $j=0; $j<$n; $j++ ) {
				# n bytes matching 10bbbbbb follow ?
				if ( (++$i == strlen($Str)) || ((ord($Str[$i]) & 0xC0) != 0x80) ) {
					return false;
				}
			}
		}
		return true;
	}
}


/**
 * Function to get the short version number
 * @version		@fileVers@
 *
 * @return		string
 * @since		1.0.0
 */
if (! function_exists( 'get_version' ) ) {
function get_version()
{
	static $version = null;

	if ( $version == null ) {
		$curversion	=	substr( DUN_ENV_VERSION, 0, 3 );

		$path	=	dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR
		.	'templates' . DIRECTORY_SEPARATOR;

		if ( is_dir( $path . $curversion ) ) {
			$version	=	$curversion;
		}
		else {
			$dh		=	opendir( $path );
			$dirs	=	array();
			while ( false !== ( $file = readdir( $dh ) ) ) {
				if ( in_array( $file, array( '.', '..' ) ) ) continue;
				if (! is_dir( $path . DIRECTORY_SEPARATOR . $file ) ) continue;
				$dirs[]	=	$file;
			}
			rsort( $dirs );
			$version	=	array_shift( $dirs );
		}
	}

	return $version;
}
}