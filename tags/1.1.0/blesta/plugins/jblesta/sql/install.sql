
SET NAMES utf8;

-- command split --

CREATE TABLE IF NOT EXISTS `jblesta_settings` (
`key` varchar( 100 ) NOT NULL ,
`value` text NOT NULL ,
PRIMARY KEY ( `key` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- command split --

INSERT INTO `jblesta_settings`(`key`, `value`) VALUES
('license', ''),
( 'localkey', '' );

