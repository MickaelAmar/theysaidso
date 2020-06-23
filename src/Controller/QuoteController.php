<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Helpers\FileHelper;
use App\Helpers\StringHelper;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;


/*
TODO :
- Validate route+request params
- Is there another way to handle params ? accessors ?
- Manage cache
- Add tests
- Deploy
- BONUS : Set up a live documentation/test page (Swagger ?)
- BONUS : Make a seeder script to populate a db table with quote references and manipulate it from an entity/model
*/

class QuoteController extends AbstractController
{
    private $quote_entity;

    public function __construct(Quote $quote_entity)
    {
        $this->quote_entity = $quote_entity;
    }

    /**
     * @Route("/quote/{author_slug}", methods="GET")
     * @param string $author_slug
     * @param Request $request
     * @param KernelInterface $kernel
     * @return JsonResponse
     */
    public function show(string $author_slug, Request $request)
    {
        // Get parameters
        $limit = $request->query->get('limit', 10);
        $author = ucwords(str_replace('-', ' ', $author_slug));

        // Json response
        $shout_quotes = $this->quote_entity->findByAuthor($author, $limit);

        return $this->json($shout_quotes);
    }

}
