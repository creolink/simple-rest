<?php

namespace CategoriesBundle\Service;

use CategoriesBundle\Exception\CategoryNotFoundException;
use CategoriesBundle\Entity\Category;
use CategoriesBundle\Exception\CategoryPatchException;
use CategoriesBundle\Repository\CategoryRepositoryInterface;
use JMS\Serializer\SerializerInterface;
use CategoriesBundle\Validator\JsonSchemaValidatorInterface;
use CategoriesBundle\Exception\InvalidJsonDataException;
use CategoriesBundle\Service\Patcher\DocumentPatcherInterface;
use CategoriesBundle\Exception\DocumentPatchException;

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
     * @var CategoryRepositoryInterface
     */
    protected $repository;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var DocumentPatcherInterface
     */
    protected $documentPatcher;

    /**
     * @param JsonSchemaValidatorInterface $jsonSchemaValidator
     * @param CategoryDataService $categoryDataService
     * @param CategoryRepositoryInterface $repository
     * @param SerializerInterface $serializer
     * @param DocumentPatcherInterface $documentPatcher
     */
    public function __construct(
        JsonSchemaValidatorInterface $jsonSchemaValidator,
        CategoryDataService $categoryDataService,
        CategoryRepositoryInterface $repository,
        SerializerInterface $serializer,
        DocumentPatcherInterface $documentPatcher
    ) {
        $this->jsonSchemaValidator = $jsonSchemaValidator;
        $this->categoryDataService = $categoryDataService;
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->documentPatcher = $documentPatcher;
    }

    /**
     * @param string $id
     * @param string|null $content
     * @return Category
     * @throws CategoryNotFoundException
     * @throws InvalidJsonDataException
     * @throws DocumentPatchException
     */
    public function patchVisibility(string $id, string $content = null): Category
    {
        $category = $this->categoryDataService->getCategoryById($id);

        $this->jsonSchemaValidator->validate($content);

        $categoryJson = $this->serializer->serialize($category, 'json');

        $patchedCategory = $this->getPatchedCategory(
            $this->documentPatcher->patchDocument($id, $categoryJson, $content)
        );

        return $this->repository->update($patchedCategory);
    }

    /**
     * @param string $patchedDocument
     * @return Category|object
     */
    private function getPatchedCategory(string $patchedDocument): Category
    {
        return $this->serializer->deserialize($patchedDocument, Category::class, 'json');
    }
}
