<?php

namespace Tests\Unit;

use App\Models\City;
use TestCase;

class CityTest extends TestCase
{

    public function testGermanZipCode()
    {
        $zip = 10115;
        $this->assertTrue(City::validateZip($zip));

        /*$zip = 'abc';

        $this->assertNotSame(true, City::validateZip($zip));*/
    }
}
