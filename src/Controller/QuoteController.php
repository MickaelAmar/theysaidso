<?php

namespace App\Controller;

use App\Entity\Quote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;


/*
TODO :
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
     * @param CacheInterface $cache
     * @return JsonResponse
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function show(string $author_slug, Request $request, CacheInterface $cache)
    {
        try {

            // Get parameters
            $author = ucwords(str_replace('-', ' ', $author_slug));
            $limit = $request->query->get('limit', 10);
            if ($limit > 10) {
                throw new HttpException(400, "Limit parameter shouldn't be higher than 10");
            }

            // Fetching quotes
            $shouted_quotes  = $cache->get('markdown_'.md5($author.$limit), function() use ($author, $limit) {
                return $this->quote_entity->findByAuthor($author, $limit);
            });

            // Json response
            return $this->json($shouted_quotes);

        } catch (\Exception $exception) {

            return new JsonResponse([
                'success' => false,
                'code'    => $exception->getCode() ?: 400,
                'message' => $exception->getMessage(),
            ]);

        }
    }
}
