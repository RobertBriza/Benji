<?php

declare(strict_types=1);

namespace app\Article\UI\Http\Web;

use app\System\UI\Http\Web\BasePresenter;

final class ArticlePresenter extends BasePresenter
{
	public function renderList(): void
	{
		$this->template->list = [];
	}
}