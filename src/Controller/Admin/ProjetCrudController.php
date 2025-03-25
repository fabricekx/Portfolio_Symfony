<?php

namespace App\Controller\Admin;

use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProjetCrudController extends AbstractCrudController
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public static function getEntityFqcn(): string
    {
        return Projet::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Récupération des images disponibles dans public/uploads/images
        $finder = new Finder();
        $images = [];
        $imageDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/images';

        if (is_dir($imageDirectory)) {
            foreach ($finder->files()->in($imageDirectory) as $file) {
                $images[$file->getFilename()] = $file->getFilename();
            }
        }

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextEditorField::new('description', 'Description'),

            // Affichage de l'image actuelle
            ImageField::new('image', 'Image actuelle')
                ->setBasePath('/uploads/images')
                ->onlyOnIndex(),

            // Sélection d'une image existante
            ChoiceField::new('existingImage', 'Choisir une image existante')
                ->setChoices($images)
                ->setRequired(false)
                ->onlyOnForms()
                ->setFormTypeOptions(['mapped' => false]), // Éviter de chercher dans l'entité

            // Upload d'une nouvelle image
            ImageField::new('newImage', 'Télécharger une nouvelle image')
                ->setBasePath('/uploads/images')
                ->setUploadDir('public/uploads/images')
                ->setRequired(false)
                ->onlyOnForms()
                ->setFormTypeOptions(['mapped' => false]), // Éviter de chercher dans l'entité
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Projet) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            parent::updateEntity($entityManager, $entityInstance);
            return;
        }

        // Récupération des valeurs du formulaire
        $existingImage = $request->request->all('Projet')['existingImage'] ?? null;
        $newImageFile = $request->files->get('newImage') ?? null;
        
        if ($newImageFile instanceof UploadedFile) {
            $imageName = uniqid() . '.' . $newImageFile->guessExtension();
            $newImageFile->move($this->getParameter('kernel.project_dir') . '/public/uploads/images', $imageName);
            $entityInstance->setImage($imageName);
        } elseif ($existingImage) {
            $entityInstance->setImage($existingImage);
        }

        $entityManager->persist($entityInstance);
        $entityManager->flush();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
