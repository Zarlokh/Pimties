<?php

namespace App\Pinger\Provider\Slack\Normalizer;

use App\Entity\PingeableInterface;
use App\Entity\Warranty;
use App\Pinger\Provider\Slack\SlackModel;
use App\Pinger\Provider\Slack\SlackModelFactory;

class WarrantyNormalizer implements SlackNormalizerInterface
{
    public function normalize(PingeableInterface $pingeable): SlackModel
    {
        if (!$pingeable instanceof Warranty) {
            throw new \LogicException(sprintf('Utilisation d\'un mauvais normalizer %s pour le pingeable %s', get_class($this), get_class($pingeable)));
        }
        $text = sprintf('La garantie [%d] %s a expiré', $pingeable->getId() ?? -1, $pingeable->getName() ?? 'No name');

        return SlackModelFactory::createSlackModel($text);
    }
}
