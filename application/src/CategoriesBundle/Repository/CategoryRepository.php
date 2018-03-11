<?php

namespace CategoriesBundle\Repository;

use CategoriesBundle\Entity\Category;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class CategoryRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Category::class);
    }

    /**
     * @param string|null $id
     * @return Category|null
     */
    public function findOneById(string $id = null): ?Category
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    /**
     * @param string|null $slug
     * @return Category|null
     */
    public function findOneBySlug(string $slug = null): ?Category
    {
        return $this->repository->findOneBy(['slug' => $slug]);
    }

    /**
     * @param string|null $parentId
     * @return Category[]
     */
    public function findByParent(string $parentId = null): array
    {
        return $this->repository->findBy(['parentCategory' => $parentId]);
    }

    /**
     * @param string|null $slug
     * @return Category[]
     */
    public function findBySlug(string $slug = null): ?array
    {
        return $this->repository->findBy(['slug' => $slug]);
    }

    /**
     * @param Category $category
     * @return Category
     */
    public function save(Category $category): Category
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush($category);

        return $category;
    }

    /**
     * @param Category $category
     * @return Category
     */
    public function update(Category $category): Category
    {
        $this->entityManager->flush(
            $this->entityManager->merge($category)
        );

        return $category;
    }
}
