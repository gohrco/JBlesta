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


/**
 * JBlesta Admin Management
 * @desc		This is class is used to manage the plugin in Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class AdminManagePlugin extends AppController
{
	
	/**
	 * Alias method for our index location
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function home()
	{
		return $this->index();
	}
	
	
	/**
	 * Method to call up the index area of J!Blesta
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		HTML content for view
	 * @since		1.0.0
	 */
	public function index()
	{
		dunmodule( 'jblesta.admin' );
		$controller = dunmodule( 'jblesta.default' );
		$controller->execute();
		
		return $controller->render();
	}
	
	
	/**
	 * Method to call up the license area of J!Blesta
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		HTML content for view
	 * @since		1.0.0
	 */
	public function license()
	{
		dunmodule( 'jblesta.admin' );
		$controller = dunmodule( 'jblesta.license' );
		$controller->execute();
		
		return $controller->render();
	}
	
	
	/**
	 * Method to call up the settings area of J!Blesta
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		HTML content for view
	 * @since		1.0.0
	 */
	public function settings()
	{
		dunmodule( 'jblesta.admin' );
		$controller = dunmodule( 'jblesta.settings' );
		$controller->execute();
		
		return $controller->render();
	}
	
	
	/**
	 * Method to call up the system check area of J!Blesta
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		HTML content for view
	 * @since		1.0.0
	 */
	public function syscheck()
	{
		dunmodule( 'jblesta.admin' );
		$controller = dunmodule( 'jblesta.syscheck' );
		$controller->execute();
		
		return $controller->render();
	}
	
	
	/**
	 * Method to call up the updates area of J!Blesta
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		HTML content for view
	 * @since		1.0.0
	 */
	public function updates()
	{
		dunmodule( 'jblesta.admin' );
		$controller = dunmodule( 'jblesta.updates' );
		$controller->execute();
	
		return $controller->render();
	}
}
