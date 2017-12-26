<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\News;

class NewsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }

    /**
     * @param array $params
     * @return News
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $news = News::fromArray($params);

        return $news;
    }

    /**
     * @param News $news
     * @param array $params
     * @return News
     */
    public function hydrate(News $news, $params)
    {
        foreach ($params as $key => $param) {

            switch ($key) {
                case  'author':
                    $news->setAuthor($param);
                    break;
                case  'title':
                    $news->setTitle($param);
                    break;
                case  'lead':
                    $news->setLead($param);
                    break;
                case  'text':
                    $news->setText($param);
                    break;
                case 'picture_url':
                    $news->setPictureUrl($param);
                    break;
                case 'url':
                    $news->setUrl($param);
                    break;
                case 'types':
                    $news->setTypes($param);
                    break;
            }
        }

        return $news;
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return News[]
     */
    public function findLatestNews(int $limit = null, int $offset = null): array
    {
        return $this->findBy(
            array(),
            array(
                'id' => 'ASC',
            ),
            $limit,
            $offset
        );
    }
}
