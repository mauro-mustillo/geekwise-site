<?php
/**
 * @package		solo
 * @copyright	2014-2016 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license		GNU GPL version 3 or later
 */

namespace Solo\View\Transfer;

use Akeeba\Engine\Platform;
use Awf\Date\Date;
use Awf\Text\Text;
use Awf\Utils\Template;

class Html extends \Solo\View\Html
{
	/** @var   array|null  Latest backup information */
	public $latestBackup = array();

	/** @var   string  Date of the latest backup, human readable */
	public $lastBackupDate = '';

	/** @var   array  Space required on the target server */
	public $spaceRequired = array(
		'size'   => 0,
		'string' => '0.00 Kb'
	);

	/** @var   string  The URL to the site we are restoring to (from the session) */
	public $newSiteUrl = '';

    public $newSiteUrlResult;

	/** @var   array  Results of support and firewall status of the known file transfer methods */
	public $ftpSupport = array(
		'supported'  => array(
			'ftp'  => false,
			'ftps' => false,
			'sftp' => false,
		),
		'firewalled' => array(
			'ftp'  => false,
			'ftps' => false,
			'sftp' => false
		)
	);

	/** @var   array  Available transfer options, for use by JHTML */
	public $transferOptions = array();

	/** @var   bool  Do I have supported but firewalled methods? */
	public $hasFirewalledMethods = false;

	/** @var   string  Currently selected transfer option */
	public $transferOption = 'manual';

	/** @var   string  FTP/SFTP host name */
	public $ftpHost = '';

	/** @var   string  FTP/SFTP port (empty for default port) */
	public $ftpPort = '';

	/** @var   string  FTP/SFTP username */
	public $ftpUsername = '';

	/** @var   string  FTP/SFTP password – or certificate password if you're using SFTP with SSL certificates */
	public $ftpPassword = '';

	/** @var   string  SFTP public key certificate path */
	public $ftpPubKey = '';

	/** @var   string  SFTP private key certificate path */
	public $ftpPrivateKey = '';

	/** @var   string  FTP/SFTP directory to the new site's root */
	public $ftpDirectory = '';

	/** @var   string  FTP passive mode (default is true) */
	public $ftpPassive = true;

	/** @var   string  FTP passive mode workaround, for FTP/FTPS over cURL (default is true) */
	public $ftpPassiveFix = true;

	/** @var   int     Forces the transfer by skipping some checks on the target site */
	public $force = 0;

    /**
	 * Runs on the wizard (default) task
	 *
	 * @param   string|null  $tpl  Ignored
	 *
	 * @return  bool  True to let the view display
	 */
	public function onBeforeWizard($tpl = null)
	{
        $button = array(
            'title' 	=> Text::_('COM_AKEEBA_TRANSFER_BTN_RESET'),
            'class' 	=> 'btn-success',
            'url'	    => $this->getContainer()->router->route('index.php?view=transfer&task=reset'),
            'icon' 		=> 'glyphicon glyphicon-refresh'
        );

        $document = $this->container->application->getDocument();
        $document->getToolbar()->addButtonFromDefinition($button);

        Template::addJs('media://js/solo/transfer.js', $this->container->application);

		/** @var \Solo\Model\Transfers $model */
		$model                  = $this->getModel();
		$session			    = $this->container->segment;

		$this->latestBackup     = $model->getLatestBackupInformation();
		$this->spaceRequired    = $model->getApproximateSpaceRequired();
		$this->newSiteUrl       = $session->get('transfer.url', '');
		$this->newSiteUrlResult = $session->get('transfer.url_status', '');
		$this->ftpSupport	    = $session->get('transfer.ftpsupport', null);
		$this->transferOption   = $session->get('transfer.transferOption', null);
		$this->ftpHost          = $session->get('transfer.ftpHost', null);
		$this->ftpPort          = $session->get('transfer.ftpPort', null);
		$this->ftpUsername      = $session->get('transfer.ftpUsername', null);
		$this->ftpPassword      = $session->get('transfer.ftpPassword', null);
		$this->ftpPubKey        = $session->get('transfer.ftpPubKey', null);
		$this->ftpPrivateKey    = $session->get('transfer.ftpPrivateKey', null);
		$this->ftpDirectory     = $session->get('transfer.ftpDirectory', null);
		$this->ftpPassive       = $session->get('transfer.ftpPassive', 1);
		$this->ftpPassiveFix    = $session->get('transfer.ftpPassiveFix', 1);

		// We get this option from the request
		$this->force = $this->input->getInt('force', 0 );

		if (!empty($this->latestBackup))
		{
			$lastBackupDate = new Date($this->latestBackup['backupstart'], 'UTC');
			$this->lastBackupDate = $lastBackupDate->format(Text::_('DATE_FORMAT_LC'), true);

			$session->set('transfer.lastBackup', $this->latestBackup);
		}

		if (empty($this->ftpSupport))
		{
			$this->ftpSupport = $model->getFTPSupport();
			$session->set('transfer.ftpsupport', $this->ftpSupport);
		}

		$this->transferOptions  = $this->getTransferMethodOptions();

		/*
		foreach ($this->ftpSupport['firewalled'] as $method => $isFirewalled)
		{
			if ($isFirewalled && $this->ftpSupport['supported'][$method])
			{
				$this->hasFirewalledMethods = true;

				break;
			}
		}
		*/

		return true;
	}

	/**
	 * Returns the JHTML options for a transfer methods drop-down, filtering out the unsupported and firewalled methods
	 *
	 * @return   array
	 */
	private function getTransferMethodOptions()
	{
		$options = array();

		foreach ($this->ftpSupport['supported'] as $method => $supported)
		{
			if (!$supported)
			{
				continue;
			}

			$methodName = Text::_('COM_AKEEBA_TRANSFER_LBL_TRANSFERMETHOD_' . $method);

			if ($this->ftpSupport['firewalled'][$method])
			{
				$methodName = '&#128274; ' . $methodName;
			}

			$options[] = array('value' => $method, 'text' => $methodName);
		}

		$options[] = array('value' => 'manual', 'text' => Text::_('COM_AKEEBA_TRANSFER_LBL_TRANSFERMETHOD_MANUALLY'));

		return $options;
	}
}