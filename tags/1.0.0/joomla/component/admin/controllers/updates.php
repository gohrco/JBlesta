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

/*-- Security Protocols --*/
defined( '_JEXEC' ) or die( 'Restricted access' );
/*-- Security Protocols --*/

/*-- File Inclusions --*/
if ( file_exists( $path = JPATH_COMPONENT_ADMINISTRATOR . DS . 'update' . DS . 'update.php' ) )
	require_once( $path );
/*-- File Inclusions --*/

/**
 * Jblesta Rules Controller
 * @author		Steven
 * @version		@fileVers@
 * 
 * @since		1.0.0
 */
class JblestaControllerUpdates extends JblestaControllerExt
{
	
	/**
	 * Task that beings the update procedure
	 * @access		public
	 * 
	 * @since		1.0.0
	 */
	public function begin()
	{
		$result		= $this->setCredentials();
		
		// We must supply FTP creds still so throw an error
		if ( $result === true ) {
			JError::raiseWarning('SOME_ERROR_CODE', JText :: _( 'COM_JBLESTA_UPDATES_CREDENTIALS_MISSING' ) );
			$this->setRedirect( 'index.php?option=com_jblesta&controller=updates&view=updates' );
			$this->redirect();
		}
		else if ( $result === false ) {
			JError::raiseWarning('SOME_ERROR_CODE', JText :: _( 'COM_JBLESTA_UPDATES_FTPCREDENTIALS_MISSING' ) );
			$this->setRedirect( 'index.php?option=com_jblesta&controller=updates&view=updates' );
			$this->redirect();
		}
		else {
			$this->setRedirect( 'index.php?option=com_jblesta&controller=updates&view=updates&task=download' );
			$this->redirect();
		}
	}
	
	
	/**
	 * Task to display the appropriate layout for J!WHMCS
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 * @see			JblestaController::display()
	 */
	public function display()
	{
		$input	=	dunloader( 'input', true );
		$input->setVar( 'view', 'updates' );
		
		if ( version_compare( JVERSION, '3.0', 'ge' ) ) {
			JblestaHelper :: set ( 'layout', 'default35' );
		}
		else {
			JblestaHelper :: set ( 'layout', 'default' );
		}
		
		parent :: display();
	}
	
	
	/**
	 * Task that downloads the updates locally
	 * @access		public
	 * 
	 * @since		1.0.0
	 */
	public function download()
	{
		$model		= $this->getModel();
		$creds		= $this->setCredentials();
		$updates	= JblestaUpdate :: getUpdateInformation( true );
		
		foreach ( $updates as $update ) {
			if ( $update['update']->hasupdate ) {
				//$update['update']->downloadURL .= $creds;
				$update['update']->creds = $creds;
				$result	= $model->download( $update );
				
				if ( $result === false ) {
					$this->setRedirect( 'index.php?option=com_jblesta&controller=updates&view=updates' );
					$this->redirect();
				}
			}
		}
		
		$this->setRedirect( 'index.php?option=com_jblesta&controller=updates&view=updates&task=extract' );
		$this->redirect();
	}
	
	
	/**
	 * Task that extracts the updates locally
	 * @access		public
	 * 
	 * @since		1.0.0
	 */
	public function extract()
	{
		$model		=   $this->getModel();
		$updates	=   JblestaUpdate :: getUpdateInformation( true );
		
		foreach ( $updates as $update ) {
			if ( $update['update']->hasupdate ) {
				$result = $model->extract( $update );
				
				// Problem with download / extraction
				if ( $result === false ) {
					JError::raiseWarning('SOME_ERROR_CODE', JText :: sprintf( 'COM_JBLESTA_UPDATES_ERROR_EXTRACT', $update['config']->get( '_extensionTitle' ) ) );
					$this->setRedirect( 'index.php?option=com_jblesta&controller=updates&view=updates' );
					$this->redirect();
				}
			}
		}
		
		$this->setRedirect( 'index.php?option=com_jblesta&controller=updates&view=updates&task=install' );
		$this->redirect();
	}
	
	
	/**
	 * Retrieves the model for the controller
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $name: default to Update
	 * @param		string		- $prefix: default prefix to JblestaModel
	 * 
	 * @return		JblestaModelUpdate model
	 * @since		1.0.0
	 */
	public function getModel( $name = 'Update', $prefix = 'JblestaModel') 
	{
		$model = parent::getModel( $name, $prefix, array( 'ignore_request' => true ) );
		return $model;
	}
	
	
	/**
	 * Task that performs that actual update procedure
	 * @access		public
	 * 
	 * @since		1.0.0
	 */
	public function install()
	{
		$model		=   $this->getModel();
		$updates	=   JblestaUpdate :: getUpdateInformation( true );
		$overall	=   true;
		
		foreach ( $updates as $update ) {
			if ( $update['update']->hasupdate ) {
				$result = $model->install( $update );
				
				if (! $result ) {
					$model->cleanup ( $update );
					$overall = false;
				}
				else {
					$cache = JFactory::getCache( 'mod_menu' );
					$cache->clean();
				}
			}
		}
		
		$this->setRedirect( 'index.php?option=com_jblesta&controller=updates&view=updates' );
		$this->redirect();
	}
	
	
	/**
	 * Method to set the credentials for downloading from Go Higher
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $client: ftp usually
	 *
	 * @return		string containing credentials for Go Higher, true if they ARE NOT set, false if they are set but the local client needs FTP credentials to function
	 * @since		1.0.0
	 */
	private function setCredentials( $client ='ftp' )
	{
		jimport( 'joomla.application.component.helper' );
		jimport( 'joomla.client.helper' );
		
		$params	= & JblestaParams :: getInstance();
		$user	= $params->get( 'GHusername' );
		$pass	= $params->get( 'GHpassword' );
		
		if ( $user == '' || $pass == '' ) return true;
		
		if (! JClientHelper :: hasCredentials( $client ) ) {
			return false;
		}
		
		return array( 'username' => $user, 'password' => $pass );
		return '?username=' . $user . '&password=' . $pass;
	}
}