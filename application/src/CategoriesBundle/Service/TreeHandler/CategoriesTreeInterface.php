<?php

namespace CategoriesBundle\Service\TreeHandler;

use CategoriesBundle\DataObject\TreeDto;
use CategoriesBundle\Exception\CategoryNotFoundException;
use CategoriesBundle\DataObject\ParametersDto;

interface CategoriesTreeInterface
{
    /**
     * @param ParametersDto|null $parameters
     * @return TreeDto
     * @throws CategoryNotFoundException
     */
    public function getTree(ParametersDto $parameters = null): TreeDto;
}
