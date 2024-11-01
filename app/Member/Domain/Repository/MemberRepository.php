<?php

declare(strict_types=1);

namespace app\Member\Domain\Repository;

use app\Member\Domain\Entity\Member;
use app\System\Domain\Repository\BaseRepository;

/**
 * @extends BaseRepository<Member>
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 */
final class MemberRepository extends BaseRepository
{
}
