<?php

declare(strict_types=1);

namespace app\Emailing\Domain\DTO;

use DateTimeImmutable;
use Nette\Utils\Json;

final readonly class SendgridTemplateVersionDTO
{
	public function __construct(
		public string $id,
		public string $templateId,
		public bool $active,
		public string $name,
		public string $htmlContent,
		public string $subject,
		public DateTimeImmutable $updatedAt,
		public array $testData,
		public string $thumbnailUrl,
		public SendgridTemplateReplacingDTO $replacing,
	) {

	}

	/** @param array<string, mixed> $data */
	public static function fromArray(array $data): self
	{
		return new self(
			$data['id'],
			$data['template_id'],
			(bool) $data['active'],
			$data['name'],
			$data['html_content'],
			$data['subject'],
			new DateTimeImmutable($data['updated_at']),
			isset($data['test_data']) ? Json::decode($data['test_data'], Json::FORCE_ARRAY) : [],
			$data['thumbnail_url'],
			SendgridTemplateReplacingDTO::fromHtml($data['html_content']),
		);
	}
}