CREATE DATABASE 'cakemail' /*!40100 DEFAULT CHARACTER SET utf8 */$$


CREATE TABLE 'Clients' (
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'firstname' varchar(45) NOT NULL,
  'lastname' varchar(45) NOT NULL,
  PRIMARY KEY ('id'),
  UNIQUE KEY 'id_UNIQUE' ('id')
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8$$

