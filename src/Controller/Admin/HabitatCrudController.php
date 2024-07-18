<?php

namespace App\Controller\Admin;

use App\Entity\Habitat;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class HabitatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Habitat::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Habitats')
            ->setEntityLabelInSingular('Habitat')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des %entity_label_plural%');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm()
            ->hideOnIndex(),
            TextField::new('name')
                ->setLabel('Nom'),
            TextField::new('description')
                ->setLabel('Détails'),
            TextField::new('imageFile')
                ->setFormType(VichImageType::class)->onlyOnForms(),
            TextField::new('imageName')
                ->onlyOnIndex(),
            IntegerField::new('imageSize')
                ->onlyOnIndex(),
            ];
    }

}
