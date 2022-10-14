--06-06-2022
ALTER TABLE `users` DROP `institute_id`, DROP `branch_id`, DROP `training_center_id`;
ALTER TABLE `users` ADD `office_id` INT(11) NULL DEFAULT NULL AFTER `role_id`;

--04-09-2022
ALTER TABLE `landless_application_attachments` CHANGE `application_id` `landless_application_id` INT(10) UNSIGNED NOT NULL;