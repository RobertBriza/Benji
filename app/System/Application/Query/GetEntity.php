<?php

declare(strict_types=1);

namespace app\System\Application\Query;

final readonly class GetEntity
{
	public function __construct(
		public string $entityClass,
		public array $criteria = [],
		public ?array $orderBy = null,
	)
	{
	}
}