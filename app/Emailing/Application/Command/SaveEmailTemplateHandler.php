<?php

declare(strict_types=1);

namespace app\Emailing\Application\Command;

use app\Emailing\Domain\DTO\SendgridTemplateDTO;
use app\Emailing\Domain\Entity\SendgridEmail;
use app\Emailing\Domain\Repository\SendgridEmailRepository;
use app\System\Base\Application\Autowired;
use Exception;
use Nette\Utils\Json;
use SendGrid;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SaveEmailTemplateHandler implements Autowired
{
	public function __construct(
		private SendgridEmailRepository $repository
	) {
	}

	public function __invoke(SaveEmailTemplate $command): void
	{
		$sg = new SendGrid('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');

		$templateData = [
			'name' => $command->name,
			'generation' => 'dynamic',
		];

		try {
			$response = $sg->client->templates()->post($templateData);

			$statusCode = $response->statusCode();
			if ($statusCode !== 201) {
				throw new Exception('Template not created');
			}

			$template = SendgridTemplateDTO::fromArray(Json::decode($response->body(), Json::FORCE_ARRAY));

			$sendgridEmail = new SendgridEmail;
			$sendgridEmail->id = $template->id;
			$sendgridEmail->name = $template->name;
			$sendgridEmail->replacing = $template->currentVersion?->replacing->toArray() ?? [];

			$this->repository->entityManager()->persist($sendgridEmail);
			$this->repository->entityManager()->flush();

			$versionData = [
				'template_id' => $template->sendgridId(),
				'active' => 1,
				'name' => $template->name . ' Version 1',
				'subject' => $command->name,
				'html_content' => $command->htmlContent,
				'plain_content' => strip_tags($command->htmlContent),
			];

			$response = $sg->client->templates()->_($template->sendgridId())->versions()->post($versionData);

			$statusCode = $response->statusCode();

			if ($statusCode !== 201) {
				throw new Exception('Template not created');
			}
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
		}
	}
}