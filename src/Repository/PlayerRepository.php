<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Player;

class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Player::class);
    }

    /**
     * @param array $params
     * @return Player
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $player = Player::fromArray($params);

        return $player;
    }

    /**
     * @param Player $player
     * @param array $params
     * @return Player
     */
    public function hydrate(Player $player, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case 'name':
                    $player->setName($param);
                    break;
                case 'number':
                    $player->setNumber($param);
                    break;
                case 'birth_date':
                    $player->setBirthDate($param);
                    break;
                case 'picture_url':
                    $player->setPictureUrl($param);
                    break;
                case 'position':
                    $player->setPosition($param);
                    break;
            }
        }

        return $player;
    }
}
