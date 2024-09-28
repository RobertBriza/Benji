<?php

namespace app\System\Domain\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

class DateTimeLoggableEntity extends Entity
{
	public function __construct()
	{
		$this->setCreatedAtValue();
		$this->setUpdatedAtValue();
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

	public function setCreatedAtValue(): void
	{
		if ($this->createdAt === null) {
			$this->createdAt = new DateTimeImmutable();
		}
	}

	public function setUpdatedAtValue(): void
	{
		$this->updatedAt = new DateTimeImmutable();
	}
}