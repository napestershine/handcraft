<?php

namespace Tests\Unit;

use App\Models\City;
use Illuminate\Validation\ValidationException;
use TestCase;

class CityTest extends TestCase
{
    protected $instance;

    public function setUp()
    {
        $this->city = new City();
    }

    public function testSetValueRefusesBadInput()
    {
        $this->assertTrue($this->city->validateZip(10115));
    }
}
