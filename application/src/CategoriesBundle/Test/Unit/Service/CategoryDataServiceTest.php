<?php

namespace CategoriesBundle\Test\Unit\Service;

use PHPUnit\Framework\TestCase;
use CategoriesBundle\Service\CategoryDataService;
use CategoriesBundle\Repository\CategoryRepository;
use Doctrine\DBAL\Exception\ServerException;
use \Mockery as m;

class CategoryDataServiceTest extends TestCase
{
    const ERROR_CATEGORY = 'ERROR';
    const NOT_FOUND_CATEGORY = 'BAR';

    /**
     * @var CategoryDataService
     */
    private $categoryDataService;

    /**
     * @expectedException CategoriesBundle\Exception\CategoryNotFoundException
     */
    public function testNotExistingCategoryById()
    {
        $this->categoryDataService->getCategoryById(self::NOT_FOUND_CATEGORY);
    }

//    /**
//     * @expectedException CategoriesBundle\Exception\CategoryNotFoundException
//     */
//    public function testGetCategoryByIdServerError()
//    {
//        $this->categoryDataService->getCategoryById(self::ERROR_CATEGORY);
//    }

    /**
     * @expectedException CategoriesBundle\Exception\CategoryNotFoundException
     */
    public function testNotExistingCategoryBySlug()
    {
        $this->categoryDataService->getCategoryBySlug(self::NOT_FOUND_CATEGORY);
    }

//    /**
//     * @expectedException CategoriesBundle\Exception\CategoryNotFoundException
//     */
//    public function testGetCategoryBySlugServerError()
//    {
//        $this->categoryDataService->getCategoryBySlug(self::ERROR_CATEGORY);
//    }

    /**
     * @SetUp
     */
    protected function setUp()
    {
        $this->categoryDataService = new CategoryDataService(
            $this->mockCategoryRepository()
        );
    }

    /**
     * @TearDown
     */
    protected function tearDown()
    {
        $this->categoryDataService = null;

        m::close();
    }

    /**
     * @return CategoryRepository
     */
    private function mockCategoryRepository(): CategoryRepository
    {
        $mock = m::mock(CategoryRepository::class);

//        $mock->shouldReceive('findOneById')
//            ->with(self::ERROR_CATEGORY)
//            ->andThrow($this->mockServerException());

        $mock->shouldReceive('findOneById')
            ->with(self::NOT_FOUND_CATEGORY)
            ->andReturn(null);

//        $mock->shouldReceive('findOneBySlug')
//            ->with(self::ERROR_CATEGORY)
//            ->andThrow($this->mockServerException());

        $mock->shouldReceive('findOneBySlug')
            ->with(self::NOT_FOUND_CATEGORY)
            ->andReturn(null);

        return $mock;
    }

//    /**
//     * @return ServerException
//     */
//    private function mockServerException(): ServerException
//    {
//        $mock = m::mock(ServerException::class);
//
//        return $mock;
//    }
}
