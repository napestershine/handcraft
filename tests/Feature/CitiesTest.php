<?php

namespace Tests\Feature;

use App\Models\City;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class CitiesTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->city = factory(City::class)->create();
    }

    public function testGetAll()
    {
        $response = $this->call('GET', '/api/v1/cities');
        $this->assertEquals(200, $response->status());
        $this->seeJson([
            'name' => $this->city->name,
            'zip' => $this->city->zip,
            'slug' => str_replace(' ', '-', strtolower($this->city->name))
        ]);
    }

    public function testGet()
    {
        $response = $this->call('GET', '/api/v1/cities/' . $this->city->id);
        $this->assertEquals(200, $response->status());
        $this->seeJson([
            'name' => $this->city->name,
            'zip' => $this->city->zip,
            'slug' => str_replace(' ', '-', strtolower($this->city->name)),
        ]);

        $response = $this->call('GET', '/api/v1/cities/5555');
        $this->assertEquals(404, $response->status());
    }

    public function testPost()
    {
        $this->post('/api/v1/cities', [
            'name' => 'Sonstige Umzugsleistungen',
            'zip' => 80404
        ])->seeJson([
            'name' => 'Sonstige Umzugsleistungen',
            'zip' => 80404,
            'slug' => str_replace(' ', '-', strtolower('Sonstige Umzugsleistungen'))
        ]);
    }

    public function testPut()
    {
        $this->put('/api/v1/cities/' . $this->city->id, [
            'name' => 'HP Computer',
            'zip' => $this->city->zip
        ])->seeJson([
            'name' => 'HP Computer',
            'slug' => str_replace(' ', '-', strtolower('HP Computer')),
            'zip' => $this->city->zip
        ]);

        $response = $this->call('PUT', '/api/v1/cities/5555');
        $this->assertEquals(404, $response->status());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', '/api/v1/cities/' . $this->city->id);
        $this->assertEquals(200, $response->status());

        $response = $this->call('DELETE', '/api/v1/cities/' . $this->city->id);
        $this->assertEquals(404, $response->status());

        $response = $this->call('DELETE', '/api/v1/cities/5555');
        $this->assertEquals(404, $response->status());
    }

    public function testGetCityByZip()
    {
        $response = $this->call('GET', '/api/v1/cities?zip=' . $this->city->zip);
        $this->assertEquals(200, $response->status());
        $this->seeJson([
            'id' => $this->city->id,
            'name' => $this->city->name,
            'zip' => $this->city->zip,
            'slug' => str_replace(' ', '-', strtolower($this->city->name))
        ]);
    }
}