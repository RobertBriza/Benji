<?php

declare(strict_types=1);

namespace app\System\Vite;

use Nette\Http\Request;
use Nette\Utils\FileSystem;
use Nette\Utils\Html;
use Nette\Utils\Json;
use Nette\Utils\JsonException;

class Vite
{
	public function __construct(
		private string $viteServer,
		private string $manifestFile,
		private bool $productionMode,
		private Request $httpRequest,
	) {
	}

	/**
	 * @throws JsonException
	 */
	public function getAsset(string $entrypoint): string
	{
		$asset = '';
		$baseUrl = '/';

		if ($this->isEnabled() === false) {
			if (file_exists($this->manifestFile)) {
				$manifest = Json::decode(FileSystem::read($this->manifestFile), Json::FORCE_ARRAY);
				$asset = $manifest[$entrypoint]['file'];

				return $baseUrl . $asset;
			}

			trigger_error('Missing manifest file: ' . $this->manifestFile, E_USER_WARNING);

			return $baseUrl . $asset;
		}

		$baseUrl = $this->viteServer . '/';
		$asset = $entrypoint;

		return $baseUrl . $asset;
	}

	/**
	 * @return string[]
	 * @throws JsonException
	 */
	public function getCssAssets(string $entrypoint): array
	{
		$assets = [];
		$baseUrl = '/';

		if (! $this->isEnabled()) {
			if (file_exists($this->manifestFile)) {
				$manifest = Json::decode(FileSystem::read($this->manifestFile), Json::FORCE_ARRAY);
				foreach ($manifest[$entrypoint]['css'] ?? [] as $asset) {
					$assets[] = $baseUrl . $asset;
				}

				return $assets;
			}

			trigger_error('Missing manifest file: ' . $this->manifestFile, E_USER_WARNING);
		}

		return [];
	}

	public function isEnabled(): bool
	{
		return $this->productionMode === false && $this->httpRequest->getCookie('netteVite') === 'true';
	}

	/**
	 * @throws JsonException
	 */
	public function printTags(string $entrypoint): void
	{
		$scripts = [$this->getAsset($entrypoint)];
		$styles = $this->getCssAssets($entrypoint);

		if ($this->isEnabled()) {
			echo Html::el('script')->type('module')->src($this->viteServer . '/' . '@vite/client');
		}

		foreach ($styles as $path) {
			echo Html::el('link')->rel('stylesheet')->href($path);
		}

		foreach ($scripts as $path) {
			echo Html::el('script')->type('module')->src($path);
		}
	}
}
