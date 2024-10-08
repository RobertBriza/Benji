<?php

declare(strict_types=1);

namespace app\System\User\Application;

use app\System\Base\Application\Autowired;
use app\System\User\Domain\Entity\User;
use app\System\User\Domain\Repository\UserRepository;
use DateTimeImmutable;
use Nette;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;
use Ramsey\Uuid\Uuid;

/**
 * Manages user-related operations such as authentication and adding new users.
 */
final class UserFacade implements Nette\Security\Authenticator, Autowired
{

	public function __construct(
		private readonly UserRepository $repository,
		private readonly Passwords $passwords,
	) {
	}
	public function authenticate(string $user, string $password): SimpleIdentity
	{
		$userEntity = $this->repository->findOneBy(['email' => $user]);

		// Authentication checks
		if ($userEntity instanceof User === false) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IdentityNotFound);
		}

		if ($this->passwords->verify($password, $userEntity->password) === false) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::InvalidCredential);
		}

		if ($this->passwords->needsRehash($userEntity->password)) {
			$userEntity->password = $this->passwords->hash($password);
			$this->repository->entityManager()->persist($userEntity);
			$this->repository->entityManager()->flush();
		}

		return new SimpleIdentity(id: $userEntity->id->toString(), roles: null, data: $userEntity->toArray());
	}

	public function add(\stdClass $data): void
	{
		Nette\Utils\Validators::assert($data->email, 'email');

		try {
			$user = new User;
			$user->firstName = $data->first_name;
			$user->lastName = $data->last_name;
			$user->email = $data->email;
			$user->password = $this->passwords->hash($data->password);
			$user->hash = Uuid::uuid4();
			$user->createDate = new DateTimeImmutable;

			$this->repository->entityManager()->persist($user);
			$this->repository->entityManager()->flush();
		} catch (Nette\Database\UniqueConstraintViolationException) {
			throw new DuplicateNameException;
		}
	}
}
