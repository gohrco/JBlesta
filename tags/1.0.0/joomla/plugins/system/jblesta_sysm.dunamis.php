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
 * Define the JWHMCS version here
 */
if (! defined( 'DUN_MOD_JBLESTA' ) ) define( 'DUN_MOD_JBLESTA', "@fileVers@" );
if (! defined( 'DUN_MOD_JBLESTA_SYSM' ) ) define( 'DUN_MOD_JBLESTA_SYSM', "@fileVers@" );

/**
 * JBlesta System Plugin Dunamis Extension
 * @desc		This class enables us to call up the sytem plugin settings and updates through Dunamis
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Jblesta_sysmDunModule extends DunModule
{
	public function initialise()
	{
		
	}
}