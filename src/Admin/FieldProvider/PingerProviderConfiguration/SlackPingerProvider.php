<?php

namespace App\Admin\FieldProvider\PingerProviderConfiguration;

use App\Admin\FieldProvider\FieldProviderInterface;
use App\Entity\Configuration\PingerProvider\AbstractPingerProviderConfiguration;
use App\Entity\Configuration\PingerProvider\PingerProviderConfigurationInterface;
use App\Entity\Configuration\PingerProvider\SlackPingerProviderConfiguration;
use App\Utils\ClassUtils;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SlackPingerProvider implements FieldProviderInterface
{
    public function supports(PingerProviderConfigurationInterface $instance): bool
    {
        return $instance instanceof SlackPingerProviderConfiguration;
    }

    public function getFields(): array
    {
        return [
            TextField::new('slackWebhook', sprintf('%s.slack_provider.slack_webhook', ClassUtils::getOnlyClassSnakeCase(AbstractPingerProviderConfiguration::class)))
                ->setRequired(true),
        ];
    }
}
