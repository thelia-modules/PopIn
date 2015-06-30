<?php

namespace PopIn\Hook\Back;

use PopIn\PopIn;
use Symfony\Component\Routing\RouterInterface;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Back-office hooks.
 */
class BackHook extends BaseHook
{
    /** @var RouterInterface */
    protected $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Add a link to the pop-in configuration page in the tools menu.
     * @param HookRenderBlockEvent $event
     */
    public function onMainTopMenuTools(HookRenderBlockEvent $event)
    {
        $event->add([
            'title' => $this->trans('Pop-in campaigns', [], PopIn::MESSAGE_DOMAIN_BO),
            'url' => $this->router->generate('popin.config'),
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
