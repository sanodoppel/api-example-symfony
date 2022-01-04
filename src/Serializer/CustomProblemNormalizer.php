<?php

namespace App\Serializer;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class CustomProblemNormalizer implements NormalizerInterface
{
    /**
     * @var string
     */
    private string $environment;

    /**
     * @param KernelInterface $kernel
     */
    #[Required]
    public function setEnvironment(KernelInterface $kernel)
    {
        $this->environment = $kernel->getEnvironment();
    }

    public function normalize($exception, $format = null, array $context = [])
    {
        return ['error' => $this->environment === 'dev' ? $exception->getMessage() : 'An error occurred'];
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof FlattenException;
    }
}
