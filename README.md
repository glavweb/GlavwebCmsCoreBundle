Installation
============

### Get the bundle using composer

Add GlavwebCmsCoreBundle by running this command from the terminal at the root of
your Symfony project:

```bash
php composer.phar require glavweb/cms-core-bundle
```


### Enable the bundle

To start using the bundle, register the bundle in your application's kernel class:

```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Glavweb\CmsCoreBundle\GlavwebCmsCoreBundle(),
        // ...
    );
}
```
