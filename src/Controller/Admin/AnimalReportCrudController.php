<?php

namespace App\Controller\Admin;

use App\Entity\AnimalReport;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundleSecurity;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class AnimalReportCrudController extends AbstractCrudController
{
    private SecurityBundleSecurity $security;

    public function __construct(SecurityBundleSecurity $security)
    {
        $this->security = $security;
    }

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
                ->setLabel('Nom de l\'utilisateur')
                ->setFormTypeOption('disabled', true)
                ->hideOnIndex()
                ->hideWhenUpdating(),
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
                ->setLabel('Date de création')
                ->setFormTypeOption('disabled', true)
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $animalReport = new AnimalReport();

        /** @var User $user */
        $user = $this->security->getUser();
        $animalReport->setUserId($user);

        return $animalReport;
    }
    
}
