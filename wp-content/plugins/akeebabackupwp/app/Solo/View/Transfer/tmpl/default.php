<?php
/**
 * @package		solo
 * @copyright	2014-2016 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license		GNU GPL version 3 or later
 */

// Protect from unauthorized access
use Awf\Text\Text;
use Solo\Helper\Escape;

/** @var  $this  Solo\View\Transfer\Html */

$translations = array(
	'UI-BROWSE'	            => Escape::escapeJS(Text::_('COM_AKEEBA_CONFIG_UI_BROWSE')),
	'UI-CONFIG'	            => Escape::escapeJS(Text::_('COM_AKEEBA_CONFIG_UI_CONFIG')),
	'UI-REFRESH'	        => Escape::escapeJS(Text::_('COM_AKEEBA_CONFIG_UI_REFRESH')),
	'UI-FTPBROWSER-TITLE'	=> Escape::escapeJS(Text::_('COM_AKEEBA_CONFIG_UI_FTPBROWSER_TITLE')),
	'UI-ROOT'	            => Escape::escapeJS(Text::_('COM_AKEEBA_FILEFILTERS_LABEL_UIROOT')),
	'UI-TESTFTP-OK'	        => Escape::escapeJS(Text::_('COM_AKEEBA_CONFIG_DIRECTFTP_TEST_OK')),
	'UI-TESTFTP-FAIL'	    => Escape::escapeJS(Text::_('COM_AKEEBA_CONFIG_DIRECTFTP_TEST_FAIL')),
	'UI-TESTSFTP-OK'	    => Escape::escapeJS(Text::_('COM_AKEEBA_CONFIG_DIRECTSFTP_TEST_OK')),
	'UI-TESTSFTP-FAIL'	    => Escape::escapeJS(Text::_('COM_AKEEBA_CONFIG_DIRECTSFTP_TEST_FAIL')),
);

$ajaxurl = $this->getContainer()->router->route('index.php?view=transfer&format=raw&force='.$this->force);

$js = <<< JS
Solo.loadScripts[Solo.loadScripts.length] = function () {
	(function($){
        Solo.System.params.AjaxURL = '$ajaxurl';

        // Initialise the translations
        Solo.Transfer.translations['UI-BROWSE']             = '{$translations['UI-BROWSE']}';
        Solo.Transfer.translations['UI-CONFIG']             = '{$translations['UI-CONFIG']}';
        Solo.Transfer.translations['UI-REFRESH']            = '{$translations['UI-REFRESH']}';
        Solo.Transfer.translations['UI-FTPBROWSER-TITLE']   = '{$translations['UI-FTPBROWSER-TITLE']}';
        Solo.Transfer.translations['UI-ROOT']               = '{$translations['UI-ROOT']}';
        Solo.Transfer.translations['UI-TESTFTP-OK']         = '{$translations['UI-TESTFTP-OK']}';
        Solo.Transfer.translations['UI-TESTFTP-FAIL']       = '{$translations['UI-TESTFTP-FAIL']}';
        Solo.Transfer.translations['UI-TESTSFTP-OK']        = '{$translations['UI-TESTSFTP-OK']}';
        Solo.Transfer.translations['UI-TESTSFTP-FAIL']      = '{$translations['UI-TESTSFTP-FAIL']}';

        // Last results of new site URL processing
        Solo.Transfer.lastUrl    = '{$this->newSiteUrl}';
        Solo.Transfer.lastResult = '{$this->newSiteUrlResult}';

        // Auto-process URL change event
        if ($('#akeeba-transfer-url').val())
        {
            Solo.Transfer.onUrlChange();
        }

	}(akeeba.jQuery));
};
JS;

$this->getContainer()->application->getDocument()->addScriptDeclaration($js);
?>
<?php if ($this->force):?>
	<div class="alert alert-danger">
		<h3><?php echo Text::_('COM_AKEEBA_TRANSFER_FORCE_HEADER')?></h3>
		<p><?php echo Text::_('COM_AKEEBA_TRANSFER_FORCE_BODY')?></p>
	</div>
<?php endif; ?>

<?php
echo $this->loadAnyTemplate('Transfer/default_dialogs');
echo $this->loadAnyTemplate('Transfer/default_prerequisites');

if (empty($this->latestBackup))
{
	return;
}

echo $this->loadAnyTemplate('Transfer/default_remoteconnection');
echo $this->loadAnyTemplate('Transfer/default_manualtransfer');
echo $this->loadAnyTemplate('Transfer/default_upload');