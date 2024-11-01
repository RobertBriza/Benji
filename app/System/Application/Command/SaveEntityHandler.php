<?php

declare(strict_types=1);

namespace app\System\Application\Command;

use app\System\Base\Application\Autowired;
use app\System\Domain\Entity\DateTimeLoggableEntity;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SaveEntityHandler implements Autowired
{
	public function __construct(private EntityManagerInterface $em)
	{
	}

	public function __invoke(SaveEntity $command): void
	{
		try {
			if ($command->entity instanceof DateTimeLoggableEntity) {
				$command->entity->setUpdatedAt();
			}

			$this->em->persist($command->entity);
			$this->em->flush();
		} catch (\Throwable $e) {
			bdump($command->entity);
			bdump($e);
			throw new RuntimeException('Error saving entity', 0, $e);
		}
	}
}
