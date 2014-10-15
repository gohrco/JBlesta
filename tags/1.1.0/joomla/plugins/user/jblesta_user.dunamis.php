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
 * Define the J!Blesta version here
 */
if (! defined( 'DUN_MOD_JBLESTA' ) ) define( 'DUN_MOD_JBLESTA', "@fileVers@" );
if (! defined( 'DUN_MOD_JBLESTA_USER' ) ) define( 'DUN_MOD_JBLESTA_USER', "@fileVers@" );


/**
 * JBlesta User Plugin Dunamis Extension
 * @desc		This is used to access settings for the user plugin in Dunamis
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Jblesta_userDunModule extends DunModule
{
	/**
	 * Initializes the class
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function initialise()
	{
		
	}
}