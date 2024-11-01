<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web\Trait;

use app\System\UI\Http\Web\Control\PagingControl;
use Nette\Http\IRequest;
use Nette\Utils\Paginator;

trait PaginatedResult
{
	protected function createPageLink(int $page): string
	{
		$pagingControl = $this->getComponent('paging');
		assert($pagingControl instanceof PagingControl);

		$queryString = $pagingControl->getQuery() !== null ? $pagingControl->getQuery() . '&' : '';

		return rtrim($pagingControl->getLink() . '?' . $queryString . ($page > 1 ? 'page=' . $page : ''), '?&');
	}

	protected function createPaginator(IRequest $req, int $totalCount, int $limit, int $page = 1): Paginator
	{
		$link = $req->getUrl()->getPath();

		$pagingControl = new PagingControl();
		$pagingControl->setLink($link);
		$pagingControl->setQuery($req->getQuery());

		$this->pagingControl = $pagingControl;

		$this->addComponent($this->pagingControl, 'paging');

		$paginator = $pagingControl->getPaginator();
		$paginator->setPage($page);

		$paginator->setItemsPerPage($limit);
		$paginator->setItemCount($totalCount);

		return $paginator;
	}
}
