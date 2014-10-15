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
if (! defined( 'DUN_MOD_JBLESTA_AUTH' ) ) define( 'DUN_MOD_JBLESTA_AUTH', "@fileVers@" );


/**
 * JBlesta Authentication Plugin Dunamis Extension
 * @desc		This class is used to enable us to call up the plugin through Dunamis
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Jblesta_authDunModule extends DunModule
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