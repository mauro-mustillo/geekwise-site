<?php
/**
 * @package        solo
 * @copyright      2014-2016 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license        GNU GPL version 3 or later
 */

namespace Solo\View\Log;

use Akeeba\Engine\Factory;
use Akeeba\Engine\Platform;
use Solo\Model\Log;

class Html extends \Solo\View\Html
{
	/**
	 * List of available log files
	 *
	 * @var  array
	 */
	public $logs = array();

	/**
	 * Currently selected log file tag
	 *
	 * @var  string
	 */
	public $tag;

	/**
	 * Is the select log too big for being
	 *
	 * @var bool
	 */
	public $logTooBig = false;

	/**
	 * Size of the log file
	 *
	 * @var int
	 */
	public $logSize = 0;

	/**
	 * Big log file threshold: 2Mb
	 */
	const bigLogSize = 2097152;

	/**
	 * Setup the main log page
	 *
	 * @return  boolean
	 */
	public function onBeforeMain()
	{
		/** @var Log $model */
		$model = $this->getModel();
		$this->logs = $model->getLogList();

		$tag = $model->getState('tag');

		if (empty($tag))
		{
			$tag = null;
		}

		$this->tag = $tag;

		// Let's check if the file is too big to display
		if ($this->tag)
		{
			$file = Factory::getLog()->getLogFilename($this->tag);

			if (@file_exists($file))
			{
				$this->logSize   = filesize($file);
				$this->logTooBig = ($this->logSize >= self::bigLogSize);
			}
		}

		// Get profile ID and name
		$this->profileid   = Platform::getInstance()->get_active_profile();;
		$this->profilename = $this->escape(Platform::getInstance()->get_profile_name($this->profileid));

		return true;
	}

	/**
	 * Setup the iframe display
	 *
	 * @return  boolean
	 */
	public function onBeforeIframe()
	{
		/** @var Log $model */
		$model = $this->getModel();
		$tag = $model->getState('tag');

		if (empty($tag))
		{
			$tag = null;
		}

		$this->tag = $tag;

		return true;
	}
}