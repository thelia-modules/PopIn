<?php

namespace PopIn\Action;

use PopIn\Action\Base\PopInCampaignAction as BasePopInCampaignAction;
use PopIn\Event\PopInCampaignEvent;
use PopIn\Event\PopInCampaignEvents;
use PopIn\Model\Map\PopInCampaignTableMap;
use PopIn\Model\PopInCampaign;
use PopIn\Model\PopInCampaignQuery;
use Propel\Runtime\Propel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Model\ContentQuery;
use TheliaLibrary\Model\Base\LibraryImage;
use TheliaLibrary\Service\LibraryImageService;
use TheliaLibrary\Service\LibraryItemImageService;

/**
 * Pop-in campaign actions.
 */
class PopInCampaignAction extends BaseAction implements EventSubscriberInterface
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var LibraryItemImageService
     */
    protected $libraryItemImageService;

    public function __construct(
        RequestStack $requestStack,
        LibraryItemImageService $libraryItemImageService
    )
    {
        $this->requestStack = $requestStack;
        $this->libraryItemImageService = $libraryItemImageService;
    }
    public function create(PopInCampaignEvent $event)
    {
        $this->createOrUpdate($event, new PopInCampaign());
    }

    public function update(PopInCampaignEvent $event)
    {
        $model = $this->getPopInCampaign($event);

        $this->createOrUpdate($event, $model);
    }

    public function delete(PopInCampaignEvent $event)
    {
        $this->getPopInCampaign($event)->delete();
    }

    protected function createOrUpdate(PopInCampaignEvent $event, PopInCampaign $model)
    {
        $this->validateCampaignDates($event->getStart(), $event->getEnd());
        $this->validateContentSource($event->getContentSourceType(), $event->getContentSourceId());

        $con = Propel::getConnection(PopInCampaignTableMap::DATABASE_NAME);
        $con->beginTransaction();

        try {
            $locale = $this->requestStack->getCurrentRequest()->getSession()->getAdminEditionLang()->getLocale();
            $model->setLocale($locale);

            if (null !== $id = $event->getId()) {
                $model->setId($id);
            }

            if (null !== $start = $event->getStart()) {
                $model->setStart($start);
            }

            if (null !== $end = $event->getEnd()) {
                $model->setEnd($end);
            }

            if (null !== $contentSourceType = $event->getContentSourceType()) {
                $model->setContentSourceType($contentSourceType);
            }

            if (null !== $contentSourceId = $event->getContentSourceId()) {
                $model->setContentSourceId($contentSourceId);
            }

            $customTitle = $event->getCustomTitle() ?? "";
            $model->setCustomTitle($customTitle);

            if (null !== $customDescription = $event->getCustomDescription()) {
                $model->setCustomDescription($customDescription);
            }

            if (null !== $customPostscriptum = $event->getCustomPostscriptum()) {
                $model->setCustomPostscriptum($customPostscriptum);
            }

            if (null !== $customLink = $event->getCustomLink()) {
                $model->setCustomLink($customLink);
            }

            if (null !== $customLinkText = $event->getCustomLinkText()) {
                $model->setCustomLinkText($customLinkText);
            }

            $model->setExcludeCategoryIds($event->getExcludeCategoryIds());

            $model->setExcludeContentIds($event->getExcludeContentIds());

            $model->setPersistent($event->getPersistent());

            $model->save($con);

            if (null !== $customImage = $event->getCustomImage()) {
                $this->libraryItemImageService->createAndAssociateImage(
                    $customImage,
                    $customTitle,
                    null,
                    "popin",
                    $model->getId(),
                    "main",
                    true,
                    null,
                    true
                );
            }

            $con->commit();
        } catch (\Exception $e) {
            $con->rollback();

            throw $e;
        }

        $event->setPopInCampaign($model);
    }

    protected function getPopInCampaign(PopInCampaignEvent $event)
    {
        $model = PopInCampaignQuery::create()->findPk($event->getId());

        if (null === $model) {
            throw new \RuntimeException(sprintf(
                "The 'pop_in_campaign' id '%d' doesn't exist",
                $event->getId()
            ));
        }

        return $model;
    }

    /**
     * Check that a pop-in campaign dates are valid.
     * @param \DateTime $start
     * @param \DateTime $end
     * @throws \InvalidArgumentException
     */
    protected function validateCampaignDates(\DateTime $start = null, \DateTime $end = null)
    {
        if ($start !== null && $end !== null && $start > $end) {
            throw new \InvalidArgumentException('Pop-in campaign starts after it ends.');
        }
    }

    /**
     * Check that a pop-campaign content source is valid.
     * @param $contentSourceType
     * @param $contentSourceId
     * @throws \InvalidArgumentException
     */
    protected function validateContentSource($contentSourceType, $contentSourceId)
    {
        switch ($contentSourceType) {
            case 'content':
                if (null === ContentQuery::create()->findPk($contentSourceId)) {
                    throw new \InvalidArgumentException('No content with id ' . $contentSourceId);
                }
                break;
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            PopInCampaignEvents::CREATE => array("create", 128),
            PopInCampaignEvents::UPDATE => array("update", 128),
            PopInCampaignEvents::DELETE => array("delete", 128)
        );
    }
}
