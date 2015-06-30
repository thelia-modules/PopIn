<?php

namespace PopIn\Controller;

use PopIn\Controller\Base\PopInCampaignController as BasePopInCampaignController;
use PopIn\Event\PopInCampaignEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Tools\URL;

/**
 * Pop-in campaigns controller.
 */
class PopInCampaignController extends BasePopInCampaignController
{
    protected function getDeleteEvent()
    {
        $event = new PopInCampaignEvent();

        $event->setId($this->getRequest()->query->get("pop_in_campaign_id"));

        return $event;
    }

    protected function renderListTemplate($currentOrder)
    {
        return $this->render("pop-in-config");
    }

    protected function renderEditionTemplate()
    {
        return $this->render("pop-in-config");
    }

    protected function redirectToEditionTemplate()
    {
        return new RedirectResponse(
            URL::getInstance()->absoluteUrl("/admin/module/PopIn")
        );
    }

    protected function redirectToListTemplate()
    {
        return new RedirectResponse(
            URL::getInstance()->absoluteUrl("/admin/module/PopIn")
        );
    }
}
