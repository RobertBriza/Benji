<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use Nette\Application\Responses\TextResponse;

class DebugPresenter extends BasePresenter
{
	public function __construct(
	) {
	}

	public function actionCreateDay(): void
	{

		$dayData = [
			'date' => "2024-03-03",
			"dayInWeek" => "neděle",
			"dayNumber" => "3",
			"holidayName" => null,
			"isHoliday" => false,
			"month" => json_decode('{"nominative":"b\u0159ezen","genitive":"b\u0159ezna"}', true),
			"monthNumber" => "3",
			"name" => "Kamil",
			"year" => 2024,
		];

		dumpe('saved');
	}

	public function actionTest(): void
	{
		//$this->sendResponse(new TextResponse($this->getHttpRequest()->getRawBody()));
		$this->sendResponse(new TextResponse(file_get_contents(__DIR__ . '/test.html')));
	}
}
