CREATE TABLE my_table (
  id INTEGER NOT NULL DEFAULT 0,
  version INTEGER NOT NULL DEFAULT 0,
  name VARCHAR(64) DEFAULT NULL,
  PRIMARY KEY (id,version)
);