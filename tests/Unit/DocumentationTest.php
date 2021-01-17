<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Documentation;
use Illuminate\Contracts\Filesystem\Filesystem;

class DocumentationTest extends TestCase
{

    /** @test */
    public function it_gets_the_documentation_page_for_a_given_version()
    {

        app()->instance(Filesystem::class, Storage::disk('stubs'));

        $content = resolve(Documentation::class)->get("1.0", "stub");
        $this->assertStringContainsString('<p>Here is the documentation stub</p>', $content);
    }

    /** @test */
    public function it_throws_and_exception_if_the_requested_markdown_file_does_not_exists(){
        $this->expectException(\Exception::class);

        (new Documentation(Storage::disk('local')))->get("1.0", "example");

    }
}
