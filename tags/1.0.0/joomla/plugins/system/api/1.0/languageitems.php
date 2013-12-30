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
 * JBlesta System Plugin API Language Items
 * @desc		This file handles the retrieval of Language Items through our API
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class LanguageitemsJblestaAPI extends JblestaAPI
{
	
	/**
	 * Method for executing on the API
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function execute()
	{
		$db		=	dunloader( 'database', true );
		$query	=	"SHOW TABLES LIKE " . $db->Quote( "%languages" );
		
		mysql_set_charset( 'utf8' );
		
		$db->setQuery( $query );
		$result	=	$db->loadResult();
		
		if (! $result ) {
			$this->error( JText :: _( 'JBLESTA_SYSM_API_LANGITEMS_NOTABLE' ) );
		}
		
		$query	=	"SELECT `title` as `name`, `lang_code` as `code`, `sef` as `shortcode` FROM #__languages WHERE `published` <> '-2' ORDER BY name";
		$db->setQuery( $query );
		$langs	=	$db->loadObjectList();
		
		$return	=	(object) array( 'languageitems' => base64_encode( serialize( $langs ) ), 'version' => DUN_ENV_VERSION );
		$this->success( $return );
	}
}