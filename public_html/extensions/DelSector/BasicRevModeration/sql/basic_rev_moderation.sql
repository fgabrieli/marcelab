
CREATE TABLE basic_rev_moderation (
  id int NOT NULL AUTO_INCREMENT,
  page_id int(10) unsigned NOT NULL,
  status tinyint(1) DEFAULT 0,
  last_approved_rev_id int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY(page_id) REFERENCES PAGE(page_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

