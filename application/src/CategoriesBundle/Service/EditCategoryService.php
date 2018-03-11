<?php

namespace CategoriesBundle\Service;

use Doctrine\DBAL\Exception\ServerException;
use CategoriesBundle\Exception\CategoryNotFoundException;
use CategoriesBundle\Entity\Category;
use CategoriesBundle\Repository\CategoryRepository;
use Rs\Json\Patch;
use JMS\Serializer\SerializerInterface;
use CategoriesBundle\Validator\JsonSchemaValidatorInterface;
use Rs\Json\Patch\Operations\Replace;

class EditCategoryService
{
    /**
     * @var JsonSchemaValidatorInterface
     */
    private $jsonSchemaValidator;

    /**
     * @var CategoryDataService
     */
    protected $categoryDataService;

    /**
     * @var CategoryRepository
     */
    protected $repository;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param JsonSchemaValidatorInterface $jsonSchemaValidator
     * @param CategoryDataService $categoryDataService
     * @param CategoryRepository $repository
     * @param SerializerInterface $serializer
     */
    public function __construct(
        JsonSchemaValidatorInterface $jsonSchemaValidator,
        CategoryDataService $categoryDataService,
        CategoryRepository $repository,
        SerializerInterface $serializer
    ) {
        $this->jsonSchemaValidator = $jsonSchemaValidator;
        $this->categoryDataService = $categoryDataService;
        $this->repository = $repository;
        $this->serializer = $serializer;
    }

    /**
     * @param string $id
     * @param string|null $content
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function patchVisibility(string $id, string $content = null): Category
    {
        $category = $this->categoryDataService->getCategoryById($id);

        if ($this->jsonSchemaValidator->validate($content)) {
            $categoryJson = $this->serializer->serialize($category, 'json');

            $patch = new Patch($categoryJson, $content, Replace::APPLY);

            $patchedDocument = $patch->apply();
            $patchedCategory = $this->serializer->deserialize($patchedDocument, Category::class, 'json');

            try {
                return $this->repository->update($patchedCategory);
            } catch (ServerException $exception) {
                throw new CategoryNotFoundException(
                    $this->createErrorMessage($id)
                );
            }
        }
    }

    /**
     * @param string $category
     * @return string
     */
    private function createErrorMessage(string $category): string
    {
        return sprintf(
            "Category `%s `not found",
            $category
        );
    }
}
