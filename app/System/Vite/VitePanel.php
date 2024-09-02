<?php

declare(strict_types=1);

namespace app\System\Vite;

use Tracy\IBarPanel;

class VitePanel implements IBarPanel
{
	public function getPanel()
	{
		return '';
	}

	public function getTab()
	{
		return file_get_contents(__DIR__ . '/Vite.html');
	}
}
