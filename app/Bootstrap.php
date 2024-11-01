<?php

declare(strict_types=1);

namespace app;

use app\System\Base\Application\TemplateRenderer;
use Nette\Bootstrap\Configurator;
use RuntimeException;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/** @SuppressWarnings(PHPMD.Superglobals) */
class Bootstrap
{
	public static function boot(): Configurator
	{
		$configurator = new Configurator();
		$appDir = dirname(__DIR__);

		$productionMode = $_ENV['PRODUCTION_MODE'] ?? true;
		$resultDir = __DIR__ . '/temp';

		$configurator->setDebugMode($productionMode);

		if (isset($_COOKIE['nette-debug']) && $_COOKIE['nette-debug'] === '1') {
			$configurator->setDebugMode(true);
		}

		$configurator->enableTracy($appDir . '/log');

		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_WARNING);

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory($appDir . '/temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		define('__APP_DIR__', __DIR__);
		define('__WWW_DIR__', __DIR__ . '/../www/');

		self::renderSecrets($resultDir);

		//dynamic config files
		$dynamicConfigs = glob($resultDir . '/*.neon');

		if ($dynamicConfigs === false) {
			throw new RuntimeException("No dynamic config files found in $resultDir");
		}

		foreach ($dynamicConfigs as $neonFile) {
			$configurator->addConfig($neonFile);
		}

		$staticConfigs = glob($appDir . '/config/*.neon');

		if ($staticConfigs === false) {
			throw new RuntimeException("No dynamic config files found in $appDir");
		}

		//static config files
		foreach ($staticConfigs as $neonFile) {
			$configurator->addConfig($neonFile);
		}

		return $configurator;
	}

	private static function renderSecrets(string $resultDir): void
	{
		$originDir = __DIR__ . '/../deploy/local';

		$twigLoader = new FilesystemLoader($originDir);
		$twig = new Environment($twigLoader);

		$renderer = new TemplateRenderer($twig);

		if (! $renderer->isGenerated($resultDir)) {
			$renderer->renderAndSaveTemplates($originDir, $resultDir);
		}
	}
}
