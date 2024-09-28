<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use app\Emailing\Application\Command\SaveEmailTemplate;
use Nette\Application\Responses\TextResponse;

class DebugPresenter extends BasePresenter
{
	public function actionCreate(): void
	{
		$htmlContent = file_get_contents(__DIR__ . '/template.html');
		$name = 'Registrace uživatele';
		$this->sendCommand(new SaveEmailTemplate($name, $htmlContent));
		$this->sendResponse(new TextResponse($name . ' Ok'));
	}
}
