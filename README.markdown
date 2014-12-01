Bundle Installation
===================

Step 1: Download the Bundle
---------------------------

NOTE: This bundle depends in the [SonataAdminBundle](http://sonata-project.org/bundles/admin/2-3/doc/index.html), [SonataUserBundle](http://sonata-project.org/bundles/user/master/doc/reference/installation.html) and in the [SonataDoctrineORMAdminBundle](http://sonata-project.org/bundles/doctrine-orm-admin/master/doc/reference/installation.html).

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require hasheado/admin-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Before to enable the bundles we have to configure the [SonataBlockBundle](http://sonata-project.org/bundles/block/master/doc/reference/installation.html#configuration).

Then, enable the bundle by adding the following line in the `app/AppKernel.php`
file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            // Add dependencies
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),

            // Then add SonataAdminBundle
            new Sonata\AdminBundle\SonataAdminBundle(),
            // And HasheadoAdminBundle
            new Hasheado\AdminBundle\HasheadoAdminBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Configuration
---------------------

If you followed the installation instructions, HasheadoAdminBundle should be installed but inaccessible. You first need to configure it for your models before you can start using it.

Import the HasheadoAdminBundle’s config files:

```yml
# app/config/config.yml
imports:
 - { resource: @HasheadoAdminBundle/Resources/config/config.yml }
 ```yml

Then you need to add the below security configuration:

```yml
security:
    role_hierarchy:
        ROLE_ADMIN:       [ROLE_USER, ROLE_SONATA_ADMIN]
        ROLE_SUPER_ADMIN: [ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
        SONATA:
            - ROLE_SONATA_PAGE_ADMIN_PAGE_EDIT  # if you are using acl then this line must be commented

    providers:
        fos_userbundle:
            id: fos_user.user_manager

    encoders:
        FOS\UserBundle\Model\UserInterface: sha512

    firewalls:
        # Disabling the security for the web debug toolbar, the profiler and Assetic.
        dev:
            pattern:  ^/(_(profiler|wdt)|css|images|js)/
            security: false

        # -> custom firewall for the admin area of the URL
        admin:
            pattern:            /admin(.*)
            context:            user
            form_login:
                provider:       fos_userbundle
                login_path:     /admin/login
                use_forward:    false
                check_path:     /admin/login_check
                failure_path:   null
            logout:
                path:           /admin/logout
                target:         /admin
            anonymous:          true

        # -> end custom configuration

    access_control:
        # Admin login page needs to be access without credential
        - { path: ^/admin/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/admin/logout$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/admin/login_check$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        # Secured part of the site
        # This config requires being logged for the whole site and having the admin role for the admin part.
        # Change these rules to adapt them to your needs
        - { path: ^/admin/, role: [ROLE_ADMIN, ROLE_SONATA_ADMIN] }
        - { path: ^/.*, role: IS_AUTHENTICATED_ANONYMOUSLY }
```

Then replace the following lines in the @HasheadoAdminBundle/Resources/config/config.yml file:
- Replace:
```yml
fos_user:
    user_class:     Sonata\UserBundle\Entity\BaseUser
    group:
        group_class:   Sonata\UserBundle\Entity\Group

doctrine:
    orm:
        entity_managers:
            default:
                mappings:
                    #ApplicationSonataUserBundle: ~
```

with:
```yml
fos_user:
    user_class:     Application\Sonata\UserBundle\Entity\User
    group:
        group_class:   Application\Sonata\UserBundle\Entity\Group

doctrine:
    orm:
        entity_managers:
            default:
                mappings:
                    ApplicationSonataUserBundle: ~
```

At this point, the bundle is functional, but not quite ready yet. You need to generate the correct entities for the media:

```bash
php app/console sonata:easy-extends:generate SonataUserBundle -d src
```

Now, add the new Application Bundle into the kernel:

```php
return array(
    // Application Bundles
    // ...
    new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),
    // ...

)
```

You need to update the schema:
```bash
php app/console doctrine:schema:update --force
```

Also you need to install the ACL tables:
```bash
php app/console init:acl
```

and create a new root user:
```bash
php app/console fos:user:create --super-admin
```

To be able to access HasheadoAdminBundle’s pages, you need to add its routes to your application’s routing file:

```yml
# app/config/routing.yml
admin:
    resource: '@HasheadoAdminBundle/Resources/config/routing.yml'

```

At this point you can already access the (empty) admin dashboard by visiting the url: http://yoursite.local/admin/dashboard.