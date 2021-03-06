<?php

namespace CategoriesBundle\Repository;

use CategoriesBundle\Entity\Category;
use CategoriesBundle\Exception\CategoryPatchException;
use CategoriesBundle\Exception\SaveCategoryException;

interface CategoryRepositoryInterface
{
    /**
     * @param string|null $id
     * @return Category|null|object
     */
    public function findOneById(string $id = null): ?Category;

    /**
     * @param string|null $slug
     * @return Category|null|object
     */
    public function findOneBySlug(string $slug = null): ?Category;

    /**
     * @param string|null $parentId
     * @return Category[]
     */
    public function findByParent(string $parentId = null): array;

    /**
     * @param string|null $slug
     * @return Category[]
     */
    public function findBySlug(string $slug = null): ?array;

    /**
     * @param Category $category
     * @return Category
     * @throws SaveCategoryException
     */
    public function save(Category $category): Category;

    /**
     * @param Category $category
     * @return Category
     * @throws CategoryPatchException
     */
    public function update(Category $category): Category;
}
