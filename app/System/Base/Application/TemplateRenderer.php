<?php

declare(strict_types=1);

namespace app\System\Base\Application;

use Nette\Utils\FileSystem;
use RuntimeException;
use Twig\Environment;

/** @SuppressWarnings(PHPMD.Superglobals) */
readonly class TemplateRenderer
{
	public function __construct(private Environment $twig)
	{
	}

	public function isGenerated(string $resultDir): bool
	{
		return empty(glob($resultDir . "*.twig")) === false;
	}

	public function renderAndSaveTemplates(string $originDir, string $resultDir): void
	{
		$twigs = glob($originDir . "/*.twig");

		if ($twigs === false) {
			$twigs = [];
		}

		foreach ($twigs as $twigFile) {
			if (preg_match('#([^/]+)\.twig$#', $twigFile, $matches) === false) {
				throw new RuntimeException("Invalid twig file name");
			}

			$fileName = $matches[1];
			$content = $this->twig->render($fileName . ".twig", $_ENV);
			$configFilePath = \sprintf("%s/%s", $resultDir, str_replace('.twig', '', $fileName));

			if (file_exists($configFilePath) === false) {
				FileSystem::createDir(dirname($configFilePath));
			}

			FileSystem::write($configFilePath, $content);
		}
	}
}
