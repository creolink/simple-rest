<?php

namespace CategoriesBundle\Service\TreeHandler;

use CategoriesBundle\DataObject\TreeDto;
use CategoriesBundle\DataObject\ParametersDto;

class CompleteCategoriesTreeService extends AbstractCategoriesTreeService
{
    /**
     * {@inheritDoc}
     */
    public function getTree(ParametersDto $parameters = null): TreeDto
    {
        $categories = $this->repository->findByParent();

        return $this->treeGeneratorService->createTree(
            $this->categoryIteratorService->getIteratedCategories(
                $categories
            )
        );
    }
}
