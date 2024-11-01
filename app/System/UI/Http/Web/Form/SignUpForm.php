<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web\Form;

use app\Emailing\Application\Command\SendRegisteredEmail;
use app\Emailing\Domain\Entity\SendgridEmail;
use app\Emailing\Domain\Enum\EmailType;
use app\Member\Domain\Entity\Member;
use app\Member\UI\Http\Web\SignPresenter;
use app\System\Application\Query\GetEntity;
use app\System\UI\Http\Web\Control\BaseControl;
use app\User\Application\MemberFacade;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;

/** @property SignPresenter $presenter */
class SignUpForm extends BaseControl
{
	public const PasswordMinLength = 7;

	public function __construct(
		private readonly MemberFacade $userFacade,
	) {
	}

	public function formSucceeded(Form $form, \stdClass $data): void
	{
		try {
			$this->userFacade->add($data);
			$sendgridEmail = $this->sendQuery(new GetEntity(SendgridEmail::class, [
				'name' => EmailType::MemberRegistration->getName(),
			]));
			$user = $this->sendQuery(new GetEntity(Member::class, [
				'email' => $data->email,
			]));
			$this->sendCommand(new SendRegisteredEmail($sendgridEmail, $user));
			$this->presenter->redirect(':System:Homepage:default');
		} catch (UniqueConstraintViolationException) {
			$this->presenter->flashMessage('Email is already registered.', 'warning');
		}
	}

	protected function createComponentSignUpForm(): IComponent
	{
		$form = new Form();
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
		$form = new Form();

		if ($this->presenter->getUser()->isLoggedIn()) {
			$form->addProtection();
		}

		return $form;
	}
}
