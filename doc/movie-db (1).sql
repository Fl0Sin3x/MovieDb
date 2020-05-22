-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 22 mai 2020 à 12:12
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `movie-db`
--

-- --------------------------------------------------------

--
-- Structure de la table `award`
--

DROP TABLE IF EXISTS `award`;
CREATE TABLE IF NOT EXISTS `award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_id` int(11) DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8A5B2EE78F93B6FC` (`movie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `award`
--

INSERT INTO `award` (`id`, `movie_id`, `label`) VALUES
(1, 2, 'Oscar du Meilleur film 1998'),
(2, 2, 'Oscar du Meilleur réalisateur1998'),
(3, 2, 'Oscar du Meilleur montage 1998'),
(4, 4, 'Oscar des Meilleurs effets visuels 1980');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `label`) VALUES
(1, 'Science-fiction'),
(2, 'Aventure'),
(4, 'Thriller'),
(5, 'Horror'),
(6, 'Comédie'),
(7, 'Drame'),
(8, 'Comédie');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200512125421', '2020-05-12 12:56:12'),
('20200512130751', '2020-05-12 13:07:58'),
('20200512131228', '2020-05-12 13:12:35'),
('20200512131836', '2020-05-12 13:18:40'),
('20200513092153', '2020-05-13 09:22:49'),
('20200513093716', '2020-05-13 09:37:23'),
('20200513113357', '2020-05-13 11:34:04'),
('20200513120425', '2020-05-13 12:04:33'),
('20200513124159', '2020-05-13 12:42:05'),
('20200513125900', '2020-05-13 12:59:06'),
('20200513131918', '2020-05-13 13:19:24'),
('20200513132323', '2020-05-13 13:23:29'),
('20200513142451', '2020-05-13 14:24:57');

-- --------------------------------------------------------

--
-- Structure de la table `movie`
--

DROP TABLE IF EXISTS `movie`;
CREATE TABLE IF NOT EXISTS `movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `director_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` date NOT NULL,
  `image_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1D5EF26F899FB366` (`director_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `movie`
--

INSERT INTO `movie` (`id`, `director_id`, `title`, `release_date`, `image_filename`) VALUES
(1, 1, 'Avatar', '2010-09-01', 's-l1600-5ec3e7cea0f3d.jpeg'),
(2, 1, 'Titanic', '1998-01-07', '20051394-jpg-r-1920-1080-f-jpg-q-x-xxyxx-5ec3e977abd01.jpeg'),
(4, 1, 'Alien', '1979-09-12', '350947-poster-l-5ec3e6562ef21.jpeg'),
(8, 1, 'Le Seigneur des anneaux : Les Deux Tours', '2002-01-04', '517s5sH-kQL-AC-5ec3e89902963.jpeg'),
(9, 20, 'Le Seigneur des anneaux : Le Retour du roi', '2003-05-01', '18366630-5ec3e9448763a.jpeg'),
(10, 20, 'Le Seigneur des anneaux : La communauté de l\'anneau', '2001-12-02', '517s5sH-kQL-AC-5ec3e5b237178.jpeg'),
(25, 22, 'Star Wars, épisode IV : Un nouvel espoir', '1977-10-19', '18867130-jpg-r-1280-720-f-jpg-q-x-xxyxx-5ec4f6c472643.jpeg'),
(26, 22, 'Star Wars, épisode V : L\'Empire contre-attaque', '1980-08-20', 'Star-Wars-Episode-5-L-Empire-Contre-Attaque-5ec4f8ed7b86b.jpeg'),
(28, 22, 'Star Wars, épisode VI : Le Retour du Jedi', '1983-10-19', 'retour-jedi-poster-5ec4f98cd9eeb.jpeg'),
(29, 22, 'Star Wars, épisode I : La Menace fantôme', '1993-10-13', 'images-5ec4fa99d46c5.jpeg'),
(30, 22, 'Star Wars, épisode II : L\'Attaque des clones', '2002-05-17', 'star-wars-episode-ii-l-attaque-des-clones-5ec4fb2ada77b.jpeg'),
(31, 22, 'Star Wars, épisode III : La Revanche des Sith', '2005-05-18', '0093ba0d2a312241474d5f2fd9158459-5ec4fb86ccc29.jpeg'),
(32, 23, 'Star Wars : Le Réveil de la Force', '2015-12-16', 'images-1-5ec4fbdfa3c9a.jpeg'),
(33, 24, 'Star Wars, épisode VIII : Les Derniers Jedi', '2017-12-13', '51VRhXndEZL-5ec53d1ab60cd.jpeg'),
(34, 23, 'Star Wars, épisode IX : L\'Ascension de Skywalker', '2019-12-18', 'images-2-5ec4fcd849f37.jpeg'),
(35, 25, 'Heat', '1996-02-21', '51WBWWKN3WL-AC-SY445-5ec51fb676f53.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `movie_actor`
--

DROP TABLE IF EXISTS `movie_actor`;
CREATE TABLE IF NOT EXISTS `movie_actor` (
  `movie_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3A374C658F93B6FC` (`movie_id`),
  KEY `IDX_3A374C65217BBB47` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `movie_actor`
--

INSERT INTO `movie_actor` (`movie_id`, `person_id`, `id`, `character_name`) VALUES
(1, 2, 1, 'Netiri'),
(1, 3, 2, 'Grace'),
(2, 6, 3, 'Jack'),
(2, 7, 4, 'Rose'),
(4, 3, 7, 'Ellen'),
(35, 26, 86, 'Neil McCauley'),
(25, 27, 87, 'Luke Skywalker'),
(25, 28, 88, 'Han Solo'),
(35, 30, 89, 'Chris Shiherlis'),
(35, 29, 90, 'Le lieutenant Vincent Hanna'),
(10, 39, 91, 'Sam Gamegie'),
(10, 40, 92, 'Frond Sacquet'),
(9, 39, 93, 'Sam Gamegie'),
(9, 40, 94, 'Frond Sacquet'),
(8, 39, 95, 'Sam Gamegie'),
(8, 40, 96, 'Frond Sacquet'),
(32, 38, 97, 'Poe Dameron'),
(32, 31, 98, 'Princesse Leia'),
(32, 27, 99, 'Luke Skywalker'),
(32, 35, 100, 'Rey'),
(32, 37, 101, 'Kylo Ren'),
(32, 36, 102, 'Finn'),
(32, 28, 103, 'Han Solo'),
(29, 34, 104, 'Anakin Skywalker'),
(29, 32, 105, 'Obi-Wan Kenoby'),
(29, 33, 106, 'Padmé Amidala'),
(30, 34, 107, 'Anakin Skywalker'),
(30, 32, 108, 'Obi-Wan Kenoby'),
(30, 33, 109, 'Padmé Amidala'),
(31, 34, 110, 'Anakin Skywalker'),
(31, 32, 111, 'Obi-Wan Kenoby'),
(31, 33, 112, 'Padmé Amidala'),
(25, 31, 113, 'Princesse Leia'),
(26, 28, 114, 'Han Solo'),
(26, 27, 115, 'Luc Skywalker'),
(26, 31, 116, 'Princesse Leia'),
(28, 28, 117, 'Han Solo'),
(28, 27, 118, 'Luc Skywalker'),
(28, 31, 119, 'Princesse Leia'),
(33, 35, 120, 'Rey'),
(33, 37, 121, 'Kylo Ren'),
(33, 36, 122, 'Finn'),
(33, 31, 123, 'Princesse Leia'),
(33, 38, 124, 'Poe Dameron');

-- --------------------------------------------------------

--
-- Structure de la table `movie_category`
--

DROP TABLE IF EXISTS `movie_category`;
CREATE TABLE IF NOT EXISTS `movie_category` (
  `movie_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`movie_id`,`category_id`),
  KEY `IDX_DABA824C8F93B6FC` (`movie_id`),
  KEY `IDX_DABA824C12469DE2` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `movie_category`
--

INSERT INTO `movie_category` (`movie_id`, `category_id`) VALUES
(1, 1),
(1, 2),
(2, 7),
(4, 1),
(4, 5),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(25, 1),
(25, 2),
(26, 1),
(26, 2),
(28, 1),
(28, 2),
(29, 1),
(29, 2),
(30, 1),
(30, 2),
(31, 1),
(31, 2),
(32, 1),
(32, 2),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(35, 4);

-- --------------------------------------------------------

--
-- Structure de la table `movie_person`
--

DROP TABLE IF EXISTS `movie_person`;
CREATE TABLE IF NOT EXISTS `movie_person` (
  `movie_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`movie_id`,`person_id`),
  KEY `IDX_CD1B4C038F93B6FC` (`movie_id`),
  KEY `IDX_CD1B4C03217BBB47` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `movie_post`
--

DROP TABLE IF EXISTS `movie_post`;
CREATE TABLE IF NOT EXISTS `movie_post` (
  `movie_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`movie_id`,`post_id`),
  KEY `IDX_A9EC4D808F93B6FC` (`movie_id`),
  KEY `IDX_A9EC4D804B89032C` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `movie_writer`
--

DROP TABLE IF EXISTS `movie_writer`;
CREATE TABLE IF NOT EXISTS `movie_writer` (
  `movie_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`movie_id`,`person_id`),
  KEY `IDX_6E6745F78F93B6FC` (`movie_id`),
  KEY `IDX_6E6745F7217BBB47` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `movie_writer`
--

INSERT INTO `movie_writer` (`movie_id`, `person_id`) VALUES
(1, 1),
(2, 1),
(4, 3),
(8, 1),
(9, 20),
(10, 20),
(25, 22),
(26, 22),
(28, 22),
(29, 22),
(30, 22),
(31, 22),
(32, 23),
(33, 24),
(34, 23),
(35, 25);

-- --------------------------------------------------------

--
-- Structure de la table `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `person`
--

INSERT INTO `person` (`id`, `name`, `birth_date`) VALUES
(1, 'James Cameron', '1954-08-16'),
(2, 'Zoe Saldana', '1978-06-19'),
(3, 'Sigourney Weaver', '1949-10-08'),
(4, 'James Gunn', '1970-08-05'),
(5, 'Chris Pratt', '1979-06-21'),
(6, 'Leonardo DiCaprio', '1974-11-11'),
(7, 'Kate Winslet', '1975-10-05'),
(8, 'Dan Abnett', '1965-10-12'),
(15, 'Jon Favreau', '1966-10-19'),
(19, 'Boris Rousseau', '1993-11-29'),
(20, 'Peter Jackson', '1961-10-31'),
(22, 'George Lucas', '1944-05-14'),
(23, 'J.J Abrams', '1966-06-27'),
(24, 'Rian Johnson', '1973-12-18'),
(25, 'Michael Mann', '1974-02-05'),
(26, 'Robert De Niro', '1943-08-17'),
(27, 'Mark Hamill', '1951-09-25'),
(28, 'Harrison Ford', '1942-07-13'),
(29, 'Al Pacino', '1940-04-25'),
(30, 'Val Kilmer', '1959-12-31'),
(31, 'Carrie Fisher', '1956-10-21'),
(32, 'Ewan McGregor', '1971-03-31'),
(33, 'Natalie Portman', '1981-06-09'),
(34, 'Hayden Christensen', '1981-04-19'),
(35, 'Daisy Ridley', '1992-04-10'),
(36, 'John Boyega', '1992-03-17'),
(37, 'Adam Driver', '1983-11-19'),
(38, 'Oscar Isaac', '1979-03-09'),
(39, 'Sean Astin', '1971-02-25'),
(40, 'Elijah Wood', '1981-01-28');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `created_at`) VALUES
(1, 'Meillleur film de SF !', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Itaque ducimus magni laborum reprehenderit, quisquam dolor repellat nam ipsa ullam, excepturi quod libero, deserunt doloribus corrupti vel maiores. Doloribus culpa ducimus hic cupiditate necessitatibus. Assumenda dolorem saepe earum, alias fuga veritatis nulla impedit quisquam id error incidunt! Neque aspernatur, fugit nemo laboriosam enim dignissimos facere labore laudantium officia itaque natus eligendi culpa quae possimus provident saepe odit, doloremque fugiat quos obcaecati quam vel. Necessitatibus dolorem laborum rerum delectus magni repudiandae commodi veritatis. Ut, maiores? Quisquam eligendi officia voluptates! Corporis eaque architecto, consectetur molestiae eos sint dolores, modi, voluptas mollitia officiis cumque a ratione atque! Eligendi quam voluptatibus modi perferendis distinctio ab necessitatibus similique in neque dolores ipsum eum incidunt vitae consectetur facilis, maiores dolore ullam aut odio aliquam aliquid voluptates. Numquam, dolorum vitae? Sint sunt harum odio neque fuga libero. Explicabo maiores magni, quaerat ad iusto eveniet neque exercitationem expedita commodi esse doloribus odio inventore voluptate dolore velit. Illum nostrum architecto, velit quo assumenda veniam tenetur quia laborum quos eos asperiores sunt beatae maiores quaerat facilis ipsa sapiente unde ducimus? Non repellat aliquid quos magni inventore molestiae cupiditate repellendus? Consequuntur accusantium quisquam labore soluta voluptates voluptas distinctio praesentium quo quae quasi.', '2020-01-06 00:00:00'),
(2, 'Le réalisateur vedette  : James Cameron', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quisquam a minima, commodi nulla molestias, esse corrupti animi neque quis assumenda eveniet, ullam quae iste ducimus modi repudiandae distinctio eum dolorem natus quos tempora aperiam. Nobis aliquid dolorum, mollitia voluptatem quasi quidem quisquam odio. Aperiam nam delectus aspernatur quos ab debitis consectetur dolor quasi iure velit? Deserunt blanditiis ullam vel officiis alias, necessitatibus corporis quam vitae voluptatem voluptate saepe explicabo earum similique nisi repudiandae quos non labore quibusdam perferendis, quaerat a, nesciunt quasi. Tenetur, possimus dicta. Eveniet laudantium recusandae reiciendis nihil deleniti rem! Earum vel blanditiis explicabo odio ad illum quod ullam? Quasi, velit repellendus alias veritatis aperiam iste corporis reprehenderit dolorum, cupiditate aliquam et quas asperiores mollitia magni nihil odio eos ducimus vel porro, quod laboriosam quis deleniti accusantium. Sed suscipit odit, praesentium molestias non consequuntur magni. Ea, natus maiores. Cum nulla esse modi asperiores deserunt quos quae, quis accusantium nam a aliquid obcaecati dolorem incidunt praesentium saepe optio rem tempore harum eveniet ratione, laboriosam dolorum fugit? Necessitatibus veritatis repellat inventore, dolorum amet ut qui impedit, facilis odit incidunt accusantium rerum omnis. Nihil doloribus voluptatum esse. Officia sed mollitia soluta esse quia. At aliquam, vel quidem facilis ipsum recusandae temporibus quas sed inventore distinctio praesentium. Velit ratione perspiciatis quisquam consectetur ad recusandae aliquid quaerat aspernatur dicta dolorum perferendis odio adipisci nihil autem, neque sapiente sit eligendi corporis iusto officia. Odio rem veritatis commodi architecto facilis aspernatur, illum quidem quaerat numquam facere dolor eos ullam aperiam qui tenetur neque dolorum soluta dolorem modi saepe provident quas tempore. Voluptatibus qui explicabo tenetur fugit illum repudiandae maxime, sit consequatur commodi officia ex, provident natus praesentium molestiae vitae eveniet et deserunt sapiente numquam voluptatum velit ducimus. Dolore nesciunt similique vitae possimus a, ipsum iusto, voluptatum culpa, quaerat veniam illo quibusdam voluptatem quis eaque delectus.', '2020-02-14 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `post_movie`
--

DROP TABLE IF EXISTS `post_movie`;
CREATE TABLE IF NOT EXISTS `post_movie` (
  `post_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`movie_id`),
  KEY `IDX_8A457E804B89032C` (`post_id`),
  KEY `IDX_8A457E808F93B6FC` (`movie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post_movie`
--

INSERT INTO `post_movie` (`post_id`, `movie_id`) VALUES
(1, 4),
(2, 1),
(2, 2),
(2, 4);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `award`
--
ALTER TABLE `award`
  ADD CONSTRAINT `FK_8A5B2EE78F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`);

--
-- Contraintes pour la table `movie`
--
ALTER TABLE `movie`
  ADD CONSTRAINT `FK_1D5EF26F899FB366` FOREIGN KEY (`director_id`) REFERENCES `person` (`id`);

--
-- Contraintes pour la table `movie_actor`
--
ALTER TABLE `movie_actor`
  ADD CONSTRAINT `FK_3A374C65217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `FK_3A374C658F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`);

--
-- Contraintes pour la table `movie_category`
--
ALTER TABLE `movie_category`
  ADD CONSTRAINT `FK_DABA824C12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DABA824C8F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `movie_person`
--
ALTER TABLE `movie_person`
  ADD CONSTRAINT `FK_CD1B4C03217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CD1B4C038F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `movie_post`
--
ALTER TABLE `movie_post`
  ADD CONSTRAINT `FK_A9EC4D804B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A9EC4D808F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `movie_writer`
--
ALTER TABLE `movie_writer`
  ADD CONSTRAINT `FK_6E6745F7217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6E6745F78F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `post_movie`
--
ALTER TABLE `post_movie`
  ADD CONSTRAINT `FK_8A457E804B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8A457E808F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
