<?php

namespace App\Controller\Admin;

use App\Entity\Race;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Race::class;
    }

    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Races')
            ->setEntityLabelInSingular('Race')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des %entity_label_plural%')
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),
            TextField::new('label')
                ->setLabel('Nom de la race'),
            TextEditorField::new('description')
                ->setLabel('Description')
                ->setHelp('Donnez un description'),
        ];
    }

}
