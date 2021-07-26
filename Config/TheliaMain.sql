
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- pop_in_campaign
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pop_in_campaign`;

CREATE TABLE `pop_in_campaign`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `visible` TINYINT,
    `start` DATETIME,
    `end` DATETIME,
    `content_source_type` VARCHAR(255),
    `content_source_id` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- pop_in_campaign_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pop_in_campaign_i18n`;

CREATE TABLE `pop_in_campaign_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `custom_title` VARCHAR(255),
    `custom_description` VARCHAR(255),
    `custom_postscriptum` VARCHAR(255),
    `custom_link` VARCHAR(255),
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `pop_in_campaign_i18n_fk_75ebd9`
        FOREIGN KEY (`id`)
        REFERENCES `pop_in_campaign` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
