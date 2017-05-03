<?php

/*
 * This file is part of the "GlavwebCmsCoreBundle" package.
 *
 * (c) GLAVWEB <info@glavweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glavweb\CmsCoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class GlavwebCmsCoreBundle
 *
 * @package Glavweb\CmsCoreBundle
 * @author Andrey Nilov <nilov@glavweb.ru>
 */
class GlavwebCmsCoreBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataAdminBundle';
    }
}
