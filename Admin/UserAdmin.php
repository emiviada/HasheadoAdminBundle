<?php

namespace Hasheado\AdminBundle\Admin;

use Sonata\UserBundle\Admin\Model\UserAdmin as SonataUserAdmin;

class UserAdmin extends SonataUserAdmin
{
    protected $baseRouteName = 'admin_sonata_user_user';

    protected $baseRoutePattern = 'user';
}
