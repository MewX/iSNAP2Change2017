CREATE DATABASE IF NOT EXISTS log;
USE log;
CREATE TABLE IF NOT EXISTS `Log` (
  LogID             MEDIUMINT AUTO_INCREMENT,
  PageName          TEXT,
  RequestMethod     TEXT,
  RequestParameters TEXT,
  SessionDump       TEXT,
  ExceptionMessage  LONGTEXT,
  ExceptionTrace    LONGTEXT,
  UserFeedback      TEXT,
  Solved            BOOLEAN   DEFAULT 0,
  LogTime           TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT Log_LogID_PK PRIMARY KEY (LogID)
)
  ENGINE = INNODB;
  