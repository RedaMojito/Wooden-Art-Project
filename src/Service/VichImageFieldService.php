<?php
namespace App\Service;

use App\Service\vo\VichImageFieldOptions;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;
use function Symfony\Component\String\s;

class VichImageFieldService {
    
    /**
     * @var PropertyMappingFactory
     */
    private $propertyMappingFactory;
    
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * VichImageFieldService constructor.
     *
     * @param PropertyMappingFactory $propertyMappingFactory
     * @param KernelInterface $kernel
     */
    public function __construct(PropertyMappingFactory $propertyMappingFactory, KernelInterface $kernel) {
        $this->propertyMappingFactory = $propertyMappingFactory;
        $this->kernel = $kernel;
    }

    public function getUploadDir($class, $field) {
        $pm = $this->propertyMappingFactory->fromField(new $class, $field);
        $uploadDestination = $pm->getUploadDestination();
        $projectDir = $this->kernel->getProjectDir();
        return s($uploadDestination)->after($projectDir)->toString();
    }
    
    public function getNamer($class, $field) {
        return function(UploadedFile $file) use ($class, $field) {
            $instance = new $class;
            $pm = $this->propertyMappingFactory->fromField($instance, $field);
            $pa = PropertyAccess::createPropertyAccessor();
            $pa->setValue($instance, $field, $file);
            return $pm->getNamer()->name($instance, $pm);
        };
    }
    
    public function setOptions(ImageField $imageField, $class, $field):ImageField {
        return $imageField->setUploadDir($this->getUploadDir($class, $field))->setUploadedFileNamePattern($this->getNamer($class, $field));
    }

}