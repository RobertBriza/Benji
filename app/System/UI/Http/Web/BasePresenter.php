<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use app\System\Application\CQRS\CQRS;
use app\System\Application\CQRS\CQRSAble;
use app\System\UI\Http\Web\Template\BaseTemplate;
use app\System\Vite\Vite;
use Contributte;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Presenter;

/**
 * @property-read BaseTemplate $template
 */
abstract class BasePresenter extends Presenter implements CQRSAble
{
	use CQRS;
	protected Vite $vite;

	public function beforeRender(): void
	{
		$this->redrawControl('title');
		$this->redrawControl('content');
		$this->redrawControl('flashes');
		$this->redrawControl('header');
	}

	public function setVite(Vite $vite): void
	{
		$this->vite = $vite;
	}

	protected function getPost(): mixed
	{
		if (json_validate($this->getHttpRequest()->getRawBody()) === false) {
			$this->sendResponse(new JsonResponse(['response' => 'Invalid JSON']));
		}

		return json_decode($this->getHttpRequest()->getRawBody(), true);
	}

	protected function startup(): void
	{
		parent::startup();
		$this->getSession()->start();

		$this->template->vite = $this->vite;
	}
}
