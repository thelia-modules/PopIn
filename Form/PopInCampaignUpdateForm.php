<?php

namespace PopIn\Form;

use PopIn\Form\Type\PopInCampaignIdType;

/**
 * Pop-in campaign update form.
 */
class PopInCampaignUpdateForm extends PopInCampaignCreateForm
{
    const FORM_NAME = "pop_in_campaign_update";

    public function buildForm()
    {
        parent::buildForm();

        $this->formBuilder
            ->add("id", PopInCampaignIdType::class)
        ;
    }
}
