<?php

namespace PopIn\Controller;

use PopIn\Hook\Front\FrontHook;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PopInFrontController extends BaseFrontController
{
    /**
     * @Route("/popin/{popinId]/dismiss", name="pop_in_dismiss", methods="POST")
     */
    public function dismissPopIn($popInId, Request $request)
    {
        $request->getSession()->set(FrontHook::getSeenSessionKeyForPopInCampaign(null, $popInId), true);

        return new Response();
    }

}
