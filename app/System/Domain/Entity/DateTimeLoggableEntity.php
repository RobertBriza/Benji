<?php

declare(strict_types=1);

namespace app\System\Domain\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

class DateTimeLoggableEntity extends Entity
{
	public function __construct()
	{
		$this->setCreatedAt();
		$this->setUpdatedAt();
	}

	/**
	 * @ORM\Column(type="datetime_immutable", nullable=true)
	 */
	public ?DateTimeImmutable $createdAt = null;

	/**
	 * @ORM\Column(type="datetime_immutable", nullable=true)
	 */
	public ?DateTimeImmutable $updatedAt = null;

	/**
	 * @ORM\Column(type="datetime_immutable", nullable=true)
	 */
	public ?DateTimeImmutable $removedAt = null;

	public function setCreatedAt(): void
	{
		if ($this->createdAt === null) {
			$this->createdAt = new DateTimeImmutable();
		}
	}

	/** @ORM\PostPersist */
	public function setUpdatedAt(): void
	{
		$this->updatedAt = new DateTimeImmutable();
	}
}
