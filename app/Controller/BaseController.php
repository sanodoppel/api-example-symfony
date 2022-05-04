<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class BaseController extends AbstractController
{
    /**
     * @var NormalizerInterface
     */
    protected NormalizerInterface $normalizer;

    /**
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * @param NormalizerInterface $normalizer
     */
    #[Required]
    public function setNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @param ValidatorInterface $validator
     */
    #[Required]
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    protected function getErrors(ConstraintViolationList $violationList): array
    {
        $errors = [];

        foreach ($violationList as $key => $child) {
            $errors[$child->getPropertyPath()][] = $child->getMessage();
        }

        return $errors;
    }
}
