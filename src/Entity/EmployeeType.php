<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Employee;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeTypeRepository")
 * @ORM\Table(name="employeeTypes")
 */
class EmployeeType implements
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
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var boolean
     */
    protected $executive;

    /**
     * @ORM\Column(type="integer", length=1000, nullable=true)
     * @var integer
     */
    protected $sortIndex;

    /**
     * @param array $params
     * @return EmployeeType
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
            'name'
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf('Required paramter "%s" was not provided', $param)
                );
            }
        }

        $type = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'name':
                    $type->setName($param);
                    break;

                case 'description':
                    $type->setExecutive($param);
                    break;

                case 'league':
                    $type->setSortIndex($param);
                    break;
            }
        }

        return $type;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return boolean
     */
    public function getExecutive()
    {
        return $this->executive;
    }

    /**
     * @param boolean $executive
     */
    public function setExecutive($executive)
    {
        $this->executive = $executive;
    }

    /**
     * @return integer
     */
    public function getSortIndex()
    {
        return $this->sortIndex;
    }

    /**
     * @param integer $sortIndex
     */
    public function setSortIndex($sortIndex)
    {
        $this->sortIndex = $sortIndex;
    }
}
