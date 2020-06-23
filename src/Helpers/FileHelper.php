<?php

namespace App\Helpers;

use Symfony\Component\HttpKernel\KernelInterface;

class FileHelper
{
    private $root_path;

    /**
     * FileHelper constructor.
     * @param string $root_path
     */
    public function __construct(string $root_path)
    {
        $this->root_path = $root_path;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getResourceFilePath(string $filename) : string
    {
        return $this->root_path . '/resources/' . $filename;
    }
}