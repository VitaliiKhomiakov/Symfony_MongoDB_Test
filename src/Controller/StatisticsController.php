<?php
declare(strict_types=1);

namespace App\Controller;

use App\Provider\LinkProvider;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/statistics")
 */
class StatisticsController extends AbstractController
{

    private LinkProvider $linkProvider;

    public function __construct(LinkProvider $linkProvider)
    {
        $this->linkProvider = $linkProvider;
    }

    /**
     * @Route("/user", methods="GET")
     * @throws Exception
     */
    public function getUsersLinks(): JsonResponse
    {
        return $this->json([
          'items' => $this->linkProvider->getLinkGroupList()
        ]);
    }

    /**
     * @Route("/user/{userId}", methods="GET")
     * @throws Exception
     */
    public function getUserLinks(string $userId): JsonResponse
    {
        return $this->json([
          'items' => $this->linkProvider->getLinkGroupList($userId)
        ]);
    }

    /**
     * @Route("/date/{date}", methods="GET")
     * @throws Exception
     */
    public function getLinkByDate(string $date): JsonResponse
    {
        return $this->json([
          'items' => $this->linkProvider->getLinkGroupList(null, $date)
        ]);
    }
}
