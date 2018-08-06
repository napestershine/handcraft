<?php

namespace Tests\Feature;

use App\Models\Category;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class CategoriesTest extends TestCase
{
   use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->category = factory(Category::class)->create();

    }


    public function testGetAll()
    {
        $response = $this->call('GET', '/api/v1/categories');
        $this->assertEquals(200, $response->status());
        $this->seeJson([
            'name' => $this->category->name,
            'uid' => $this->category->uid,
            'image' => $this->category->image,
        ]);
    }


    public function testGet()
    {
        $response = $this->call('GET', '/api/v1/categories/' . $this->category->id);
        $this->assertEquals(200, $response->status());
        $this->seeJson([
            'name' => $this->category->name,
            'uid' => $this->category->uid,
            'image' => $this->category->image,
            'slug' => str_replace(' ', '-', strtolower($this->category->name)),
        ]);

        $response = $this->call('GET', '/api/v1/categories/5555');
        $this->assertEquals(404, $response->status());
    }

    public function testPost()
    {
        $this->post('/api/v1/categories', [
            'name' => 'Sonstige Umzugsleistungen',
            'uid' => 804040,
            'image' => 'http://gofooddy.com/wp-content/uploads/2017/07/logo0.jpg'
        ])->seeJson([
            'name' => 'Sonstige Umzugsleistungen',
            'uid' => 804040,
            'slug' => str_replace(' ', '-', strtolower('Sonstige Umzugsleistungen')),
            'image' => 'http://gofooddy.com/wp-content/uploads/2017/07/logo0.jpg'
        ]);
    }


    public function testPut()
    {
        $this->put('/api/v1/categories/' . $this->category->id, [
            'name' => 'HP Computer',
            'uid' => $this->category->uid,
            'image' => $this->category->image,
        ])->seeJson([
            'name' => 'HP Computer',
            'slug' => str_replace(' ', '-', strtolower('HP Computer')),
            'uid' => $this->category->uid,
            'image' => $this->category->image,
        ]);

        $response = $this->call('PUT', '/api/v1/categories/5555');
        $this->assertEquals(404, $response->status());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', '/api/v1/categories/' . $this->category->id);
        $this->assertEquals(200, $response->status());

        $response = $this->call('DELETE', '/api/v1/categories/' . $this->category->id);
        $this->assertEquals(404, $response->status());

        $response = $this->call('DELETE', '/api/v1/categories/5555');
        $this->assertEquals(404, $response->status());
    }
}