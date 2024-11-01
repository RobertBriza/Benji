<?php

declare(strict_types=1);

namespace app\Emailing\Domain\DTO;

final readonly class SendgridTemplateReplacingDTO
{
	/**
	 * @param array<int, mixed> $variables
	 * @param array<string, mixed> $cycles
	 */
	public function __construct(public array $variables, public array $cycles)
	{
	}

	public static function fromHtml(string $htmlContent): self
	{
		$pattern = '/{{(.*?)}}/';
		$matches = [];
		preg_match_all($pattern, $htmlContent, $matches);

		$eachCycleName = null;
		$eachVariables = [];
		$variables = [];
		$cycles = [];
		foreach (array_unique($matches[1]) as $item) {
			if (str_contains($item, '#each')) {
				$eachCycleName = substr($item, 6);
				continue;
			}

			if (str_contains($item, '/each')) {
				$cycles[$eachCycleName] = $eachVariables;
				$eachVariables = [];
				$eachCycleName = null;
				continue;
			}

			if ($eachCycleName !== null) {
				$eachVariables[] = $item;
				continue;
			}

			$variables[] = $item;
		}

		return new self($variables, $cycles);
	}

	/** @return array<string, mixed> */
	public function toArray(): array
	{
		return [
			'variables' => $this->variables,
			'cycles' => $this->cycles,
		];
	}
}
