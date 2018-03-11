<?php

namespace CategoriesBundle\Service\TreeHandler;

use CategoriesBundle\DataObject\TreeDto;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface CategoriesTreeInterface
{
    /**
     * @param string|null $slug
     * @return TreeDto
     * @throws NotFoundHttpException
     */
    public function getTree(string $slug = null): TreeDto;
}
