<?php

namespace PopIn\Hook\Front;

use PopIn\Model\Map\PopInCampaignTableMap;
use PopIn\Model\PopInCampaign;
use PopIn\Model\PopInCampaignQuery;
use PopIn\PopIn;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Map\TableMap;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Front-office hooks.
 */
class FrontHook extends BaseHook
{
    /**
     * Base session key used to store if a campaign has been seen. The campaign id will be appended later.
     * @var string
     */
    protected static $BASE_SESSION_KEY_CAMPAIGN_SEEN;

    public function __construct()
    {
        self::$BASE_SESSION_KEY_CAMPAIGN_SEEN = PopIn::getModuleCode() . '.seen.campaign';
    }

    /**
     * Get the currently running pop-in campaign (if any).
     * @return PopInCampaign|null
     */
    protected static function getCurrentPopInCampaign()
    {
        $now = new \DateTime();

        return PopInCampaignQuery::create()
            ->where(PopInCampaignTableMap::COL_START . Criteria::ISNULL)
            ->_or()
            ->where(PopInCampaignTableMap::COL_START . Criteria::LESS_EQUAL . '?', $now)
            ->_and()
            ->where(PopInCampaignTableMap::COL_END . Criteria::ISNULL)
            ->_or()
            ->where(PopInCampaignTableMap::COL_END . Criteria::GREATER_EQUAL . '?', $now)
            ->findOne();
    }

    /**
     * Get the session key used to store if a campaign has been seen.
     * @param PopInCampaign $campaign
     * @return string
     */
    protected static function getSeenSessionKeyForPopInCampaign(PopInCampaign $campaign)
    {
        return static::$BASE_SESSION_KEY_CAMPAIGN_SEEN . '.' . $campaign->getId();
    }

    /**
     * Render the pop-in for the currently running campaign (if any), and mark it as seen in the client session.
     * @param HookRenderEvent $event
     */
    public function onMainBodyTop(HookRenderEvent $event)
    {
        // TODO Fix in Thelia hook called multiple times
        if (!count($this->getRequest()->attributes->all())) {
            return;
        }
        $currentCampaign = static::getCurrentPopInCampaign();

        if ($currentCampaign === null) {
            return;
        }

        if ($this->getSession()->get(static::getSeenSessionKeyForPopInCampaign($currentCampaign))) {
            return;
        }

        $view = $this->getRequest()->attributes->get("_view");
        if ($view === "category" && $currentCampaign->getExcludeCategoryIds() !== null) {
            $excludedCategoriesIds = explode(',', $currentCampaign->getExcludeCategoryIds());
            if (in_array($this->getRequest()->attributes->get('category_id'), $excludedCategoriesIds)) {
                return;
            }
        }
        if ($view === "content" && $currentCampaign->getExcludeContentIds() !== null) {
            $excludedContentsIds = explode(',', $currentCampaign->getExcludeContentIds());
            if (in_array($this->getRequest()->attributes->get('content_id'), $excludedContentsIds)) {
                return;
            }
        }

        $event->add(
            $this->render(
                'pop-in.html',
                [
                    'campaign' => $currentCampaign->toArray(TableMap::TYPE_FIELDNAME),
                ]
            )
        );

        $this->getSession()->set(static::getSeenSessionKeyForPopInCampaign($currentCampaign), true);
    }

    /**
     * Add the front-office javascript.
     * @param HookRenderEvent $event
     */
    public function onMainJavascriptInitialization(HookRenderEvent $event)
    {
        $event->add($this->addJS('assets/js/pop-in.js'));
    }

    /**
     * Add the front-office stylesheets.
     * @param HookRenderEvent $event
     */
    public function onMainStylesheet(HookRenderEvent $event)
    {
        $event->add($this->addCSS('assets/less/pop-in.less', [], 'less'));
    }
}
