<?php
/**
 *
 */
namespace console\components\commands;

\Yii::import('system.cli.commands.MessageCommand');

/**
 * Class MessageCommand
 *
 * @package console\commands
 */
class MessageCommand extends \MessageCommand
{
	/**
	 * @var string
	 */
	public $translator = 't';

	/**
	 * @param array $args
	 *
	 * @return int|void
	 */
	public function run($args)
	{
		if (!isset($args[0])) {
			$this->usageError('the configuration file is not specified.');
		}
		if (!is_file($args[0])) {
			$this->usageError("the configuration file {$args[0]} does not exist.");
		}

		$config = require($args[0]);
		$translator = $this->translator;
		extract($config);

		if (!isset($sourcePath, $messagePath, $languages)) {
			$this->usageError('The configuration file must specify "sourcePath", "messagePath" and "languages".');
			return;
		}
		if (!is_dir($sourcePath)) {
			$this->usageError("The source path $sourcePath is not a valid directory.");
		}
		if (!is_dir($messagePath)) {
			$this->usageError("The message path $messagePath is not a valid directory.");
		}
		if (empty($languages)) {
			$this->usageError("Languages cannot be empty.");
		}

		if (!isset($overwrite)) {
			$overwrite = false;
		}

		if (!isset($removeOld)) {
			$removeOld = false;
		}

		if (!isset($sort)) {
			$sort = false;
		}

		$options = array();
		if (isset($fileTypes)) {
			$options['fileTypes'] = $fileTypes;
		}
		if (isset($exclude)) {
			$options['exclude'] = $exclude;
		}
		$files = \CFileHelper::findFiles(realpath($sourcePath), $options);

		$messages = array();
		foreach ($files as $file) {
			$messages = array_merge_recursive($messages, $this->extractMessages($file, $translator));
		}

		foreach ($languages as $language) {
			$dir = $messagePath . DIRECTORY_SEPARATOR . $language;
			if (!is_dir($dir)) {
				@mkdir($dir);
			}
			foreach ($messages as $category => $categoryMessages) {
				$categoryMessages = array_values(array_unique($categoryMessages));
				$this->generateMessageFile(
					$categoryMessages,
					$dir . DIRECTORY_SEPARATOR . $category . '.php',
					$overwrite,
					$removeOld,
					$sort
				);
			}
		}
	}

	protected function extractMessages($fileName, $translator)
	{
		echo "Extracting messages from $fileName...\n";
		$subject = file_get_contents($fileName);
		$messages = array();
		if (!is_array($translator)) {
			$translator = array($translator);
		}

		foreach ($translator as $currentTranslator) {
			$n = preg_match_all(
				'/\b' . $currentTranslator . '\s*\(\s*(\'.[^\']*?(?<!\\\\)\'|".[^"]*?(?<!\\\\)")\s*[\)]/',
				$subject,
				$matches,
				PREG_SET_ORDER
			);

			for ($i = 0; $i < $n; ++$i) {
				$category = 'core';
				$message = $matches[$i][1];
				$messages[$category][] = eval("return {$message};"); // use eval to eliminate quote escape
			}

			$n = preg_match_all(
				'/\b'.$currentTranslator.'\s*\(\s*(\'[\w.\/]*?(?<!\.)\'|"[\w.]*?(?<!\.)")\s*,\s*(\'.[^\']*?(?<!\\\\)\'|".[^"]*?(?<!\\\\)")\s*[,\)]/',
				$subject,
				$matches,
				PREG_SET_ORDER
			);

			for ($i = 0; $i < $n; ++$i) {
				if (($pos = strpos($matches[$i][1], '.')) !== false) {
					$category = substr($matches[$i][1], $pos + 1, -1);
				} else {
					$category = substr($matches[$i][1], 1, -1);
				}
				$message = $matches[$i][2];
				$messages[$category][] = eval("return $message;"); // use eval to eliminate quote escape
			}
		}

		return $messages;
	}

	protected function generateMessageFile($messages, $fileName, $overwrite, $removeOld, $sort)
	{
		echo "Saving messages to $fileName...";
		if (is_file($fileName)) {
			$translated = require($fileName);
			sort($messages);
			ksort($translated);
			if (array_keys($translated) == $messages) {
				echo "nothing new...skipped.\n";

				return;
			}
			$merged = array();
			$untranslated = array();
			foreach ($messages as $message) {
				if (array_key_exists($message, $translated) && strlen($translated[$message]) > 0) {
					$merged[$message] = $translated[$message];
				} else {
					$untranslated[] = $message;
				}
			}
			ksort($merged);
			sort($untranslated);
			$todo = array();
			foreach ($untranslated as $message) {
				$todo[$message] = '';
			}
			ksort($translated);
			foreach ($translated as $message => $translation) {
				if (!isset($merged[$message]) && !isset($todo[$message]) && !$removeOld) {
					if (substr($translation, 0, 2) === '@@' && substr($translation, -2) === '@@') {
						$todo[$message] = $translation;
					} else {
						$todo[$message] = '@@' . $translation . '@@';
					}
				}
			}
			$merged = array_merge($todo, $merged);
			if ($sort) {
				ksort($merged);
			}
			if ($overwrite === false) {
				$fileName .= '.merged';
			}
			echo "translation merged.\n";
		} else {
			$merged = array();
			foreach ($messages as $message) {
				$merged[$message] = '';
			}
			ksort($merged);
			echo "saved.\n";
		}
		$array = str_replace(
			array("',\n  '", "array (\n  '"),
			array("',\n\t'", "array (\n\t'"),
			var_export($merged, true)
		);
		$array = str_replace("\r", '', $array);
		$content = <<<EOD
<?php
/**
 * Message translations.
 *
 * This file is automatically generated by 'yiic message' command.
 * It contains the localizable messages extracted from source code.
 * You may modify this file by translating the extracted messages.
 *
 * Each array element represents the translation (value) of a message (key).
 * If the value is empty, the message is considered as not translated.
 * Messages that no longer need translation will have their translations
 * enclosed between a pair of '@@' marks.
 *
 * Message string can be used with plural forms format. Check i18n section
 * of the guide for details.
 *
 * NOTE, this file must be saved in UTF-8 encoding.
 */

return $array;

EOD;
		file_put_contents($fileName, $content);
	}
}
