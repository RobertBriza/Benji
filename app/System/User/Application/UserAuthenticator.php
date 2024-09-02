<?php

declare(strict_types=1);

namespace app\System\User\Application;

use Nette\Database\Explorer;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;

class UserAuthenticator implements Authenticator
{
	public function __construct(
		private Explorer $database,
		private Passwords $passwords,
	) {
	}

	public function authenticate(string $username, string $password): IIdentity
	{
		$row = $this->database->table('users')
			->where('username', $username)
			->fetch();

		if (!$row) {
			throw new AuthenticationException('User not found.');
		}

		if (!$this->passwords->verify($password, $row->password)) {
			throw new AuthenticationException('Invalid password.');
		}

		return new UserIdentity(
			$row->id,
			$row->role,
			['name' => $row->username],
		);
	}
}