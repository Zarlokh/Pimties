<?php

namespace App\Pinger\Provider\Email;

class EmailModel
{
    public function __construct(
        private readonly string $subject,
        private readonly string $content
    ) {
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
