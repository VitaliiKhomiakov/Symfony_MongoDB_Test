<?php
declare(strict_types=1);

namespace App\Controller;

use App\Provider\LinkProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/goto")
 */
class RedirectController extends AbstractController
{
    private LinkProvider $linkProvider;

    public function __construct(LinkProvider $linkProvider)
    {
        $this->linkProvider = $linkProvider;
    }

    /**
     * @Route("/", methods="GET")
     * @Route("/{url}", methods="GET")
     */
    public function getRedirectLink(string $url): RedirectResponse
    {
        $link = $this->linkProvider->getFullLink($url);
        return new RedirectResponse($link);
    }
}
