-- ---------------------------------------------------------------------
-- pop_in_campaign
-- ---------------------------------------------------------------------

alter table pop_in_campaign
    add exclude_category_ids varchar(255) null;

alter table pop_in_campaign
    add exclude_content_ids varchar(255) null;