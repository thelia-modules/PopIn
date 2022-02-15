-- ---------------------------------------------------------------------
-- pop_in_campaign
-- ---------------------------------------------------------------------

alter table pop_in_campaign add `implicitly_excluded_category_ids` TEXT AFTER `exclude_category_ids`;
alter table pop_in_campaign add `implicitly_excluded_product_ids` TEXT AFTER `implicitly_excluded_category_ids`;
alter table pop_in_campaign add `exclude_folder_ids` VARCHAR(255) AFTER `implicitly_excluded_product_ids`;
alter table pop_in_campaign add `implicitly_excluded_folder_ids` TEXT AFTER `exclude_folder_ids`;
alter table pop_in_campaign add `implicitly_excluded_content_ids` TEXT AFTER `implicitly_excluded_folder_ids`;
