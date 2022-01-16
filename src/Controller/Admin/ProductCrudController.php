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
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;


class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->setLabel('Nom'),
            SlugField::new('slug')->setTargetFieldName('name'),

            BooleanField::new('offrepro'),

            ImageField::new('illustration')
            ->setBasePath('uploads/')
            ->setUploadDir('public/uploads')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),

            ImageField::new('plans')
            ->setBasePath('uploadsPlans/')
            ->setUploadDir('public/uploadsPlans')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),

            ImageField::new('dataroom')
            ->setBasePath('uploadsDataroom/')
            ->setUploadDir('public/uploadsDataroom')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),

            //ImageField::new('illustration')->setBasePath('uploads/')->setFormTypeOptions(['mapped'=>false,'required'=>false]),
            TextField::new('subtitle'),
            ChoiceField::new('typeOffre')->setChoices(fn () => ['Location' => 'Location', 'Vente' => 'Vente']),
            TextField::new('etat'),
            TextField::new('dispoDate'),
            TextareaField::new('description'),
            MoneyField::new('prix')->setCurrency('EUR'),
            MoneyField::new('montantTaxeFonciere')->setCurrency('EUR'),
            MoneyField::new('montantCharges')->setCurrency('EUR'),
            MoneyField::new('montantTaxeBureaux')->setCurrency('EUR'),
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
