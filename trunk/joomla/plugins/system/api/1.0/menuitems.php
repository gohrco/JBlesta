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
 * JBlesta System Plugin API Menu Items
 * @desc		This file handles the retrieval of menu items through our API
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class MenuitemsJblestaAPI extends JblestaAPI
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
		$db			=	dunloader( 'database', true );
		$children	=   array();
		
		mysql_set_charset( 'utf8' );
		
		$query = 'SELECT menutype, title' .
				' FROM #__menu_types' .
				' ORDER BY title';
		$db->setQuery( $query );
		$menuTypes = $db->loadObjectList();
		
		if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
			$query = 'SELECT id, parent_id, title as name, title, menutype, type, link, lft as ordering FROM #__menu WHERE published = 1';
		}
		else if ( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
			$query = 'SELECT id, parent_id, title as name, title, menutype, type, link, ordering FROM #__menu WHERE published = 1';
		}
		else {
			$query = 'SELECT id, parent, parent as parent_id, name, name as title, menutype, type, link, ordering, sublevel FROM #__menu WHERE published = 1';
		}
		
		$db->setQuery($query);
		$menuItems = $db->loadObjectList();
		
		if ($menuItems)
		{
			foreach ($menuItems as $v)
			{
				$pt 	= $v->parent_id;
				$list 	= @$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;
			}
		}
		
		$list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0 );
		
		$n = count( $list );
		$groupedList = array();
		foreach ($list as $k => $v) {
			if ( empty( $v->menutype ) ) continue;
			$groupedList[$v->menutype][] = &$list[$k];
		}
		
		// Reorganize Menutypes
		$mt	=	array();
		foreach ( $menuTypes as $type ) {
			if (! isset( $mt[$type->menutype] ) ) $mt[$type->menutype] = $type->title;
		}
		
		$return	=	(object) array( 'menuitems' => base64_encode( serialize( $groupedList ) ), 'version' => DUN_ENV_VERSION, 'menutypes' => base64_encode( serialize( $mt ) ) );
		$this->success( $return );
	}
}