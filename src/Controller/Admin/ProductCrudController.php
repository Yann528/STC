<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            ImageField::new('illustration')
            ->setBasePath('uploads/')
            ->setUploadDir('public/uploads')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            //ImageField::new('illustration')->setBasePath('uploads/')->setFormTypeOptions(['mapped'=>false,'required'=>false]),
            TextField::new('subtitle'),
            TextareaField::new('description'),
            MoneyField::new('prix')->setCurrency('EUR'),
            TextField::new('localisation'),
            NumberField::new('codePostal'),
            NumberField::new('surface'),
            MoneyField::new('loyer')->setCurrency('EUR'),
            BooleanField::new('dispo'),
            //BooleanField::new('isBest'),
            AssociationField::new('category')
            //AssociationField::new('categoty')
        ];
    }

}
