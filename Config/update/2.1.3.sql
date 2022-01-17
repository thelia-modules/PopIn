-- ---------------------------------------------------------------------
-- pop_in_campaign
-- ---------------------------------------------------------------------

alter table pop_in_campaign add `exclude_home` TINYINT DEFAULT 0 AFTER `exclude_content_ids`;
