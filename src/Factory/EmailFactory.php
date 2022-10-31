<?php

namespace App\Factory;

use App\Entity\Configuration\PingerProvider\EmailPingerProviderConfiguration;
use Symfony\Component\Mime\Email;

class EmailFactory
{
    /** @psalm-suppress MixedArgument */
    public function createEmail(array $to, string $subject, string $content, bool $asHtml = false): Email
    {
        $email = (new Email())
            ->to(...$to)
            ->subject($subject)
        ;

        $asHtml ? $email->html($content) : $email->text($content);

        return $email;
    }

    public function createPingEmail(EmailPingerProviderConfiguration $emailPingerProviderConfiguration, string $subject, string $content): Email
    {
        return $this->createEmail([$emailPingerProviderConfiguration->getEmail()], $subject, $content);
    }
}
