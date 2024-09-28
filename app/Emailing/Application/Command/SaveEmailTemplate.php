<?php

declare(strict_types=1);

namespace app\Emailing\Application\Command;

final readonly class SaveEmailTemplate
{
	public function __construct(
		public string $name,
		public string $htmlContent,
	)
	{
	}
}