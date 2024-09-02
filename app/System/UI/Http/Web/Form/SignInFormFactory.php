<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web\Form;

use app\System\UI\Http\Web\Control\ControlFactory;

interface SignInFormFactory extends ControlFactory
{
	public function create(): SignInForm;
}