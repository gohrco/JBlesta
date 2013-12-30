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
 * JBlesta Main Controller
 * @desc		This class is called up directly when debugging
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class Main extends JblestaController
{
	/**
	 * Method to assemble the checkinstall screen
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function checkinstall()
	{
		// @TODO: Implement
		die('hi');
		$config	=	dunloader( 'config', 'jwhmcs' );
		$input	=	dunloader( 'input', true );
		$debug	=	$config->get( 'debug', false );
		$task	=	$input->getVar( 'task', 'cp' );
		
		if (! $debug ) return;
		
		load_bootstrap( 'jwhmcs' );
		
		$data	=	array(
				'pagetitle'		=>	t( 'jwhmcs.client.breadcrumb.' . $task ),
				'breadcrumb'	=>	array( 'index.php?m=jwhmcs&task=checkinstall' => t( 'jwhmcs.client.breadcrumb.' . $task ) ),
				'templatefile'	=>	'templates/client-' . $task,
				'requirelogin'	=>	false,
				'vars'			=>	array(
						'title'		=>	t( 'jwhmcs.client.pagetitle' ),
						'desc'		=>	t( 'jwhmcs.client.pagedesc.'. $task ),
				),
		);
		
		switch ( $task ) :
		case 'checkinstall' :
			$doc	=	dunloader( 'document', true );
			
		$doc->addScript( get_baseurl( 'jwhmcs' ) . 'assets/syscheck.js' );
		$doc->addScriptDeclaration( 'var ajaxurl = "' . get_baseurl( 'jwhmcs' ) . '";' );
			
		$syschk	=	dunmodule( 'jwhmcs.syscheck' );
		$model	=	$syschk->getModel();
		$rows	=	array();
		
		// Let's build our table
		foreach ( array( 'api', 'files', 'whmcs', 'env' ) as $row ) {
		
			$rows[]	=	'<table class="table-bordered table-striped">';
			$rows[]	=	'	<thead><tr><th colspan="2">' . t( 'jwhmcs.syscheck.tblhdr.' . $row ) . '</th></tr></thead>';
			$rows[]	=	'	<tbody>';
		
			foreach ( $model->$row as $item => $value ) {
				// Skip some
				if ( in_array( $item, array( 'files', 'supported', 'templatesupported' ) ) ) continue;
					
				$rows[]	=	'	<tr>';
				$rows[]	=	'		<td class="span4">' . $syschk->getItem( 'label', $item, $model->$row, $row ) . '</td>';
				$rows[]	=	'		<td class="span3">' . $syschk->getItem( 'value', $item, $model->$row, $row ) . '</td>';
				$rows[]	=	'	</tr>';
			}
		
			$rows[]	=	'</tbody></table><br/><br/>';
		}
			
		$data['vars']['data']	=	implode( "\r\n", $rows );
			
		break;
		endswitch;
	}
	
	
	/**
	 * Method to assemble the checkrender screen
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function checkrender()
	{
		// Initialize Dunamis!
		$this->init();
		
		$doc	=	dunloader( 'document', true );
		$input	=	dunloader( 'input', true );
		
		$render	=	dunmodule( 'jblesta.render' );
		$render->execute();
		$info	=	$render->getItem( 'debug' );
		
		$rows[]	=	'<table class="table-bordered table-striped">';
		$rows[]	=	'	<tbody>';
		
		foreach ( $info as $key => $value ) {
		
			$rows[]	=	'	<tr>';
		
			if ( $key == 'url' ) {
				$value	=	'<textarea class="span6">' . $value . '</textarea>';
			}
			else {
				$value	=	'<code>' . $value . '</code>';
			}
		
			$rows[]	=	'		<td class="span2 pull-right">' . $key . '</td>';
			$rows[]	=	'		<td class="span6">' . $value . '</td>';
			$rows[]	=	'	</tr>';
		}
		
		$rows[]	=	'</tbody></table><br/><br/>';
		
		$data	=	implode( "\r\n", $rows );
		
		$this->set( 'content', $data );
		$this->view->file = 'checkrender';
	}
	
	
	/**
	 * Method to assemble the index
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function index()
	{
		// Initialize Dunamis!
		$this->init();
		
		$doc	=	dunloader( 'document', true );
		$input	=	dunloader( 'input', true );
		
		$this->view->file = 'index';
		
	}
	
	
	/**
	 * Method to initialize our plugin on the client area
	 * @access		protected
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	protected function init()
	{
		parent :: init();
		
		$config	=	dunloader( 'config', 'jblesta' );
		
		if (! $config->get( 'debug', false ) ) {
			$this->redirect();
		}
		
		// Initialize the Blesta side
		$this->structure->setDefaultView(APPDIR);
		$this->structure->setView(null, $this->orig_structure_view);
		
		// Initialize Dunamis
		load_bootstrap( 'jblesta' );
		$doc	=	dunloader( 'document', true );
		
		$doc->setVar( 'title',	t( 'jblesta.client.pagetitle' ) );
	}
}
?>