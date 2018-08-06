<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\City;
use App\Models\Job;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class JobsTest extends TestCase
{
  use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->job = factory(Job::class)->create();
    }

    public function testGetAll()
    {
        $response = $this->call('GET', '/api/v1/jobs');
        $this->assertEquals(200, $response->status());
        $this->seeJson([
            'title' => $this->job->title,
            'description' => $this->job->description,
            'execution' => $this->job->execution,
            'status' => $this->job->status,
            'user_id' => $this->job->user_id,
            'category_id' => $this->job->category_id,
            'city_id' => $this->job->city_id,
        ]);
    }


    public function testGet()
    {
        $response = $this->call('GET', '/api/v1/jobs/' . $this->job->id);
        $this->assertEquals(200, $response->status());
        $this->seeJson([
            'title' => $this->job->title,
            'description' => $this->job->description,
            'execution' => $this->job->execution,
            'status' => $this->job->status,
            'user_id' => $this->job->user_id,
            'category_id' => $this->job->category_id,
            'city_id' => $this->job->city_id,
        ]);

        $response = $this->call('GET', '/api/v1/jobs/5555');
        $this->assertEquals(404, $response->status());
    }

    public function testPost()
    {
        $city = factory(City::class)->create();
        $category = factory(Category::class)->create();
        $user = factory(User::class)->create();

        $this->post('/api/v1/jobs', [
            'title' => 'Sonstige Umzugsleistungen',
            'description' => 'this is description',
            'execution' => 'contemporary',
            'status' => 'Pending',
            'user_id' => $user->id,
            'city_id' => $city->id,
            'category_id' => $category->id,
        ])->seeJson([
            'title' => 'Sonstige Umzugsleistungen',
            'description' => 'this is description',
            'execution' => 'contemporary',
            'status' => 'Pending',
            'user_id' => $user->id,
            'city_id' => $city->id,
            'category_id' => $category->id,
        ]);
    }

    public function testPut()
    {
        $this->put('/api/v1/jobs/' . $this->job->id, [
            'title' => 'this is new title',
            'description' => $this->job->description,
            'execution' => $this->job->execution,
            'status' => $this->job->status,
            'user_id' => $this->job->user_id,
            'city_id' => $this->job->city_id,
            'category_id' => $this->job->category_id
        ])->seeJson([
            'title' => 'this is new title',
            'description' => $this->job->description,
            'execution' => $this->job->execution,
            'status' => $this->job->status,
            'user_id' => $this->job->user_id,
            'city_id' => $this->job->city_id,
            'category_id' => $this->job->category_id
        ]);

        $response = $this->call('PUT', '/api/v1/jobs/5555');
        $this->assertEquals(404, $response->status());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', '/api/v1/jobs/' . $this->job->id);
        $this->assertEquals(200, $response->status());

        $response = $this->call('DELETE', '/api/v1/jobs/' . $this->job->id);
        $this->assertEquals(404, $response->status());

        $response = $this->call('DELETE', '/api/v1/jobs/5555');
        $this->assertEquals(404, $response->status());
    }
}