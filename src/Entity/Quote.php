<?php

namespace App\Entity;

use App\Helpers\FileHelper;
use App\Helpers\StringHelper;

class Quote
{
    private $quotes;

    /**
     * Quote constructor.
     * @param FileHelper $file_helper
     */
    public function __construct(FileHelper $file_helper)
    {
        // Fetches quotes references from json file
        $this->quotes = json_decode(file_get_contents($file_helper->getResourceFilePath('quotes.json')), true)['quotes'];
    }

    /**
     * @param $author
     * @param int $limit
     * @return array
     */
    public function findByAuthor(string $author, int $limit = 10) : array
    {
        $shouted_quotes = [];

        foreach ($this->quotes AS $quote) {
            if ($quote['author'] === $author && count($shouted_quotes) < $limit) {

                // StringHelper::shout should be specific to an action but for this example, we assume that all quote fetched should be shouted
                $shouted_quotes[] = StringHelper::shout($quote['quote']);
            }
        }

        return $shouted_quotes;
    }
}