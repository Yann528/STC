<?php

namespace App\Controller\Admin;

use App\Entity\Productimg;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class ProductimgCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Productimg::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           // CollectionField::new('photos')
           ImageField::new('photos')
            ->setBasePath('uploadsDiapos/')
            ->setUploadDir('public/uploadsDiapos')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            TextField::new('alt'),
            AssociationField::new('product')
        ];
    }
    
}
