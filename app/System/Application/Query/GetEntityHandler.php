<?php

declare(strict_types=1);

namespace app\System\Application\Query;

use app\System\Base\Application\Autowired;
use app\System\Domain\Entity\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetEntityHandler implements Autowired
{
	public function __construct(private EntityManagerInterface $em)
	{
	}

	public function __invoke(GetEntity $query): ?Entity
	{
		$repository = $this->em->getRepository($query->entityClass);
		return $repository->findOneBy($query->criteria, $query->orderBy);
	}
}