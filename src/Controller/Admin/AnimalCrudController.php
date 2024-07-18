<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnimalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Animal::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Animaux')
            ->setEntityLabelInSingular('Animal')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des %entity_label_plural%')
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
        IdField::new('id')
            ->hideOnForm()
            ->hideOnIndex(),
        TextField::new('name')
            ->setLabel('Nom'),
        TextField::new('details')
            ->setLabel('Détails'),
        AssociationField::new('habitat')
            ->setLabel('abitat')
            ->setHelp('Choisissez l\'habitat de l\'animal'),
        AssociationField::new('race')
            ->setLabel('race')
            ->setHelp('Choisissez la race de l\'animal'),
        ];
    }
}
