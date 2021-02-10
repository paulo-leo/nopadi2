-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 09-Fev-2021 às 10:46
-- Versão do servidor: 5.7.26
-- versão do PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `np2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `charts`
--

DROP TABLE IF EXISTS `charts`;
CREATE TABLE IF NOT EXISTS `charts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` longtext COLLATE utf8mb4_unicode_ci,
  `date_open` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_end` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `charts`
--

INSERT INTO `charts` (`id`, `name`, `type`, `role`, `code`, `date_open`, `date_end`, `created_in`) VALUES
(1, 'Gráfico de usuários', 'doughnut', 'count', 'SELECT status as label,count(*) as total FROM users group by status', NULL, NULL, NULL),
(2, 'Gráfico de barras para os usuários', 'bar', 'sum', 'SELECT status as label,count(*) as total FROM users group by status', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `crm_accounts`
--

DROP TABLE IF EXISTS `crm_accounts`;
CREATE TABLE IF NOT EXISTS `crm_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prospecting_source` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_segment` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_linkedin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_website` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_zip_code` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_state` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_public_place` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_neighborhood` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_complement` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_in` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `crm_accounts`
--

INSERT INTO `crm_accounts` (`id`, `code`, `name`, `prospecting_source`, `company_name`, `company_segment`, `company_linkedin`, `company_website`, `company_phone`, `address_zip_code`, `address_number`, `address_state`, `address_public_place`, `address_neighborhood`, `address_city`, `address_complement`, `created_in`) VALUES
(1, '', '5c', 'linkedin', '', 'fdfbdf', '', '', '', '', '', '', '', '', '', '', '2021-02-04 21:47:42'),
(2, '17.890.253/0001-80', 'RUSSEL SERVICOS GERAIS EIRELI', 'linkedin', 'RUSSEL SERVICOS', 'Serviços', '', '', '', '20.051-011', '105', 'RJ', 'R DA CONCEICAO', 'CENTRO', 'RIO DE JANEIRO', 'SALA 1401', '2021-02-04 21:48:33');

-- --------------------------------------------------------

--
-- Estrutura da tabela `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_in` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tokens`
--

DROP TABLE IF EXISTS `tokens`;
CREATE TABLE IF NOT EXISTS `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_in` datetime DEFAULT NULL,
  `token` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `role`, `status`, `created_in`, `token`) VALUES
(1, 1, 'recover', 'active', '2020-07-11 17:46:24', '9dcfc470e086c9e75756f66534a2c5b5'),
(2, 5, 'recover', 'active', '2020-07-25 12:53:41', '165d706541dfc5eb29e0e15da0fff3a6'),
(3, 13, 'remember', 'active', '2020-08-09 12:57:48', '1cf9f0f45a2e37e1e8a5821781f5393d'),
(4, 13, 'recover', 'used', '2020-10-24 16:46:23', '099c19e36a5f49e131d8148def5227ae'),
(5, 13, 'recover', 'used', '2020-10-24 19:29:21', '9011862efedcaeed9dee935b44655daf'),
(6, 13, 'recover', 'used', '2020-10-24 19:33:12', 'bf3d9d85603a3aa2b3108fb976176f3b'),
(7, 13, 'recover', 'used', '2020-10-24 19:39:40', '26b3f59677856bd8e81d36833bb4b5c0'),
(8, 13, 'recover', 'used', '2020-10-24 19:52:08', '1d4b85975e7b68b2f2c2f5bc19fb6ca0'),
(9, 13, 'recover', 'used', '2020-12-23 02:02:15', '9e05a0c376aa98b190fa7df0d473eea0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(62) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_in` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `lang`, `image`, `status`, `password`, `created_in`) VALUES
(13, 'admin', 'Paulo Leonardo', 'pauloleonardo.rio@gmail.com', 'pt-br', '', 'active', '$2y$10$FctPPYhG4gxOjgym9Dp1OOwH0vTxXAY8m9GTpFSYkT5PWYTNDI1Dm', '2020-07-26 15:57:29'),
(23, 'partner', 'Marcos paulo', 'marco@russel.com', 'en', NULL, 'pending', '$2y$10$ee8l4FhhZXZ837fXDd.h9uYGzf2G9v9zkstrTSRXxhssKupXtO.Ie', '2021-01-27 21:23:37'),
(24, 'partner', 'Mais paulo', 'marcox@russel.com', 'pt-br', NULL, 'pending', '$2y$10$SzalPzEjwLbZHOf9lB9SHeJnw5uQt9KPTz.THdAGRnjM3wY4iKnrO', '2021-01-27 21:25:15');

-- --------------------------------------------------------

--
-- Estrutura da tabela `yebas`
--

DROP TABLE IF EXISTS `yebas`;
CREATE TABLE IF NOT EXISTS `yebas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parents` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meeting_point` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gooqle_map_html` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_booking` int(6) DEFAULT NULL,
  `price` float(15,2) DEFAULT NULL,
  `local_price` float(15,2) DEFAULT NULL,
  `image_id` bigint(20) DEFAULT NULL,
  `lang` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `demand` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT 'off',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `yebas`
--

INSERT INTO `yebas` (`id`, `user_id`, `name`, `uri`, `description`, `type`, `status`, `parents`, `city`, `meeting_point`, `gooqle_map_html`, `group_booking`, `price`, `local_price`, `image_id`, `lang`, `demand`) VALUES
(7, 13, 'Um bom Yebad', 'um-bom-yebad', 'Mais um Yeba para Você', 'script', 'active', 'Brasil', 'Rio de Janeiro', '', '', 0, 752.56, 89.00, 7, '', 'off'),
(9, 13, 'Tamnho 2', 'tamnho-2', 'tamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotamanhotaman', 'script', 'active', 'Brasil', 'São Paulo', '', '', 0, 45.54, 899.25, 37, '', 'off'),
(10, 13, 'Tetse', 'tetse', 'dfergrthty trbrtbtybttnt', 'script', 'active', 'EUA', 'Dallas', '', '', 0, 589.00, 0.00, 35, '', 'off'),
(12, 13, 'Meu Yeba', 'meu-yeba', 'cdfvdbvdfbfb', 'script', 'active', 'Brasil', 'Dallas', 'undefined', 'undefined', 0, 655.00, 6765.00, NULL, '', 'off'),
(14, 13, 'Paulo teste', 'paulo-teste1', 'Um yeba bom', 'script', 'active', 'Italia', 'Damasco', '', '', 1, 33.55, 44.55, 0, 'pt-br', 'on'),
(15, 13, 'O teste', 'o-teste1', 'mais voc é burro', 'script', 'active', 'Brasil', 'Niteroí', '', '', 1, 45.00, 55.00, 20, 'pt-br', 'on');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `yebas`
--
ALTER TABLE `yebas`
  ADD CONSTRAINT `yebas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
