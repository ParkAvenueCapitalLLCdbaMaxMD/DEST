
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- sdoh_form
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sdoh_form`;

CREATE TABLE `sdoh_form`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT DEFAULT 0 NOT NULL,
    `domain` VARCHAR(32) NOT NULL,
    `screening_data` TEXT,
    `diagnoses_data` TEXT,
    `goals_data` TEXT,
    `intervention_data` TEXT,
    `status` VARCHAR(16),
    `created_ts` DATETIME,
    `updated_ts` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `valid` TINYINT(1) DEFAULT 1 NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_id` (`user_id`),
    INDEX `domain` (`domain`),
    INDEX `status` (`status`),
    INDEX `updated_ts` (`updated_ts`),
    INDEX `created_ts` (`created_ts`),
    INDEX `valid` (`valid`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(256) NOT NULL,
    `password` TEXT,
    `salt` VARCHAR(32) NOT NULL,
    `first_name` VARCHAR(128),
    `last_name` VARCHAR(128),
    `role` VARCHAR(32) DEFAULT 'User',
    `token` VARCHAR(64),
    `token_expire_ts` DATETIME,
    `created_ts` DATETIME,
    `updated_ts` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `active` TINYINT(1) DEFAULT 0 NOT NULL,
    `valid` TINYINT(1) DEFAULT 1 NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `email` (`email`),
    INDEX `token` (`token`),
    INDEX `created_ts` (`created_ts`),
    INDEX `updated_ts` (`updated_ts`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
