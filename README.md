DoctrineTwigBundle
==================

[![Build Status](https://travis-ci.org/antalaron/doctrine-twig-bundle.svg?branch=master)](https://travis-ci.org/antalaron/doctrine-twig-bundle)
[![Latest Stable Version](https://poser.pugx.org/antalaron/doctrine-twig-bundle/v/stable)](https://packagist.org/packages/antalaron/doctrine-twig-bundle)
[![Latest Unstable Version](https://poser.pugx.org/antalaron/doctrine-twig-bundle/v/unstable)](https://packagist.org/packages/antalaron/doctrine-twig-bundle)

[Doctrine](http://www.doctrine-project.org/) [Twig](http://twig.sensiolabs.org/)
loader bundle for [Symfony](https://symfony.com/). This bundle allows you to store
templates in database.

Installation
------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require antalaron/doctrine-twig-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...

            new Antalaron\DoctrineTwigBundle\AntalaronDoctrineTwigBundle(),
        ];

        // ...
    }

    // ...
}
```
