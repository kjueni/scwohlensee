<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\File;

class FileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, File::class);
    }

    /**
     * @param array $params
     * @return File
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $file = File::fromArray($params);

        return $file;
    }

    /**
     * @param File $file
     * @param array $params
     * @return File
     */
    public function hydrate(File $file, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case  'title':
                    $file->setTitle($param);
                    break;
                case 'name':
                    $file->setName($param);
                    break;
                case 'type':
                    $file->setType($param);
                    break;
                case 'size':
                    $file->setSize($param);
                    break;
                case 'url':
                    $file->setUrl($param);
                    break;
                case 'navigation_entries':
                    $file->setNavigationEntries($param);
                    break;
                case 'sort_index':
                    $file->setSortIndex($param);
                    break;
            }
        }

        return $file;
    }
}
