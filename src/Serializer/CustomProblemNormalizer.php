<?php

namespace App\Serializer;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class CustomProblemNormalizer implements NormalizerInterface
{
    public function __construct()
    {
    }

    /**
     * @var string
     */
    private string $environment;

    /**
     * @param KernelInterface $kernel
     */
    #[Required]
    public function setEnvironment(KernelInterface $kernel): void
    {
        $this->environment = $kernel->getEnvironment();
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        return ['error' => $this->environment === 'dev' ? $object->getMessage() : 'An error occurred'];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof FlattenException;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            FlattenException::class => true,
        ];
    }
}
