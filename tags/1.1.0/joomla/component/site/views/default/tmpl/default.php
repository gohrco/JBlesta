<?php 
/**
 * @projectName@
 * 
 * @package    @packageName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      2.1.0
 * 
 * @desc       Default View - default layout:  The default layout for the default view
 *  
 */

defined('_JEXEC') or die('Restricted access');
?>

<?php if ( $this->params->get( 'show_page_heading', false ) ): ?>
<h1><?php echo $this->params->get( 'page_title' ); ?></h1>
<?php endif; ?>

<!-- J!Blesta -->
<jblesta /><!-- J!Blesta:  COMPONENT -->
<!-- J!Blesta -->