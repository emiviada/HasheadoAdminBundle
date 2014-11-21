<?php

namespace Hasheado\AdminBundle\AdminExtension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdminExtension extends AdminExtension
{
    /**
     * {@inheritdoc}
     */
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('groups', 'sonata_type_model', array(
                    'required' => false,
                    'expanded' => false,
                    'multiple' => true,
                    'btn_add' => false
            ))
            ->add('dateOfBirth', 'sonata_type_date_picker', array('required' => false));

        $formMapper
            ->add('realRoles', 'sonata_security_roles', array(
                'label'    => 'form.label_roles',
                'expanded' => false,
                'multiple' => true,
                'required' => false
            ));
    }
}
