/*
SQLyog Enterprise v12.5.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - dbtoko
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `detailpembelian` */

DROP TABLE IF EXISTS `detailpembelian`;

CREATE TABLE `detailpembelian` (
  `detailid` bigint(20) NOT NULL AUTO_INCREMENT,
  `detailbelinota` char(20) DEFAULT NULL,
  `detailbelikode` char(30) DEFAULT NULL,
  `detsatid` int(11) DEFAULT NULL,
  `detsatqty` int(11) DEFAULT NULL,
  `detailbeliqty` int(11) DEFAULT NULL,
  `detailbeliharga` double DEFAULT NULL,
  `detailbelisubtotal` double DEFAULT NULL,
  PRIMARY KEY (`detailid`),
  KEY `detailbelinota` (`detailbelinota`),
  KEY `detsatid` (`detsatid`),
  CONSTRAINT `detailpembelian_ibfk_1` FOREIGN KEY (`detailbelinota`) REFERENCES `pembelian` (`belinota`) ON UPDATE CASCADE,
  CONSTRAINT `detailpembelian_ibfk_2` FOREIGN KEY (`detsatid`) REFERENCES `satuan` (`satid`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `detailpembelian` */

/*Table structure for table `detailpenjualan` */

DROP TABLE IF EXISTS `detailpenjualan`;

CREATE TABLE `detailpenjualan` (
  `detjualid` bigint(20) NOT NULL AUTO_INCREMENT,
  `detjualnota` char(20) DEFAULT NULL,
  `detjualtgl` datetime DEFAULT NULL,
  `detjualprodukkode` char(30) DEFAULT NULL,
  `detjualsatid` int(11) DEFAULT NULL,
  `detjualsatqty` int(11) DEFAULT NULL,
  `detjualqty` int(11) DEFAULT NULL,
  `detjualharga` double DEFAULT NULL,
  `detjualsubtotal` double DEFAULT NULL,
  `detjualuserinput` char(30) DEFAULT NULL,
  PRIMARY KEY (`detjualid`),
  KEY `detjualnota` (`detjualnota`),
  KEY `detjualsatid` (`detjualsatid`),
  CONSTRAINT `detailpenjualan_ibfk_1` FOREIGN KEY (`detjualnota`) REFERENCES `penjualan` (`jualnota`) ON UPDATE CASCADE,
  CONSTRAINT `detailpenjualan_ibfk_2` FOREIGN KEY (`detjualsatid`) REFERENCES `satuan` (`satid`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `detailpenjualan` */

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `katid` int(11) NOT NULL AUTO_INCREMENT,
  `katnama` varchar(100) DEFAULT NULL,
  `katket` enum('-','P') DEFAULT '-',
  PRIMARY KEY (`katid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `kategori` */

insert  into `kategori`(`katid`,`katnama`,`katket`) values 
(1,'-','-');

/*Table structure for table `nnlevel` */

DROP TABLE IF EXISTS `nnlevel`;

CREATE TABLE `nnlevel` (
  `levelid` int(11) NOT NULL AUTO_INCREMENT,
  `levelnama` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`levelid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `nnlevel` */

insert  into `nnlevel`(`levelid`,`levelnama`) values 
(1,'Administrator'),
(2,'Kasir'),
(3,'Super Admin');

/*Table structure for table `nnuser` */

DROP TABLE IF EXISTS `nnuser`;

CREATE TABLE `nnuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` char(20) NOT NULL,
  `usernama` varchar(100) DEFAULT NULL,
  `userpass` varchar(100) DEFAULT NULL,
  `useraktif` char(1) DEFAULT '1',
  `userfoto` varchar(150) DEFAULT NULL,
  `userlevelid` int(11) DEFAULT NULL,
  `usertokoid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`userid`),
  KEY `userlevelid` (`userlevelid`),
  CONSTRAINT `nnuser_ibfk_1` FOREIGN KEY (`userlevelid`) REFERENCES `nnlevel` (`levelid`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `nnuser` */

insert  into `nnuser`(`id`,`userid`,`usernama`,`userpass`,`useraktif`,`userfoto`,`userlevelid`,`usertokoid`) values 
(1,'superadmin','Super Admin','$2y$10$A04zjkjeFMS0JiYllYOkqeaGkOk9Ruwb1PilDsGYGK/p8bBL6QD7S','1',NULL,3,NULL);

/*Table structure for table `pembelian` */

DROP TABLE IF EXISTS `pembelian`;

CREATE TABLE `pembelian` (
  `belinota` char(20) NOT NULL,
  `belitgl` date DEFAULT NULL,
  `belisupid` int(11) DEFAULT NULL,
  `beliuserinput` char(20) DEFAULT NULL,
  `belitotal` double DEFAULT 0,
  `belitokoid` int(11) DEFAULT NULL,
  PRIMARY KEY (`belinota`),
  KEY `belisupid` (`belisupid`),
  KEY `belitokoid` (`belitokoid`),
  CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`belisupid`) REFERENCES `supplier` (`supid`) ON UPDATE CASCADE,
  CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`belitokoid`) REFERENCES `toko` (`tokoid`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pembelian` */

/*Table structure for table `penjualan` */

DROP TABLE IF EXISTS `penjualan`;

CREATE TABLE `penjualan` (
  `jualnota` char(20) NOT NULL,
  `jualtgl` datetime DEFAULT NULL,
  `jualuserinput` char(20) DEFAULT NULL,
  `jualtotal` double DEFAULT 0,
  `jualdiskon` double DEFAULT 0,
  `jualbayar` double DEFAULT 0,
  `jualsisa` double DEFAULT 0,
  `jualtokoid` int(11) DEFAULT NULL,
  PRIMARY KEY (`jualnota`),
  KEY `jualtokoid` (`jualtokoid`),
  CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`jualtokoid`) REFERENCES `toko` (`tokoid`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `penjualan` */

/*Table structure for table `produk` */

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `produkid` bigint(20) NOT NULL AUTO_INCREMENT,
  `produkkode` char(30) DEFAULT NULL,
  `produknm` varchar(200) DEFAULT NULL,
  `produkkatid` int(11) DEFAULT NULL,
  `produksatid` int(11) DEFAULT NULL,
  `produkharga` double DEFAULT NULL,
  `tglinput` datetime DEFAULT NULL,
  `userinput` char(20) DEFAULT NULL,
  `tgledit` datetime DEFAULT NULL,
  `useredit` char(20) DEFAULT NULL,
  `produktokoid` int(11) DEFAULT NULL,
  PRIMARY KEY (`produkid`),
  KEY `produk_ibfk_1` (`produkkatid`),
  KEY `produksatid` (`produksatid`),
  CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`produkkatid`) REFERENCES `kategori` (`katid`) ON UPDATE CASCADE,
  CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`produksatid`) REFERENCES `satuan` (`satid`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `produk` */

/*Table structure for table `satuan` */

DROP TABLE IF EXISTS `satuan`;

CREATE TABLE `satuan` (
  `satid` int(11) NOT NULL AUTO_INCREMENT,
  `satnama` varchar(20) DEFAULT NULL,
  `satqty` int(11) DEFAULT 1,
  PRIMARY KEY (`satid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `satuan` */

insert  into `satuan`(`satid`,`satnama`,`satqty`) values 
(1,'-',1);

/*Table structure for table `stok` */

DROP TABLE IF EXISTS `stok`;

CREATE TABLE `stok` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `stokprodukid` bigint(20) DEFAULT NULL,
  `stokjml` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stokprodukid` (`stokprodukid`),
  CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`stokprodukid`) REFERENCES `produk` (`produkid`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `stok` */

/*Table structure for table `stokmasuk` */

DROP TABLE IF EXISTS `stokmasuk`;

CREATE TABLE `stokmasuk` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tglmasuk` datetime DEFAULT NULL,
  `userinput` char(20) DEFAULT NULL,
  `stokprodukid` bigint(20) DEFAULT NULL,
  `jml` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stokprodukid` (`stokprodukid`),
  CONSTRAINT `stokmasuk_ibfk_1` FOREIGN KEY (`stokprodukid`) REFERENCES `produk` (`produkid`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `stokmasuk` */

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `supid` int(11) NOT NULL AUTO_INCREMENT,
  `supnm` varchar(200) DEFAULT NULL,
  `supalamat` varchar(200) DEFAULT NULL,
  `suptelp` char(20) DEFAULT NULL,
  PRIMARY KEY (`supid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `supplier` */

insert  into `supplier`(`supid`,`supnm`,`supalamat`,`suptelp`) values 
(1,'-',NULL,NULL);

/*Table structure for table `tempjual` */

DROP TABLE IF EXISTS `tempjual`;

CREATE TABLE `tempjual` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tempnota` char(20) DEFAULT NULL,
  `temptgl` datetime DEFAULT NULL,
  `tempkode` char(50) DEFAULT NULL,
  `tempsatid` int(11) DEFAULT NULL,
  `tempsatqty` int(11) DEFAULT NULL,
  `tempqty` int(11) DEFAULT NULL,
  `tempharga` double DEFAULT NULL,
  `tempsubtotal` double DEFAULT NULL,
  `tempuserinput` char(20) DEFAULT NULL,
  `temptokoid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tempjual` */

/*Table structure for table `toko` */

DROP TABLE IF EXISTS `toko`;

CREATE TABLE `toko` (
  `tokoid` int(11) NOT NULL AUTO_INCREMENT,
  `tokonama` varchar(100) DEFAULT NULL,
  `tokoalamat` varchar(100) DEFAULT NULL,
  `tokotelp` varchar(50) DEFAULT NULL,
  `tokopemilik` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tokoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `toko` */

/* Trigger structure for table `detailpembelian` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_insert_detailpembelian` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_insert_detailpembelian` AFTER INSERT ON `detailpembelian` FOR EACH ROW BEGIN
	update pembelian set belitotal = belitotal + new.detailbelisubtotal where belinota = new.detailbelinota;
    END */$$


DELIMITER ;

/* Trigger structure for table `detailpembelian` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_delete_detailpembelian` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_delete_detailpembelian` AFTER DELETE ON `detailpembelian` FOR EACH ROW BEGIN
	UPDATE stok a, produk b, satuan c, kategori d SET stokjml = stokjml - (old.detailbeliqty * old.detsatqty) WHERE a.stokprodukid=b.produkid AND
	b.produksatid=c.satid and d.katid=b.produkkatid AND b.produkkode=old.detailbelikode and d.katket='-';
	
	UPDATE pembelian SET belitotal = belitotal - old.detailbelisubtotal WHERE belinota = old.detailbelinota;
    END */$$


DELIMITER ;

/* Trigger structure for table `detailpenjualan` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_insert_detailpenjualan` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_insert_detailpenjualan` AFTER INSERT ON `detailpenjualan` FOR EACH ROW BEGIN
	UPDATE stok a, produk b, satuan c, kategori d SET stokjml = stokjml - (new.detjualqty * new.detjualsatqty) WHERE a.stokprodukid=b.produkid AND
	b.produksatid=c.satid AND d.katid=b.produkkatid AND b.produkkode=new.detjualprodukkode AND d.katket='-';
    
    END */$$


DELIMITER ;

/* Trigger structure for table `detailpenjualan` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_delete_detailpenjualan` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_delete_detailpenjualan` AFTER DELETE ON `detailpenjualan` FOR EACH ROW BEGIN
	UPDATE stok a, produk b, satuan c, kategori d SET stokjml = stokjml + (old.detjualqty * old.detjualsatqty) WHERE a.stokprodukid=b.produkid AND
	b.produksatid=c.satid AND d.katid=b.produkkatid AND b.produkkode=old.detjualprodukkode AND d.katket='-';
    END */$$


DELIMITER ;

/* Trigger structure for table `produk` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_insert_stok` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_insert_stok` AFTER INSERT ON `produk` FOR EACH ROW BEGIN
	insert into stok(stokprodukid,stokjml) values(new.produkid,0);
    END */$$


DELIMITER ;

/* Trigger structure for table `tempjual` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_insert_tempjual` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_insert_tempjual` AFTER INSERT ON `tempjual` FOR EACH ROW BEGIN
	UPDATE stok a, produk b, satuan c, kategori d SET stokjml = stokjml - (new.tempqty * new.tempsatqty) WHERE a.stokprodukid=b.produkid AND
	b.produksatid=c.satid AND d.katid=b.produkkatid AND b.produkkode=new.tempkode AND d.katket='-';
    
    END */$$


DELIMITER ;

/* Trigger structure for table `tempjual` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_delete_tempjual` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_delete_tempjual` AFTER DELETE ON `tempjual` FOR EACH ROW BEGIN
UPDATE stok a, produk b, satuan c, kategori d SET stokjml = stokjml + (old.tempqty * old.tempsatqty) WHERE a.stokprodukid=b.produkid AND
	b.produksatid=c.satid AND d.katid=b.produkkatid AND b.produkkode=old.tempkode AND d.katket='-';
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
