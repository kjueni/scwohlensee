<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Page;

class PageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /**
     * @param array $params
     * @return Page
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $page = Page::fromArray($params);

        return $page;
    }

    /**
     * @param Page $page
     * @param array $params
     * @return Page
     */
    public function hydrate(Page $page, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case  'title':
                    $page->setTitle($param);
                    break;
                case  'description':
                    $page->setDescription($param);
                    break;
                case  'text':
                    $page->setText($param);
                    break;
            }
        }

        return $page;
    }
}
