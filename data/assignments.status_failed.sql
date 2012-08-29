ALTER TABLE `assignments` MODIFY COLUMN `status` ENUM('PENDING','REJECTED','ACCEPTED','EXPIRED','COMPLETED','LEFT', 'FAILED') NOT NULL DEFAULT 'PENDING' COMMENT 'The status of the assignment.';