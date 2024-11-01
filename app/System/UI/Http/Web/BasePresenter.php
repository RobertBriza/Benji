<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use app\System\CQRS\CQRS;
use app\System\CQRS\CQRSAble;
use app\System\UI\Http\Web\Template\BaseTemplate;
use app\System\Vite\Vite;
use Nette\Application\Helpers;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Presenter;

/**
 * @property BaseTemplate $template
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
		$rawBody = $this->getHttpRequest()->getRawBody();

		if ($rawBody === null) {
			return null;
		}

		if (json_validate($rawBody) === false) {
			$this->sendResponse(new JsonResponse([
				'response' => 'Invalid JSON',
			]));
		}

		return json_decode($rawBody, true);
	}

	protected function startup(): void
	{
		parent::startup();
		$this->getSession()->start();
		$this->template->vite = $this->vite;
	}

	/**
	 * @return array<int, string>
	 */
	public function formatLayoutTemplateFiles(): array
	{
		[, $presenter] = Helpers::splitName((string) $this->getName());

		$layout = $this->getLayout() ?: 'layout';

		$dir = dirname((string) static::getReflection()->getFileName());

		$presenterLayout = sprintf('%s/templates/%s/%s.latte', $dir, $presenter, $layout);
		if (file_exists($presenterLayout)) {
			return [$presenterLayout];
		}

		$templatesLayout = sprintf('%s/templates/%s.latte', $dir, $layout);
		if (file_exists($templatesLayout)) {
			return [$templatesLayout];
		}

		if (defined('__WWW_DIR__')) {
			return [__WWW_DIR__ . '/templates/' . $layout . '.latte'];
		}

		return [];
	}

	protected function getUrlWithoutUtmParameters(): string
	{
		$urlScript = $this->getHttpRequest()->getUrl();
		$urlParameters = $urlScript->getQueryParameters();
		$urlParameterKeys = array_keys($urlParameters);

		foreach ($urlParameterKeys as $key) {
			if (! preg_match("'^utm\_'si", (string) $key)) {
				continue;
			}

			unset($urlParameters[$key]);
		}

		$paramQuery = http_build_query($urlParameters);

		if ($paramQuery !== '') {
			return $urlScript->getPath() . '?' . $paramQuery;
		}

		return $urlScript->getPath();
	}
}
