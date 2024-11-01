<?php

declare(strict_types=1);

namespace app\Emailing\Application\Command;

use app\System\Base\Application\Autowired;
use Exception;
use Ramsey\Uuid\UuidInterface;
use SendGrid;
use SendGrid\Mail\Mail;
use SendGrid\Mail\Personalization;
use SendGrid\Mail\Substitution;
use SendGrid\Mail\To;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SendRegisteredEmailHandler implements Autowired
{
	public function __invoke(SendRegisteredEmail $command): void
	{
		$sg = new SendGrid('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');

		$email = new Mail();
		$email->setFrom('benji@robertbriza.cz', "Toller Benji");
		$email->setTemplateId($command->email->sendgridId());

		$personalization = new Personalization();
		$personalization->addTo(new To($command->member->email));

		$dynamicData = [
			"activationHash" => $command->member->hash,
		];

		foreach ($dynamicData as $key => $value) {
			if ($value instanceof UuidInterface) {
				$value = $value->toString();
			}

			$personalization->addSubstitution(new Substitution($key, $value));
		}

		$email->addPersonalization($personalization);

		try {
			$response = $sg->send($email);

			$statusCode = $response->statusCode();

			if (in_array($statusCode, [200, 201, 202], true) === false) {
				throw new Exception('Email not sent');
			}
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
		}
	}
}
