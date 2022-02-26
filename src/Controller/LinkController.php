<?php
declare(strict_types=1);

namespace App\Controller;

use App\Provider\LinkProvider;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/link")
 */
class LinkController extends AbstractController
{
    private LinkProvider $linkProvider;

    public function __construct(LinkProvider $linkProvider)
    {
        $this->linkProvider = $linkProvider;
    }

    /**
     * @Route("/", methods="GET")
     */
    public function getLinks(): JsonResponse
    {
        return $this->json([
          'items' => $this->linkProvider->getLinks(),
          'total' => $this->linkProvider->getTotal(),
        ]);
    }

    /**
     * @Route("/", methods="POST")
     * @IsGranted("STANDARD_USER")
     */
    public function createLinks(Request $request): JsonResponse
    {
        $this->linkProvider->createLink(
          $this->getUser(),
          $request->request->get('url', '')
        );

        return $this->json([
          'items' => [
            $this->linkProvider->getLink()
          ]
        ]);
    }
}
