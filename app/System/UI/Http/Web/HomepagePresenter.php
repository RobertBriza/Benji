<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use app\System\UI\Http\Web\Form\BaseForm;
use Nette;
use Nette\Application\UI\Form;

final class HomepagePresenter extends BasePresenter
{
	protected function createComponentForm(): ?Nette\ComponentModel\IComponent
	{
		$form = new BaseForm(name: 'form');
		$form->addText('name', 'Jirka Babica')
			->setRequired();
		$form->addSubmit('send', 'Send');

		$form->onSuccess[] = function (Form $form, Nette\Utils\ArrayHash $values): void {
			$this->flashMessage('Control was submitted', 'success');
			$this->redrawControl('snippet');
		};

		return $form;
	}
}
