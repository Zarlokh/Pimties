<?php

namespace App\Admin\Field;

use App\Utils\FieldUtils;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class ToggleHideOtherFieldsField implements FieldInterface
{
    use FieldTrait;

    final protected const PREFIX_CLASS_NAME_OF_FIELDS_TO_TOGGLE_HIDE = 'toggle-hide-';
    final protected const CLASS_TO_ADD_TO_HIDE_ELEMENT = 'd-none';

    final public const CUSTOM_OPTION_PREFIX_CLASS_NAME_OF_FIELDS_TO_TOGGLE_HIDE = 'prefix_class_name_of_fields_to_toggle_hide';
    final public const CUSTOM_OPTION_CLASS_TO_ADD_TO_HIDE_ELEMENT = 'class_to_add_to_hide_element';
    final public const CUSTOM_OPTION_REQUIRED_FIELDS_IF_SHOWN = 'required_fields_if_shown';

    public static function new(string $propertyName, ?string $label = null): self
    {
        $defaultPrefix = self::PREFIX_CLASS_NAME_OF_FIELDS_TO_TOGGLE_HIDE;
        $defaultHideClass = self::CLASS_TO_ADD_TO_HIDE_ELEMENT;

        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTextAlign(TextAlign::CENTER)
            ->setFormType(CheckboxType::class)
            ->addCssClass('field-boolean toggle-hide-other-fields')
            ->addWebpackEncoreEntries('toggleHideOtherFields')
            ->setCustomOption(self::CUSTOM_OPTION_CLASS_TO_ADD_TO_HIDE_ELEMENT, $defaultHideClass)
            ->setCustomOption(self::CUSTOM_OPTION_PREFIX_CLASS_NAME_OF_FIELDS_TO_TOGGLE_HIDE, $defaultPrefix)
            ->setFormTypeOption('attr', [
                'data-prefix' => $defaultPrefix,
                'data-hide' => $defaultHideClass
            ])
        ;
    }

    public function setCustomOptionClassToAddToHideElement(string $value): self
    {
        $this->setCustomOption(self::CUSTOM_OPTION_CLASS_TO_ADD_TO_HIDE_ELEMENT, $value);
        $this->updateDataAttribute();

        return $this;
    }

    public function setCustomOptionPrefixClassNameOfFieldsToToggleHide(string $value): self
    {
        $this->setCustomOption(self::CUSTOM_OPTION_PREFIX_CLASS_NAME_OF_FIELDS_TO_TOGGLE_HIDE, $value);
        $this->updateDataAttribute();

        return $this;
    }

    private function updateDataAttribute(): void
    {
        $dto = $this->getAsDto();
        FieldUtils::addAttrToField($dto, [
            'data-prefix' => $dto->getCustomOption(self::CUSTOM_OPTION_PREFIX_CLASS_NAME_OF_FIELDS_TO_TOGGLE_HIDE),
            'data-hide' => $dto->getCustomOption(self::CUSTOM_OPTION_CLASS_TO_ADD_TO_HIDE_ELEMENT)
        ]);
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    private function getPrefix(): string
    {
        return $this->getAsDto()->getCustomOption(self::CUSTOM_OPTION_PREFIX_CLASS_NAME_OF_FIELDS_TO_TOGGLE_HIDE);
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    private function getHiddenClass(): string
    {
        return $this->getAsDto()->getCustomOption(self::CUSTOM_OPTION_CLASS_TO_ADD_TO_HIDE_ELEMENT);
    }

    /** @param FieldInterface[] $fields */
    public function addFieldsToToggleHide(array $fields, array $fieldsRequiredIfShown = []): self
    {
        $this->setCustomOption(self::CUSTOM_OPTION_REQUIRED_FIELDS_IF_SHOWN, $fieldsRequiredIfShown);
        $classes = [$this->getPrefix().$this->getAsDto()->getProperty(), $this->getHiddenClass()];

        foreach ($fields as $field) {
            $fieldDto = $field->getAsDto();
            $fieldDto->setCssClass(implode(' ', $classes));

            if (in_array($field, $fieldsRequiredIfShown)) {
                FieldUtils::addAttrToField($fieldDto, [
                    'data-required-field' => true
                ]);
            }
        }

        return $this;
    }
}
