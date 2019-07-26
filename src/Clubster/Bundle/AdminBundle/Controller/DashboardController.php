<?php

declare(strict_types=1);

namespace Clubster\Bundle\AdminBundle\Controller;

use Clubster\Component\Core\Model\AdminUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Translation\TranslatorInterface;

class DashboardController extends AbstractController
{
    /**
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(TranslatorInterface $translator)
    {
        $this->denyAccessUnlessGranted(AdminUser::DEFAULT_ROLE);

        return $this->render('@ClubsterAdmin/Dashboard/index.html.twig', [
            'header' => $translator->trans('clubster.ui.dashboard')
        ]);
    }
}
