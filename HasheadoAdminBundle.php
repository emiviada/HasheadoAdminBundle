<?php

namespace Hasheado\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HasheadoAdminBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}
