<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use app\System\UI\Http\Web\Form\SignInForm;
use app\System\UI\Http\Web\Form\SignInFormFactory;
use app\System\UI\Http\Web\Form\SignUpForm;
use app\System\UI\Http\Web\Form\SignUpFormFactory;
use Nette\Application\Attributes\Persistent;

/**
 * Presenter for sign-in and sign-up actions.
 */
final class SignPresenter extends BasePresenter
{
	#[Persistent]
	public string $backlink = '';

	public function __construct(
		private SignInFormFactory $signInFormFactory,
		private SignUpFormFactory $signUpFormFactory,
	) {
	}

	public function actionIn(): void
	{
		if ($this->getUser()->isLoggedIn()) {
			$this->redirect(':System:Homepage:default');
		}
	}

	public function actionUp(): void
	{
		if ($this->getUser()->isLoggedIn()) {
			$this->redirect(':System:Homepage:default');
		}
	}

	protected function createComponentSignInForm(): SignInForm
	{
		return $this->signInFormFactory->create();
	}

	protected function createComponentSignUpForm(): SignUpForm
	{
		return $this->signUpFormFactory->create();
	}

	public function actionOut(): void
	{
		$this->redrawControl('header');

		if ($this->getUser()->isLoggedIn()) {
			$this->getUser()->logout(true);
			return;
		}

		$this->redirect(':System:Sign:in');
	}
}