<?php

namespace App\Controller\Admin;

use App\Entity\FoodReport;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FoodReportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FoodReport::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Reports de nourriture')
            ->setEntityLabelInSingular('Report de nourriture')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des %entity_label_plural%');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),
            AssociationField::new('user_id')
                ->setLabel('Nom de l\'utilisateur'),
            AssociationField::new('animal_id')
                ->setLabel('Nom de l\'animal'),
            TextField::new('food_quantity')
                ->setLabel('Quantité de nourriture'),
            TextField::new('details')
                ->setLabel('Détails de la nourriture'),
            DateTimeField::new('date_time')
                ->setLabel('Date et heure')    
        ];
    }
    
}
