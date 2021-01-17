<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Documentation;

class DocumentationController extends Controller
{
    protected $docs;

    public function __construct(Documentation $docs) {
        $this->docs = $docs;
    }

    public function show($version, $page = '')
    {
        if (! in_array($version, Documentation::versions())){
            return redirect("docs/" . DEFAULT_VERSION . "/some-page");
        }

        return view('docs', [
            'content' => $this->docs->get($version, $page)
        ]);

    }
}
