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

// Initialize the WHMCS system
$rootpath	= dirname( dirname( dirname( dirname(__FILE__) ) ) ) . DIRECTORY_SEPARATOR;

// If we still have dbconnect
if ( file_exists( $rootpath . 'dbconnect.php' ) ) {
	require( $rootpath . "dbconnect.php" );
	require( $rootpath . "includes/functions.php" );
	require( $rootpath . "includes/clientareafunctions.php" );
}
// Else we may be in WHMCS v5.2
else {
	require( $rootpath . 'init.php' );
}

/*-- Dunamis Inclusion --*/
$path		= $rootpath . 'includes' . DIRECTORY_SEPARATOR . 'dunamis.php';
if ( file_exists( $path ) ) include_once( $path );
/*-- Dunamis Inclusion --*/

// Initialize Belong and determine the task
$dun		=	get_dunamis( 'jwhmcs' );
$task		=	dunloader( 'input', true )->getVar( 'task', 'ping' );

/**
 * Ajax Module Class for J!WHMCS Integrator
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		2.5.0
 */
class JwhmcsAjaxDunModule extends JwhmcsAdminDunModule
{
	/**
	 * Method for executing a task
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		2.5.0
	 */
	public function execute()
	{
		
	}
	
	
	/**
	 * Initialise the object
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		2.5.0
	 * @see			JwhmcsAdminDunModule :: initialise()
	 */
	public function initialise()
	{
		$this->action = 'ajax';
		parent :: initialise();
	}
	
	
	/**
	 * Render the response back to the client
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		json encoded string
	 * @since		2.5.0
	 * @see			JwhmcsAdminDunModule :: render()
	 */
	public function render( $data = null )
	{
		$data	=	array();
		
		switch ( $this->task ) {
			// --------------------------------
			// Fix a certain template file
			case 'fixfile' :
				
				$install	=	dunmodule( 'jwhmcs.install' );
				$input		=	dunloader( 'input', true );
				
				$file	=	$input->getVar( 'file' );
				$result	=	$install->fixFile( $file );
				
				$data	=	array(
						'state'	=> ( $result ? 1 : 0 ),
						'span'	=> t( 'jwhmcs.syscheck.general.yesno.' . ( $result ? 'yes' : 'no' ) ),
				);
				
				break;
				
			// --------------------------------
			// Download update
			case 'updateinstall' :
				$updates	=	dunloader( 'updates', 'jwhmcs' );
				$result		=	$updates->extract();
				$version	=	$updates->getVersion();
				
				$install = dunmodule( 'jwhmcs.install' );
				$install->upgrade();
				
				$data	=	array(
						'state'		=> 1,
						'title' 	=> t( 'jwhmcs.updates.complete.title' ),
						'subtitle'	=> sprintf( t( 'jwhmcs.updates.complete.subtitle' ), $version ),
				);
				
				break;
			// --------------------------------
			// Download update
			case 'updatedownload' :
				$updates	=	dunloader( 'updates', 'jwhmcs' );
				$result		=	$updates->download();
				$state		=	( $result ? 'download' : 'error' );
				$error		=	( $result ? $updates->getError() : null );
				
				$data	=	array(
						'state'		=> ( $result ? 1 : 0 ),
						'title' 	=> t( 'jwhmcs.updates.' . $state . '.title' ),
						'subtitle'	=> sprintf( t( 'jwhmcs.updates.' . $state . '.subtitle' ), $error ),
				);
				
				break;
			// --------------------------------
			// Initialize update
			case 'updateinit' :
				$updates	=	dunloader( 'updates', 'jwhmcs' );
				
				$data	=	array(
						'title' 	=> t( 'jwhmcs.updates.init.title' ),
						'subtitle'	=> sprintf( t( 'jwhmcs.updates.init.subtitle' ), $updates->getVersion() ),
				);
				break;
			// --------------------------------
			// Update checker
			case 'checkforupdates' :
				$updates	=	dunloader( 'updates', 'jwhmcs', array( 'force' => true ) );
				$insert		=	null;
				
				switch( $updates->exist() ) {
					case true:
						$var	=	'exist';
						$state	=	1;
						break;
					case false:
						$var	=	'none';
						$state	=	0;
						$insert	=	$updates->getVersion();
						break;
					case 'error' :
						$var	=	'error';
						$state	=	-1;
						$insert	=	$updates->getError();
						break;
				}
				
				$data	=	array(
						'state'		=> $state, 
						'title' 	=> t( 'jwhmcs.updates.' . $var . '.title' ),
						'subtitle'	=> sprintf( t( 'jwhmcs.updates.' . $var . '.subtitle' ), $insert ),
						);
				
				break;
			// --------------------------------
			// Product addons handler
			case 'getproductaddons' :
				$db		=	dunloader( 'database', true );
				$relid	=	dunloader( 'input', true )->getVar( 'relid' );
				
				// Start with no addon response
				$data[]	=	array( 'id' => 0, 'name' => t( 'jwhmcs.admin.form.prodaddon.option.none' ) );
				
				// First go through all addons and find addons that are selected for the requested relid
				$db->setQuery( "SELECT * FROM `tbladdons`" );
				$result	=	$db->loadObjectList();
				
				foreach ( $result as $row ) {
					$pids	=	explode( ',', $row->packages );
					if (! in_array( $relid, $pids ) ) continue;
					$data[]	=	array( 'id' => $row->id, 'name' => $row->name );
				}
				
				// Now find the support addon for licensing products
				$db->setQuery( "SELECT p.configoption7 FROM `tblproducts` p WHERE p.id = " . $db->Quote( $relid ) . " AND p.servertype = 'licensing'" );
				
				if ( ( $result = $db->loadObjectList() ) != null ) {
					$parts			=	explode( "|", $result );
					$id				=	array_shift( $parts );
					$add_to_array	=	true;
					
					foreach ( $data as $line ) {
						if ( $line['id'] == $id ) {
							$add_to_array	=	false;
							break;
						}
					}
					
					if ( $add_to_array ) {
						$data[]	=	array( 'id' => $id, 'name' => implode( "|", $parts ) );
					}
				}
				
				break;
			case 'ping' :
				$data	= array( 'data' => 'pong' );
				break;
		}
		
		return json_encode( $data );
	}
}

/**
 * Here we are actually calling the module up
 */
$module	= new JwhmcsAjaxDunModule();
$module->initialise();
$module->execute();
echo $module->render();