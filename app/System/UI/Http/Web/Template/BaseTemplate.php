<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web\Template;

use app\System\Vite\Vite;
use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\InvalidStateException;
use Nette\Security\User;
use Nette\Utils\Arrays;

final class BaseTemplate extends Template
{
	public Control $control;
	public array $flashes = [];
	public Presenter $presenter;
	public User $user;
	public Vite $vite;

	public function add(string $name, mixed $value): static
	{
		if (property_exists($this, $name)) {
			throw new InvalidStateException(sprintf("The variable '%s' already exists.", $name));
		}

		$this->{$name} = $value;

		return $this;
	}

	public function render(?string $file = null, array $params = []): void
	{
		$this->user = $this->presenter->user;
		parent::render($file, $params);
	}

	public function setParameters(object $templateObject): void
	{
		$vars = get_object_vars($templateObject);
		Arrays::toObject($vars, $this);
	}
}
