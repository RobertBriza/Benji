<?php

declare(strict_types=1);

namespace App\UI\Accessory;
trait RequireLoggedUser
{
	public function injectRequireLoggedUser(): void
	{
		$this->onStartup[] = function () {
			$user = $this->getUser();

			if ($user->isLoggedIn()) {
				return;
			}

			if ($user->getLogoutReason() === $user::LogoutInactivity) {
				$this->flashMessage('You have been signed out due to inactivity. Please sign in again.');
				$this->redirect('Sign:in', ['backlink' => $this->storeRequest()]);
			}

			$this->redirect('Sign:in');
		};
	}
}