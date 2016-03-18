CREATE TABLE `{source}` (
  `id`                INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `feed`              VARCHAR(255)        NOT NULL DEFAULT '',
  `time_create`       INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `time_check_last`   INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `time_check_period` INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `status`            TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `extra`             TEXT,
  PRIMARY KEY (`id`),
  KEY `time_check_last` (`time_check_last`),
  KEY `time_check_period` (`time_check_period`),
  KEY `status` (`status`)
);