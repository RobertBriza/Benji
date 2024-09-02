<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web\Form;

use app\System\Base\Application\Autowired;
use Nette;

abstract class FormFactory implements Autowired
{
	use Nette\SmartObject;

	public function createForm(): BaseForm
	{
		return new BaseForm();
	}
}
