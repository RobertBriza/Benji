<?php

declare(strict_types=1);

namespace app\System\Domain\Entity;

use app\System\Domain\Exception\PropertyNotSet;
use LogicException;
use Ramsey\Uuid\UuidInterface;

abstract class Entity
{
	public UuidInterface $id;

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function setRemovedAt(\DateTimeImmutable $param): void
	{
		throw new LogicException('This entity cannot be removed.');
	}
}
