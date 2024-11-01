<?php

declare(strict_types=1);

namespace app\System\CQRS;

trait CQRS
{
	protected BusProvider $busProvider;

	public function sendCommand(object $command): void
	{
		$this->busProvider->sendCommand($command);
	}

	public function sendQuery(object $query): mixed
	{
		return $this->busProvider->sendQuery($query);
	}

	public function setBusProvider(BusProvider $busProvider): void
	{
		$this->busProvider = $busProvider;
	}
}
