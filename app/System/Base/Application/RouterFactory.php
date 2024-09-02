<?php

declare(strict_types=1);

namespace app\System\Base\Application;

use Nette\Application\Routers\RouteList;

final class RouterFactory
{
	public static function createRouter(): RouteList
	{
		$router = new RouteList;

		$router->addRoute('/', 'System:Homepage:default');

		$router->addRoute('<module>/<presenter>/<action>[/<id>]');

		return $router;
	}
}
