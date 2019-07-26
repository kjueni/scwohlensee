<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\ResourceBundle\Controller\AuthorizationCheckerInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Component\Resource\Metadata\MetadataInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker as BaseAuthorizationChecker;

class AuthorizationChecker implements AuthorizationCheckerInterface
{
    /**
     * @var BaseAuthorizationChecker
     */
    protected $baseAuthorizationChecker;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @param BaseAuthorizationChecker $baseAuthorizationChecker
     * @param EntityManagerInterface $entityManager
     * @param RequestStack $requestStack
     */
    public function __construct(
        BaseAuthorizationChecker $baseAuthorizationChecker,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ) {
        $this->baseAuthorizationChecker = $baseAuthorizationChecker;
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    /**
     * @param RequestConfiguration $configuration
     * @param string $permission
     * @return bool
     */
    public function isGranted(RequestConfiguration $configuration, string $permission): bool
    {
        $resource = $this->getResourceFromMetadata($configuration->getMetadata());

        return $this->baseAuthorizationChecker->isGranted([$permission], $resource);
    }

    /**
     * @param MetadataInterface $metaData
     * @return ResourceInterface|null
     */
    protected function getResourceFromMetadata(MetadataInterface $metaData): ?ResourceInterface
    {
        $resourceId = $this->requestStack->getMasterRequest()->get('id');

        if ($resourceId) {
            $repository = $this->entityManager->getRepository($metaData->getClass('model'));

            /** @var ResourceInterface|null $resource */
            $resource = $repository->find($resourceId);

            return $resource;
        }

        return null;
    }
}
