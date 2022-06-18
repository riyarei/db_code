CREATE DATABASE IF NOT EXISTS `team14`;
use `team14`;

/* 
	ID 編號開頭(最高位)
	1: enterprise
	2: player
	3: machine
	4: gashapon
	5: orderform
*/

CREATE TABLE IF NOT EXISTS `enterprise`
(
	`enterprise_id`   int         NOT NULL AUTO_INCREMENT,
	`password`        varchar(8)  not null,
	`account`         varchar(18) not null,
	`money`		      decimal(12,0) not null,

	primary key (`enterprise_id`)

)ENGINE=INNODB AUTO_INCREMENT = 10001;

CREATE TABLE IF NOT EXISTS `machine`
(
	`machine_id`      int         NOT NULL AUTO_INCREMENT,
	`name`            varchar(10) not null,
	`price`           decimal(5,0)  check (price>0),
	`picture`         VARCHAR(200),
	`amount`          decimal(12,0) check (amount>=0),
	`enterprise_ID`   int,
	primary key (`machine_id`),
	foreign key (`enterprise_ID`) references enterprise (enterprise_id) 
		on delete cascade

)ENGINE=INNODB AUTO_INCREMENT = 30001;

CREATE TABLE IF NOT EXISTS `announces`
(
	`enterprise_id`   int,
	`machine_id`      int ,
	`content`         varchar(1000) not null,

	primary key (`enterprise_id`, `machine_id`),
	foreign key (`enterprise_id`) references `enterprise` (enterprise_id) 
		on delete cascade,
	foreign key (`machine_id`) references machine (machine_id) 
		on delete cascade
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS `player`
(
	`player_id`       int         NOT NULL AUTO_INCREMENT,
	`password`        varchar(8)  not null,
	`account`         varchar(18) not null,
	`money`           decimal(12,0),
	`address`         varchar(50) not null,
	primary key (`player_id`)
)ENGINE=INNODB AUTO_INCREMENT = 20001;

CREATE TABLE IF NOT EXISTS `gashapon`
(
	`gashapon_id`     int         NOT NULL AUTO_INCREMENT,
	`name`            varchar(10) not null,
	`picture`         varchar(200),
	`amount`          decimal(12,0) not null,
	`machine_id`      int ,
	primary key (`gashapon_id`),
	foreign key (`machine_id`) references machine (machine_id) 
		on delete set null
)ENGINE=INNODB AUTO_INCREMENT = 40001;

CREATE TABLE IF NOT EXISTS `orderform`
(
	`orderform_id`    int         NOT NULL AUTO_INCREMENT,
	`send`             decimal(5,0),
	`gashapon_id`     int,
	`player_id`       int,
	primary key (`orderform_id`),
	foreign key (`player_id`) references player (player_id) 
		on delete set null
)ENGINE=INNODB AUTO_INCREMENT = 50001;


/* 
	ID編號開頭(最高位)
	1: enterprise
	2: player
	3: machine
	4: gashapon
	5: orderform
*/
delete from `enterprise`;
delete from `machine`;
delete from `announces`;
delete from `player`;
delete from `gashapon`;
delete from `orderform`;


INSERT INTO `enterprise` (`enterprise_id`, `password`, `account`, `money`) VALUES
	(10001, '12345', '1234510001', 0),
	(10002, '12345', '1234510002', 0),
	(10003, '12345', '1234510003', 0),
	(10004, '12345', '1234510004', 0),
	(10005, '12345', '1234510005', 0);
	
INSERT INTO `machine` (	`machine_id`, `name`, `price`, `picture`, `amount`, `enterprise_id`) VALUES
	(30001, '祈禱的動物', 60, 'https://i.imgur.com/HeclyrO.jpg', 6, 10001),
	(30002, '熱帶水果鳥', 70, 'https://i.imgur.com/9V2kjvC.jpg', 5, 10002),
	(30003, 'ハイキュー！！', 80, 'https://i.imgur.com/yoo3H74.jpg', 4, 10003);
	
INSERT INTO `announces` (`enterprise_id`, `machine_id`, `content`) VALUES
	(10001, 30001, 'on sale'),
	(10002, 30002, 'hot sale'),
	(10003, 30003, 'new!!');
	
INSERT INTO `player` (`player_id`, `password`, `account`, `money`, `address`) VALUES
	(20001, '67890', '6789020001', 500, '台北市文山區汀州路四段88號'),
	(20002, '67890', '6789020002', 500, '台北市大安區和平東路一段162號'),
	(20003, '67890', '6789020003', 500, '台北市大安區和平東路一段129號');

INSERT INTO `gashapon` (`name`, `picture`, `amount`, `machine_id`) VALUES
	('鬣蜥', 'https://i.imgur.com/O0EBfta.png', 4, 30001),
	('貓咪', 'https://i.imgur.com/L5cfwRg.png', 5, 30001),
	('狼', 'https://i.imgur.com/FsjKO1t.png', 5, 30001),
	('鯨頭鶴', 'https://i.imgur.com/MEtAtuH.png', 4, 30001),
	('水豚', 'https://i.imgur.com/tJ1s2hx.png', 5, 30001),
	('老虎', 'https://i.imgur.com/ovyKwXK.png', 5, 30001),
	('西瓜鳥', 'https://i.imgur.com/52ibBTy.png', 5, 30002),
	('檸檬鳥', 'https://i.imgur.com/fJFPX64.png', 4, 30002),
	('無花果鳥', 'https://i.imgur.com/0liV1XH.png', 5, 30002),
	('芒果鳥', 'https://i.imgur.com/FMZY3hJ.png', 5, 30002),
	('藍莓鳥', 'https://i.imgur.com/cppwwUH.png', 5, 30002),
	('日向', 'https://i.imgur.com/DgycVXk.png', 5, 30003),
	('影山', 'https://i.imgur.com/qvqwsW3.png', 5, 30003),
	('黑尾', 'https://i.imgur.com/2WHVMFP.png', 5, 30003),
	('研磨', 'https://i.imgur.com/pD3RVEc.png', 5, 30003);

	
INSERT INTO `orderform` (`send`, `gashapon_id`, `player_id`) VALUES
/* 0: 未寄出 1:已寄出 */
	(0, 40001, 20001),
	(0, 40002, 20001),
	(1, 40003, 20001),
	(1, 40004, 20001),
	(1, 40005, 20001),
	(1, 40006, 20001),
	(1, 40004, 20002),
	(1, 40008, 20003);
