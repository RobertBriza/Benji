<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web\Template;

use Nette\Bridges\ApplicationLatte\Template;
use Nette\Utils\Paginator;

final class PagingTemplate extends Template
{
	/** @param int[] $steps */
	public function __construct(
		public Paginator $paginator,
		public string $link,
		public ?string $query = null,
		public array $steps = [],
		public ?string $type = null,
	) {
	}
}
