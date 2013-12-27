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

defined( '_JEXEC' ) or die( 'Restricted access' );

JHtml::_('behavior.tooltip');

$elements	=	$this->data->elements;

// Set link / img
$img	=	JURI :: root() . 'media/com_jblesta/icons/' . ( $this->data->hasupdates === true ? 'updates-48' : ( $this->data->hasupdates === false ? 'accept-48' : 'fail-48' ) ) . '.png';
//$link	= ( $this->data->hasupdates === true ? JRoute :: _( 'index.php?option=com_jblesta&controller=updates&task=begin' ) : '#' );
$link	=	( $this->data->hasupdates === true ? 'javascript:performUpdate();' : '#' );
$axn	=	JText :: _( 'COM_JBLESTA_UPDATES_LINK_' . ( $this->data->hasupdates === true ? 'UPDATE' : ( $this->data->hasupdates === false ? 'NOTHING' : 'ERROR' ) ) );

// 3.0+ compatibility inclusion
if ( version_compare( JVERSION, '3', 'ge' ) ) : ?>
<script type="text/javascript">
	Joomla.submitbutton = function( task ) { Joomla.submitform(task, document.getElementById('item-form')); }
</script>
<?php endif; ?>



<div id="jblesta">

	<div class="row-fluid">
		
		<div class="span8">
		
			<table class="table table-striped">
				
				<thead>
					
					<tr>
						
						<th>
							
							<?php echo JText::_( 'COM_JBLESTA_UPDATES_HEADING_EXTNAME' ); ?>
							
						</th>
						
						<th colspan="2">
							
							<?php echo JText::_( 'COM_JBLESTA_UPDATES_HEADING_VERSION' ); ?>
							
						</th>
					
				</thead>
				
				<tbody>
				
					<?php foreach ( $elements as $element => $data ) : ?>
					
					<tr class="<?php echo ( $data->update ? 'warning' : 'success' ); ?>">
						
						<td class="lead">
							
							<?php echo $data->name; ?>
							
						</td>
						
						<td class="lead">
							
							<?php echo ( $data->update ? $data->version : null ); ?>
							
						</td>
						
						<td class="lead">
							
							<?php echo ( $data->update ? $data->released : null ); ?>
							
						</td>
						
					</tr>
					
					<?php endforeach; ?>
					
				</tbody>
				
			</table>
			
		</div>
		
		<div class="span4">
			
			<div class="icon">
				<a href="<?php echo $link; ?>">
					<img border="0" alt="<?php echo $axn; ?>" src="<?php echo $img; ?>" id="jblesta_icon_updates_img">
					<span id="jblesta_icon_updates_title">
						<?php echo $axn; ?>
					</span>
				</a>
			</div>
			
		</div>
		
		<div class="span4"><div class="" id="jblesta_icon_updates_error"></div></div>
		
	</div>
	
</div>

<form action="<?php echo JRoute::_('index.php?option=com_jblesta'); ?>" method="post" name="adminForm" id="item-form">
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_( 'form.token' ); ?>
</form>

<input type="hidden" value="<?php echo JURI :: root() . 'media/com_jblesta/icons/'; ?>" id="rootimgurl" />
<input type="hidden" value="<?php echo JText :: _( 'COM_JBLESTA_UPDATES_LINK_INIT' ); ?>" id="inittitle" />
<input type="hidden" value="<?php echo JText :: _( 'COM_JBLESTA_UPDATES_LINK_DONE' ); ?>" id="donetitle" />