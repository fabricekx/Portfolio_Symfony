<?php
namespace App\Form;
// formulaire pour le crud admin projet
use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Finder\Finder;

class ProjetImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Récupérer les images existantes dans le répertoire public/build/images
        $finder = new Finder();
        $images = [];
        foreach ($finder->files()->in('public/build/images') as $file) {
            $images[$file->getFilename()] = $file->getFilename();
        }

        // Ajouter le champ pour choisir une image existante
        $builder
            ->add('existingImage', ChoiceType::class, [
                'choices' => $images,
                'required' => false,
                'placeholder' => 'Choisissez une image existante',
            ])
            ->add('newImage', FileType::class, [
                'label' => 'Télécharger une nouvelle image',
                'required' => false,
                'mapped' => false, // Cette donnée n'est pas liée à une propriété de l'entité
                'data_class' => null,
            ])
            // Ajout d'un champ caché pour la gestion de l'image actuelle si aucun changement
            ->add('image', HiddenType::class, [
                'mapped' => false,
            ]);

        // Ajouter un événement pour traiter le formulaire avant soumission
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            // Si une nouvelle image est téléchargée, on remplace l'image existante
            if ($data['newImage']) {
                $form->get('image')->setData($data['newImage']);
            } elseif ($data['existingImage']) {
                // Sinon, utiliser l'image existante
                $form->get('image')->setData($data['existingImage']);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
