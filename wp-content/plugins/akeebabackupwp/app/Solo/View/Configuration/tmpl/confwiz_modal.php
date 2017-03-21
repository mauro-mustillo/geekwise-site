<?php
/**
 * @package        solo
 * @copyright      2014-2016 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license        GNU GPL version 3 or later
 */

use Awf\Text\Text;
use Solo\Helper\Escape;

/** @var $this \Solo\View\Configuration\Html */

$router = $this->container->router;

?>

<div id="akeeba-config-confwiz-bubble" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>
					<?php echo Text::_('COM_AKEEBA_CONFIG_HEADER_CONFWIZ') ?>
				</h4>
			</div>
			<div class="modal-body">
				<p>
					<?php echo Text::_('COM_AKEEBA_CONFIG_LBL_CONFWIZ_INTRO') ?>
				</p>
				<p>
					<a href="<?php echo $this->getContainer()->router->route('index.php?view=wizard') ?>"
					   class="btn btn-lg btn-success">
						<span class="glyphicon glyphicon-flash"></span>
						<?php echo Text::_('COM_AKEEBA_CONFWIZ'); ?>
					</a>
				</p>
				<p>
					<?php echo Text::_('COM_AKEEBA_CONFIG_LBL_CONFWIZ_AFTER'); ?>
				</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove"></span>
					<?php echo Text::_('SOLO_BTN_CANCEL'); ?>
				</a>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function(){
		jQuery("#akeeba-config-confwiz-bubble").modal({
			backdrop: true,
			keyboard: true,
			show: true
		});
	});
</script>