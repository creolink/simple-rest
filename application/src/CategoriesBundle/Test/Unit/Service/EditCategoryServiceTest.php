<?php

namespace CategoriesBundle\Test\Unit\Service;

use PHPUnit\Framework\TestCase;
use CategoriesBundle\Service\EditCategoryService;
use CategoriesBundle\Repository\CategoryRepository;
use Doctrine\DBAL\Exception\ServerException;
use CategoriesBundle\Validator\JsonSchemaValidatorInterface;
use CategoriesBundle\Service\CategoryDataService;
use CategoriesBundle\Entity\Category;
use JMS\Serializer\SerializerInterface;
use \Mockery as m;

class EditCategoryServiceTest extends TestCase
{
    const ERROR_CATEGORY = 'ERROR';

    /**
     * @var EditCategoryService
     */
    private $editCategoryService;

    /**
     * @expectedException CategoriesBundle\Exception\CategoryNotFoundException
     */
    public function testUpdateCategoryServerError()
    {
        $this->editCategoryService->patchVisibility(
            self::ERROR_CATEGORY,
            $this->createContent()
        );
    }

    /**
     * @SetUp
     */
    protected function setUp()
    {
        $this->editCategoryService = new EditCategoryService(
            $this->mockJsonSchemaValidatorInterface(),
            $this->mockCategoryDataService(),
            $this->mockCategoryRepository(),
            $this->mockSerializerInterface()
        );
    }

    /**
     * @TearDown
     */
    protected function tearDown()
    {
        $this->editCategoryService = null;

        m::close();
    }

    /**
     * @return CategoryRepository
     */
    private function mockCategoryRepository(): CategoryRepository
    {
        $mock = m::mock(CategoryRepository::class);

        $mock->shouldReceive('update')
            ->andThrow($this->mockServerException());

        return $mock;
    }

    /**
     * @return ServerException
     */
    private function mockServerException(): ServerException
    {
        $mock = m::mock(ServerException::class);

        return $mock;
    }

    /**
     * @return JsonSchemaValidatorInterface
     */
    private function mockJsonSchemaValidatorInterface(): JsonSchemaValidatorInterface
    {
        $mock = m::mock(JsonSchemaValidatorInterface::class);

        $mock->shouldReceive('validate')
            ->andReturn(true);

        return $mock;
    }

    /**
     * @return CategoryDataService
     */
    private function mockCategoryDataService(): CategoryDataService
    {
        $mock = m::mock(CategoryDataService::class);

        $mock->shouldReceive('getCategoryById')
            ->andReturn(
                $this->createCategory()
            );

        return $mock;
    }

    /**
     * @return SerializerInterface
     */
    private function mockSerializerInterface(): SerializerInterface
    {
        $mock = m::mock(SerializerInterface::class);

        $mock->shouldReceive('serialize')
            ->andReturn(
                '{"id":"Foo","isVisible":true,"children":[],"slug":"Bar","name":"FooBar"}'
            );

        $mock->shouldReceive('deserialize')
            ->andReturn(
                $this->createCategory()
            );

        return $mock;
    }

    /**
     * @return Category
     */
    private function createCategory(): Category
    {
         $category = new Category();
         $category->setId('Foo');
         $category->setIsVisible(true);
         $category->setSlug('Bar');
         $category->setName('FooBar');

         return $category;
    }

    /**
     * @return string
     */
    private function createContent(): string
    {
        $operation['op'] = 'replace';
        $operation['path'] = '/isVisible';
        $operation['value'] = true;

        $content = [];
        $content[] = $operation;

        return json_encode($content);
    }
}
