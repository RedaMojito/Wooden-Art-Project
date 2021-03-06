<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Service\VichImageFieldService;
use App\Controller\Admin\Field\VichImageField;
use App\Form\AttachementType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class ArticleCrudController extends AbstractCrudController
{   
      /**
     * @var VichImageField
     */
    /* 
    private $vichImageField;

   public function __construct(VichImageField $vichImageField) {
        $this->vichImageField = $vichImageField;
    }
    */
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // set this option if you prefer the page content to span the entire
            // browser width, instead of the default design which sets a max width
           // ->renderContentMaximized()

            // set this option if you prefer the sidebar (which contains the main menu)
            // to be displayed as a narrow column instead of the default expanded design
          //  ->renderSidebarMinimized()
            //->setEntityLabelInSingular('Article')
           // ->setEntityLabelInPlural('Articles')
            // the Symfony Security permission needed to manage the entity
            // (none by default, so you can manage all instances of the entity)
            //->setEntityPermission('ROLE_EDITOR')
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextareaField::new('description'),
            MoneyField::new('price')->setCurrency('MAD'),
            AssociationField::new('user'),
            AssociationField::new('Category'),
            CollectionField::new('attachements')
            ->setFormTypeOption('by_reference', false)
            ->setEntryType(AttachementType::class)
            ->onlyOnForms()
         /*
            
            ImageField::new('imageFile', 'Image')
              //->setBasePath('/images/articles')
                ->setUploadDir('public/images/articles')
                ->onlyOnForms()
                ->setFormType(VichImageType::class)
           $this->vichImageFieldService->setOptions(ImageField::new('imageFile'), Article::class, 'ImageFile')
        */
        ];
    }
/*
    public function configureActions(Actions $actions): Actions
    {  
      //  dd($actions->add(Crud::PAGE_INDEX, Action::DETAIL));
        return $actions
          ->add(Crud::PAGE_INDEX, Action::DETAIL);
       
        
    } 
*/
  
}
