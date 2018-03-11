<?php

namespace CategoriesBundle\Service\TreeHandler;

use \RecursiveIteratorIterator;
use CategoriesBundle\Service\TreeHandler\TreeGeneratorService;
use CategoriesBundle\Repository\CategoryRepository;
use CategoriesBundle\DataObject\TreeDto;
use CategoriesBundle\Service\Iterator\CategoryIteratorService;

abstract class AbstractCategoriesTreeService implements CategoriesTreeInterface
{
    /**
     * @var CategoryRepository
     */
    protected $repository;

    /**
     * @var TreeGeneratorService
     */
    protected $treeGeneratorService;

    /**
     * @var CategoryIteratorService
     */
    protected $categoryIteratorService;

    /**
     * @param CategoryRepository $repository
     * @param CategoryIteratorService $categoryIteratorService
     * @param TreeGeneratorService $treeGeneratorService
     */
    public function __construct(
        CategoryRepository $repository,
        CategoryIteratorService $categoryIteratorService,
        TreeGeneratorService $treeGeneratorService
    ) {
        $this->repository = $repository;
        $this->categoryIteratorService = $categoryIteratorService;
        $this->treeGeneratorService = $treeGeneratorService;
    }

    /**
     * {@inheritDoc}
     */
    abstract public function getTree(string $slug = null): TreeDto;

    /**
     * @param RecursiveIteratorIterator|null $iteratedCategories
     * @param bool $hasParent
     * @return TreeDto
     */
    protected function createTree(
        ?RecursiveIteratorIterator $iteratedCategories,
        bool $hasParent = true
    ): TreeDto {
        if (empty($iteratedCategories)) {
            return new TreeDto();
        }

        return $this->treeGeneratorService->createTree(
            $iteratedCategories,
            $hasParent
        );
    }
}
