<?php

declare(strict_types=1);

namespace app\Emailing\Domain\Repository;

use app\Emailing\Domain\Entity\SendgridEmail;
use app\System\Domain\Repository\BaseRepository;

/**
 * @extends BaseRepository<SendgridEmail>
 * @method SendgridEmail|null findOneBy(array $criteria, array $orderBy = null)
 */
final class SendgridEmailRepository extends BaseRepository
{
}
