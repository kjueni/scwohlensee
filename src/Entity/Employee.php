<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\EmployeeType;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 * @ORM\Table(name="employees")
 */
class Employee implements
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
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     * @var string
     */
    protected $telephoneNumber;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string
     */
    protected $address;

    /**
     * @ORM\Column(type="integer", length=4, nullable=true)
     * @var integer
     */
    protected $zipCode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string
     */
    protected $place;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @var string
     */
    protected $pictureUrl;

    /**
     * Many Employees have Many Types.
     * @ORM\ManyToMany(targetEntity="EmployeeType")
     * @ORM\JoinTable(name="employees_employee_types",
     *      joinColumns={@ORM\JoinColumn(name="employee_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="type_id", referencedColumnName="id")}
     *      )
     * @var EmployeeType[]
     */
    protected $types;

    /**
     * @param array $params
     * @return Employee
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
            'first_name',
            'last_name',
            'types',
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf('Required paramter "%s" was not provided', $param)
                );
            }
        }

        $employee = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'first_name':
                    $employee->setFirstName($param);
                    break;
                case  'last_name':
                    $employee->setLastName($param);
                    break;
                case  'telephone_number':
                    $employee->setTelephoneNumber($param);
                    break;
                case  'email':
                    $employee->setEmail($param);
                    break;
                case  'address':
                    $employee->setAddress($param);
                    break;
                case  'zip_code':
                    $employee->setZipCode($param);
                    break;
                case  'place':
                    $employee->setPlace($param);
                    break;
                case 'picture_url':
                    $employee->setPictureUrl($param);
                    break;
                case 'types':
                    $employee->setTypes($param);
                    break;
            }
        }

        return $employee;
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getTelephoneNumber()
    {
        return $this->telephoneNumber;
    }

    /**
     * @param string $telephoneNumber
     */
    public function setTelephoneNumber($telephoneNumber)
    {
        $this->telephoneNumber = $telephoneNumber;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @return string
     */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    /**
     * @param string $pictureUrl
     */
    public function setPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;
    }

    /**
     * @return EmployeeType[]
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param EmployeeType[] $types
     */
    public function setTypes($types)
    {
        $this->types = $types;
    }
}
