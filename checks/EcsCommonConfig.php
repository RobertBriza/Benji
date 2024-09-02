<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

final class EcsCommonConfig
{
    public static function addCommonConfiguration(ECSConfig $ecsConfig): void
    {
        $ecsConfig->sets([
            SetList::PSR_12,
            SetList::CLEAN_CODE,
            SetList::ARRAY,
            SetList::NAMESPACES,
            SetList::STRICT,
        ]);

        $ecsConfig->rule(NotOperatorWithSuccessorSpaceFixer::class);

        $ecsConfig->indentation('tab');

        $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, [
            'syntax' => 'short',
        ]);

        $ecsConfig->ruleWithConfiguration(ConcatSpaceFixer::class, [
            'spacing' => 'one',
        ]);

        $ecsConfig->ruleWithConfiguration(IncrementStyleFixer::class, [
            'style' => 'pre',
        ]);

        $ecsConfig->ruleWithConfiguration(LineLengthFixer::class, [
            'max_line_length' => '160',
            'break_long_lines' => true,
            'inline_short_lines' => false,
        ]);

        $ecsConfig->ruleWithConfiguration(TrailingCommaInMultilineFixer::class, [
            'elements' => [
                TrailingCommaInMultilineFixer::ELEMENTS_ARRAYS,
                TrailingCommaInMultilineFixer::ELEMENTS_ARGUMENTS,
                TrailingCommaInMultilineFixer::ELEMENTS_PARAMETERS,
            ],
        ]);

        $ecsConfig->ruleWithConfiguration(ClassAttributesSeparationFixer::class, [
            'elements' => [
                'method' => 'one',
            ],
        ]);

        $ecsConfig->skip([
            PhpdocTypesOrderFixer::class,
            SwitchCaseSemicolonToColonFixer::class,
            VisibilityRequiredFixer::class,
        ]);
    }
}
