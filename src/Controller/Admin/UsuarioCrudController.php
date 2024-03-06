<?php

namespace App\Controller\Admin;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsuarioCrudController extends AbstractCrudController
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return Usuario::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityInstance);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            TextField::new('nombre'),
            TextField::new('password')
            ->setFormType(PasswordType::class)
            ->onlyOnForms(),
            ArrayField::new('roles'), //COMO PONER LOS ROLES????
        ];
    }

    private function encodePassword(Usuario $usuario): void {
        $plainPassword = $usuario->getPassword();

        if($plainPassword !== null) {
            $hashedPassword = $this->passwordHasher->hashPassword($usuario, $plainPassword);
            $usuario->setPassword($hashedPassword);
        }
    }
}
