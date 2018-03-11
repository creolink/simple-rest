<?php

namespace CategoriesBundle\Service;

use CategoriesBundle\Validator\JsonSchemaValidatorInterface;
use CategoriesBundle\Repository\CategoryRepository;
use CategoriesBundle\Entity\Category;
use JMS\Serializer\SerializerInterface;
use CategoriesBundle\DataObject\CategoryDto;
use CategoriesBundle\Service\Transformer\CategoryTransformer;
use CategoriesBundle\Exception\InvalidCategoryDataException;

class CreateCategoryService
{
    /**
     * @var JsonSchemaValidatorInterface
     */
    private $jsonSchemaValidator;

    /**
     * @var CategoryRepository
     */
    protected $repository;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var CategoryTransformer
     */
    private $transformer;

    /**
     * @param JsonSchemaValidatorInterface $jsonSchemaValidator
     * @param CategoryRepository $repository
     * @param CategoryTransformer $transformer
     * @param SerializerInterface $serializer
     */
    public function __construct(
        JsonSchemaValidatorInterface $jsonSchemaValidator,
        CategoryRepository $repository,
        CategoryTransformer $transformer,
        SerializerInterface $serializer
    ) {
        $this->jsonSchemaValidator = $jsonSchemaValidator;
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->transformer = $transformer;
    }

    /**
     * @param string|null $content
     * @return Category
     */
    public function createCategory(string $content = null)
    {
        if ($this->jsonSchemaValidator->validate($content)) {
            $categoryDto = $this->removeTags(
                $this->createCategoryDto($content)
            );

            $this->validateSlug($categoryDto);
            $this->validateName($categoryDto);

            $category = $this->transformer->reverseTransform(
                $categoryDto,
                $this->getParentCategory($categoryDto)
            );

            return $this->repository->save($category);
        }
    }

    /**
     * @return Category|null
     * @throws InvalidCategoryDataException
     */
    private function getParentCategory(CategoryDto $categoryDto): ?Category
    {
        if (!empty($categoryDto->getParentCategory())) {
            $parentCategory = $this->repository->findOneById(
                $categoryDto->getParentCategory()
            );

            if (empty($parentCategory)) {
                throw new InvalidCategoryDataException(
                    sprintf(
                        "Parent category `%s` does not exists!",
                        $categoryDto->getParentCategory()
                    )
                );
            }

            return $parentCategory;
        }

        return null;
    }

    /**
     * @param string $data
     * @return CategoryDto
     */
    private function createCategoryDto(string $data): CategoryDto
    {
        return $this->serializer->deserialize($data, CategoryDto::class, 'json');
    }

    /**
     * @param CategoryDto $categoryDto
     * @return CategoryDto
     */
    private function removeTags(CategoryDto $categoryDto): CategoryDto
    {
        return $categoryDto->setName(
            strip_tags(
                $categoryDto->getName()
            )
        );
    }

    /**
     * @param CategoryDto $categoryDto
     * @return void
     * @throws InvalidCategoryDataException
     */
    private function validateName(CategoryDto $categoryDto): void
    {
        if (empty($categoryDto->getName())) {
            throw new InvalidCategoryDataException(
                "Category name contains invalid signs or is empty!"
            );
        }
    }

    /**
     * @param CategoryDto $categoryDto
     * @return void
     * @throws InvalidCategoryDataException
     */
    private function validateSlug(CategoryDto $categoryDto): void
    {
        $category = $this->repository->findOneBySlug(
            $categoryDto->getSlug()
        );

        if (!empty($category)) {
            throw new InvalidCategoryDataException(
                sprintf(
                    "Category with slug `%s` already exists!",
                    $categoryDto->getSlug()
                )
            );
        }
    }
}
