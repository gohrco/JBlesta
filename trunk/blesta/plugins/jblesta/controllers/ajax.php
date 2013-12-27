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
 * JBlesta Ajax Controller
 * @desc		This class is called up through ajax requests
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Ajax extends JblestaController
{
	/**
	 * Method for checking for updates on Go Higher
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		false			After echoing json data out
	 * @since		1.0.0
	 */
	public function checkforupdates()
	{
		if (! $this->isAjax() ) {
			$this->redirect();
		}
		
		$updates	=	dunloader( 'updates', 'jblesta', array( 'force' => true ) );
		
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
				'title' 	=> t( 'jblesta.updates.' . $var . '.title' ),
				'subtitle'	=> sprintf( t( 'jblesta.updates.' . $var . '.subtitle' ), $insert ),
		);
		
		$this->outputAsJson( $data );
		return false;
	}
	
	
	/**
	 * Method to fix a template file
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		false to kill output
	 * @since		1.0.0
	 */
	public function fixfile()
	{
		if (! $this->isAjax() ) {
			$this->redirect();
		}
		
		get_dunamis( 'jblesta' );
		$install	=	dunmodule( 'jblesta.install' );
		$input		=	dunloader( 'input', true );
		$file		=	$input->getVar( 'file' );
		$result		=	$install->fixFile( $file );
		
		$data	=	array(
				'state'		=>	( $result === true ? 1 : 0 ),
				'span'		=>	t( 'jblesta.syscheck.general.yesno.' . ( $result === true ? 'yes' : 'no' ) ),
				'message'	=>	( $result !== true ? $result : null ),
		);
		
		$this->outputAsJson( $data );
		return false;
	}
	
	
	/**
	 * Method to return nothing in case someone comes here
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		false
	 */
	public function index()
	{
		return false;
	}
	
	
	/**
	 * Method for downloading an update from Go Higher
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		false			After echoing json data out
	 * @since		1.0.0
	 */
	public function updatedownload()
	{
		if (! $this->isAjax() ) {
			$this->redirect();
		}
		
		$updates	=	dunloader( 'updates', 'jblesta' );
		$result		=	$updates->download();
		$state		=	( $result ? 'download' : 'error' );
		$error		=	( $result ? $updates->getError() : null );
		
		$data	=	array(
				'state'		=> ( $result ? 1 : 0 ),
				'title' 	=> t( 'jblesta.updates.' . $state . '.title' ),
				'subtitle'	=> sprintf( t( 'jblesta.updates.' . $state . '.subtitle' ), $error ),
		);
		
		$this->outputAsJson( $data );
		return false;
	}
	
	
	/**
	 * Method for starting the process of updating
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		false			After echoing json data out
	 * @since		1.0.0
	 */
	public function updateinit()
	{
		if (! $this->isAjax() ) {
			$this->redirect();
		}
		
		$updates	=	dunloader( 'updates', 'jblesta' );
		
		$data	=	array(
				'title' 	=> t( 'jblesta.updates.init.title' ),
				'subtitle'	=> sprintf( t( 'jblesta.updates.init.subtitle' ), $updates->getVersion() ),
		);
		
		$this->outputAsJson( $data );
		return false;
	}
	
	
	/**
	 * Method to actually perform the update from Go Higher
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		false			After echoing json data out
	 * @since		1.0.0
	 */
	public function updateinstall()
	{
		if (! $this->isAjax() ) {
			$this->redirect();
		}
		
		$updates	=	dunloader( 'updates', 'jblesta' );
		$result		=	$updates->extract();
		$version	=	$updates->getVersion();
		
		$install = dunmodule( 'jblesta.install' );
		$install->upgrade();
		
		$data	=	array(
				'state'		=> 1,
				'title' 	=> t( 'jblesta.updates.complete.title' ),
				'subtitle'	=> sprintf( t( 'jblesta.updates.complete.subtitle' ), $version ),
		);
		
		$this->outputAsJson( $data );
		return false;
	}
}
?>