CREATE TABLE `{source}` (
  `id`                INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `title`             VARCHAR(255)        NOT NULL DEFAULT '',
  `link`              VARCHAR(255)        NOT NULL DEFAULT '',
  `time_create`       INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `time_parse_last`   INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `time_parse_period` INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `status`            TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `extra`             TEXT,
  PRIMARY KEY (`id`),
  KEY `time_parse_last` (`time_parse_last`),
  KEY `time_parse_period` (`time_parse_period`),
  KEY `status` (`status`)
);

CREATE TABLE `{feed}` (
  `id`            INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `title`         VARCHAR(255)        NOT NULL DEFAULT '',
  `link`          VARCHAR(255)        NOT NULL DEFAULT '',
  `description`   MEDIUMTEXT,
  `date_modified` VARCHAR(255)        NOT NULL DEFAULT '',
  `status`        TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `time_create`   INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `hits`          INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `source`        INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `time_create` (`time_create`),
  KEY `status` (`status`),
  KEY `source` (`source`),
  KEY `story_list` (`status`, `source`),
  KEY `story_order` (`time_create`, `id`)
);