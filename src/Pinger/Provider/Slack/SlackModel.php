<?php

namespace App\Pinger\Provider\Slack;

class SlackModel
{
    public function __construct(
        private readonly string $text
    ) {
    }

    public function getTextToBodyFormat(): string
    {
        return json_encode([
            'text' => $this->text,
        ]);
    }
}
