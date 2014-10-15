<?php
/**
 * -------------------------------------------
 * @packageName@
 * -------------------------------------------
 * @package         @packageName@
 * @subpackage		Joomla
 * @version         @fileVers@
 *
 * @author          @packageAuth@
 * @link            @packageLink@
 * @copyright       @packageCopy@
 * @license         @packageLice@
 * 
 * Big thanks to YooTheme for the core installation routine
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * JBlesta Installation Extension
 * @desc		This class would be used if we had the 1.5 installer to consider
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class com_jblestaInstallerScript extends JBlestaInstallerScript {}


/**
 * JBlesta Installation Script
 * @desc		This class is used to install our various pieces of J!Blesta
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JBlestaInstallerScript
{
	/**
	 * Method to display the results of an upgrade, install or uninstall
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $extensions: the extensions we just worked with and their result
	 * 
	 * @since		1.0.0
	 */
	public static function displayAdditionalExtensions( $extensions )
	{
		?>
			<table class="adminlist table table-bordered table-striped">
				<thead>
					<tr>
						<th class="title"><?php echo JText::_('Extension'); ?></th>
						<th width="60%"><?php echo JText::_('Status'); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
				</tfoot>
				<tbody>
					<?php
						foreach ( $extensions as $i => $extension ) : ?>
						<tr class="row<?php echo $i % 2; ?>">
							<td class="key"><?php echo $extension->name; ?></td>
							<td>
								<?php $style = $extension->status ? 'font-weight: bold; color: green;' : 'font-weight: bold; color: red;'; ?>
								<span style="<?php echo $style; ?>"><?php echo $extension->message; ?></span>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php 
	}
	
	
	/**
	 * Method for installing the component
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $parent: instance of JInstaller
	 * @param		boolean		- $isInstall: if we are coming from the upgrade call we don't want to actiate deactivated plugins automatically
	 * 
	 * @since		1.0.0
	 */
	public function install( $parent, $isInstall = true )
	{
		$installer	=	$parent->getParent();
		$extensions	=	$this->getAdditionalExtensions( $installer );
		
		// install additional extensions
		foreach ($extensions as $extension) {
		
			if (! $extension->install() ) {
				// rollback on installation errors
				$installer->abort( JText::_('Component') . ' ' . JText::_('Install') . ': ' . JText::_('Error'), 'component' );
		
				foreach ( $extensions as $extension ) {
					if ( $extension->status ) {
						$extension->abort();
					}
				}
				break;
			}
			
			// Only enable plugins on initial install
			if ( $isInstall && $extension->type == 'plugin' ) {
				$extension->enable();
			}
			
			// Perform reorder on plugins
			$extension->reorder();
		}
		
		// display table
		if ( $extensions ) {
			self :: displayAdditionalExtensions( $extensions );
		}
	}
	
	
	/**
	 * Method for updating the component
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $parent: instance of JInstaller
	 *
	 * @since		1.0.0
	 */
	public function update( $parent )
	{
		return $this->install( $parent, false );
	}
	
	
	/**
	 * Method for uninstalling the component
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $parent: instance of JInstaller
	 *
	 * @since		1.0.0
	 */
	public function uninstall( $parent )
	{
		// init vars
		$installer  = $parent->getParent();
		$extensions = $this->getAdditionalExtensions( $installer );
		
		// uninstall additional extensions
		foreach ( $extensions as $extension ) {
			$extension->uninstall();
		}
		
		// display table
		if ( $extensions ) {
			self::displayAdditionalExtensions( $extensions );
		}
	}
	
	
	/**
	 * Method for installing the component
	 * @access		protected
	 * @version		@fileVers@
	 * @param		object		- $installer: instance of JInstaller
	 * 
	 * @return		array of extensions to run
	 * @since		1.0.0
	 */
	protected function getAdditionalExtensions( $installer )
	{
		// Initialize
		$extensions	=	array();
		
		// Find the additional extensions in manifest file
		if (	( $manifest = simplexml_load_file( $installer->getPath( 'manifest' ) ) ) &&
				( $additional = $manifest->xpath( 'additional/*' ) ) ) {
			
			foreach ( $additional as $data ) {
				$extensions[] = new JBlestaAdditionalExtension( $installer, $data );
			}
		}

		return $extensions;
	}
}


/**
 * JBlesta Additional Extension
 * @desc		This class is a container for each of the additional extensions found in our xml manifest
 * @package		J!Blesta
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaAdditionalExtension
{
	public $name;
	public $element;
	public $type;
	public $status;
	public $message;
	public $data;
	public $parent;
	public $installer;
	public $database;
	public $folder;
	public $source_path;
	public $last;
	
	/**
	 * Constructor Method
	 * @access		public
	 * @version		@fileVers@
	 * @param		object		- $parent: instance of JInstaller
	 * @param		$data		- $data: what we read from the manifest file
	 *
	 * @since		1.0.0
	 */
	public function __construct( $parent, $data )
	{
		// init vars
		$this->name			=	(string) $data;
		$this->element		=	(string) $data->attributes()->name;
		$this->type			=	$data->getName();
		$this->status		=	false;
		$this->data			=	$data;
		$this->parent		=	$parent;
		$this->installer	=	new JInstaller();
		$this->database		=	JFactory::getDBO();
		$this->folder		=	(string) $data->attributes()->folder;
		$this->source_path	=	rtrim($this->parent->getPath('source').'/'.$this->folder, "\\/") . '/';
		
		if ( $data->getName() == 'plugin' ) {
			$last		=	(string) $data->attributes()->last;
			$this->last =	(bool) ( $last == 'true' ? true : false );
		}
	}
	
	
	/**
	 * Method for installing an extension
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function install()
	{
		// set message
		if ( $this->status = $this->installer->install( $this->parent->getPath('source').'/'.$this->data->attributes()->folder ) ) {
			$this->message = JText::_('Installed successfully');
		}
		else {
			$this->message = JText::_('NOT Installed');
		}
		
		return $this->status;
	}
	
	
	/**
	 * Method for uninstalling an extension
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function uninstall()
	{
		// get extension id and client id
		$result		=	$this->load();
		$ext_id		=	isset( $result->extension_id ) ? $result->extension_id  : 0;
		$client_id	=	isset( $result->client_id ) ? $result->client_id : 0;
		
		// set message
		if (	$this->status = $ext_id > 0 && 
				$this->installer->uninstall( $this->type, $ext_id, $client_id ) ) {
			$this->message = JText::_('Uninstalled successfully');
		}
		else {
			$this->message = JText::_('Uninstall FAILED');
		}
		
		return $this->status;
	}
	
	
	/**
	 * Method for aborting an extension
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function abort()
	{
		$this->installer->abort( JText::_($this->type).' '.JText::_('Install').': '.JText::_('Error'), $this->type );
		$this->status = false;
	}
	
	
	/**
	 * Method for aborting an install of an extension
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		object of fields from database
	 * @since		1.0.0
	 */
	public function load()
	{
		$this->database->setQuery( sprintf("SELECT * FROM #__extensions WHERE type='%s' AND element='%s'", $this->type, $this->element ) );
		return $this->database->loadObject();
	}
	
	
	/**
	 * Method for enabling an extension
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function enable()
	{
		$this->database->setQuery( sprintf("UPDATE #__extensions SET enabled=1 WHERE type='%s' AND element='%s'", $this->type, $this->element ) );
		$this->database->query();
	}
	
	
	/**
	 * Method for reordering a plugin to last or first position
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function reorder()
	{
		// Only plugins allowed
		if ( $this->type != 'plugin' ) return;
		
		// Isolate the plugin folder type
		$parts		=	explode( '/', $this->folder );
		$folder		=	array_pop( $parts );
		
		// Build our query
		$ordering	=	( $this->last ? 'DESC' : 'ASC' );
		$query		=	"SELECT `ordering` FROM #__extensions WHERE `type` = '%s' AND `folder` = '%s' ORDER BY `ordering` " . $ordering;
		$this->database->setQuery( sprintf( $query, $this->type, $folder ) );
		
		// Grab the order value
		$order		=	$this->database->loadResult();
		$order		=	( $this->last ? ++$order : --$order );
		
		$this->database->setQuery( sprintf("UPDATE #__extensions SET `ordering` = %s WHERE type='%s' AND element='%s'", $order, $this->type, $this->element ) );
		$this->database->query();
	}
}