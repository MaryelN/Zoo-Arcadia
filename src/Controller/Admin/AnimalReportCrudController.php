<?php

namespace App\Controller\Admin;

use App\Entity\AnimalReport;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Faker\Provider\ar_EG\Text;

class AnimalReportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AnimalReport::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Reports d\'animaux')
            ->setEntityLabelInSingular('Report d\'animal')
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
            TextField::new('proposed_food')
                ->setLabel('Nourriture proposée'),
            TextField::new('proposed_quantity')
                ->setLabel('Quantité proposée'), 
            TextField::new('health')
                ->setLabel('Etat de santé animal'),   
            TextField::new('details')
                ->setLabel('Commentaires sur l\'habitat'),
            DateTimeField::new('timestamp')
            ->setFormTypeOption('disabled', true)
        ];
    }
    
}
