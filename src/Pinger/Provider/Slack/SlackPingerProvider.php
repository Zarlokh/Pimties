<?php

namespace App\Pinger\Provider\Slack;

use App\Entity\Configuration\PingerProvider\PingerProviderConfigurationInterface;
use App\Entity\Configuration\PingerProvider\SlackPingerProviderConfiguration;
use App\Entity\PingeableInterface;
use App\Entity\Warranty;
use App\Exception\NoNormalizerFoundException;
use App\Pinger\Provider\PingerProviderInterface;
use App\Pinger\Provider\Slack\Normalizer\SlackNormalizerInterface;
use App\Pinger\Provider\Slack\Normalizer\WarrantyNormalizer;
use Symfony\Component\HttpClient\HttpClient;

class SlackPingerProvider implements PingerProviderInterface
{
    /** @var SlackNormalizerInterface[] */
    private readonly array $normalizers;

    public function __construct(WarrantyNormalizer $warrantyNormalizer)
    {
        // TODO : dto pas normalize
        // TODO : Mediator ?
        $this->normalizers = [
            Warranty::class => $warrantyNormalizer,
        ];
    }

    public function ping(PingeableInterface $pingeable, PingerProviderConfigurationInterface $pingerConfiguration): void
    {
        /** @var SlackPingerProviderConfiguration $pingerConfiguration */
        if (!($normalizer = $this->normalizers[get_class($pingeable)] ?? false)) {
            throw new NoNormalizerFoundException(sprintf('Aucun normalizer a été trouvé pour le pingeable %s et le provider %s', get_class($pingeable), __CLASS__));
        }

        if (!($slackWebhook = $pingerConfiguration->getSlackWebhook())) {
            throw new \LogicException('Should never happened, slack provider without slack webhook');
        }

        $slackModel = $normalizer->normalize($pingeable);

        $httpClient = HttpClient::create();

        $httpClient->request('POST', $slackWebhook, [
            'body' => $slackModel->getTextToBodyFormat(),
        ]);
        // TODO Gestion de la response
    }

    public function support(PingerProviderConfigurationInterface $pingerConfiguration): bool
    {
        return $pingerConfiguration instanceof SlackPingerProviderConfiguration;
    }
}
