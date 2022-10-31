<?php

namespace App\Admin\FieldProvider\PingerProviderConfiguration;

use App\Admin\FieldProvider\FieldProviderInterface;
use App\Entity\Configuration\PingerProvider\AbstractPingerProviderConfiguration;
use App\Entity\Configuration\PingerProvider\EmailPingerProviderConfiguration;
use App\Utils\ClassUtils;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EmailPingerProvider implements FieldProviderInterface
{
    public function supports(object $instance): bool
    {
        return $instance instanceof EmailPingerProviderConfiguration;
    }

    public function getFields(): array
    {
        return [
            TextField::new('email', sprintf('%s.email_provider.email', ClassUtils::getOnlyClassSnakeCase(AbstractPingerProviderConfiguration::class)))
                ->setRequired(true),
        ];
    }
}
