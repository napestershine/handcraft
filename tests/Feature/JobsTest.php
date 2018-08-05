<?php

namespace Tests\Feature;

use App\Models\Job;
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

   /* public function testPost()
    {
        $this->post('/api/v1/jobs', [
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
        $this->put('/api/v1/jobs/' . $this->job->id, [
            'name' => 'HP Computer',
            'uid' => $this->job->uid,
            'image' => $this->job->image,
        ])->seeJson([
            'name' => 'HP Computer',
            'slug' => str_replace(' ', '-', strtolower('HP Computer')),
            'uid' => $this->job->uid,
            'image' => $this->job->image,
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
    }*/
}