<?php

namespace app\System\UI\Http\Web\Form;

use app\System\UI\Http\Web\Control\BaseControl;
use app\System\UI\Http\Web\SignPresenter;
use app\System\User\Application\DuplicateNameException;
use app\System\User\Application\UserFacade;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;
use Nette\Security\AuthenticationException;
use Nette\Security\User;

/** @property SignPresenter $presenter */
class SignUpForm extends BaseControl
{
	public const PasswordMinLength = 7;

	public function __construct(
		private readonly UserFacade $userFacade,
	)
	{
	}

	public function formSucceeded(Form $form, \stdClass $data): void
	{
		try {
			$this->userFacade->add($data);
			$this->redirect(':System:Sign:in');
		} catch (DuplicateNameException) {
			$form['email']->addError('Email is already registered.');
		}
	}

	protected function createComponentSignUpForm(): IComponent
	{
		$form = new Form;
		$form->addText('first_name')
			->setRequired('Please pick a username.');
		$form->addText('last_name', 'Pick a last name:')
			->setRequired('Please pick a username.');
		$form->addEmail('email', 'Your e-mail:')
			->setRequired('Please enter your e-mail.');

		$form->addPassword('password', 'Create a password:')
			->setOption('description', sprintf('at least %d characters', $this::PasswordMinLength))
			->setRequired('Please create a password.')
			->addRule($form::MinLength, null, $this::PasswordMinLength);
		$form->addPassword('password_repeat', 'Create a password:')
			->setOption('description', sprintf('at least %d characters', $this::PasswordMinLength))
			->setRequired('Repeat password.')
			->addRule($form::MinLength, null, $this::PasswordMinLength);

		$form->addSubmit('send', 'Sign up');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}

	/**
	 * Create a new form instance. If user is logged in, add CSRF protection.
	 */
	public function create(): Form
	{
		$form = new Form;

		if ($this->presenter->getUser()->isLoggedIn()) {
			$form->addProtection();
		}

		return $form;
	}
}