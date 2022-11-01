<?php

namespace App\Controller\Admin;

use App\Admin\Field\FileField;
use App\Admin\Field\ToggleHideOtherFieldsField;
use App\Entity\Warranty;
use App\Utils\Traits\Controller\AddConstraintForToggleHideOtherFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WarrantyCrudController extends AbstractCrudController
{
    use AddConstraintForToggleHideOtherFieldsTrait;

    public static function getEntityFqcn(): string
    {
        return Warranty::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('warranty.add_new_action');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('warranty.create_action');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('warranty.add_new_another_action');
            })
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setDefaultSort([
                'endDate' => 'ASC',
            ])
            ->setPageTitle('new', 'warranty.add_new')
            ->setPageTitle('index', 'warranty.title')
        ;
    }

    public function configureFields(string $pageName): array
    {
        $warrantyTimeField = NumberField::new('extendedWarrantyTime', 'warranty.extended_warranty_time')
            ->setRequired(false)
            ->hideOnIndex()
        ;

        $hasExtendedWarrantyTime = ToggleHideOtherFieldsField::new('hasExtendedWarrantyTime', 'warranty.has_extended_warranty_time')
            ->addFieldsToToggleHide([$warrantyTimeField], [$warrantyTimeField])
            ->onlyOnForms()
        ;

        return [
            TextField::new('name', 'warranty.name'),
            DateField::new('startDate', 'warranty.start_date')->setFormTypeOption('input', 'datetime_immutable'),
            DateField::new('endDate', 'warranty.end_date')->hideOnForm(),
            NumberField::new('calculateWarrantyTime', 'warranty.warranty_time')->onlyOnIndex()->formatValue(fn (int $warrantyTime) => "$warrantyTime an(s)"),
            BooleanField::new('isSecondHandProduct', 'warranty.is_second_hand'),
            FileField::new('file.transientUploadedFile', 'warranty.bill_field')->onlyOnForms(),
            FileField::new('file.storageMetadata', 'warranty.bill_filepath')->onlyOnIndex(),
            $hasExtendedWarrantyTime,
            $warrantyTimeField,
        ];
    }
}
