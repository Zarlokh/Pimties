<?php

namespace App\Utils\Traits\Controller;

use App\Admin\Field\ToggleHideOtherFieldsField;
use App\Validator\RequireToggleHideOtherFields;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use Symfony\Component\Form\FormBuilderInterface;

trait AddConstraintForToggleHideOtherFieldsTrait
{
    /**
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedArrayAssignment
     */
    private function addConstraintsToForm(EntityDto $entityDto, KeyValueStore $formOptions): void
    {
        if (!$entityDto->getFields()) {
            return;
        }
        foreach ($entityDto->getFields() as $field) {
            if (ToggleHideOtherFieldsField::class !== $field->getFieldFqcn()) {
                continue;
            }
            $customOptionsRequiredFields = $field->getCustomOption(ToggleHideOtherFieldsField::CUSTOM_OPTION_REQUIRED_FIELDS_IF_SHOWN);

            if (!$customOptionsRequiredFields || !is_array($customOptionsRequiredFields)) {
                continue;
            }

            $requiredFields = array_map(function (FieldInterface $field) {
                return $field->getAsDto()->getProperty();
            }, $customOptionsRequiredFields);

            $constraints = $formOptions->get('constraints', []);
            $constraints[] = new RequireToggleHideOtherFields([
                RequireToggleHideOtherFields::OPTION_TOGGLE_FIELD => $field->getProperty(),
                RequireToggleHideOtherFields::OPTION_REQUIRED_FIELDS => $requiredFields,
            ]);
            $formOptions->set('constraints', $constraints);
        }
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $this->addConstraintsToForm($entityDto, $formOptions);

        return parent::createEditFormBuilder($entityDto, $formOptions, $context);
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $this->addConstraintsToForm($entityDto, $formOptions);

        return parent::createNewFormBuilder($entityDto, $formOptions, $context);
    }
}
