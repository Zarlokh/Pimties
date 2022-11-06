<?php

namespace App\Pinger\Provider\Slack;

class SlackModelFactory
{
    public static function createSlackModel(string $text): SlackModel
    {
        return new SlackModel($text);
    }
}
