<?php

declare(strict_types=1);

namespace app\Article\UI\Http\Web\Template;

use Nette\Bridges\ApplicationLatte\Template;
use Nette\Utils\Paginator;

final class ArticleListTemplate extends Template
{
	/** @param array<string, mixed> $list */
	public function __construct(
		public array $list,
		public Paginator $paginator,
		public string $link,
		public string $prevPageLink,
		public string $nextPageLink,
	) {
	}
}
