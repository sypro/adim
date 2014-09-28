<?php
/**
 * Yiinitialzr\Composer\Callback provides composer hooks
 *
 * Totally inspired by the ComposerCallback of Phundament3 and adapted for its use with Yiinitialzr
 *
 * This setup class triggers `./yiic migrate` at post-install and post-update.
 * For a package the class triggers `./yiic <vendor/<packageName>-<action>` at post-package-install and
 * post-package-update.
 *
 * You can also create new commands to be called within your boilerplate configuration.
 *
 * See composer manual (http://getcomposer.org/doc/articles/scripts.md)
 *
 * Usage example
 *
 * config.php
 *     'params' => array(
 *            'composer.callbacks' => array(
 *            'post-update' => array('yiic', 'migrate'),
 *            'post-install' => array('yiic', 'migrate'),
 *            'yiisoft/yii-install' => array('yiic', 'webapp', realpath(dirname(__FILE__))),
 *        ),
 * ))
 *
 * composer.json
 *   "scripts": {
 *            "pre-install-cmd": "Yiinitialzr\\Composer\\Callback::preInstall",
 *            "post-install-cmd": "Yiinitialzr\\Composer\\Callback::postInstall",
 *            "pre-update-cmd": "Yiinitialzr\\Composer\\Callback::preUpdate",
 *            "post-update-cmd": "Yiinitialzr\\Composer\\Callback::postUpdate",
 *            "post-package-install": [
 *                "Yiinitialzr\\Composer\\Callback::postPackageInstall"
 *            ],
 *            "post-package-update": [
 *            "Yiinitialzr\\Composer\\Callback::postPackageUpdate"
 *            ]
 * }
 *
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://2amigos.us
 * @copyright 2013 2amigOS! Consultation Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 *
 * Credits to Phundament... Tobias, thanks for introducing me the wonders of composer
 *
 * @author Tobias Munk <schmunk@usrbin.de>
 * @link http://www.phundament.com/
 * @copyright Copyright &copy; 2012 diemeisterei GmbH
 * @license http://www.phundament.com/license
 */
namespace core;

use Composer\Script\Event;

/**
 * Class Callback
 *
 * @package core
 */
class Callback
{
	private static $_app;
	/**
	 * Displays welcome message
	 *
	 * @static
	 *
	 * @param \Composer\Script\Event $event
	 */
	public static function preInstall(Event $event)
	{
		self::runHook('pre-install');
	}

	/**
	 * Executes a post-install callback
	 *
	 * @static
	 *
	 * @param \Composer\Script\Event $event
	 */
	public static function postInstall(Event $event)
	{
		self::runHook('post-install');
		Console::output("\n%GInstallation completed!%n\n");
	}

	/**
	 * Displays updating message
	 *
	 * @static
	 *
	 * @param \Composer\Script\Event $event
	 */
	public static function preUpdate(Event $event)
	{
		Console::output("Updating your application to the latest available packages...");
		self::runHook('pre-update');
	}

	/**
	 * Executes post-update message
	 *
	 * @static
	 *
	 * @param \Composer\Script\Event $event
	 */
	public static function postUpdate(Event $event)
	{
		self::runHook('post-update');
		Console::output("%GUpdate completed.%n");
	}

	/**
	 * Executes ./yiic <vendor/<packageName>-<action>
	 *
	 * @static
	 *
	 * @param \Composer\Script\Event $event
	 */
	public static function postPackageInstall(Event $event)
	{
		$installedPackage = $event->getOperation()->getPackage();
		$hookName = $installedPackage->getPrettyName() . '-install';
		self::runHook($hookName);
	}

	/**
	 * Executes ./yiic <vendor/<packageName>-<action>
	 *
	 * @static
	 *
	 * @param \Composer\Script\Event $event
	 */
	public static function postPackageUpdate(Event $event)
	{
		$installedPackage = $event->getOperation()->getTargetPackage();
		$commandName = $installedPackage->getPrettyName() . '-update';
		self::runHook($commandName);
	}

	/**
	 * Runs Yii command, if available (defined in config.php)
	 */
	private static function runHook($name)
	{
		$app = self::getYiiApplication();
		if ($app === null) {
			return;
		}

		if (isset($app->params['composer.callbacks'][$name]) && is_array($app->params['composer.callbacks'][$name])) {
			$app->commandRunner->addCommands(\Yii::getPathOfAlias('system.cli.commands'));
			foreach ($app->params['composer.callbacks'][$name] as $command) {
				$app->commandRunner->run($command);
			}
		}
	}

	/**
	 * Creates console application, if Yii is available
	 */
	private static function getYiiApplication()
	{
		if (self::$_app) {
			return self::$_app;
		}
		$vendor = realpath(
			__DIR__ . DIRECTORY_SEPARATOR
			. '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
			. 'vendor'
		);
		self::$_app = \core\MelonApp::create(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'console', $vendor, true);
		return self::$_app;
	}
}
