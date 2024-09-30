<?php

namespace app\System\UI\Http\Web\Form;

use app\System\UI\Http\Web\Control\BaseControl;
use app\System\UI\Http\Web\SignPresenter;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;
use Nette\Security\AuthenticationException;

/** @property SignPresenter $presenter */
class SignInForm extends BaseControl
{
	public function formSucceeded(Form $form, \stdClass $data): void
	{
		try {
			// Attempt to login user
			$this->presenter->getUser()->login($data->email, $data->password);
			$this->presenter->restoreRequest($this->presenter->backlink);
			$this->presenter->redirect(':System:Homepage:default');
		} catch (AuthenticationException) {
			$form->addError('The username or password you entered is incorrect.');
		}
	}

	protected function createComponentSignInForm(): IComponent
	{
		$form = new Form;
		$form->addText('email', 'Email:')
			->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addSubmit('send', 'Sign in');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}

	public function create(): Form
	{
		$form = new Form;
		if ($this->presenter->getUser()->isLoggedIn()) {
			$form->addProtection();
		}
		return $form;
	}
}