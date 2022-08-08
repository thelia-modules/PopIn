<?php

namespace PopIn\Controller;

use PopIn\Event\PopInCampaignEvent;
use PopIn\Event\PopInCampaignEvents;
use PopIn\Model\PopInCampaign;
use PopIn\Model\PopInCampaignQuery;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Thelia\Controller\Admin\AbstractCrudController;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Template\ParserContext;
use Thelia\Tools\URL;

/**
 * Pop-in campaigns controller.
 */
class PopInCampaignController extends AbstractCrudController
{
    public function __construct()
    {
        parent::__construct(
            "pop_in_campaign",
            "id",
            "order",
            AdminResources::MODULE,
            PopInCampaignEvents::CREATE,
            PopInCampaignEvents::UPDATE,
            PopInCampaignEvents::DELETE,
            null,
            null,
            "PopIn"
        );
    }

    /**
     * Return the creation form for this object
     */
    protected function getCreationForm()
    {
        return $this->createForm("pop_in_campaign.create");
    }

    /**
     * Return the update form for this object
     */
    protected function getUpdateForm($data = array())
    {
        if (!is_array($data)) {
            $data = array();
        }

        return $this->createForm("pop_in_campaign.update", FormType::class, $data);
    }

    /**
     * Hydrate the update form for this object, before passing it to the update template
     *
     * @param PopInCampaign $object
     */
    protected function hydrateObjectForm(ParserContext $parserContext, $object)
    {
        $data = array(
            "id" => $object->getId(),
            "start" => $object->getStart(),
            "end" => $object->getEnd(),
            "content_source_type" => $object->getContentSourceType(),
            "content_source_id" => $object->getContentSourceId(),
            "custom_title" => $object->getCustomTitle(),
            "custom_description" => $object->getCustomDescription(),
            "custom_postscriptum" => $object->getCustomPostscriptum(),
            "custom_link" => $object->getCustomLink(),
            "custom_link_text" => $object->getCustomLinkText(),
            "exclude_category_ids" => $object->getExcludeCategoryIds(),
            "exclude_folder_ids" => $object->getExcludeFolderIds(),
            "exclude_content_ids" => $object->getExcludeContentIds(),
            "exclude_home" => $object->getExcludeHome(),
            "exclude_url" => $object->getExcludeUrl(),
            "persistent" => $object->getPersistent(),
        );

        return $this->getUpdateForm($data);
    }

    /**
     * Creates the creation event with the provided form data
     *
     * @param mixed $formData
     * @return \Thelia\Core\Event\ActionEvent
     */
    protected function getCreationEvent($formData)
    {
        $event = new PopInCampaignEvent();

        $event->setStart($formData["start"]);
        $event->setEnd($formData["end"]);
        $event->setContentSourceType($formData["content_source_type"]);
        $event->setContentSourceId($formData["content_source_id"]);
        $event->setCustomTitle($formData["custom_title"]);
        $event->setCustomImage($formData["custom_image"]);
        $event->setCustomDescription($formData["custom_description"]);
        $event->setCustomPostscriptum($formData["custom_postscriptum"]);
        $event->setCustomLinkText($formData["custom_link_text"]);
        $event->setExcludeCategoryIds($formData["exclude_category_ids"]);
        $event->setExcludeFolderIds($formData["exclude_folder_ids"]);
        $event->setExcludeContentIds($formData["exclude_content_ids"]);
        $event->setExcludeHome($formData["exclude_home"]=== "on");
        $event->setExcludeUrl($formData["exclude_url"]);
        $event->setPersistent($formData["persistent"] === "on");

        return $event;
    }

    /**
     * Creates the update event with the provided form data
     *
     * @param mixed $formData
     * @return \Thelia\Core\Event\ActionEvent
     */
    protected function getUpdateEvent($formData)
    {
        $event = new PopInCampaignEvent();

        $event->setId($formData["id"]);
        $event->setStart($formData["start"]);
        $event->setEnd($formData["end"]);
        $event->setContentSourceType($formData["content_source_type"]);
        $event->setContentSourceId($formData["content_source_id"]);
        $event->setCustomTitle($formData["custom_title"]);
        $event->setCustomImage($formData["custom_image"]);
        $event->setCustomDescription($formData["custom_description"]);
        $event->setCustomPostscriptum($formData["custom_postscriptum"]);
        $event->setCustomLink($formData["custom_link"]);
        $event->setCustomLinkText($formData["custom_link_text"]);
        $event->setExcludeCategoryIds($formData["exclude_category_ids"]);
        $event->setExcludeFolderIds($formData["exclude_folder_ids"]);
        $event->setExcludeContentIds($formData["exclude_content_ids"]);
        $event->setExcludeHome($formData["exclude_home"] === "on");
        $event->setExcludeUrl($formData["exclude_url"]);
        $event->setPersistent($formData["persistent"] === "on");

        return $event;
    }

    /**
     * Creates the delete event with the provided form data
     */
    protected function getDeleteEvent()
    {
        $event = new PopInCampaignEvent();

        $event->setId($this->getRequest()->get("pop_in_campaign_id"));

        return $event;
    }

    /**
     * Return true if the event contains the object, e.g. the action has updated the object in the event.
     *
     * @param mixed $event
     */
    protected function eventContainsObject($event)
    {
        return null !== $this->getObjectFromEvent($event);
    }

    /**
     * Get the created object from an event.
     *
     * @param mixed $event
     */
    protected function getObjectFromEvent($event)
    {
        return $event->getPopInCampaign();
    }

    /**
     * Load an existing object from the database
     */
    protected function getExistingObject()
    {
        return PopInCampaignQuery::create()
            ->findPk($this->getRequest()->query->get("pop_in_campaign_id"))
            ;
    }

    /**
     * Returns the object label form the object event (name, title, etc.)
     *
     * @param mixed $object
     */
    protected function getObjectLabel($object)
    {
        return '';
    }

    /**
     * Returns the object ID from the object
     *
     * @param mixed $object
     */
    protected function getObjectId($object)
    {
        return $object->getId();
    }

    /**
     * Render the main list template
     *
     * @param mixed $currentOrder , if any, null otherwise.
     */
    protected function renderListTemplate($currentOrder)
    {
        $this->getParser()
            ->assign("order", $currentOrder)
        ;

        return $this->render("pop-in-config");
    }

    /**
     * Render the edition template
     */
    protected function renderEditionTemplate()
    {
        $this->getParserContext()
            ->set(
                "pop_in_campaign_id",
                $this->getRequest()->query->get("pop_in_campaign_id")
            )
        ;

        return $this->render("pop-in-config");
    }

    /**
     * Must return a RedirectResponse instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToEditionTemplate()
    {
        $id = $this->getRequest()->query->get("pop_in_campaign_id");

        return new RedirectResponse(
            URL::getInstance()->absoluteUrl(
                "/admin/module/PopIn/pop_in_campaign/edit",
                [
                    "pop_in_campaign_id" => $id,
                ]
            )
        );
    }

    /**
     * Must return a RedirectResponse instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToListTemplate()
    {
        return new RedirectResponse(
            URL::getInstance()->absoluteUrl("/admin/module/PopIn")
        );
    }
}
