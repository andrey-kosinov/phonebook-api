
CREATE TABLE users (
	`id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`first_name` VARCHAR(100) NULL,
	`last_name` VARCHAR(100) NULL,
	`phone_number` VARCHAR(30) NULL,
	`country_code` VARCHAR(2) NULL,
	`timezone` VARCHAR(100) NULL,
	`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
	`updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	INDEX(created_at),
	INDEX(updated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

##>-<##

DROP TABLE IF EXISTS users;
