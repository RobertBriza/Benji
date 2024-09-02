<?php

declare(strict_types=1);

namespace app\System\Base\Application;

use app\System\Vite\Vite;
use Nette\Utils\JsonException;

class AssetFilter
{
	public function __construct(
		private Vite $vite,
	) {
	}

	/**
	 * @throws JsonException
	 */
	public function __invoke(string $path): string
	{
		return $this->vite->getAsset($path);
	}
}
