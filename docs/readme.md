Problemes en autenticar:
SECURI Authenticator does not support the request.
https://github.com/symfony/symfony/issues/44541
canviant la cookie_secure to false.

## Injectar serveis en Twig
- https://symfony.com/doc/current/templating/global_variables.html

## Gestió d'imatges
- https://fakerphp.github.io/
- https://github.com/woodsandwalker/Faker-Picture
- https://github.com/corriol/2022-movies-symfony/blob/main/src/DataFixtures/AppFixtures.php
- https://symfony.com/doc/5.4/configuration.html
- https://github.com/dustin10/VichUploaderBundle/blob/master/docs/usage.md


## Error serialització File
- https://corriol.github.io/desweb/08-symfony/07-seguretat-control-acces/#establir-la-manera-dautenticacio-i-origen-de-dades
- https://symfony.com/doc/5.4/security.html#understanding-how-users-are-refreshed-from-the-session

## Manipulació d'imatges

- https://symfony.com/bundles/LiipImagineBundle/current/installation.html#step-1-download-the-bundle
- https://symfony.com/bundles/LiipImagineBundle/current/basic-usage.html

## Symfony UX

Quant a l'ús de `ux-cropper` es descarta el seu ús ja que implica 
que les imatges estiguen ja al servidor per a manipular-les.

- https://github.com/symfony/ux-twig-component
- https://www.youtube.com/watch?v=0lQUQA4p7ac
- https://symfony.com/doc/current/frontend/ux.html

## Integrant Cropperjs: PrestaImageBundle

npm i cropperjs

https://github.com/prestaconcept/PrestaImageBundle

### Implementació en WebpackEncore

- https://github.com/prestaconcept/PrestaImageBundle/blob/master/Resources/doc/webpack.md

### Errors

TypeError: __webpack_require__.nmd(...) is not a function

```
  .addAliases({
        prestaimage: path.resolve(__dirname, 'public/bundles/prestaimage')
    })
```

this.$modal.modal is not a function

Aquest error es soluciona posant el 2n paràmetre de Cropper a `true`:
```
$(function () {
    $('.cropper').each(function () {
        new Cropper($(this), true);
    });
});
```
## Extenent el repositori

- https://stackoverflow.com/questions/43073982/doctrine-how-to-check-if-a-collection-contains-an-entity


