<?php

declare(strict_types=1);

namespace app\Emailing\Domain\DTO;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class SendgridTemplateDTO
{
	/**
	 * @param SendgridTemplateVersionDTO[] $versions
	 */
	public function __construct(
		public UuidInterface $id,
		public string $name,
		public string $generation,
		public DateTimeImmutable $updatedAt,
		public array $versions,
		public ?SendgridTemplateVersionDTO $currentVersion,
	) {
	}

	/** @param array<string, mixed> $data */
	public static function fromArray(array $data): self
	{
		$currentVersion = null;

		$versions = [];

		foreach ($data['versions'] as $version) {
			$versions[] = SendgridTemplateVersionDTO::fromArray($version);

			if ($version['active'] === 1) {
				$currentVersion = SendgridTemplateVersionDTO::fromArray($version);
			}
		}

		return new self(
			Uuid::fromString(substr($data['id'], 2)),
			$data['name'],
			$data['generation'],
			new DateTimeImmutable($data['updated_at']),
			$versions,
			$currentVersion,
		);
	}

	public function sendgridId(): string
	{
		return 'd-' . str_replace('-', '', $this->id->toString());
	}
}
