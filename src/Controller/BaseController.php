<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class BaseController extends AbstractController
{
    /**
     * @var NormalizerInterface
     */
    protected NormalizerInterface $normalizer;

    /**
     * @param NormalizerInterface $normalizer
     */
    #[Required]
    public function setNormalizer(NormalizerInterface $normalizer): void
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    protected function getFormErrors(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->all() as $key => $child) {
            foreach ($child->getErrors(true) as $error) {
                if (!$error->getOrigin()?->getParent()?->isRoot()) {
                    $key .= '.' . $error->getOrigin()->getName();
                }
                $errors[$key][] = $error->getMessage();
            }
        }

        return $errors;
    }
}
