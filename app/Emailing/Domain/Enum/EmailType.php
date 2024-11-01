<?php

declare(strict_types=1);

namespace app\Emailing\Domain\Enum;

enum EmailType: string
{
	case MemberRegistration = 'member_registration';

	public function getName(): string
	{
		return match ($this) {
			self::MemberRegistration => 'Registrace člena',
		};
	}
}
