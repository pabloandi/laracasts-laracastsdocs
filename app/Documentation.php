<?php

namespace App;

use Parsedown;
use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;

class Documentation
{
    protected $storage;

    public function __construct(FileSystem $storage) {
        $this->storage = $storage;
    }

    public function get($version, $page)
    {

        if($this->storage->exists($page = $this->markdownPath($version, $page))) {
            return (new Parsedown)->text($this->storage->get($page));
        }

        throw new Exception('The requested documentation page was not found.');

    }

    public static function versions(){
        return [1.0, 1.1];
    }

    public function markdownPath($version, $page)
    {
        return "docs/{$version}/{$page}.md";
    }
}
