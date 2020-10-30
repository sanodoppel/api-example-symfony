<?php

namespace App\Controller;

use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/api/default", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Return something",
     * )
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     @OA\Schema(type="int")
     * )
     * @OA\Tag(name="default")
     * @Security(name="Bearer")
     */
    public function index()
    {
        return new Response();
    }
}