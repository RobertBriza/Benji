<?php

namespace app\Emailing\Domain\Entity;

use app\System\Domain\Entity\DateTimeLoggableEntity;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="app\Emailing\Domain\Repository\SendgridEmailRepository")
 * @ORM\Table(name="sendgrid_email")
 */
class SendgridEmail extends DateTimeLoggableEntity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 */
	public UuidInterface $id;

	/**
	 * @ORM\Column(type="string")
	 */
	public string $name;

	/**
	 * @ORM\Column(type="json",nullable=true,options={"jsonb"=true})
	 */
	public mixed $replacing;
}