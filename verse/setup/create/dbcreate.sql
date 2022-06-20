USE verses;

DROP TABLE IF EXISTS `verse`;
DROP TABLE IF EXISTS `booklookup`;
DROP TABLE IF EXISTS `chapter`;
DROP TABLE IF EXISTS `comment`;
DROP TABLE IF EXISTS `editornotes`;
DROP TABLE IF EXISTS `hebrew`;
DROP TABLE IF EXISTS `engcit`;
DROP TABLE IF EXISTS `sedarim`;


CREATE TABLE verse (
 id INT NOT NULL PRIMARY KEY,
 verse TEXT NOT NULL DEFAULT "",
 book INT NOT NULL DEFAULT 0,
 ch INT NOT NULL DEFAULT 0,
 vr INT NOT NULL DEFAULT 0,
 last_updated DATETIME NOT NULL DEFAULT NOW() ON UPDATE NOW()
);

CREATE TABLE comment (
 id INT NOT NULL PRIMARY KEY,
 keyvalue INT NOT NULL DEFAULT 0,
 verse TEXT NOT NULL DEFAULT "",
 book INT NOT NULL DEFAULT 0,
 ch INT NOT NULL DEFAULT 0,
 vr INT NOT NULL DEFAULT 0,
 last_updated DATETIME NOT NULL DEFAULT NOW() ON UPDATE NOW()
);

CREATE TABLE editornotes (
 id INT NOT NULL PRIMARY KEY,
 keyvalue INT NOT NULL DEFAULT 0,
 verse TEXT NOT NULL DEFAULT "",
 book INT NOT NULL DEFAULT 0,
 ch INT NOT NULL DEFAULT 0,
 vr INT NOT NULL DEFAULT 0,
 last_updated DATETIME NOT NULL DEFAULT NOW() ON UPDATE NOW()
);

CREATE TABLE hebrew (
 id INT NOT NULL PRIMARY KEY,
 verse TEXT NOT NULL DEFAULT "",
 book INT NOT NULL DEFAULT 0,
 ch INT NOT NULL DEFAULT 0,
 vr INT NOT NULL DEFAULT 0,
 last_updated DATETIME NOT NULL DEFAULT NOW() ON UPDATE NOW()
);

CREATE TABLE booklookup (
 book INT NOT NULL PRIMARY KEY,
 fullbook VARCHAR (12) NOT NULL DEFAULT "",
 shortbook VARCHAR (6) NOT NULL DEFAULT "",
 hebbook VARCHAR (13) NOT NULL DEFAULT "",
 sederbook VARCHAR (13) NOT NULL DEFAULT "",
 tnk  TINYINT NOT NULL
);


CREATE TABLE chapter (
  id int NOT NULL PRIMARY KEY,
  book int NOT NULL DEFAULT 0,
  ch int NOT NULL DEFAULT 0,
  vr int NOT NULL DEFAULT 0
);

CREATE TABLE engcit (
 id INT NOT NULL PRIMARY KEY,
 heb VARCHAR (16) NOT NULL DEFAULT "",
 eng VARCHAR (16) NOT NULL DEFAULT ""
);

CREATE TABLE sedarim (
 keyvalue INT NOT NULL PRIMARY KEY,
 hebchap INT NOT NULL DEFAULT 0,
 hebverse INT NOT NULL DEFAULT 0,
 book INT NOT NULL DEFAULT 0,
 bookname VARCHAR (16) NOT NULL DEFAULT "",
 ch INT NOT NULL DEFAULT 0,
 vr INT NOT NULL DEFAULT 0
);


