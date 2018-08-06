<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\City;
use App\Models\Job;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class JobTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->job = factory(Job::class)->create();
    }
    public function testBelongsToAUser()
    {
        $this->assertInstanceOf(User::class, $this->job->user);
    }

    public function testBelongsToACity()
    {
        $this->assertInstanceOf(City::class, $this->job->city);
    }

    public function testBelongsToACategory()
    {
        $this->assertInstanceOf(Category::class, $this->job->category);
    }
}
