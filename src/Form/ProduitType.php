<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('prix')
            ->add('quantiteenstock')
            ->add('idcategorie')
            ->add('image', FileType::class, [
                'label' => 'Image (JPEG, PNG, GIF)',
                'required' => false,  // Permettre que le champ soit vide
                'mapped' => false,   // Ne pas mapper directement ce champ à la propriété 'image' de l'entité
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
