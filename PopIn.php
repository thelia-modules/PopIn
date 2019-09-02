<?php

namespace PopIn;

use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;
use Symfony\Component\Finder\Finder;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Core\Translation\Translator;
use Thelia\Install\Database;
use Thelia\Model\Config;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Folder;
use Thelia\Model\FolderQuery;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Module\BaseModule;

/**
 * PopIn module.
 */
class PopIn extends BaseModule
{
    const MESSAGE_DOMAIN = "popin";
    const MESSAGE_DOMAIN_BO = "popin.bo.default";
    const MESSAGE_DOMAIN_FO = "popin.fo.default";
    const ROUTER = "router.popin";

    const CONF_KEY_IMAGE_FOLDER_ID = "popin.image_folder_id";

    public function postActivation(ConnectionInterface $con = null)
    {
        $database = new Database($con);

        $database->insertSql(null, [__DIR__ . "/Config/thelia.sql", __DIR__ . "/Config/insert.sql"]);

        $this->loadBackOfficeTranslationResources();
        $this->createPopInImageFolder();
    }

    public function update($currentVersion, $newVersion, ConnectionInterface $con = null)
    {
        $finder = Finder::create()
            ->name('*.sql')
            ->depth(0)
            ->sortByName()
            ->in(__DIR__ . DS . 'Config' . DS . 'update');

        $database = new Database($con);

        /** @var \SplFileInfo $file */
        foreach ($finder as $file) {
            if (version_compare($currentVersion, $file->getBasename('.sql'), '<')) {
                $database->insertSql(null, [$file->getPathname()]);
            }
        }
    }

    public function getHooks()
    {
        return [
            [
                "type" => TemplateDefinition::FRONT_OFFICE,
                "code" => "pop-in.content",
                "title" => [
                    "en_US" => "Pop-in content",
                    "fr_FR" => "Contenu de la pop-in",
                ],
                "block" => false,
                "active" => true,
            ]
        ];
    }

    /**
     * Load the back-office translations into the translator.
     */
    protected function loadBackOfficeTranslationResources()
    {
        /** @var Lang $lang */
        foreach (LangQuery::create()->find() as $lang) {
            Translator::getInstance()->addResource(
                "php",
                __DIR__ . "/I18n/backOffice/default/" . $lang->getLocale() . ".php",
                $lang->getLocale(),
                static::MESSAGE_DOMAIN_BO
            );
        }
    }

    /**
     * Create and save the id of the pop-in images folder if necessary.
     *
     * @throws \Exception
     * @throws PropelException
     */
    protected function createPopInImageFolder()
    {
        $imageFolderIdConfig = ConfigQuery::create()->findOneByName(static::CONF_KEY_IMAGE_FOLDER_ID);
        if (null !== $imageFolderIdConfig && null !== FolderQuery::create()->findPk($imageFolderIdConfig->getValue())) {
            // we already have and know our images folder
            return;
        }

        Propel::getConnection()->beginTransaction();

        try {
            // create the folder
            $folder = new Folder();
            $folder->setVisible(true);

            /** @var Lang $lang */
            foreach (LangQuery::create()->find() as $lang) {
                $localizedTitle = Translator::getInstance()->trans(
                    "Pop-in images",
                    [],
                    static::MESSAGE_DOMAIN_BO,
                    $lang->getLocale(),
                    false
                );

                if ($localizedTitle == "") {
                    continue;
                }

                $folder
                    ->setLocale($lang->getLocale())
                    ->setTitle($localizedTitle);
            }

            $folder->save();

            // save the folder id in configuration
            if ($folder->getId() !== null) {
                $config = new Config();
                $config
                    ->setName(static::CONF_KEY_IMAGE_FOLDER_ID)
                    ->setValue($folder->getId())
                    ->setHidden(false);

                /** @var Lang $lang */
                foreach (LangQuery::create()->find() as $lang) {
                    $localizedTitle = Translator::getInstance()->trans(
                        "Pop-in images folder id",
                        [],
                        static::MESSAGE_DOMAIN_BO,
                        $lang->getLocale(),
                        false
                    );

                    if ($localizedTitle == "") {
                        continue;
                    }

                    $config
                        ->setLocale($lang->getLocale())
                        ->setTitle($localizedTitle);
                }

                $config->save();
            }
        } catch (\Exception $e) {
            Propel::getConnection()->rollBack();
            throw $e;
        }

        Propel::getConnection()->commit();
    }
}
