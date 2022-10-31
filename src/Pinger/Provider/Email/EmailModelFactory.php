<?php

namespace App\Pinger\Provider\Email;

class EmailModelFactory
{
    public static function create(string $subject, string $content): EmailModel
    {
        return new EmailModel($subject, $content);
    }
}
