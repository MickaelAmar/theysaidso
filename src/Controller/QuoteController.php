<?php

namespace App\Controller;

use App\Helpers\StringHelper;
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
- Put statements in organized and logical files (everything's done in the this controller action now)
- Deploy
- BONUS : Set up a live documentation/test page (Swagger ?)
- BONUS : Make a seeder script to populate a db table with quote references and manipulate it from an entity/model
*/

class QuoteController extends AbstractController
{

    /**
     * @Route("/quote/{author_slug}", methods="GET")
     * @param string $author_slug
     * @param Request $request
     * @param KernelInterface $kernel
     * @return JsonResponse
     */
    public function show(string $author_slug, Request $request, KernelInterface $kernel)
    {
        // Json response
        $shout_quotes = [];

        // Get parameters
        $limit = $request->query->get('limit', 1);
        $author = ucwords(str_replace('-', ' ', $author_slug));

        // Get quotes references from json file
        $resource_dir_path = $kernel->getProjectDir() . '/resources/';
        $quotes = json_decode(file_get_contents($resource_dir_path . 'quotes.json'), true)['quotes'];

        // Preparing response
        foreach ($quotes AS $quote) {
            if ($quote['author'] === $author && count($shout_quotes) < $limit) {
                $shout_quotes[] = StringHelper::shout($quote['quote']);
            }
        }

        return $this->json($shout_quotes);
    }

}
