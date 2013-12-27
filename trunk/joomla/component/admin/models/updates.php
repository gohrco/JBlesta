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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * JBlesta Updates Module
 * @desc		This class is used to handle the updates model
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaModelUpdates extends JblestaModelExt
{
	/**
	 * Retrieves the data to render for the view
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array of objects
	 * @since		1.0.0
	 */
	public function getData( $force = false )
	{
		$elements	=	$this->_getElements();
		$data		=	array();
		$hasupdates	=	false;
		
		foreach ( $elements as $element => $object ) {
			
			// Load up Dunamis!
			get_dunamis( $element );
			$updates	=	dunloader( 'updates', $element, array( 'force' => $force ) );
			
			if (! $updates ) continue;
			
			// ---- BEGIN JBLESTA-10
			//		If Dunamis can't load the element the updates->exist() method fails ugly
			if (! is_object( $updates ) ) continue;
			// ---- END JBLESTA-10
			
			$data[$element]	=	(object) array(
					'name'		=> $object->name,
					'update'	=> $updates->exist(),
					'current'	=> constant( 'DUN_MOD_' . strtoupper( $element ) ),
					'version'	=> null,
					'released'	=> null,
					);
			
			if ( $updates->exist() ) {
				$hasupdates	=	true;
				$data[$element]->version	=	preg_replace( '#^v#', '', $updates->getUpdate()->version );
				$data[$element]->released	=	$updates->getUpdate()->release_date;
			}
		}
		
		$data	=	(object) array(
				'elements'		=> $data,
				'hasupdates'	=>	$hasupdates
				);
		
		return $data;
	}
	
	
	/**
	 * Completes updates available for user
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public function updatecomplete()
	{
		$items	=	$this->getData( false );
		$items	=	$items->elements;
		$data	=	(object) array(
				'state'		=>	1,
				'message'	=>	array(),
				);
		
		foreach ( $items as $element => $item ) {
			
			get_dunamis( $element );
			$updates	=	dunloader( 'updates', $element );
			$extracted	=	$updates->extract();
			
			if (! $extracted ) {
				$data->state = 0;
				$data->message[]	=	JText :: sprintf( 'COM_JBLESTA_UPDATES_MESSAGE_EXTRACTFAILED', $item->name );
				continue;
			}
			
			$complete	=	$updates->update();
			
			if (! $complete ) {
				$data->state		=	0;
				$data->message[]	=	JText :: sprintf( 'COM_JBLESTA_UPDATES_MESSAGE_UPDATEFAILED', $item->name );
				continue;
			}
			
			$data->message[]	=	JText :: sprintf( 'COM_JBLESTA_UPDATES_MESSAGE_UPDATESUCCESS', $item->name, $item->version );
		}
		
		$data->message	=	implode( '<br/>', $data->message );
		return $data;
	}
	
	
	/**
	 * Downloads updates available for user
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public function updateDownload()
	{
		$items	=	$this->getData( false );
		$items	=	$items->elements;
		
		$data	=	(object) array(
				'state'		=>	1,
				'message'	=>	array(),
				);
		
		foreach ( $items as $element => $item ) {
			
			// Load up Dunamis!
			get_dunamis( $element );
			$updates	=	dunloader( 'updates', $element );
			$result		=	$updates->download();
			
			if (! $result ) {
				$data->state = 0;
				$data->message[]	=	$updates->getError();
				break;
			}
			else {
				$data->message[]	=	sprintf( JText :: _( 'COM_JBLESTA_UPDATES_MESSAGE_DOWNLOADED' ), $item->version, $item->name );
			}
		}
		
		$data->message	=	implode( '<br/>', $data->message );
		
		return $data;
	}
	
	
	/**
	 * Initializes the update routine
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	public function updateInit()
	{
		$data	=	$this->getData( false );
		$data	=	$data->elements;
		$text	=	array();
		
		foreach ( $data as $item ) {
			$text[]	=	sprintf( JText :: _( 'COM_JBLESTA_UPDATES_MESSAGE_INIT' ), $item->current, $item->name, $item->version );
		}
		
		return implode( '<br/>', $text );
	}
	
	
	/**
	 * Gathers the various elements based on the com_jblesta.xml file
	 * @access		private
	 * @version		@fileVers@
	 *
	 * @return		array of objects
	 * @since		1.0.0
	 */
	private function _getElements()
	{
		// Lets build the component first
		$data	=	array(
				'com_jblesta'	=>	(object) array(
						'name' => 'J!WHMCS Integrator Component'
						),
				);
		
		$path	=	JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jblesta' . DS . 'com_jblesta.xml';
		$xml	=	simplexml_load_file( $path );
		
		if (! $xml ) {
			return $data;
		}
		
		$additional	=	$xml->xpath( 'additional/*' );
		
		foreach ( $additional as $added ) {
			
			$object			=	(object) array(
									'name' => (string) $added
								);
			
			$elem			=	(string) $added->attributes()->name;
			$data[$elem]	=	$object;
		}
		
		return $data;
	}
}