<?php

namespace Tests\Unit;

use Tests\Mocks\ArticlesMock;
use PHPUnit\Framework\TestCase;

class ArticlesTest extends TestCase
{
    protected function setUp(): void
    {
        require_once('tests/Mocks/ArticlesMock.php');
    }

    public function testGetAll()
    {
        $filter = 'views';
        $result = ArticlesMock::getAll($filter);

        $this->assertCount(2, $result);
        $this->assertEquals(200, $result[0]['views']);
        $this->assertEquals(100, $result[1]['views']);
    }

    public function testGetOne()
    {
        $result = ArticlesMock::getOne(1);
        $this->assertNotEmpty($result);
        $this->assertEquals(1, $result['id']);
    }

    public function testAddOneView()
    {
        $this->expectNotToPerformAssertions();
        ArticlesMock::addOneView(1);
    }

    public function testGetByUser()
    {
        $result = ArticlesMock::getByUser(1);
        $this->assertNotEmpty($result);
        $this->assertEquals(1, $result[0]['user_id']);
    }

    public function testGetSuggest()
    {
        $result = ArticlesMock::getSuggest();
        $this->assertNotEmpty($result);
        $this->assertEquals('Suggested Mock Article', $result[0]['name']);
    }

    public function testSave()
    {
        $data = [
            'name' => 'Test Article',
            'description' => 'This is a test article.',
            'user_id' => 1,
        ];

        $result = ArticlesMock::save($data);
        $this->assertEquals(1, $result);
    }

    public function testAttachPicture()
    {
        $this->expectNotToPerformAssertions();
        ArticlesMock::attachPicture(1, 'picture.jpg');
    }

    public function testUpdate()
    {
        $data = [
            'name' => 'Updated Article',
            'description' => 'This is an updated article.',
            'published_date' => '2024-01-01',
        ];

        $result = ArticlesMock::update(1, $data);
        $this->assertTrue($result);
    }

    public function testDelete()
    {
        $result = ArticlesMock::delete(1);
        $this->assertTrue($result);
    }

    public function testCountAll()
    {
        $result = ArticlesMock::countAll();
        $this->assertEquals(10, $result);
    }
}