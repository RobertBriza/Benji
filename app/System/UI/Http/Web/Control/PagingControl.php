<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web\Control;

use app\System\UI\Http\Web\Template\PagingTemplate;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Utils\Paginator;

/**
 * @property Template $template
 */
final class PagingControl extends BaseControl
{
	/** @persistent */
	public int $page = 1;
	private string $link;
	private Paginator $paginator;
	private ?string $query = null;

	/**
	 * @return int[]
	 */
	public function getLimitedSteps(int $totalSteps): array
	{
		$paginator = $this->getPaginator();
		$page = $paginator->getPage();
		$steps = [];

		$totalSteps = max($totalSteps, 3);

		$first = $page - ($totalSteps - 2);
		$last = $page + 1;

		if ($page === $paginator->getPageCount()) {
			$first = $page - $totalSteps;
			$last = $page;
		}

		if ($page < $totalSteps) {
			$first = 1;
			$last = $totalSteps;
		}

		if ($paginator->getPageCount() < $totalSteps) {
			$first = 1;
			$last = $paginator->getPageCount();
		}

		for ($counter = $first; $counter <= $last; ++$counter) {
			$steps[] = $counter;
		}

		return $steps;
	}

	public function getLink(): string
	{
		return $this->link;
	}

	public function setLink(string $link): void
	{
		$this->link = $link;
	}

	public function getPaginator(): Paginator
	{
		if (! isset($this->paginator)) {
			$this->paginator = new Paginator();
		}

		return $this->paginator;
	}

	public function getQuery(): ?string
	{
		return $this->query;
	}

	/**
	 * @param array<string, mixed> $query
	 */
	public function setQuery(array $query = []): void
	{
		if (array_key_exists('page', $query)) {
			unset($query['page']);
		}

		$arrayKeys = array_keys($query);
		foreach ($arrayKeys as $key) {
			if (! preg_match("'^utm\_'si", (string) $key)) {
				continue;
			}

			unset($query[$key]);
		}

		if (empty($query)) {
			$this->query = null;

			return;
		}

		$this->query = http_build_query($query, '', '&');
	}

	/**
	 * @return int[]
	 */
	public function getSteps(): array
	{
		$paginator = $this->getPaginator();
		$page = $paginator->getPage();

		if ($paginator->getPageCount() < 2) {
			return [$page];
		}

		$arr = range(max($paginator->getFirstPage(), $page - 2), (int) min($paginator->getLastPage(), $page + 2));
		$count = 2;
		$quotient = ($paginator->getPageCount() - 1) / $count;
		for ($counter = 0; $counter <= $count; ++$counter) {
			$arr[] = (int) round($quotient * $counter) + $paginator->getFirstPage();
		}

		sort($arr);

		return array_values(array_unique($arr));
	}

	/**
	 * @param array<string, mixed> $params
	 */
	public function loadState(array $params): void
	{
		parent::loadState($params);

		$this->getPaginator()->setPage($this->page);
	}

	/**
	 * @param array<int, mixed> $args
	 */
	public function render(...$args): void
	{
		//$this->renderControl($this->createPagingTemplate($args));
	}

	/**
	 * @param array<int, mixed> $args
	 */
	public function renderToString(...$args): string
	{
		return "";
		//return (string) $this->renderControl($this->createPagingTemplate($args), true);
	}


	/**private function createPagingTemplate(...$args): PagingTemplate // phpcs:ignore
	{
		$options = $args[0][0] ?? [];
		$paginator = $this->getPaginator();
		$type = null;
		$steps = $this->getSteps();

		if (array_key_exists('count', $options)) {
			$paginator->setItemCount($options['count']);
		}

		if (array_key_exists('pageSize', $options)) {
			$paginator->setItemsPerPage($options['pageSize']);
		}

		if (array_key_exists('limitedSteps', $options)) {
			$steps = $this->getLimitedSteps($options['limitedSteps']);
		}

		if (array_key_exists('type', $options)) {
			$type = $options['type'];
		}

		return new PagingTemplate(
			$paginator,
			$this->link,
			$this->query,
			$steps,
			$type,
		);
	}*/
}
