<?php

declare(strict_types=1);

namespace app\System\Application\Command;

use app\System\Domain\Entity\Entity;

final readonly class SaveEntity
{
	public function __construct(
		public Entity $entity,
	) {
	}
}
