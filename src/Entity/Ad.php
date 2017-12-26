<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\AdType;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdRepository")
 * @ORM\Table(name="ads")
 */
class Ad implements
    EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     * @var string
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @var string
     */
    protected $pictureUrl;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string
     */
    protected $url;

    /**
     * Many Ads have Many Types.
     * @ORM\ManyToMany(targetEntity="AdType")
     * @ORM\JoinTable(name="ads_ad_types",
     *      joinColumns={@ORM\JoinColumn(name="ad_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="type_id", referencedColumnName="id")}
     *      )
     * @var AdType[]
     */
    protected $types;

    /**
     * Many Ads have Many Teams.
     * @ORM\ManyToMany(targetEntity="Team")
     * @ORM\JoinTable(name="teams_ads",
     *      joinColumns={@ORM\JoinColumn(name="ad_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")}
     *      )
     * @var Team[]
     */
    protected $teams;

    /**
     * @param array $params
     * @return Ad
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf('Required paramter "%s" was not provided', $param)
                );
            }
        }

        $ad = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'description':
                    $ad->setDescription($param);
                    break;
                case  'address':
                    $ad->setAddress($param);
                    break;
                case 'picture_url':
                    $ad->setPictureUrl($param);
                    break;
                case 'url':
                    $ad->setUrl($param);
                    break;
                case 'types':
                    $ad->setTypes($param);
                    break;
                case 'teams':
                    $ad->setTeams($param);
                    break;
            }
        }

        return $ad;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(string $description = null)
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(string $address = null)
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    /**
     * @param string|null $pictureUrl
     */
    public function setPictureUrl(string $pictureUrl = null)
    {
        $this->pictureUrl = $pictureUrl;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(string $url = null)
    {
        $this->url = $url;
    }

    /**
     * @return AdType[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param AdType[] $types
     */
    public function setTypes(array $types)
    {
        $this->types = $types;
    }

    /**
     * @return Team[]
     */
    public function getTeams(): array
    {
        return $this->teams;
    }

    /**
     * @param Team[] $teams
     */
    public function setTeams(array $teams)
    {
        $this->teams = $teams;
    }
}
