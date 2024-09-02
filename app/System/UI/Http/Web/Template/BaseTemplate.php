<?php

namespace app\System\UI\Http\Web\Template;

use AllowDynamicProperties;
use app\System\Vite\Vite;
use Nette\Bridges\ApplicationLatte\Template;

#[AllowDynamicProperties]
final class BaseTemplate extends Template
{
	public Vite $vite;
}