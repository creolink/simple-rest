<?php

namespace CategoriesBundle\Service\TreeHandler;

use CategoriesBundle\Repository\CategoryRepositoryInterface;
use CategoriesBundle\DataObject\TreeDto;
use CategoriesBundle\Service\Iterator\CategoryIteratorService;
use CategoriesBundle\DataObject\ParametersDto;

abstract class AbstractCategoriesTreeService implements CategoriesTreeInterface
{
    /**
     * @var CategoryRepositoryInterface
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
     * @param CategoryRepositoryInterface $repository
     * @param CategoryIteratorService $categoryIteratorService
     * @param TreeGeneratorService $treeGeneratorService
     */
    public function __construct(
        CategoryRepositoryInterface $repository,
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
    abstract public function getTree(ParametersDto $parameters = null): TreeDto;
}
