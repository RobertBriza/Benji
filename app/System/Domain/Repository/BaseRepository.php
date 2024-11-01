<?php

declare(strict_types=1);

namespace app\System\Domain\Repository;

use app\System\Doctrine\Repository\T;
use app\System\Domain\Entity\Entity;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @template T of Entity
 * @extends EntityRepository<T>
 * @method T|null find($id, $lockMode = null, $lockVersion = null)
 * @method T[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method T[] findAll()
 * @method T|null findOneBy(array $criteria, array $orderBy = null)
 */
abstract class BaseRepository extends EntityRepository
{
	public function entityManager(): EntityManagerInterface
	{
		return $this->getEntityManager();
	}

	public function hardRemove(Entity $entity): void
	{
		$this->getEntityManager()->remove($entity);
		$this->getEntityManager()->flush();
	}

	public function isSoftRemoveable(): bool
	{
		return property_exists($this->getClassName(), 'removedAt');
	}

	public function save(Entity $entity): void
	{
		$this->getEntityManager()->persist($entity);
		$this->getEntityManager()->flush();
	}

	public function softRemove(Entity $entity): void
	{
		if ($this->isSoftRemoveable()) {
			$entity->setRemovedAt(new DateTimeImmutable());
		}

		$this->getEntityManager()->remove($entity);
		$this->getEntityManager()->flush();
	}
}
