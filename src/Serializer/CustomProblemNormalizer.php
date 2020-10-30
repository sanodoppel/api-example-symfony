<?php

namespace App\Serializer;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CustomProblemNormalizer implements NormalizerInterface
{
    public function normalize($exception, string $format = null, array $context = [])
    {
        return ['error' => $exception->getMessage()];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof FlattenException;
    }
}
