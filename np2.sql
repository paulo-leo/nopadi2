-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 30-Abr-2021 às 20:25
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
-- Estrutura da tabela `fin_accounts`
--

DROP TABLE IF EXISTS `fin_accounts`;
CREATE TABLE IF NOT EXISTS `fin_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `bank_code` varchar(5) NOT NULL,
  `agency` int(6) NOT NULL,
  `type` int(1) NOT NULL,
  `number` int(10) NOT NULL,
  `digit` int(3) NOT NULL,
  `total` float(15,2) DEFAULT '0.00',
  `status` int(1) DEFAULT '0',
  `branche_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fin_accounts`
--

INSERT INTO `fin_accounts` (`id`, `name`, `bank_code`, `agency`, `type`, `number`, `digit`, `total`, `status`, `branche_id`) VALUES
(1, 'Conta central', '237', 2030, 1, 254600545, 13, 0.00, 1, 1),
(7, 'BB', '745', 555, 3, 5555, 9, 0.00, 0, 2),
(8, 'BB2', '001', 278, 3, 442, 8, 0.00, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_branches`
--

DROP TABLE IF EXISTS `fin_branches`;
CREATE TABLE IF NOT EXISTS `fin_branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(1) NOT NULL DEFAULT '2',
  `tax_type` int(1) DEFAULT '1',
  `site` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_zip_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_number` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_public_place` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_district` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_city` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_state` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `created_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `fin_branches`
--

INSERT INTO `fin_branches` (`id`, `code`, `name`, `type`, `tax_type`, `site`, `phone`, `address_zip_code`, `address_number`, `address_public_place`, `address_district`, `address_city`, `address_state`, `status`, `created_in`) VALUES
(1, '', 'Rio de Janeiro', 1, 1, '', ' 2122230397', '', '', '', '', 'Rio de Janeiro', 'RJ', 1, NULL),
(2, '', 'São Paulo', 2, 2, '', ' 113138-6120', '', '', '', '', 'São Paulo', 'SP', 1, NULL),
(3, '2554455655', 'Russel Serviços - RS', 2, 3, '', '', '', '', '', '', 'Porto Alegre', 'RS', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_groups`
--

DROP TABLE IF EXISTS `fin_groups`;
CREATE TABLE IF NOT EXISTS `fin_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `subtype` int(1) DEFAULT '1',
  `group_order` int(3) DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  `month_value` int(10) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `fin_groups`
--

INSERT INTO `fin_groups` (`id`, `name`, `description`, `type`, `subtype`, `group_order`, `status`, `month_value`, `group_id`) VALUES
(12, 'Alimentação', '', 5, 1, 1, 1, NULL, NULL),
(10, 'Escritório', '', 2, 7, 1, 1, NULL, NULL),
(23, 'Marketing', NULL, 2, 4, 1, 1, NULL, NULL),
(13, 'Uniformes', '', 5, 1, 1, 2, NULL, NULL),
(15, 'Mercadorias', NULL, 2, 1, 1, 1, NULL, NULL),
(16, 'FGTS', NULL, 2, 1, 1, 1, NULL, NULL),
(17, 'Contrato 675', NULL, 1, 1, 1, 1, NULL, NULL),
(18, 'CMS', NULL, 2, 1, 1, 1, NULL, NULL),
(19, '660 Trimak Engenharia', NULL, 1, 1, 1, 1, NULL, NULL),
(20, '772 Globo TV', NULL, 1, 1, 1, 1, NULL, NULL),
(21, 'Folha de Pagamento', NULL, 2, 3, 1, 1, NULL, NULL),
(22, 'INSS', NULL, 2, 5, 1, 1, NULL, NULL),
(24, 'Teste DRE', NULL, 2, 8, 1, 1, NULL, NULL),
(25, 'Teste', NULL, 2, 6, 1, 1, NULL, NULL),
(26, 'Salário', NULL, 2, 1, 1, 1, NULL, NULL),
(27, 'Diária', NULL, 2, 8, 1, 1, NULL, NULL),
(28, '13 Salário', NULL, 2, 2, 1, 1, NULL, NULL),
(29, 'Rescisão ', NULL, 2, 2, 1, 1, NULL, NULL),
(30, 'Vale alimentação', NULL, 2, 3, 1, 1, NULL, NULL),
(31, 'Vale transporte', NULL, 2, 3, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_items`
--

DROP TABLE IF EXISTS `fin_items`;
CREATE TABLE IF NOT EXISTS `fin_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qtd` int(10) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_orders`
--

DROP TABLE IF EXISTS `fin_orders`;
CREATE TABLE IF NOT EXISTS `fin_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `classification` int(2) DEFAULT '1',
  `delivery_forecast` datetime DEFAULT NULL,
  `created_in` datetime NOT NULL,
  `updated_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_products`
--

DROP TABLE IF EXISTS `fin_products`;
CREATE TABLE IF NOT EXISTS `fin_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branche_id` int(11) DEFAULT NULL,
  `provider_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `total` int(10) DEFAULT NULL,
  `max` int(10) DEFAULT NULL,
  `min` int(10) DEFAULT NULL,
  `price` float(16,2) DEFAULT NULL,
  `measured_unit` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `watch_stock` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `online_sale` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT 'off',
  `sell_product` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `created_in` datetime NOT NULL,
  `updated_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `fin_products`
--

INSERT INTO `fin_products` (`id`, `type`, `name`, `description`, `status`, `code`, `branche_id`, `provider_id`, `group_id`, `user_id`, `tax_id`, `total`, `max`, `min`, `price`, `measured_unit`, `watch_stock`, `online_sale`, `sell_product`, `image`, `album_id`, `created_in`, `updated_in`) VALUES
(1, 'product', 'Camisa Branca', 'description', 'active', '', 1, 3, 10, 13, NULL, 0, 1, 1, 33.55, 'un', 'on', 'off', 'on', NULL, NULL, '2021-02-27 14:00:43', '2021-02-27 14:00:43'),
(2, 'product', 'Camisa verde', 'description', 'active', '123', 1, 3, 10, 13, NULL, 0, 1, 1, 33.55, 'un', 'on', 'off', 'on', NULL, NULL, '2021-02-27 14:37:45', '2021-02-27 14:37:45'),
(3, 'product', 'Camisa Rosa', 'description', 'active', '12344', 1, 3, 10, 13, NULL, 10, 15, 5, 33.55, 'un', 'on', 'off', 'on', NULL, NULL, '2021-02-27 14:39:22', '2021-02-27 14:39:22'),
(4, 'product', 'Camisa Rosa', 'description', 'active', '12344', 2, 3, 10, 13, NULL, 10, 15, 5, 33.55, 'un', 'on', 'off', 'on', NULL, NULL, '2021-02-27 14:39:34', '2021-02-27 14:39:34'),
(5, 'product', 'Camisa Laranja', 'description', 'disabled', '', 1, 3, 10, 13, NULL, 0, 1, 1, 10.67, 'un', 'on', 'off', 'off', NULL, NULL, '2021-02-27 14:53:04', '2021-02-27 14:53:04'),
(6, 'product', 'Teste', 'description', 'disabled', '', 1, 3, 12, 13, NULL, 0, 1, 1, 1.75, 'un', 'on', 'off', 'off', NULL, NULL, '2021-02-27 16:40:23', '2021-02-27 16:40:23'),
(7, 'product', 'Paulo teste', 'description', 'disabled', '', 1, 3, 10, 13, NULL, 0, 1, 1, 12.00, 'un', 'on', 'off', 'off', NULL, NULL, '2021-02-27 16:41:56', '2021-02-27 16:41:56'),
(8, 'product', 'Camisa Branca', 'description', 'disabled', '', 2, 3, 10, 13, NULL, 0, 1, 1, 10.30, 'un', 'on', 'off', 'off', NULL, NULL, '2021-02-27 17:37:33', '2021-02-27 17:37:33'),
(9, 'product', 'Camisa do vasco', 'description', 'disabled', '100134', 1, 3, 10, 13, NULL, 12, 20, 15, 25.67, 'un', 'on', 'off', 'off', NULL, NULL, '2021-02-27 19:17:07', '2021-02-27 19:17:07'),
(10, 'product', 'Teste 2', 'description', 'disabled', '223', 1, 3, 10, 13, NULL, 22, 18, 7, 18.05, 'un', 'on', 'off', 'off', NULL, NULL, '2021-02-27 20:05:48', '2021-02-27 20:05:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_providers`
--

DROP TABLE IF EXISTS `fin_providers`;
CREATE TABLE IF NOT EXISTS `fin_providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT '1',
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_zip_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_number` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_public_place` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_district` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_city` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_state` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `fin_providers`
--

INSERT INTO `fin_providers` (`id`, `type`, `code`, `name`, `site`, `phone`, `address_zip_code`, `address_number`, `address_public_place`, `address_district`, `address_city`, `address_state`, `status`, `created_in`) VALUES
(3, 1, '', 'Loja de EPI', '', '', '', '', '', '', '', 'RJ', 1, NULL),
(6, 2, '', 'Trimak', '', '', '', '', '', '', '', 'AC', 1, '2021-03-31 16:39:34'),
(7, 1, '', 'MKT Engenharia', '', '', '', '', '', '', '', 'AC', 1, '2021-03-31 16:39:36'),
(11, 4, '', 'MK', '', '', '', '', '', '', '', 'AC', 1, '2021-04-22 15:53:55');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_titles`
--

DROP TABLE IF EXISTS `fin_titles`;
CREATE TABLE IF NOT EXISTS `fin_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT '1',
  `code` varchar(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `verification_code` varchar(20) DEFAULT NULL,
  `due_date` datetime NOT NULL,
  `emission_date` datetime NOT NULL,
  `payment_date` datetime DEFAULT NULL,
  `prediction_date` datetime DEFAULT NULL,
  `competence_date` datetime DEFAULT NULL,
  `authorization_date` datetime DEFAULT NULL,
  `cancellation_date` datetime DEFAULT NULL,
  `value` float(10,2) NOT NULL,
  `pis` float(10,2) DEFAULT '0.00',
  `cofins` float(10,2) DEFAULT '0.00',
  `csll` float(10,2) DEFAULT '0.00',
  `irrf` float(10,2) DEFAULT '0.00',
  `inss` float(10,2) DEFAULT '0.00',
  `iss` float(10,2) DEFAULT '0.00',
  `value_final` float(10,2) DEFAULT '0.00',
  `user_id` int(11) NOT NULL,
  `branche_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `group1_id` int(11) DEFAULT '0',
  `group2_id` int(11) DEFAULT '0',
  `group3_id` int(11) DEFAULT '0',
  `payment_type` int(2) DEFAULT '0',
  `description` varchar(250) DEFAULT NULL,
  `created_in` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fin_titles`
--

INSERT INTO `fin_titles` (`id`, `type`, `code`, `status`, `verification_code`, `due_date`, `emission_date`, `payment_date`, `prediction_date`, `competence_date`, `authorization_date`, `cancellation_date`, `value`, `pis`, `cofins`, `csll`, `irrf`, `inss`, `iss`, `value_final`, `user_id`, `branche_id`, `account_id`, `participant_id`, `group1_id`, `group2_id`, `group3_id`, `payment_type`, `description`, `created_in`) VALUES
(13, 1, '5757', 1, NULL, '2021-04-22 00:00:00', '2021-04-17 00:00:00', NULL, NULL, NULL, NULL, NULL, 589.00, 30.00, 15.33, 7.58, 40.00, 7.55, 89.00, 0.00, 13, 2, 8, 3, 20, 15, 0, 0, NULL, '2021-01-17 15:48:44'),
(15, 1, '7780', 7, NULL, '2021-04-22 00:00:00', '2021-04-17 00:00:00', NULL, NULL, NULL, '2021-04-21 13:42:00', NULL, 788.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 13, 2, 8, 3, 0, 15, 0, 0, NULL, '2021-04-17 15:40:44'),
(16, 1, '67868', 2, NULL, '2021-04-12 00:00:00', '2021-04-18 00:00:00', NULL, NULL, NULL, '2021-04-21 13:24:38', NULL, 4544.55, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 13, 1, 8, 3, 19, 15, 0, 0, '', '2021-04-18 12:18:36'),
(17, 1, '77', 2, NULL, '2021-04-20 00:00:00', '2021-04-18 00:00:00', NULL, NULL, NULL, '2021-04-21 13:24:33', NULL, 495.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 13, 1, 1, 3, 0, 16, 0, 0, '', '2021-04-18 00:55:22'),
(18, 1, '98.59', 2, NULL, '2021-04-22 00:00:00', '2021-04-17 00:00:00', NULL, NULL, NULL, '2021-04-20 16:14:55', NULL, 78.49, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 13, 2, 8, 3, 0, 15, 0, 0, NULL, '2021-04-17 15:40:44'),
(19, 1, '67868', 4, NULL, '2021-04-12 00:00:00', '2021-04-18 00:00:00', '2021-04-22 00:00:00', NULL, NULL, '2021-04-21 13:24:29', NULL, 4544.55, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 13, 1, 8, 3, 0, 15, 0, 0, '', '2021-04-18 12:18:36'),
(20, 1, '5786783678', 7, NULL, '2021-04-14 00:00:00', '2021-04-19 00:00:00', NULL, NULL, NULL, '2021-04-20 14:24:55', NULL, 66.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 13, 1, 8, 3, 19, 18, 0, 0, '', '2021-04-19 16:27:24'),
(21, 2, '578787', 2, NULL, '2021-04-22 00:00:00', '2021-04-21 00:00:00', NULL, NULL, NULL, NULL, NULL, 1521.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 13, 1, 1, 3, 0, 16, 0, 0, '', '2021-04-21 12:39:10'),
(22, 2, '5857', 2, NULL, '2021-04-12 00:00:00', '2021-04-18 00:00:00', NULL, NULL, NULL, '2021-04-21 13:24:38', NULL, 4544.55, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 13, 1, 8, 3, 19, 15, 0, 0, '', '2021-04-18 12:18:36'),
(23, 1, '454465', 1, NULL, '2021-04-23 00:00:00', '2021-04-22 00:00:00', NULL, NULL, NULL, NULL, NULL, 10555.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 13, 1, 1, 6, 19, 21, 0, 0, '', '2021-04-22 15:36:55'),
(24, 2, '574457', 1, NULL, '2021-04-22 00:00:00', '2021-04-17 00:00:00', NULL, NULL, NULL, NULL, NULL, 175.58, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 13, 2, 8, 3, 20, 15, 0, 0, NULL, '2021-02-17 15:48:44'),
(14, 2, '45545778', 1, NULL, '2021-04-22 00:00:00', '2021-04-17 00:00:00', NULL, NULL, NULL, NULL, NULL, 589.00, 45.00, 55.00, 44.00, 45.00, 7.55, 77.00, 0.00, 13, 2, 8, 3, 20, 15, 0, 0, NULL, '2021-04-17 15:48:44');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(9, 13, 'recover', 'used', '2020-12-23 02:02:15', '9e05a0c376aa98b190fa7df0d473eea0'),
(10, 13, 'recover', 'active', '2021-03-09 11:34:41', '49817d968e631e2d5475d64556ce8a86'),
(11, 13, 'remember', 'active', '2021-04-15 09:12:29', '69857c7a6b8b2a5e8f803202a462d35f'),
(12, 13, 'remember', 'active', '2021-04-21 09:39:23', 'a084a21d04457a866a50734d22754675'),
(13, 13, 'remember', 'active', '2021-04-26 09:17:12', '239a38818c8d6885e477d3ee10fa825f'),
(14, 13, 'remember', 'active', '2021-04-30 10:59:43', 'f09d174a73ab4dd1f4e48d8067cb115c');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'public',
  `password` varchar(62) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accept_terms` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off',
  `email_marketing` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT 'off',
  `theme` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'black',
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'America/Sao_Paulo',
  `autobiography` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_in` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `role`, `sector`, `name`, `email`, `lang`, `image`, `status`, `privacy`, `password`, `accept_terms`, `email_marketing`, `theme`, `timezone`, `autobiography`, `created_in`) VALUES
(13, 'admin', NULL, 'Paulo Leonardo', 'pauloleonardo.rio@gmail.com', 'pt-br', 'uploads/avatar/IMG_c51ce410c124a10e0db5e4b97fc2af39.jpg', 'active', 'public', '$2y$10$FctPPYhG4gxOjgym9Dp1OOwH0vTxXAY8m9GTpFSYkT5PWYTNDI1Dm', 'off', 'off', 'black', '', '', '2020-07-26 15:57:29'),
(23, 'admin', NULL, 'Hugo Leonardo', 'hugoleonardo@russelservicos.com.br', 'pt-br', NULL, 'active', 'public', '$2y$10$FctPPYhG4gxOjgym9Dp1OOwH0vTxXAY8m9GTpFSYkT5PWYTNDI1Dm', 'off', 'off', 'black', '', '', '2021-01-27 21:23:37'),
(24, 'admin', NULL, 'Raphael Financeiro', 'gerencia.financeiro@russelservicos.com.br', 'pt-br', NULL, 'active', 'public', '$2y$10$FctPPYhG4gxOjgym9Dp1OOwH0vTxXAY8m9GTpFSYkT5PWYTNDI1Dm', 'off', 'off', 'black', '', '', '2021-01-27 21:25:15'),
(25, 'subscriber', NULL, 'Admin System', 'admin@russelservicos.com.br', 'pt-br', 'uploads/avatar/IMG_8e296a067a37563370ded05f5a3bf3ec.png', 'active', 'public', '$2y$10$/G5vyfxfi2ZvNTcP8OKZEOyc0tZ1DGLGI7cX6Y2rxtrCYkwzhwOSa', 'on', 'off', 'black', 'America/Fortaleza', NULL, '2021-02-18 10:48:01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
