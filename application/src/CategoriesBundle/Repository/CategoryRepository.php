<?php

namespace CategoriesBundle\Repository;

use CategoriesBundle\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use CategoriesBundle\Exception\CategoryPatchException;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Category::class);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneById(string $id = null): ?Category
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBySlug(string $slug = null): ?Category
    {
        return $this->repository->findOneBy(['slug' => $slug]);
    }

    /**
     * {@inheritdoc}
     */
    public function findByParent(string $parentId = null): array
    {
        return $this->repository->findBy(['parentCategory' => $parentId]);
    }

    /**
     * {@inheritdoc}
     */
    public function findBySlug(string $slug = null): ?array
    {
        return $this->repository->findBy(['slug' => $slug]);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Category $category): Category
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush($category);

        return $category;
    }

    /**
     * {@inheritdoc}
     */
    public function update(Category $category): Category
    {
        try {
            $this->entityManager->flush(
                $this->entityManager->merge($category)
            );

            return $category;
        } catch (ORMException $exception) {
            throw new CategoryPatchException(
                sprintf(
                    "Category `%s` cannon be saved: `%s`",
                    $category->getId(),
                    $exception->getMessage()
                )
            );
        }
    }
}
