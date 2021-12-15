<?php

namespace App\Controller\Admin;

use App\Entity\LoggerOrder;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class LoggerOrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LoggerOrder::class;
    }

    public function configureFields(string $pageName): iterable
    {

      $id =   IdField::new('id');
       $description =  TextEditorField::new('description');
        $createdAt = DateTimeField::new('createdAt');
        $orderToLog =   AssociationField::new('orderToLog');
        $state =   AssociationField::new('state');
       
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $description,$createdAt->setFormat('short', 'short'), $orderToLog, $state];
        }
        return [
            FormField::addPanel('Basic Information'),
            $id, $description, $orderToLog, $state
        ];
    }
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userRoles = $this->getUser()->getRoles();
        $qb = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if(!in_array('ROLE_ADMIN', $userRoles)){
            $qb->andWhere('entity.user = :user');
            $qb->setParameter('user', $this->getUser());

        }
       
        return $qb;
    }
    public function configureActions(Actions $actions): Actions
    {
        $viewInvoice = Action::new('invoice', 'View invoice', 'fa fa-file-invoice')
        ->linkToCrudAction('renderInvoice');

        return $actions
            // ...
            ->add(Crud::PAGE_NEW, $viewInvoice)
            // use the 'setPermission()' method to set the permission of actions
            // (the same permission is granted to the action on all pages)
           // ->setPermission('invoice', 'ROLE_FINANCE')

            // you can set permissions for built-in actions in the same way
            ->setPermission(Action::NEW, 'ROLE_ADMIN');
    }
}
