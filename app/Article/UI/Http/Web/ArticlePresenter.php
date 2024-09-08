<?php

declare(strict_types=1);

namespace app\Article\UI\Http\Web;

use app\Article\UI\Http\Web\Template\ArticleListTemplate;
use app\System\UI\Http\Web\BasePresenter;

use app\System\UI\Http\Web\Control\PagingControl;
use BG\System\UI\Http\Web\PaginatedResult;
use Nette\Utils\Paginator;

final class ArticlePresenter extends BasePresenter
{
	use PaginatedResult;

	protected PagingControl $pagingControl;

	private int $page = 1;


	public function renderList(): void
	{
		$list = [];

		$paginator = $this->createPaginator(
			$this->getHttpRequest(),
			count($list),
			12,
			$this->page,
		);

		$this->template->setParameters($this->createTemplateParams($list, $paginator));
		$this->template->list = $list;
	}

	private function createTemplateParams(
		array $list,
		Paginator $paginator,
	): ArticleListTemplate {
		return new ArticleListTemplate(
			$list,
			$paginator,
			urldecode($this->getUrlWithoutUtmParameters()),
			$this->createPageLink($paginator->getPage() - 1),
			$this->createPageLink($paginator->getPage() + 1),
		);
	}
}