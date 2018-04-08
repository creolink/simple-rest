<?php

namespace CategoriesBundle\Service\TreeHandler;

use CategoriesBundle\DataObject\TreeDto;
use CategoriesBundle\Exception\CategoryNotFoundException;
use CategoriesBundle\DataObject\ParametersDto;

class VisibleChildCategoriesTreeService extends AbstractCategoriesTreeService
{
    /**
     * {@inheritDoc}
     */
    public function getTree(ParametersDto $parameters = null): TreeDto
    {
        $categories = $this->repository->findBySlug($parameters->getSlug());

        if (empty($categories)) {
            throw new CategoryNotFoundException(
                sprintf(
                    "Category `%s` not found",
                    $parameters->getSlug()
                )
            );
        }

        return $this->treeGeneratorService->createTree(
            $this->categoryIteratorService->getIteratedCategories(
                $categories,
                true
            ),
            false
        );
    }
}
