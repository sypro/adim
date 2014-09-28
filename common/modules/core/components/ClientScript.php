<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

/**
 * Class ClientScript
 *
 * @package core\components
 */
class ClientScript extends \CClientScript
{
	public function renderCoreScripts()
	{
		if ($this->coreScripts === null) {
			return;
		}
		$cssFiles = array();
		$jsFiles = array();
		foreach ($this->coreScripts as $name => $package) {
			$baseUrl = $this->getPackageBaseUrl($name);
			if (!empty($package['js'])) {
				foreach ($package['js'] as $js) {
					$jsFiles[$baseUrl . '/' . $js] = $baseUrl . '/' . $js;
				}
			}
			if (!empty($package['css'])) {
				foreach ($package['css'] as $css => $media) {
					if (is_integer($css)) {
						$cssFiles[$baseUrl . '/' . $media ] = '';
					} else {
						$cssFiles[$baseUrl . '/' . $css] = $media;
					}
				}
			}
		}
		// merge in place
		if ($cssFiles !== array()) {
			foreach ($this->cssFiles as $cssFile => $media) {
				$cssFiles[$cssFile]=$media;
			}
			$this->cssFiles = $cssFiles;
		}
		if ($jsFiles !== array()) {
			if (isset($this->scriptFiles[$this->coreScriptPosition])) {
				foreach($this->scriptFiles[$this->coreScriptPosition] as $url) {
					$jsFiles[$url] = $url;
				}
			}
			$this->scriptFiles[$this->coreScriptPosition] = $jsFiles;
		}
	}
}
