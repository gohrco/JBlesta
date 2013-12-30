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
 * JBlesta Update class
 * @desc		This class handles updates within Joomla for J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaUpdate
{
	
	/**
	 * Method to create a sorted list of updates to display to user in update view
	 * @access		public
	 * @version		@fileVers@
	 * @param		bool		- $force: indicates that the update should be forcibly retrieved
	 * 
	 * @return		array
	 * @since		1.0.0
	 */
	public function getSortedList( $force = false )
	{
		$updates	= self :: getUpdateInformation( $force );
		$data		= array( 'component' => array(), 'file' => array(), 'plugin' => array(), 'action' => false );
		
		foreach ( $updates as $element => $update ) {
			$c		= $update['config'];
			$u		= $update['update'];
			$temp	= array( 'name' => $c->get( '_extensionTitle' ), 'version' => 'Extension is current' );
			switch ( $c->get( '_extensionType', null ) ) {
				case 'component':
					if ( $u->hasupdate ) {
						$temp['version']	= $update['update']->version . ' (' . $update['update']->stability . ')';
						$data['action'] = true;
					}
					$data['component'][] = $temp;
					break;
				case 'file':
					if ( $element == 'file_whmcs_jblesta' ) {
						if ( $u->hasupdate ) {
							$temp['version'] = $u->version . ' (' . $u->stability . ')';
							$data['action'] = true;
						}
						$data['file'][] = $temp;
					}
					break;
				case 'plugin':
					if ( $u->hasupdate ) {
						$temp['version']	= $u->version . ' (' . $u->stability . ')';
						$data['action'] = true;
					}
					
					$data['plugin'][] = $temp;
					break;
				case 'module' : 
					if ( $u->hasupdate ) {
						$temp['version']	= $u->version . ' (' . $u->stability . ')';
						$data['action'] = true;
					}
						
					$data['module'][] = $temp;
					break;
			}
		}
		
		return $data;
	}
	
	
	/**
	 * Method to retrieve the updates from the Go Higher site
	 * @access		public
	 * @version		@fileVers@
	 * @param		bool		- $force: indicates that the update should be forcibly retrieved
	 * 
	 * @return		array
	 * @since		1.0.0
	 */
	public function getUpdateInformation( $force = false )
	{
		require_once( dirname(__FILE__) . DS . 'classes' . DS . 'fetch.php' );
		
		$update	= new JblestaUpdateFetch();
		$info	= $update->getUpdateInformation( $force );
		
		return $info;
	}
	
	
	/**
	 * Method to check to see if there are updates to apply
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		integer
	 * @since		1.0.0
	 */
	public function hasUpdates( $force = false )
	{
		$updates	= self :: getUpdateInformation( $force );
		$exists		= 0;
		
		foreach ( $updates as $data ) {
			if ( $data['update']->stuck == 1 ) {
				$exists = -2;
			}
			else if ( $data['update']->hasupdate == 1 ) {
				$exists = 1;
				break;
			}
		}
		
		return $exists;
	}
}