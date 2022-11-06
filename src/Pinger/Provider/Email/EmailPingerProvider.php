<?php

namespace App\Pinger\Provider\Email;

use App\Entity\Configuration\PingerProvider\EmailPingerProviderConfiguration;
use App\Entity\Configuration\PingerProvider\PingerProviderConfigurationInterface;
use App\Entity\PingeableInterface;
use App\Entity\Warranty;
use App\Exception\NoNormalizerFoundException;
use App\Factory\EmailFactory;
use App\Pinger\Provider\AbstractPingerProvider;
use App\Pinger\Provider\Email\Normalizer\EmailNormalizerInterface;
use App\Pinger\Provider\Email\Normalizer\WarrantyNormalizer;
use Symfony\Component\Mailer\MailerInterface;

class EmailPingerProvider extends AbstractPingerProvider
{
    /** @var EmailNormalizerInterface[] */
    private readonly array $normalizers;

    public function __construct(
        private readonly EmailFactory $emailFactory,
        private readonly MailerInterface $mailer,
        WarrantyNormalizer $warrantyNormalizer
    ) {
        $this->normalizers = [Warranty::class => $warrantyNormalizer];
    }

    public function ping(PingeableInterface $pingeable, PingerProviderConfigurationInterface $pingerConfiguration): void
    {
        if (!($normalizer = $this->normalizers[get_class($pingeable)] ?? false)) {
            throw new NoNormalizerFoundException(sprintf('Aucun normalizer a été trouvé pour le pingeable %s et le provider %s', get_class($pingeable), __CLASS__));
        }
        $emailModel = $normalizer->normalize($pingeable);

        /** @var EmailPingerProviderConfiguration $pingerConfiguration */
        $this->mailer->send($this->emailFactory->createPingEmail($pingerConfiguration, $emailModel->getSubject(), $emailModel->getContent()));
    }

    public function support(PingerProviderConfigurationInterface $pingerConfiguration): bool
    {
        return $pingerConfiguration instanceof EmailPingerProviderConfiguration;
    }
}
