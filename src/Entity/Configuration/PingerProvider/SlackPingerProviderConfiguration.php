<?php

namespace App\Entity\Configuration\PingerProvider;

use App\Utils\ClassUtils;
use App\Utils\Traits\AllChildOnSameCrudControllerTrait;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Translation\TranslatableMessage;

#[Entity]
class SlackPingerProviderConfiguration extends AbstractPingerProviderConfiguration
{
    use AllChildOnSameCrudControllerTrait;

    #[Column(type: 'string')]
    private ?string $slackWebhook = null;

    public function getSlackWebhook(): ?string
    {
        return $this->slackWebhook;
    }

    public function setSlackWebhook(?string $slackWebhook): void
    {
        $this->slackWebhook = $slackWebhook;
    }

    public function getAdminListName(): string|TranslatableMessage
    {
        return new TranslatableMessage(sprintf('%s.%s', ClassUtils::getOnlyClassSnakeCase(parent::class), ClassUtils::getOnlyClassSnakeCase($this::class)), ['%webhook%' => $this->getSlackWebhook() ?? 'no url']);
    }
}
