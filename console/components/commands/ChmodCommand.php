<?php
/**
 *
 */
namespace console\components\commands;

use CConsoleCommand;
use CException;
use Yii;

/**
 * Class ChmodCommand
 *
 * @package console\components\commands
 */
class ChmodCommand extends CConsoleCommand
{
	/**
	 * Aliases of the paths you want to set permissions 777
	 * Can be configured in console configuration
	 *
	 * @var array
	 */
	public $directories = array(
		// runtime folders
		'console.runtime',
		'backend.runtime',
		'frontend.runtime',
		// asset folders
		'backend.www.assets',
		'frontend.www.assets',
		// uploads
		'frontend.www.uploads',
		'frontend.www.uploads.files',
	);

	/**
	 * Run all chmod commands in one action
	 */
	public function actionIndex()
	{
		$directories = (array) $this->directories;
		foreach ($directories as $path) {
			if ($path) {
				$path = Yii::getPathOfAlias($path);
				$this->chmod($path);
			}
		}
	}

	/**
	 * @param string $path
	 *
	 * @throws CException
	 * @return bool
	 */
	protected function chmod($path)
	{
		$realPath = realpath($path);
		if ($realPath !== false) {
			if (is_writable($realPath)) {
				// TODO: may cause error when owner is other user and permission is 0777 already
				if (chmod($realPath, 0777)) {
					$message = strtr('Set permission [777] of the [{path}].', array('{path}' => h($realPath), ));
					echo $message . PHP_EOL;
					return true;
				}
			}
		}
		$error = strtr('File or directory [{path}] does not exist or permission denied.', array('{path}' => h($path), ));
		throw new CException($error);
	}

	/**
	 * Provides the command description.
	 * This method may be overridden to return the actual command description.
	 * @return string the command description. Defaults to 'Usage: php entry-script.php command-name'.
	 */
	public function getHelp()
	{
		return parent::getHelp() .
<<<EOD

You can configure list of the directories to set 777 permission
  in console application config file in 'directories' section:
	'commandMap' => array(
		...
		'chmod' => array(
			'class' => '\console\components\commands\ChmodCommand',
			'directories' => array(
				'yii.alias.to.the.folder',
			),
		),
		...
	),

EOD;
	}
}
