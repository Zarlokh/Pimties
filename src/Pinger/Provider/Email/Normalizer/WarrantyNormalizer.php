<?php

namespace App\Pinger\Provider\Email\Normalizer;

use App\Entity\PingeableInterface;
use App\Entity\Warranty;
use App\Pinger\Provider\Email\EmailModel;
use App\Pinger\Provider\Email\EmailModelFactory;

class WarrantyNormalizer implements EmailNormalizerInterface
{
    public function normalize(PingeableInterface $pingeable): EmailModel
    {
        if (!$pingeable instanceof Warranty) {
            throw new \LogicException(sprintf('Le normalizer %s ne gère pas le pingeable %s', __CLASS__, get_class($pingeable)));
        }

        $subjectAndMessage = sprintf('La garantie [%d] %s a expiré', $pingeable->getId() ?? -1, $pingeable->getName() ?? 'No name');

        return EmailModelFactory::create($subjectAndMessage, $subjectAndMessage);
    }
}
