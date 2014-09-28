<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

/**
 * Class ErrorHandler
 *
 * @package core\components
 */
class ErrorHandler extends \CErrorHandler
{
	/**
	 * This setting determines the format of the links that are made in the display of stack traces where file names are used.
	 * This allows IDEs to set up a link-protocol that makes it possible to go directly to a line and file by clicking on the code line.
	 * An example format might look like:
	 *
	 * myide://{file}:{line}
	 * http://localhost:8091?message={file}:{line}
	 *
	 * @var string
	 */
	public $fileLinkFormat = 'http://localhost:8091?message={file}:{line}';

	/**
	 * Renders the source code around the error line.
	 * @param string $file source file path
	 * @param integer $errorLine the error line number
	 * @param integer $maxLines maximum number of lines to display
	 * @return string the rendering result
	 */
	protected function renderSourceCode($file, $errorLine, $maxLines)
	{
		$errorLine--; // adjust line number to 0-based from 1-based
		if ($errorLine < 0 || ($lines = @file($file)) === false || ($lineCount = count($lines)) <= $errorLine) {
			return '';
		}

		$halfLines = (int)($maxLines / 2);
		$beginLine = $errorLine - $halfLines > 0 ? $errorLine - $halfLines : 0;
		$endLine = $errorLine + $halfLines < $lineCount ? $errorLine + $halfLines : $lineCount - 1;
		$lineNumberWidth = strlen($endLine + 1);

		$output = '';
		$link = strtr($this->fileLinkFormat, array('{file}' => $file, ));
		for ($i = $beginLine; $i <= $endLine; ++$i) {
			$isErrorLine = $i === $errorLine;
			$lineLink = strtr($link, array('{line}' => $i + 1, ));
			$url = \Chtml::link(
				str_pad($i + 1, $lineNumberWidth, '0', STR_PAD_LEFT),
				$lineLink,
				array(
					'onclick' => 'javascript: var r = new XMLHttpRequest; r.open("get", "' . $lineLink . '"); r.send(); return false;',
				)
			);
			$line = \CHtml::encode(str_replace("\t", '    ', $lines[$i]));
			$code = "<span class=\"ln" . ($isErrorLine ? ' error-ln' : '') . "\">{$url}</span> {$line}";
			if (!$isErrorLine) {
				$output .= $code;
			} else {
				$output .= '<span class="error">' . $code . '</span>';
			}
		}

		return '<div class="code"><pre>' . $output . '</pre></div>';
	}

	protected function render($view, $data)
	{
		if (r()->isAjaxRequest) {
			echo $data['message'];
		} else {
			if (isset($_GET['DEBUG_MODE']) && $_GET['DEBUG_MODE']==='ON') {
				$debug = array();
				if (function_exists('gethostname')) {
					$hostname = gethostname();
					if ($hostname) {
						$debug[] = $hostname;
					}
				}
				$debug[] = \Yii::app()->request->getHostInfo();
				$debug[] = \Yii::app()->request->getServerName();
				echo join('|', $debug);
				unset($debug);
			}
			parent::render($view, $data);
		}
	}
}
