<?php

namespace PopIn\Form;

use PopIn\Form\Base\PopInCampaignCreateForm as BasePopInCampaignCreateForm;
use PopIn\PopIn;

/**
 * Pop-in campaign creation form.
 */
class PopInCampaignCreateForm extends BasePopInCampaignCreateForm
{
    const PHP_DATETIME_FORMAT = "Y-m-d H:i:s";
    const PHP_INTLDATE_FORMAT = "yyyy-MM-dd HH:mm:ss";
    const MOMENT_JS_DATE_FORMAT = "YYYY-MM-DD HH:mm:ss";

    public function getTranslationKeys()
    {
        return array(
            "start" => "Start",
            "end" => "End",
            "content_source_type" => "Content source type",
            "content_source_data" => "Content source data",
        );
    }

    protected function addDateField($fieldName, array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add(
            $fieldName,
            "datetime",
            [
                "label" => $this->translator->trans(
                    $this->readKey($fieldName, $translationKeys),
                    [],
                    PopIn::MESSAGE_DOMAIN
                ),
                "label_attr" => [
                    "for" => $this->readKey($fieldName, $fieldsIdKeys),
                    "php_datetime_format" => static::PHP_DATETIME_FORMAT,
                    "moment_js_date_format" => static::MOMENT_JS_DATE_FORMAT,
                ],
                "required" => false,
                "widget" => "single_text",
                "format" => static::PHP_INTLDATE_FORMAT,
            ]
        );
    }

    protected function addStartField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->addDateField("start", $translationKeys, $fieldsIdKeys);
    }

    protected function addEndField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->addDateField("end", $translationKeys, $fieldsIdKeys);
    }

    protected function addContentSourceTypeField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add(
            "content_source_type",
            "choice",
            [
                "label" => $this->translator->trans(
                    $this->readKey("content_source_type", $translationKeys),
                    [],
                    PopIn::MESSAGE_DOMAIN
                ),
                "label_attr" => [
                    "for" => $this->readKey("content_source_type", $fieldsIdKeys)
                ],
                "required" => false,
                "choices" => [
                    "content" => $this->translator->trans("Content"),
                    "content-image" => $this->translator->trans("Image"),
                    // do not use the core "Template" translation, as it refers to product template
                    "template" => $this->translator->trans("Template", [], PopIn::MESSAGE_DOMAIN),
                    "hook" => $this->translator->trans("Hook"),
                ],
            ]
        );
    }
}
