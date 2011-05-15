--
-- Table structure for table 'users'
--

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  surname varchar(128) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  sex enum('male','female') NOT NULL,
  born int(11) NOT NULL,
  dead int(11) NOT NULL,
  daughters int(11) NOT NULL,
  sons int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'users'
--

INSERT INTO users VALUES(1, 'Quam', 'Pellentesq', 'female', 485283421, 636012478, 0, 3);
INSERT INTO users VALUES(2, 'Nemo', 'Velit', 'female', 699546973, 884040323, 2, 1);
INSERT INTO users VALUES(3, 'Ipsam', 'Enim', 'female', 564782899, 977876553, 4, 2);
INSERT INTO users VALUES(4, 'Quia', 'Voluptatem', 'female', 531385976, 1126938311, 1, 2);
INSERT INTO users VALUES(5, 'Aspernatur', 'Voluptas', 'male', 912160292, 1220856236, 4, 4);
INSERT INTO users VALUES(6, 'Fugit', 'Odit', 'female', 764288459, 1242192466, 0, 0);
INSERT INTO users VALUES(7, 'Magni', 'Consequuntur', 'male', 549801111, 861429070, 3, 0);
INSERT INTO users VALUES(8, 'Ratione', 'Dolores', 'male', 795175162, 934906434, 4, 1);
INSERT INTO users VALUES(9, 'Nesciunt', 'Sequi', 'female', 769722764, 911582129, 4, 2);
INSERT INTO users VALUES(10, 'Tincidunt', 'Nunc', 'female', 866622869, 888463187, 4, 1);
INSERT INTO users VALUES(11, 'Vitae', 'Ante', 'female', 533976843, 1189942001, 3, 2);
INSERT INTO users VALUES(12, 'Auctor', 'Massa', 'male', 832520804, 1157833463, 2, 2);
INSERT INTO users VALUES(13, 'Wisi', 'Ornare', 'female', 473673618, 554978663, 0, 1);
INSERT INTO users VALUES(14, 'Proin', 'Metus', 'female', 796257946, 1055601838, 4, 2);
INSERT INTO users VALUES(15, 'Lacinia', 'Mattis', 'male', 494504989, 971518698, 2, 1);
INSERT INTO users VALUES(16, 'Erat', 'Justo', 'female', 746997549, 1087630571, 0, 0);
INSERT INTO users VALUES(17, 'Convallis', 'Volutpat', 'male', 651263786, 1222660486, 3, 4);
INSERT INTO users VALUES(18, 'Quidem', 'Harum', 'male', 1067544552, 1076427120, 1, 4);
INSERT INTO users VALUES(19, 'Facilis', 'Rerum', 'male', 1024387425, 1214538346, 1, 1);
INSERT INTO users VALUES(20, 'Distinctio', 'Expedita', 'male', 740121016, 1058420577, 1, 4);
INSERT INTO users VALUES(21, 'Elementum', 'Cras', 'male', 477589361, 962021477, 4, 1);
INSERT INTO users VALUES(22, 'Viverra', 'Duis', 'female', 1018826310, 1045786979, 4, 3);
INSERT INTO users VALUES(23, 'Phasellus', 'Diam', 'male', 939868746, 1089630912, 2, 4);
INSERT INTO users VALUES(24, 'Posuere', 'Vestibulum', 'male', 925628544, 1109165833, 2, 4);
INSERT INTO users VALUES(25, 'Tortor', 'Dapibus', 'male', 887878790, 998601788, 4, 3);
INSERT INTO users VALUES(26, 'Sociis', 'Sollicitudin', 'female', 581280692, 961172393, 0, 3);
INSERT INTO users VALUES(27, 'Penatibus', 'Natoque', 'female', 971345815, 1224846034, 0, 0);
INSERT INTO users VALUES(28, 'Montes', 'Parturient', 'female', 959311410, 1170456370, 2, 1);
INSERT INTO users VALUES(29, 'Ridiculus', 'Nascetur', 'male', 510860553, 954395343, 4, 3);
INSERT INTO users VALUES(30, 'Fusce', 'Maecenas', 'male', 879916084, 950313380, 2, 4);
INSERT INTO users VALUES(31, 'Risus', 'Consectetuer', 'male', 775098894, 1144078915, 0, 0);
INSERT INTO users VALUES(32, 'Nullam', 'Nunc', 'male', 588895852, 1118076679, 2, 4);
INSERT INTO users VALUES(33, 'Nonummy', 'Sapien', 'male', 822558735, 1134944082, 0, 0);
INSERT INTO users VALUES(34, 'Suspendisse', 'Lobortis', 'female', 539794989, 1106610695, 0, 4);
INSERT INTO users VALUES(35, 'Ultrices', 'Sagittis', 'male', 812129755, 820094342, 0, 2);
INSERT INTO users VALUES(36, 'Donec', 'Augue', 'female', 599958300, 1249799837, 0, 2);
INSERT INTO users VALUES(37, 'Ullamcorper', 'Ipsum', 'male', 581244135, 690469041, 2, 1);
INSERT INTO users VALUES(38, 'Mauris', 'Scelerisque', 'male', 813807822, 931771868, 1, 4);
INSERT INTO users VALUES(39, 'Felis', 'Dolor', 'male', 742805466, 1052682338, 2, 4);
INSERT INTO users VALUES(40, 'Tellus', 'Luctus', 'male', 620823293, 1177673473, 3, 0);
INSERT INTO users VALUES(41, 'Turpis', 'Null', 'male', 788873381, 899965348, 0, 2);
INSERT INTO users VALUES(42, 'Cursus', 'Magna', 'male', 694735244, 868309709, 4, 4);
INSERT INTO users VALUES(43, 'Suscipit', 'Amet', 'male', 529711069, 689982972, 1, 3);
INSERT INTO users VALUES(44, 'Minima', 'Interdum', 'female', 674967738, 1005778203, 0, 4);
INSERT INTO users VALUES(45, 'Quis', 'Veniam', 'male', 556654332, 1025927747, 2, 1);
INSERT INTO users VALUES(46, 'Exercitationem', 'Nostrum', 'male', 492442285, 827263177, 2, 1);
INSERT INTO users VALUES(47, 'Corporis', 'Ullam', 'male', 563368386, 1068966712, 1, 1);
INSERT INTO users VALUES(48, 'Nisi', 'Laboriosam', 'female', 621027399, 896576869, 2, 2);
INSERT INTO users VALUES(49, 'Commodi', 'Aliquid', 'female', 1023722128, 1040432941, 1, 4);
