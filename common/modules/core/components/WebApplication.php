<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

/**
 * Class WebApplication
 *
 * @package core\components
 *
 * @property \core\components\ClientScript $clientScript
 * @property \CHttpRequest $request
 * @property \CFormatter $format
 * @property \language\components\LanguageUrlManager $urlManager
 * @property \configuration\components\ConfigurationComponent $config
 * @property \console\components\YiiMail $mail
 *
 * @method \core\components\ClientScript getClientScript()
 * @method \CHttpRequest getRequest()
 * @method \CWebUser getUser()
 * @method \language\components\LanguageUrlManager getUrlManager()
 */
class WebApplication extends \CWebApplication
{
}
