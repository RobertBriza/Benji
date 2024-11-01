<?php

declare(strict_types=1);

namespace app\Emailing\Application\Command;

use app\Emailing\Domain\Entity\SendgridEmail;
use app\Member\Domain\Entity\Member;

final readonly class SendRegisteredEmail
{
	public function __construct(public SendgridEmail $email, public Member $member)
	{
	}
}
