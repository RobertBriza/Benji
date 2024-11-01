<?php

declare(strict_types=1);

namespace app\System\CQRS;

interface CQRSAble
{
	public function sendCommand(object $command): void;

	public function sendQuery(object $query): mixed;

	public function setBusProvider(BusProvider $busProvider): void;
}
