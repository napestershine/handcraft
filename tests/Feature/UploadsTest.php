<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class UploadsTest extends TestCase
{
    public function testAvatarUpload()
    {
        $response = $this->call('POST', '/api/v1/upload', [
            'file' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $this->assertEquals(200, $response->status());
    }
}