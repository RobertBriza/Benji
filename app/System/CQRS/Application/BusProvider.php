<?php

declare(strict_types=1);

namespace app\System\Application\CQRS;

use Contributte\Messenger\Bus\CommandBus;
use Contributte\Messenger\Bus\QueryBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final readonly class BusProvider
{
	public function __construct(
		protected CommandBus $commandBus,
		protected QueryBus $queryBus,
	) {
	}

	public function sendCommand(object $command): void
	{
		try {
			$this->commandBus->handle($command);
		} catch (HandlerFailedException $ex) {
			throw $ex->getPrevious() ?? throw $ex;
		}
	}

	public function sendQuery(object $query): mixed
	{
		try {
			return $this->queryBus->query($query);
		} catch (HandlerFailedException $ex) {
			throw $ex->getPrevious() ?? throw $ex;
		}
	}
}
