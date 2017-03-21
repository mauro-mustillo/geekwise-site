<?php
/**
 * @package   AkeebaBackup
 * @copyright Copyright (c)2009-2016 Nicholas K. Dionysopoulos
 * @license   GNU General Public License version 3, or later
 *
 * @since     1.3
 */

/** @var  array  $record */
/** @var  Solo\View\Manage\Html  $this */

use Awf\Text\Text;
use Solo\Helper\Utils as AkeebaHelperUtils;

$router           = $this->container->router;
$cancelLabel      = Text::_('SOLO_MANAGE_LBL_CANCELMODAL');

$archiveExists    = $record['meta'] == 'ok';
$showManageRemote = in_array($record['meta'], array('ok', 'remote')) && !empty($record['remote_filename']) && (AKEEBABACKUP_PRO == 1);
$showUploadRemote = $archiveExists && @empty($record['remote_filename']) && ($this->enginesPerProfile[$record['profile_id']] != 'none') && ($record['meta'] != 'obsolete') && (AKEEBABACKUP_PRO == 1);
$showDownload     = $archiveExists;
$showViewLog      = isset($record['backupid']) && !empty($record['backupid']);
$postProcEngine   = '';
$thisPart         = '';
$thisID           = urlencode($record['id']);

if ($showUploadRemote)
{
	$postProcEngine   = $this->enginesPerProfile[$record['profile_id']];
	$showUploadRemote = !empty($postProcEngine);
}

?>
<div class="hide fade">
	<div id="akeeba-buadmin-<?php echo $record['profile_id'] ?>" tabindex="-1" role="dialog">
		<h3><?php echo Text::_('COM_AKEEBA_BUADMIN_LBL_BACKUPINFO') ?></h3>
		<p>
			<strong><?php echo Text::_('COM_AKEEBA_BUADMIN_LBL_ARCHIVEEXISTS') ?></strong><br/>
			<?php if ($record['meta'] == 'ok'): ?>
				<span class="label label-success">
					<?php echo Text::_('SOLO_YES') ?>
				</span>
			<?php else: ?>
				<span class="label label-danger">
					<?php echo Text::_('SOLO_NO') ?>
				</span>
			<?php endif; ?>
		</p>
		<p>
			<strong><?php echo Text::_('COM_AKEEBA_BUADMIN_LBL_ARCHIVEPATH' . ($archiveExists ? '' : '_PAST')) ?></strong><br/>
		<span class="label label-default">
		<?php echo htmlentities(AkeebaHelperUtils::getRelativePath(APATH_BASE, dirname($record['absolute_path']))) ?>
		</span>
		</p>
		<p>
			<strong><?php echo Text::_('COM_AKEEBA_BUADMIN_LBL_ARCHIVENAME' . ($archiveExists ? '' : '_PAST')) ?></strong><br/>
		<span class="label label-default">
		<?php echo htmlentities($record['archivename']) ?>
		</span>
		</p>
	</div>

	<div id="akeeba-buadmin-download-<?php echo $record['profile_id'] ?>" tabindex="-2" role="dialog">
		<div class="alert">
			<h4>
				<span class="fa fa-warning"></span>
				<?php echo Text::_('COM_AKEEBA_BUADMIN_LBL_DOWNLOAD_TITLE') ?>
			</h4>
			<?php echo Text::_('COM_AKEEBA_BUADMIN_LBL_DOWNLOAD_WARNING') ?>
		</div>

		<?php if ($record['multipart'] < 2): ?>
			<a class="btn btn-default btn-xs" href="javascript:confirmDownload('<?php echo $thisID ?>', '<?php echo $thisPart ?>');">
				<span class="fa fa-fw fa-download"></span>
				<?php echo Text::_('COM_AKEEBA_BUADMIN_LOG_DOWNLOAD'); ?>
			</a>
		<?php else: ?>
			<div>
				<?php echo Text::sprintf('COM_AKEEBA_BUADMIN_LBL_DOWNLOAD_PARTS', $record['multipart']); ?>
			</div>
			<?php for ($count = 0; $count < $record['multipart']; $count++):
				$thisPart = urlencode($count);
				$label = Text::sprintf('COM_AKEEBA_BUADMIN_LABEL_PART', $count);
				?>
				<?php if ($count > 0): ?>
				&bull;
			<?php endif; ?>
				<a class="btn btn-default btn-xs" href="javascript:confirmDownload('<?php echo $thisID ?>', '<?php echo $thisPart ?>');">
					<span class="fa fa-fw fa-download"></span>
					<?php echo $label; ?>
				</a>
			<?php endfor; ?>
		<?php endif; ?>
	</div>
</div>

<?php if ($showManageRemote): ?>
<div style="padding-bottom: 3pt;">
	<button class="akeeba_remote_management_link btn btn-primary"
	        rel='{"href": "<?php echo $router->route('index.php?view=Remotefiles&tmpl=component&task=listActions&id=' . $record['id']) ?>", "CancelLabel": "<?php echo $cancelLabel ?>", "OkLabel": "", "OkHandler": "function(){ window.location = window.location; }", "CancelHandler": "function(){ window.location = window.location; }" }'
	        onclick="Solo.System.modal(this); return false;">
		<span class="fa fa-fw fa-cloud"></span>
		<?php echo Text::_('COM_AKEEBA_BUADMIN_LABEL_REMOTEFILEMGMT'); ?>
	</button>
</div>
<?php elseif ($showUploadRemote): ?>
	<button class="btn btn-primary akeeba_upload"
       rel='{"href": "<?php echo $router->route('index.php?view=Upload&tmpl=component&task=start&id=' . $record['id']) ?>", "OkLabel": "", "CancelLabel": "", "showButtons": "0"}'
            onclick="Solo.System.modal(this); return false;"
	   title="<?php echo Text::sprintf('COM_AKEEBA_TRANSFER_DESC', Text::_("ENGINE_POSTPROC_{$postProcEngine}_TITLE")) ?>"
		>
		<span class="fa fa-fw fa-cloud-upload"></span>
		<?php echo Text::_('COM_AKEEBA_TRANSFER_TITLE') ?>
		(<em><?php echo $postProcEngine ?></em>)
	</button>
<?php endif; ?>

<div style="padding-bottom: 3pt">
	<?php if ($showDownload): ?>
	<button class="btn <?php echo $showManageRemote || $showUploadRemote ? 'btn-sm' : 'btn-success' ?>"
	        rel='{"href": "#akeeba-buadmin-download-<?php echo $record['profile_id'] ?>", "CancelLabel": "<?php echo $cancelLabel ?>", "OkLabel": "", "OkHandler": "function(){ window.location = window.location; }", "CancelHandler": "function(){ window.location = window.location; }" }'
	        onclick="Solo.System.modal(this); return false;"
		>
		<span class="fa fa-fw fa-download"></span>
		<?php echo Text::_('COM_AKEEBA_BUADMIN_LOG_DOWNLOAD'); ?>
	</button>
	<?php endif; ?>

	<?php if ($showViewLog): ?>
	<button class="btn btn-default btn-sm akeebaCommentPopover" <?php echo ($record['meta'] != 'obsolete') ? '' : 'disabled="disabled" onclick="return false;"'?>
		rel="popover"
	<?php if (($record['meta'] != 'obsolete')): ?>
	   onclick="window.location='<?php echo $router->route('index.php?view=Log&tag=' . $this->escape($record['tag']) . '.' . $this->escape($record['backupid']) . '&task=start&profileid=' . $record['profile_id']) ?>'; return false;"
	<?php endif; ?>
	   title="<?php echo Text::_('COM_AKEEBA_BUADMIN_LBL_LOGFILEID') ?>"
	   data-content="<?php echo $this->escape($record['backupid']) ?>"
		>
		<span class="fa fa-fw fa-list"></span>
		<?php echo Text::_('COM_AKEEBA_LOG'); ?>
	</button>
	<?php endif; ?>

	<button class="btn btn-default btn-sm"
        rel='{"href": "#akeeba-buadmin-<?php echo $record['profile_id'] ?>", "CancelLabel": "<?php echo $cancelLabel ?>", "OkLabel": "", "OkHandler": "function(){ window.location = window.location; }", "CancelHandler": "function(){ window.location = window.location; }" }'
        onclick="Solo.System.modal(this); return false;"
		title="<?php echo Text::_('COM_AKEEBA_BUADMIN_LBL_BACKUPINFO'); ?>"
		>
		<span class="fa fa-fw fa-info"></span>
	</button>
</div>

<?php if ($showDownload): ?>
<?php endif; ?>
