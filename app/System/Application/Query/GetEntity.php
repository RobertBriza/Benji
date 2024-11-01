<?php

declare(strict_types=1);

namespace app\System\Application\Query;

final readonly class GetEntity
{
	/**
	 * @param class-string<object> $entityClass
	 * @param array<string, mixed> $criteria
	 * @param array<string, string>|null $orderBy
	 */
	public function __construct(
		public string $entityClass,
		public array $criteria = [],
		public ?array $orderBy = null,
	) {
	}
}
