<?php

/*
 * This file is part of the "GlavwebCmsCoreBundle" package.
 *
 * (c) GLAVWEB <info@glavweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glavweb\CmsCoreBundle\Controller;

use Pix\SortableBehaviorBundle\Controller\SortableAdminController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CRUDController
 *
 * @package Glavweb\CmsCoreBundle\Controller
 * @author Andrey Nilov <nilov@glavweb.ru>
 */
class CRUDController extends SortableAdminController
{
    /**
     * To keep backwards compatibility with older Sonata Admin code.
     *
     * @internal
     */
    private function resolveRequest(Request $request = null)
    {
        if (null === $request) {
            return $this->getRequest();
        }

        return $request;
    }

    /**
     * Returns the base template name.
     *
     * @param Request $request
     *
     * @return string The template name
     */
    protected function getBaseTemplate(Request $request = null)
    {
        $request = $this->resolveRequest($request);

        if ($request->get('_pjax')) {
            return 'GlavwebCmsCoreBundle::sonata_admin_pajax_layout.html.twig';
        }

        if ($this->isXmlHttpRequest($request)) {
            return $this->admin->getTemplate('ajax');
        }

        return $this->admin->getTemplate('layout');
    }
}
