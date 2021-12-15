<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    
    private $stateRepository;

    public function __construct(StateRepository $stateRepository){
        $this->stateRepository = $stateRepository;
    }
    
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Order')
            ->setEntityLabelInPlural('Orders')
            ->setSearchFields(['id', 'total', 'discount']);
    }

    
    public function configureFields(string $pageName): iterable
    {

      $id =   IdField::new('id');
       $total =  NumberField::new('total');
        $discount = NumberField::new('discount');
        $state =   AssociationField::new('state');
        $items = NumberField::new('items');
        $shippingDetails = TextEditorField::new('shippingDetails');
        if(Crud::PAGE_NEW === $pageName) {
            $state =   AssociationField::new('state')->hideOnForm();
        }
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $total, $discount, $items, $state];
        }
        return [
            FormField::addPanel('Basic Information'),
             $total, $discount,$items,$shippingDetails, $state
        ];
    }
    

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

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        $state= $this->stateRepository->findOneBy(['content'=>'ORDER_RECEIVED']);
        $entityInstance->setState($state);
        $entityInstance->setUser($this->getUser());
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

}
