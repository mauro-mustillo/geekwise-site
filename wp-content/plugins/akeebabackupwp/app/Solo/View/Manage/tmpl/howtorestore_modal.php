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

$proKey = (defined('AKEEBABACKUP_PRO') && AKEEBABACKUP_PRO) ? 'PRO' : 'CORE';
?>

<div id="akeeba-config-howtorestore-bubble" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>
					<?php echo Text::_('COM_AKEEBA_BUADMIN_LABEL_HOWDOIRESTORE_LEGEND') ?>
				</h4>
			</div>
			<div class="modal-body">
				<?php echo Text::sprintf('COM_AKEEBA_BUADMIN_LABEL_HOWDOIRESTORE_TEXT_' . $proKey,
					'https://www.akeebabackup.com/videos/1214-akeeba-solo/1637-abts05-restoring-site-new-server.html',
					$router->route('index.php?view=Transfer'),
					'https://www.akeebabackup.com/latest-kickstart-core.zip'
				); ?>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove"></span>
					<?php echo Text::_('COM_AKEEBA_BUADMIN_BTN_REMINDME'); ?>
				</a>
				<a href="<?php echo $router->route('index.php?view=Manage&task=hideModal') ?>" class="btn btn-success">
					<span class="glyphicon glyphicon-ok-sign"></span>
					<?php echo Text::_('COM_AKEEBA_BUADMIN_BTN_DONTSHOWTHISAGAIN'); ?>
				</a>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function(){
		jQuery("#akeeba-config-howtorestore-bubble").modal({
			backdrop: true,
			keyboard: true,
			show: true
		});
	});
</script>