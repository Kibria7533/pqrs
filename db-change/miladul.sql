--07-06-2022--
-- change status & stage default value in landless table--
ALTER TABLE `landless` CHANGE `status` `status` MEDIUMINT UNSIGNED NULL DEFAULT '3', CHANGE `stage` `stage` MEDIUMINT NULL DEFAULT '3';

--14-6-2022--
-- status field position change
ALTER TABLE `committee_types` CHANGE `status` `status` MEDIUMINT UNSIGNED NULL DEFAULT '1' AFTER `office_type`;

--31-7-2022
ALTER TABLE `division20_muted_khotians`  ADD `dcr_number` VARCHAR(255) NULL DEFAULT NULL  AFTER `revenue`;

--29-08-2022
ALTER TABLE `eight_registers`  ADD `provided_khasland_area` VARCHAR(255) NULL DEFAULT NULL  AFTER `remaining_khasland_area`;

--04-09-2022
ALTER TABLE `landless_users`  ADD `landless_application_id` INT(11) NULL  AFTER `id`;
ALTER TABLE `landless_users` DROP `office_id`;
ALTER TABLE `landless_users` CHANGE `loc_division_id` `division_bbs_code` MEDIUMINT UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `landless_users` CHANGE `loc_district_id` `district_bbs_code` MEDIUMINT UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `landless_users`  ADD `upazila_bbs_code` MEDIUMINT(11) NULL DEFAULT NULL  AFTER `district_bbs_code`;

--13-09-2022
ALTER TABLE `land_assignments`  ADD `meeting_id` INT(11) UNSIGNED NOT NULL  AFTER `id`;

--14-09-2022
ALTER TABLE `eight_registers`  ADD `provided_khasland_area` VARCHAR(20) NULL DEFAULT '0'  AFTER `remaining_khasland_area`;
ALTER TABLE `eight_registers` CHANGE `provided_khasland_area` `provided_khasland_area` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '0';
ALTER TABLE `eight_registers` CHANGE `details` `details` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

--02-10-2022
ALTER TABLE `land_assignments` CHANGE `is_land_assignment_approved_by_uno` `is_approved_by_uno` TINYINT UNSIGNED NULL DEFAULT '0';
ALTER TABLE `land_assignments` CHANGE `is_land_assignment_approved_by_dc` `is_approved_by_dc` TINYINT UNSIGNED NULL DEFAULT '0';
ALTER TABLE `land_assignments`  ADD `is_approved_by_acland` TINYINT UNSIGNED NULL DEFAULT '0'  AFTER `is_jomabondi_approved_by_acland`;
