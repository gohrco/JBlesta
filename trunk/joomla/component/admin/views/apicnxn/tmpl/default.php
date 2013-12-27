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

JHTML::_('behavior.tooltip');
JHTML::_('behavior.formvalidation');

$data = $this->data;

// 3.0+ compatibility inclusion
if ( version_compare( JVERSION, '3', 'ge' ) ) : ?>
<script type="text/javascript">
	Joomla.submitbutton = function( task ) { Joomla.submitform(task, document.getElementById('item-form')); }
</script>
<?php endif; ?>

<div id="jblesta">
	
	<form action="index.php" method="post" name="adminForm" class="form-horizontal" id="item-form">
		
		<div class="row">
			
			<div class="span8">
				
				<div class="control-group">
					
					<label class="control-label" for="blestaapiurl">
						<?php echo JText::_( "COM_JBLESTA_INSTALL_VIEW_APICNXN_BLESTAAPIURL_TEXT" ); ?>
					</label>
					
					<div class="controls">
						
						<input	class="text_area required span4"
								type="text"
								name="blestaapiurl"
								value="<?php echo $data->blestaapiurl; ?>"
								size="40"
								onChange="apicnxnCheck();"
								id="blestaapiurl"
								placeholder="http://www.yourdomain.com/blesta"
								/>
						
						<span class="help-block">
							<?php echo JText::_( "COM_JBLESTA_INSTALL_VIEW_APICNXN_BLESTAAPIURL_DESC" ); ?>
						</span>
					</div>
				</div>
				
				<div class="control-group">
					
					<label class="control-label" for="blestaapiusername">
						<?php echo JText::_( "COM_JBLESTA_INSTALL_VIEW_APICNXN_BLESTAAPIUSERNAME_TEXT" ); ?>
					</label>
					
					<div class="controls">
						
						<input	class="text_area required span4"
								type="text"
								name="blestaapiusername"
								value="<?php echo $data->blestaapiusername; ?>"
								size="40"
								onChange="apicnxnCheck();"
								id="blestaapiusername"
								/>
						
						<span class="help-block">
							<?php echo JText::_( "COM_JBLESTA_INSTALL_VIEW_APICNXN_BLESTAAPIUSERNAME_DESC" ); ?>
						</span>
					</div>
				</div>
				
				<div class="control-group">
					
					<label class="control-label" for="blestaapikey">
						<?php echo JText::_( "COM_JBLESTA_INSTALL_VIEW_APICNXN_BLESTAAPIKEY_TEXT" ); ?>
					</label>
					
					<div class="controls">
						
						<input	class="text_area required span4"
								type="password"
								name="blestaapikey"
								value="<?php echo $data->blestaapikey; ?>"
								size="40"
								onChange="apicnxnCheck();"
								id="blestaapikey"
								/>
						
						<span class="help-block">
							<?php echo JText::_( "COM_JBLESTA_INSTALL_VIEW_APICNXN_BLESTAAPIKEY_DESC" ); ?>
						</span>
					</div>
				</div>
				
			</div>
			
			<div class="span4">
			
				<div id="apistatus">
					
					<div id="apistatusimg" class="icon"></div>
					<div id="apistatusmsg" style="width: 200px; margin: 0px auto; font-size: small; font-weight: bold; clear: both; padding: 10px; text-align: center; "></div>
					<div class="alert" id="apistatushelp"></div>
				</div>
				
			</div>
			
		</div>
	<input type="hidden" name="option" value="com_jblesta" />
	<input type="hidden" name="apiconnection" id="apiconnection" value="0" />
	<input type="hidden" name="task" value="display" />
	<input type="hidden" name="controller" value="default" />
	<input type="hidden" id="apistatusmsgdefault" value="<?php echo JText::_( "COM_JBLESTA_INSTALL_VIEW_APICNXN_STATUSDEFAULT" ); ?>" />
	</form>
	<script language="javascript">
	window.onload = apicnxnCheck();
	</script>
</div>