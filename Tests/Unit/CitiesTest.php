<?php

use PHPUnit\Framework\TestCase;

class CitiesTest extends TestCase
{
    protected function setUp(): void
    {
        require_once('tests/Mocks/CitiesMock.php');
    }

    public function testSearchWithResult()
    {
        $result = \Tests\Mocks\CitiesMock::search('Paris');
        $this->assertNotEmpty($result);
        $this->assertEquals([1, 2, 3], $result);
    }

    public function testSearchWithoutResult()
    {
        $result = \Tests\Mocks\CitiesMock::search('NonExistentCity');
        $this->assertEmpty($result);
    }
}
