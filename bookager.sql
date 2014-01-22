
-- 
-- Database: `bookager`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `bookmarks`
-- 

CREATE TABLE `bookmarks` (
  `id` varchar(13) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(2048) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;