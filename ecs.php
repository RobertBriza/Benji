<?php

declare(strict_types=1);

use Sniffs\Psr4Sniff;
use Symplify\EasyCodingStandard\Config\ECSConfig;

require_once __DIR__ . '/checks/Sniffs/Psr4Sniff.php';
require_once __DIR__ . '/checks/EcsCommonConfig.php';

return static function (ECSConfig $ecsConfig): void {

    EcsCommonConfig::addCommonConfiguration($ecsConfig);

    $ecsConfig->ruleWithConfiguration(Psr4Sniff::class, [
        'rootNamespaces' => [
            'app' => 'app',
            //'test' => 'test\\Tests',
        ],
    ]);
};
