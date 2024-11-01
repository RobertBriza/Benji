<?php

declare(strict_types=1);

namespace app\System\Vite;

use Spiral\Core\Exception\Container\NotFoundException;
use Tracy\IBarPanel;

class VitePanel implements IBarPanel
{
	public function getPanel()
	{
		return '';
	}

	public function getTab(): string
	{
		$content = file_get_contents(__DIR__ . '/Vite.html');

		if ($content !== false) {
			return $content;
		}

		throw new NotFoundException('Vite panel template not found');
	}
}
