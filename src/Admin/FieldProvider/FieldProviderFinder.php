<?php

namespace App\Admin\FieldProvider;

use App\Exception\NoFieldProviderFoundException;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class FieldProviderFinder
{
    /**
     * @param FieldProviderInterface[] $providers
     *
     * @psalm-suppress InvalidAttribute
     */
    public function __construct(
      #[TaggedIterator('app.field_provider')] private readonly iterable $providers
    ) {
    }

    public function getFields(object $instance): array
    {
        return $this->getProviderForInstance($instance)->getFields();
    }

    protected function getProviderForInstance(object $instance): FieldProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($instance)) {
                return $provider;
            }
        }

        throw new NoFieldProviderFoundException('No field provider found for instance '.get_class($instance));
    }
}
