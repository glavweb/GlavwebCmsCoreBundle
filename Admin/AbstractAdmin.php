<?php

/*
 * This file is part of the "GlavwebCmsCoreBundle" package.
 *
 * (c) GLAVWEB <info@glavweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glavweb\CmsCoreBundle\Admin;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Sonata\AdminBundle\Admin\AbstractAdmin as BaseAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraints\Image;

/**
 * Class AbstractAdmin
 *
 * @package Glavweb\CmsCoreBundle\Admin
 * @author Andrey Nilov <nilov@glavweb.ru>
 */
class AbstractAdmin extends BaseAdmin
{
    /**
     * The number of result to display in the list.
     *
     * @var int
     */
    protected $maxPerPage = 20;

    /**
     * Predefined per page options.
     *
     * @var array
     */
    protected $perPageOptions = [20, 40, 60, 120, 180];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->formOptions['translation_domain'] = $this->getTranslationDomain();
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->remove('export');

        if ($this instanceof HasSortable) {
            $collection->add('move', $this->getRouterIdParameter() . '/move/{position}');
        }
    }

    /**
     * @param mixed $entity
     */
    public function prePersist($entity)
    {
        $this->updateEntity($entity);
    }

    /**
     * @param mixed $entity
     */
    public function preUpdate($entity)
    {
        $this->updateEntity($entity);
    }

    /**
     * @param mixed $entity
     */
    protected function updateEntity($entity)
    {}

    /**
     * Example: getHelpForImage($task, 'imageFile')
     *
     * @param object $entity
     * @param string $fieldName
     * @return string
     */
    protected function getHelpForImage($entity, $fieldName)
    {
        $container        = $this->getConfigurationPool()->getContainer();
        $annotationReader = $container->get('annotation_reader');

        $reflectionClass = new \ReflectionClass(get_class($entity));
        $annotation = $annotationReader->getPropertyAnnotation($reflectionClass->getProperty($fieldName), Image::class);
        $imageHelp = sprintf('Допустимый размер %s*%s', $annotation->minWidth, $annotation->minHeight);

        return $imageHelp;
    }

    /**
     * Example: getPreviewForFile($task, 'image', 'imageFile')
     *
     * @param object $entity
     * @param string $propertyName
     * @param string $fieldName
     * @param bool $isImage
     * @return string
     */
    protected function getPreviewForFile($entity, $propertyName, $fieldName, $isImage = true)
    {
        $container      = $this->getConfigurationPool()->getContainer();
        $uploaderHelper = $container->get('vich_uploader.templating.helper.uploader_helper');

        $getterProperty = 'get' . $propertyName;
        $isValidEntity = method_exists($entity, 'id') || method_exists($entity, $getterProperty);
        if (!$isValidEntity) {
            throw new \RuntimeException(sprintf('Object %s not provided file upload methods.', get_class($entity)));
        }

        $filePreview = 'Не загружено';
        if ($entity && $entity->getId() && $entity->$getterProperty()) {
            $filePath = $uploaderHelper->asset($entity, $fieldName);

            if ($isImage) {
                $filePreview = '<img src="' . $filePath . '" style="max-width:150px;">';

            } else {
                $filePreview = '<a href="' . $filePath . '" target="_blank">Скачать файл</a>';
            }
        }

        return $filePreview;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->getConfigurationPool()->getContainer();
    }

    /**
     * @return Registry
     */
    public function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }
}
