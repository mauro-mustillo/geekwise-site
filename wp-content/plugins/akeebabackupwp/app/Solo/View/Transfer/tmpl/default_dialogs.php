<?php
/**
 * @package		solo
 * @copyright	2014-2016 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license		GNU GPL version 3 or later
 */

// Protect from unauthorized access
use Awf\Text\Text;

/** @var  $this  Solo\View\Transfer\Html */
?>

<div class="modal fade" id="ftpdialog" tabindex="-1" role="dialog" aria-labelledby="ftpdialogLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="ftpdialogLabel">
					<?php echo Text::_('COM_AKEEBA_CONFIG_UI_FTPBROWSER_TITLE') ?>
				</h4>
			</div>
			<div class="modal-body">
				<p class="instructions alert alert-info hidden-xs">
					<?php echo Text::_('COM_AKEEBA_FTPBROWSER_LBL_INSTRUCTIONS'); ?>
				</p>
				<div class="error alert alert-danger" id="ftpBrowserErrorContainer">
					<h2><?php echo Text::_('COM_AKEEBA_FTPBROWSER_LBL_ERROR'); ?></h2>

					<p id="ftpBrowserError"></p>
				</div>
				<ul id="ak_crumbs2" class="breadcrumb"></ul>
				<div class="folderBrowserWrapper" id="ftpBrowserWrapper">
					<table id="ftpBrowserFolderList" class="table table-striped">
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="ftpdialogCancelButton" class="btn btn-default" data-dismiss="modal">
					<?php echo Text::_('SOLO_BTN_CANCEL') ?>
				</button>
				<button type="button" id="ftpdialogOkButton" class="btn btn-primary">
					<?php echo Text::_('COM_AKEEBA_BROWSER_LBL_USE') ?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="sftpdialog" tabindex="-1" role="dialog" aria-labelledby="sftpdialogLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="sftpdialogLabel">
					<?php echo Text::_('COM_AKEEBA_CONFIG_UI_SFTPBROWSER_TITLE') ?>
				</h4>
			</div>
			<div class="modal-body">
				<p class="instructions alert alert-info">
					<?php echo Text::_('COM_AKEEBA_SFTPBROWSER_LBL_INSTRUCTIONS'); ?>
				</p>
				<div class="error alert alert-danger" id="sftpBrowserErrorContainer">
					<h2><?php echo Text::_('COM_AKEEBA_SFTPBROWSER_LBL_ERROR'); ?></h2>

					<p id="sftpBrowserError"></p>
				</div>
				<ul id="ak_scrumbs" class="breadcrumb"></ul>
				<div class="folderBrowserWrapper" id="sftpBrowserWrapper">
					<table id="sftpBrowserFolderList" class="table table-striped">
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="sftpdialogCancelButton" class="btn btn-default" data-dismiss="modal">
					<?php echo Text::_('SOLO_BTN_CANCEL') ?>
				</button>
				<button type="button" id="sftpdialogOkButton" class="btn btn-primary">
					<?php echo Text::_('COM_AKEEBA_BROWSER_LBL_USE') ?>
				</button>
			</div>
		</div>
	</div>
</div>

