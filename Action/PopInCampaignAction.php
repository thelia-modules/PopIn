<?php

namespace PopIn\Action;

use PopIn\Action\Base\PopInCampaignAction as BasePopInCampaignAction;
use PopIn\Event\PopInCampaignEvent;
use PopIn\Model\PopInCampaign;
use Thelia\Model\ContentQuery;

/**
 * Pop-in campaign actions.
 */
class PopInCampaignAction extends BasePopInCampaignAction
{
    protected function createOrUpdate(PopInCampaignEvent $event, PopInCampaign $model)
    {
        $this->validateCampaignDates($event->getStart(), $event->getEnd());
        $this->validateContentSource($event->getContentSourceType(), $event->getContentSourceId());

        parent::createOrUpdate($event, $model);
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
}
