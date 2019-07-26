<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Controller;

use Cloudtec\Bundle\CoreBundle\Events\UserEvents;
use Cloudtec\Bundle\CoreBundle\Form\Type\UserResetType;
use Clubster\Component\Core\Model\AdminUser;
use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\UserBundle\Controller\UserController as BaseUserController;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends BaseUserController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function resetUser(Request $request, AdminUser $user): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        if (!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedException('You have to be registered user to access this section.');
        }

        $formType = UserResetType::class;
        $form = $this->createResourceForm($configuration, $formType, $user);

        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'],
                true) && $form->handleRequest($request)->isValid()) {

            return $this->handleResetUser($request, $configuration, $user);
        }

        if (!$configuration->isHtmlRequest()) {
            return $this->viewHandler->handle($configuration, View::create($form, Response::HTTP_BAD_REQUEST));
        }

        return $this->container->get('templating')->renderResponse(
            '@CloudtecAdmin/Account/userReset.html.twig', [
                'form' => $form->createView(),
                'resource' => $user,
            ]
        );
    }

    /**
     * @param Request $request
     * @param RequestConfiguration $configuration
     * @param UserInterface $user
     * @return Response|RedirectResponse
     */
    protected function handleResetUser(
        Request $request,
        RequestConfiguration $configuration,
        UserInterface $user
    ) {
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch(UserEvents::PRE_RESET_USER, new GenericEvent($user));

        $this->manager->flush();
        $this->addTranslatedFlash('success', 'cloudtec.admin_user.reset');

        $formData = $request->get('userReset');

        $resetPassword = false;

        if (array_key_exists('resetPassword', $formData) !== false) {
            $resetPassword = $formData['resetPassword'];
        }

        $dispatcher->dispatch(UserEvents::POST_RESET_USER, new GenericEvent($user, [
            'reset_password' => (bool)$resetPassword,
        ]));

        if (!$configuration->isHtmlRequest()) {
            return $this->viewHandler->handle($configuration, View::create(null, Response::HTTP_NO_CONTENT));
        }

        return new RedirectResponse($this->container->get('router')->generate('sylius_admin_admin_user_index'));
    }
}
