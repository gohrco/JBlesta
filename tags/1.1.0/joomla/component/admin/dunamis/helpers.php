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

/**
 * Function for building a full name based on the Blesta user data
 * @version		@fileVers@
 * @param		object		The user object from Blesta to use
 *
 * @return		string
 * @since		1.0.0
 */
if (! function_exists( 'build_fullname' ) ) {
function build_fullname( $user )
{
	$user	=	(object) $user;
	$name	=	"{$user->first_name} {$user->last_name}";
	
	return $name;
}
}

/**
 * Function for building a username based on J!Blesta settings
 * @version		@fileVers@
 * @param		array		The user array from Blesta to use
 *
 * @return		string
 * @since		1.0.0
 */
if (! function_exists( 'build_username' ) ) {
	function build_username( $user )
	{
		$user	=	(object) $user;
		$config	=	dunloader( 'config', 'com_jblesta' );
		$input	=	dunloader( 'input', true );
		$name	=	null;
		
		switch ( $config->get( 'useraddusernamepattern', 1 ) ) :
		// Create the username as `firstname.lastname`
		case '0' :
			$name	=	"{$user->first_name}.{$user->last_name}";
		break;
		// Create the username as `lastname.firstname`
		case '1' :
			$name	=	"{$user->last_name}.{$user->first_name}";
			break;
			// Create the username as `random`
		default :
		case '2' :
			for ($i=0; $i<12; $i++) {
				$d = rand(1,30)%2;
				$name	.=	( $d ? chr(rand(65,90)) : chr(rand(48,57)));
			}
			$name	=	ucfirst(strtolower($user));
			break;
			// Create the username as `f.lastname`
		case '4' :
			$name	=	substr($user->first_name, 0, 1).".{$user->last_name}";
			break;
			// Create the username as `firstname.l`
		case '8' :
			$name	=	"{$user->first_name}.".substr($user->last_name, 0, 1);
			break;
			// Create the username as `firstname`
		case '16' :
			$name	=	"{$user->first_name}";
			break;
			// Create the username as `lastname`
		case '32' :
			$name	=	"{$user->last_name}";
			break;
			// Create the username as their email address
		case '64' :
			$name	=	"{$user->email}";
			break;
		endswitch;
		

		return $name;
	}
}