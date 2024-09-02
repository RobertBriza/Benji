<?php

declare(strict_types=1);

namespace app\System\User\Domain\Entity;


use app\System\Domain\Entity\Entity;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="app\System\User\Domain\Repository\UserRepository")
 * @ORM\Table(name="user_table")
 */
class User extends Entity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class=UuidGenerator::class)
 */
	public UuidInterface $id;

	/**
	 * @ORM\Column(type="string")
	 */
	public string $email;

	/**
	 * @ORM\Column(type="string")
	 */
	public string $firstName;

	/**
	 * @ORM\Column(type="string")
	 */
	public string $lastName;

	/**
	 * @ORM\Column(type="string")
	 */
	public string $password;

	/**
	 * @ORM\Column(type="boolean")
	 */
	public bool $isConfirmed = false;

	/**
	 * @ORM\Column(type="boolean")
	 */
	public bool $isAdmin = false;


	/**
	 * @ORM\Column(type="uuid")
	 */
	public UuidInterface $hash;

	/**
	 * @ORM\Column(type="date_immutable")
	 */
	public DateTimeImmutable $createDate;

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'email' => $this->email,
			'firstName' => $this->firstName,
			'lastName' => $this->lastName,
			'isConfirmed' => $this->isConfirmed,
			'isAdmin' => $this->isAdmin,
			'hash' => $this->hash,
			'createDate' => $this->createDate,
		];
	}
}
