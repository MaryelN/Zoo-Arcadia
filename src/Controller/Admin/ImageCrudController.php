<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Images')
            ->setEntityLabelInSingular('Image')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des %entity_label_plural%')
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        $mappingParams = $this->getParameter('vich_uploader.mappings'); 

        $animalsImagePath = $mappingParams['images']['uri_prefix'];
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),
            AssociationField::new('animal')
                ->setLabel('Nom de l\'animal')
                ->setCrudController(AnimalCrudController::class)
                ->setHelp('Choisissez l\'animal auquel cette image est associée'),
            TextareaField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('imageName')
                ->setBasePath($animalsImagePath)
                ->setUploadDir('public/uploads/animals')
                ->hideOnForm(),
            IntegerField::new('imageSize')
                ->hideOnForm()
                ->hideOnIndex()
                ->setRequired(false),
            DateTimeField::new('updatedAt')
                ->hideOnForm()
                ->hideOnIndex(), 
            DateTimeField::new('createdAt')
                ->hideOnForm()
                ->hideOnIndex(),             
        ];
    }
    
}
