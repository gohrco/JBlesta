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
 */

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.html.pane' );

if ( version_compare( JVERSION, '3.0', 'l' ) ) {
	JHTML :: _( 'behavior.mootools' );
}

JHTML :: _( 'behavior.tooltip' );

?>

<div id="jblesta">
	
	<div class="row-fluid">
		
		<?php foreach ( $this->icons as $icon ) : ?>
		
		<div class="icon">
			<a href="<?php echo $icon->link; ?>">
				<img border="0" alt="<?php echo $icon->label; ?>" src="<?php echo $icon->icon; ?>" id="<?php echo $icon->id; ?>_img">
				<span id="<?php echo $icon->id; ?>_title">
					<?php echo $icon->label; ?>
				</span>
			</a>
		</div>
		
		<?php endforeach; ?>
		
	</div>
	
</div>

<script type="text/javascript">
	jQuery.ready( checkForUpdates() );
</script>