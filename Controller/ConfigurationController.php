<?php

namespace PopIn\Controller;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\HttpFoundation\Response;

/**
 * Module configuration controller.
 */
class ConfigurationController extends BaseAdminController
{
    /**
     * Render the module configuration page.
     * @return Response
     */
    public function configAction()
    {
        return $this->render("pop-in-config");
    }
}
