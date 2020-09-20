<?php

namespace App\Controller\Admin;

use App\Entity\Produits;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProduitsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produits::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $imageFile = ImageField::new('imageFile', 'Image du produit')->setFormType(VichImageType::class);
        $image = ImageField::new('filename')->setBasePath('/image/produit');

        $fields = [
            TextField::new('nom', 'Nom du produit'),
            ChoiceField::new('cathegorie', 'Cathégorie du produit')->setChoices(Produits::CATHEGORIE),
            TextField::new('action', 'Ce que fait le produit'),
            NumberField::new('prix', 'Le prix du produit'),
            //MoneyField::new('prix', 'Le prix du produit')->setCurrency('EUR'),
            BooleanField::new('statue', 'Publier sur le site'),
            TextEditorField::new('description','Description du produit'),
        ];

        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL){
            $fields[] = $image;
        }else{
            $fields[] = $imageFile;
        }

        return $fields;
    }

}
