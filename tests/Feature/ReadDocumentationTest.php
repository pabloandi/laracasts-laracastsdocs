<?php

namespace Tests\Feature;

use App\Documentation;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Mockery;

class ReadDocumentationTest extends TestCase
{
   /** @test */
   public function it_assumes_the_latests_documentation_version(){

        $version = DEFAULT_VERSION;
        $this->get('docs/some-page')->assertRedirect("docs/{$version}/some-page");
    }

    /** @test */
    public function it_loads_and_parsers_a_markdown(){
        $version = DEFAULT_VERSION;
        $path = "docs/{$version}/stub";

        $this->withoutExceptionHandling();


        $mock = Mockery::mock(Documentation::class, [Storage::disk('stubs')])->makePartial();
        $mock->allows()->markdownPath()->andReturns(
            "tests/helpers/stubs/docs/1.0/stub.md"
        );

        app()->instance(Documentation::class, $mock);

        $this->get($path)
            ->assertSee("<h1>Stub</h1>", false)
            ->assertSee("<p>Here is the documentation stub</p>", false);

    }
}
