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

// Deny direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * JblestaControllerAjax class handles ajax calls from the backend
 * @version		@fileVers@
 *
 * @since		1.0.0
 * @author		Steven
 */
class JblestaControllerAjax extends JblestaControllerExt
{

	/**
	 * Constructor task
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	
	/**
	 * Task for checking the apicnxn through ajax
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function apicnxncheck()
	{
		$app	=	JFactory :: getApplication();
		$model	=   $this->getModel( 'ajax' );
		$data	=	$model->apicnxncheck();
		
		// Save settings
		$config	=	dunloader( 'config', 'com_jblesta' );
		$config->save();
		
		echo json_encode( $data );
		$app->close();
	}
	
	
	/**
	 * Task for checking updates for the product
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function checkforupdates()
	{
		$app	=	JFactory :: getApplication();
		$model	=   $this->getModel( 'updates' );
		$data	=	$model->getData();
		$status	=	( $data->hasupdates === true ? '1' : ( $data->hasupdates === false ? '0' : '-2' )  );
		$msg	=   JText :: _( 'COM_JBLESTA_CHECKUPDATE_' . $status );
		
		echo json_encode( array( 'result' => 'success', 'message'=> $msg, 'updates' => $status ) );
		$app->close();
	}
	
	
	/**
	 * Task for completing an update
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function updatecomplete()
	{
		$app	=	JFactory :: getApplication();
		$model	=   $this->getModel( 'updates' );
		$data	=	$model->updatecomplete();
	
		echo json_encode( array( 'result' => 'success', 'message' => $data->message, 'state' => $data->state ) );
		$app->close();
	}
	
	
	/**
	 * Task for downloading the updates from our servers
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function updatedownload()
	{
		$app	=	JFactory :: getApplication();
		$model	=   $this->getModel( 'updates' );
		$data	=	$model->updateDownload();
		
		echo json_encode( array( 'result' => 'success', 'message' => $data->message, 'state' => $data->state ) );
		$app->close();
	}
	
	
	/**
	 * Task for initializing the update routine
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function updateinit()
	{
		$app	=	JFactory :: getApplication();
		$model	=   $this->getModel( 'updates' );
		$data	=	$model->updateInit();
		
		echo json_encode( array( 'result' => 'success', 'message' => $data ) );
		$app->close();
	}
}