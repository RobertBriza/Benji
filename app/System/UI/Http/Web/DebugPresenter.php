<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use app\Emailing\Application\Command\SaveEmailTemplate;
use app\Member\Domain\Entity\Member;
use app\System\Application\Query\GetEntity;
use Nette\Application\Responses\TextResponse;
use Ramsey\Uuid\Uuid;

class DebugPresenter extends BasePresenter
{
	public function actionCreate(): void
	{
		$htmlContent = file_get_contents(__DIR__ . '/template.html');
		$name = 'Registrace člena';
		$this->sendCommand(new SaveEmailTemplate($name, $htmlContent));
		$this->sendResponse(new TextResponse($name . ' Ok'));
	}

	public function actionEntity(): void
	{
		dumpe($this->sendQuery(new GetEntity(Member::class, [
			'hash' => Uuid::fromString('6fc96bb2-32bb-478e-a0fc-175cdaa6ad26'),
		])));
	}
}
