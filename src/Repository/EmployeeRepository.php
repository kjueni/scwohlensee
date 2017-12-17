<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Employee;

class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @param array $params
     * @return Employee
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $employee = Employee::fromArray($params);

        return $employee;
    }

    /**
     * @param Employee $employee
     * @param array $params
     * @return Employee
     */
    public function hydrate(Employee $employee, $params)
    {
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
}
