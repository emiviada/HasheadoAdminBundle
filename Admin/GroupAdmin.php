<?php

namespace Hasheado\AdminBundle\Admin;

use Sonata\UserBundle\Admin\Model\GroupAdmin as SonataGroupAdmin;

class GroupAdmin extends SonataGroupAdmin
{
    protected $baseRouteName = 'admin_sonata_user_group';

    protected $baseRoutePattern = 'group';
}
