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

defined('DUNAMIS') OR exit('No direct script access allowed');

// Set our defined constant in place
if (! defined( 'JBLESTAPDT' ) ) {
	dunloader( 'helpers', 'jblesta' );
	define( 'JBLESTAPDT', dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . get_version() . DIRECTORY_SEPARATOR );
}

/**
 * JBlestaPlugin Installer
 * @desc		This is the install file for J!Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JblestaInstallDunModule extends BlestaDunModule
{
	private $destinationpath;
	private $files				=	array();
	private $sourcepath;
	
	
	/**
	 * Method for cycling through files to check for updated / modified files
	 * @access		public
	 * @version		@fileVers@
	 * @param		boolean				Should we remove the file or not?
	 *
	 * @return		array of objects
	 * @since		1.0.0
	 */
	public function checkFiles( $remove = false )
	{
		$files	=	$this->_getTemplatefiles( null, 'pdt', $remove );
		$css	=	$this->_getTemplatefiles( 'theme', 'css', $remove );
		//$js		=	$this->_getTemplatefiles( $tpl, 'js' );
		$files	=	array_merge( $files, $css );
		ksort( $files );
		
		return $files;
	}
	
	
	/**
	 * Method for moving a single file into place
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $file: subpath of the file / filename to handle
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function fixFile( $file )
	{
		$parts		=	explode( '.', $file );
		$ext		=	array_pop( $parts );
		$filepath	=	implode( '.', $parts );
		
		$file	=	array_shift( $this->_getTemplatefiles( $filepath, $ext ) );
		$result	=	$file->fix();
		
		return $result === true ? true : $file->getErrormsg();
	}
	
	
	/**
	 * Method to get the table settings for a given table
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $table: the table to get
	 *
	 * @return		array
	 * @since		1.0.0
	 */
	public function getConfiguration( $table = 'settings' )
	{
		return $this->_getTablevalues( $table );
	}
	
	
	/**
	 * Initializes the module
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function initialise()
	{
		// Template time
		$this->sourcepath		=	dirname( __FILE__ ) . DIRECTORY_SEPARATOR
								.	'templates' . DIRECTORY_SEPARATOR
								.	get_version() . DIRECTORY_SEPARATOR;
		
		$this->destinationpath	=	DUN_ENV_PATH
								.	'app'	. DIRECTORY_SEPARATOR
								.	'views'	. DIRECTORY_SEPARATOR;
		
	}
	
	
	/**
	 * Performs module installation
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function install()
	{
		// Load the database handler
		$db	= dunloader( 'database', true );
	
		// Load the initial tables
		$db->handleFile( 'sql' . DIRECTORY_SEPARATOR . 'install.sql', 'jblesta' );
	
		// Now we need to insert the settings
		$table = $this->_getTablevalues();
	
		foreach ( $table as $key => $value ) {
			$db->setQuery( "SELECT * FROM `jblesta_settings` WHERE `key`=" . $db->Quote( $key ) );
			if ( $db->loadResult() ) continue;
				
			$db->setQuery( "INSERT INTO `jblesta_settings` ( `key`, `value` ) VALUES (" . $db->Quote( $key ) . ", " . $db->Quote( $value ) . " )" );
			$db->query();
		}
	
		// Template time
		$files	=	$this->checkFiles();
	
		foreach ( $files as $file ) {
			$file->fix();
		}
	
		return true;
	}
	
	
	/**
	 * Trigger an upgrade event from ajax
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function triggerUpgrade()
	{
		Loader :: loadModels( $this, array( 'PluginManager' ) );
		$plugins	=	$this->PluginManager->getByDir( 'jblesta' );
		
		foreach ( $plugins as $plugin ) {
			$this->PluginManager->upgrade( $plugin->id );
		}
	}
	
	
	/**
	 * Method to deactivate the product
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function uninstall()
	{
		// Load the database handler
		$db		=	dunloader( 'database', true );
		$config	=	dunloader( 'config', 'jblesta' );
		
		// Run the uninstall sql
		if (! $config->get( 'preservedb', true ) ) {
			$db->handleFile( 'sql' . DIRECTORY_SEPARATOR . 'uninstall.sql', 'jblesta' );
		}
		
		$files	=	$this->checkFiles( true );
		$errors	=	array();
		
		foreach ( $files as $file ) {
			$result	=	$file->restore();
			
			if (! $result ) {
				$errors[]	=	$file->getErrormsg();
			}
		}
		
		if (! empty( $errors ) ) {
			$this->setErrors( $errors );
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Perform any upgrade logic
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function upgrade()
	{
		
	}
	
	
	/**
	 * Method to get the table values
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $config: which table to get for
	 * 
	 * @return		array
	 * @since		1.0.0
	 */
	private function _getTablevalues( $config = 'settings' )
	{
		$data	= array();
		
		switch ( $config ) :
		case 'settings' :
			$data	= array(
					'license' => null,
					'localkey' => null,
					'updates'	=> null,
		
					// General Settings
					'enable'		=> false,
					'debug'			=> false,
					'joomlaurl'		=> null,
					'logintoken'	=> null,
		
					// User Settings
					'userenable'	=> true,
					'useraddmethod'	=> 4,
					'regmethod'		=> 1,
					'namestyle'		=> 1,
					'userstyle'		=> 1,
					'usernamestyle'	=> 3,
					'usernamefield'	=> null,
		
					// Visual Settings
					'visualenable'		=>	true,
					//'jqueryenable'		=> true,
					'customimageurl'	=>	1,
					'imageurl'			=>	null,
					'menuitem'			=>	null,
					'resetcss'			=>	1,
					'showmyinfo'		=>	false,
					'showheader'		=>	true,
					//'shownavbar'		=> false,
					//'showfooter'		=> true,
		
					// Language Settings
					'languageenable'	=> false,
					'languagesettings'	=> null,
		
					// Login Settings
					'loginenable'	=> true,
					'logouturl'		=> null,
		
					// Advanced Settings
					'dlid'					=>	null,
					'preservedb'			=>	true,
					'passalonguseragent'	=>	false,
					'parseheadlinebyline'	=>	false,
					'forceapitoget'			=>	false,
			);
			break;
			endswitch;
		
		return $data;
	}
	
	
	/**
	 * Method to gather tpl files for moving around
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $subdir: any recursive subdirs or a filename (minus the extension)
	 * @param		string		- $type: indicates what we are looking for [tpl|bak]
	 * @param		boolean			We can indicate we are going opposite way (true indicates from destination to source)
	 *
	 * @return		array
	 * @since		1.0.0
	 */
	private function _getTemplatefiles( $subdir = null, $type = 'pdt', $remove = false )
	{
		$files	=	array();
		$path	=	$this->sourcepath
				.	$subdir;
		
		// Catch explicit calls for specific files
		if ( file_exists( $path . '.' . $type ) ) {
			$files[$subdir.'.'.$type]	=	new JBFile( $subdir.'.'.$type, $remove );
		}
		
		// In case our path isn't a path but just a file
		if (! is_dir( $path ) ) {
			return $files;
		}
		
		$dh	=	scandir( $path );
		
		foreach ( $dh as $file ) {
			if ( in_array( $file, array( '.', '..', 'custom.css', 'custom.css.new' ) ) ) continue;
			if ( is_dir( $path . $file ) ) {
				$files	=	array_merge( $files, $this->_getTemplatefiles( $subdir . $file . DIRECTORY_SEPARATOR, $type, $remove ) );
				continue;
			}
			$info	=	pathinfo( $file );
			if ( $info['extension'] != $type ) continue;
			$files[$subdir . $file]	=	new JBFile( $subdir . $file, $remove );
		}
		
		return $files;
	}
}


/**
 * JBFile class
 * @desc		This class is used to manipulate installation files for J!Blesta
 * @package		J!Blesta
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JBFile extends DunObject
{
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		string			The filename including subpath we are working with
	 * @param		boolean			Indicates we want to remove the file
	 *
	 * @since		1.0.0
	 */
	public function __construct( $filename = null, $remove = false )
	{
		$this->setFilepath( $filename );
		$this->setRemove( $remove );
		
		$path	=	pathinfo( JBLESTAPDT . $filename );
		
		foreach ( $path as $k => $v ) {
			$method = 'set' . ucfirst( $k );
			$this->$method( $v );
		}
		
		// Do our work
		$this->_checkfilesize();
		$this->_compareVersions();
	}
	
	
	/**
	 * Method to fix a file in the system
	 * @access		public
	 * @version		@fileVers@
	 * @param		boolean			Indicates we want to backup the destination file [T|f]
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function fix( $backup = true )
	{
		$src	=	( $this->getRemove() ? $this->_destination() : $this->_source() );
		$dst	=	( $this->getRemove() ? $this->_source() : $this->_destination() );
		
		if (! is_readable( $src ) ) {
			$this->setErrormsg( t( 'jblesta.install.file.fix.fail.readsrc', $src ) );
			return false;
		}
		
		// Handle backup first
		if ( $backup ) {
			$bak	=	str_replace( $this->getBasename(), $this->getFilename() . '.jblesta', ( $this->getRemove() ? $this->_source() : $this->_destination() ) );
			
			if ( file_exists( $bak ) ) {
				$bak	=	str_replace( 'jblesta', 'jblesta-' . str_replace( '.', '', DUN_MOD_JBLESTA ), $bak );
			}
			
			if ( file_exists( $bak ) ) {
				if (! @unlink( $bak ) ) {
					$this->setErrormsg( t( 'jblesta.install.file.fix.fail.delbackup', $bak ) );
					return false;
				}
			}
			
			if ( file_exists( $dst ) ) {
				if (! @rename( $dst, $bak ) ) {
					$this->setErrormsg( t( 'jblesta.install.file.fix.fail.movebackup', $dst ) );
					return false;
				}
			}
		}
		
		// Check our path
		if (! $this->_checkpath() ) {
			$this->setErrormsg( t( 'jblesta.install.file.fix.fail.pathcheck', $dst ) );
			return false;
		}
		
		// Copy our file over
		if (! @copy( $src, $dst ) ) {
			$this->setErrormsg( t( 'jblesta.install.file.fix.fail.copy', $dst ) );
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Method to indicate if the file is current
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function isCurrent()
	{
		if ( $this->getSizecheck() ) {
			return true;
		}
		
		// Check for source read errors
		if ( $this->getErrorcode( false ) ) {
			return false;
		}
		
		return false;
	}
	
	
	/**
	 * Method to restore backup files to the original destination
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function restore()
	{
		$bak	=	str_replace( $this->getBasename(), $this->getFilename() . '.jblesta', $this->_destination() );
		$dst	=	( $this->getRemove() ? $this->_destination() : $this->_source() );
		$rmv	=	$this->_removes();
		
		// If we are just removing the file do so
		if ( array_key_exists( $this->getBasename(), $rmv ) ) {
			
			if ( file_exists( $dst ) ) {
				if (! @unlink( $dst ) ) {
					$this->setErrormsg( t( 'jblesta.install.file.fix.fail.delfile', $dst ) );
					return false;
				}
			}
			
			return true;
		}
		
		// Restore the backup
		if (! file_exists( $bak ) ) {
			$this->setErrormsg( t( 'jblesta.install.file.fix.fail.missbackup', $dst ) );
			return false;
		}
		
		if ( file_exists( $dst ) ) {
			if (! @unlink( $dst ) ) {
				$this->setErrormsg( t( 'jblesta.install.file.fix.fail.deloriginal', $dst ) );
				return false;
			}
		}
		
		// Copy our file over
		if (! @rename( $bak, $dst ) ) {
			$this->setErrormsg( t( 'jblesta.install.file.fix.fail.restore', $dst ) );
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Method to check the file size
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	private function _checkfilesize()
	{
		$src	=	( $this->getRemove() ? $this->_destination() : $this->_source() );
		$dst	=	( $this->getRemove() ? $this->_source() : $this->_destination() );
		
		if (! file_exists( $src ) || ! file_exists( $dst ) ) {
			$data	=	false;
		}
		
		$data	=	( md5_file( $src ) === md5_file( $dst ) );
		
		$this->setSizecheck( $data );
		
		if (! $data ) {
			$this->setErrorcode( 4 );
			$this->setErrormsg( t( 'jblesta.install.file.error.chksum' ) );
		}
	}
	
	
	/**
	 * Method to check for the path
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	private function _checkpath()
	{
		$dst	=	str_replace( DUN_ENV_PATH, '', ( str_replace( $this->getBasename(), '', $this->getRemove() ? $this->_source() : $this->_destination() ) ) );
		$root	=	DUN_ENV_PATH;
		$paths	=	explode( DIRECTORY_SEPARATOR, rtrim( $dst, DIRECTORY_SEPARATOR ) );
		
		foreach ( $paths as $path ) {
			$root	.=	$path . DIRECTORY_SEPARATOR;
			if ( is_dir( $root ) ) continue;
			
			if (! @mkdir( $root ) ) {
				return false;
			}
		}
		
		return true;
	}
	
	
	/**
	 * Method to perform our version comparisons
	 * @access		private
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	private function _compareVersions()
	{
		$src	=	( $this->getRemove() ? $this->_destination() : $this->_source() );
		$dst	=	( $this->getRemove() ? $this->_source() : $this->_destination() );
		
		// Read files
		$source	=	file_exists( $src )	? @file( $src ) : false;
		$dest	=	file_exists( $dst )	? @file( $dst ) : false;
		
		// Catch errors reading
		if (! $source || ! $dest ) {
			
			$this->setErrorcode( ( ! $source ? 1 : 4 ) );
			$this->setErrormsg( t( 'jblesta.install.file.error.read', ( ! $source ? 'source' : 'existing template' ) ) );
			return;
		}
			
		// Find versions of files
		$sv	=
		$dv	=	false;
		
		foreach( array( 'sv' => 'source', 'dv' => 'dest' ) as $holder => $item ) {
			foreach ( $$item as $s ) {
				if ( preg_match( '/@version\s+([0-9\.]+)/im', $s, $matches, PREG_OFFSET_CAPTURE ) ) {
					$$holder	=	$matches[1][0];
					break;
				}
			}
		}
			
		// Ensure we found versions
		if (! $dv || ! $sv ) {
			$this->setErrorcode( 2 );
			$this->setErrormsg( t( 'jblesta.install.file.error.version', ( ! $sv ? 'source' : 'existing template' ) ) );
			return;
		}
			
		// Do our comparisons
		if ( version_compare( $dv, $sv, 'lt' ) ) {
			
			$this->setErrorcode( 4 );
			$this->setErrormsg( t( 'jblesta.install.file.error.newer', ucfirst( t( 'jblesta.install.file.jwhmcs' ) ), t( 'jblesta.install.file.template' ) ) );
		}
		else if ( version_compare( $dv, $sv, 'gt' ) ) {
			$this->setErrorcode( 4 );
			$this->setErrormsg( t( 'jblesta.install.file.error.newer', ucfirst( t( 'jblesta.install.file.template' ) ), t( 'jblesta.install.file.jblesta' ) ) );
		}
	}
	
	
	/**
	 * Method to return the intended destination of the file
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	private function _destination()
	{
		$routes	=	$this->_routes();
		
		if ( array_key_exists( $this->getBasename(), $routes ) ) {
			$path	=	$routes["{$this->getBasename()}"];
		}
		else {
			$path	=	$routes["*"];
		}
		
		return rtrim( $path, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR . $this->getFilepath(); 
	}
	
	
	/**
	 * Moethod for getting which files should just be removed
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		array
	 * @since		1.0.0
	 */
	private function _removes()
	{
		$data	=	array();
		$data['theme.css']	=	true;
		return $data;
	}
	
	
	/**
	 * Method for getting the routes our source files get mapped to
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		array			Contains an array of routes 
	 * @since		1.0.0
	 */
	private function _routes()
	{
		$data	=	array();
		$data['*']			=	VIEWDIR;
		$data['theme.css']	=	VIEWDIR
							.	'client' . DIRECTORY_SEPARATOR
							.	'default' . DIRECTORY_SEPARATOR
							.	'css' . DIRECTORY_SEPARATOR
							.	'jblesta' . DIRECTORY_SEPARATOR;
		return $data;
	}
	
	
	/**
	 * Method to get the source from our object
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	private function _source()
	{
		return $this->getDirname() . DIRECTORY_SEPARATOR . $this->getBasename();
	}
}