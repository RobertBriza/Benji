<?php

declare(strict_types=1);

namespace app\Member\UI\Http\Web;

use app\Member\Domain\Entity\Member;
use app\System\Application\Command\SaveEntity;
use app\System\Application\Query\GetEntity;
use app\System\UI\Http\Web\BasePresenter;
use Nette\Application\Responses\TextResponse;

final class MemberPresenter extends BasePresenter
{
	public function actionVerify(string $hash): void
	{
		/** @var Member $member */
		$member = $this->sendQuery(new GetEntity(Member::class, [
			'hash' => $hash,
			'isConfirmed' => false,
		]));

		if ($member === null) {
			$this->redirect(':System:Homepage:default');
		}

		$member->isConfirmed = true;
		$this->sendCommand(new SaveEntity($member));

		$this->sendResponse(new TextResponse('Váš členský přístup byl aktivován. <a href="/">Zpátky na web</a>'));
	}
}
