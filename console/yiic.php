<?php
$composer = realpath(
	__DIR__ . DIRECTORY_SEPARATOR
	. '..' . DIRECTORY_SEPARATOR
	. 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'
);
require($composer);

\core\MelonApp::create(__DIR__)->run();
