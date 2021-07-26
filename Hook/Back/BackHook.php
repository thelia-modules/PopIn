<?php

namespace PopIn\Hook\Back;

use PopIn\PopIn;
use Symfony\Component\Routing\RouterInterface;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

/**
 * Back-office hooks.
 */
class BackHook extends BaseHook
{
    /**
     * Add a link to the pop-in configuration page in the tools menu.
     * @param HookRenderBlockEvent $event
     */
    public function onMainTopMenuTools(HookRenderBlockEvent $event)
    {
        $event->add([
            'title' => $this->trans('Pop-in campaigns', [], PopIn::MESSAGE_DOMAIN_BO),
            'url' => URL::getInstance()->absoluteUrl("/admin/module/PopIn"),
        ]);
    }

    /**
     * Add a link to the pop-in configuration page in the tools page.
     * @param HookRenderEvent $event
     */
    public function onToolsCol1Bottom(HookRenderEvent $event)
    {
        $event->add($this->render('pop-in-tools.html'));
    }
}
