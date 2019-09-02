
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
    `start` DATETIME,
    `end` DATETIME,
    `content_source_type` VARCHAR(255),
    `content_source_id` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- pop_in_free_content
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pop_in_free_content`;

CREATE TABLE `pop_in_free_content`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `id_pop_in_campaign` INTEGER NOT NULL,
    `text_free` VARCHAR(255),
    `link` VARCHAR(255),
    PRIMARY KEY (`id`),
    INDEX `FI_id_pop_in_campaign` (`id_pop_in_campaign`),
    CONSTRAINT `fk_id_pop_in_campaign`
        FOREIGN KEY (`id_pop_in_campaign`)
        REFERENCES `pop_in_campaign` (`id`)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
