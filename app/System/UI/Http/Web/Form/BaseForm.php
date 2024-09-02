<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web\Form;

use Exception;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\BaseControl;

class BaseForm extends Form
{
	public function addErrorToControl(string $controlName, string $message): void
	{
		$control = $this[$controlName];

		if (($control instanceof BaseControl) === false) {
			throw new Exception('Component is not instance of BaseControl');
		}

		$control->addError($message);
	}
}
