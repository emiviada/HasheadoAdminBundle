<?php

namespace Hasheado\AdminBundle\AdminExtension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class GroupAdminExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('roles', 'sonata_security_roles', array(
                'expanded' => false,
                'multiple' => true,
                'required' => false
        ));
    }
}
