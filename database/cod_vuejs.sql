-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 04 fév. 2024 à 16:14
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cod_vuejs`
--

-- --------------------------------------------------------

--
-- Structure de la table `api_messageries`
--

CREATE TABLE `api_messageries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_name` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `api_secret` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `api_messageries`
--

INSERT INTO `api_messageries` (`id`, `api_name`, `api_key`, `api_secret`, `created_at`, `updated_at`) VALUES
(2, 'Vonage', '03bfa716', '55rjMssDlYgYYOH9', '2023-08-02 13:40:22', '2023-08-02 13:40:22');

-- --------------------------------------------------------

--
-- Structure de la table `boutiques`
--

CREATE TABLE `boutiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `store_url` varchar(255) NOT NULL,
  `consumer_key` varchar(255) NOT NULL,
  `consumer_secret` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `boutiques`
--

INSERT INTO `boutiques` (`id`, `name`, `store_url`, `consumer_key`, `consumer_secret`, `user_id`, `type_id`, `created_at`, `updated_at`, `logo`) VALUES
(1, 'Local', 'https://www.google.com', 'ck_0e0e0e0e0e0e0e0e0e0e0e0e0e', 'cs_0e0e0e0e0e0e0e0e0e0e0e0e0e', 2, 1, NULL, '2023-05-25 21:18:23', 'local.png'),
(2, 'Mongadget', 'https://mongadget.ma', 'ck_9870b42d64ae42a4c2037447e6ce0faf390c593b', 'cs_ab065b8d89f8b89bd7855c4630d0cb4a47878dbd', 1, 2, NULL, '2023-06-22 11:09:53', 'mongadget.png'),
(4, 'Miimstore', 'https://miimstore.com', 'ck_21400bab70a48dbf4d7a0b068781c06467cf8474', 'cs_adfce4c995a2c6dab57bcb9cebe9fb1280bfabb2', 1, 2, '2023-05-22 13:40:39', '2023-07-07 07:36:02', 'woocommerce.png'),
(5, 'Test Mongadget', 'http://10.1.1.60:8001/', 'ck_1a96d23d2b1a0b7acee169a00b34164ee53c4746', 'cs_5bf0cacfdd5831a3bd03b6f78d203741156708ac', 2, 2, '2023-11-02 10:56:12', '2023-11-02 10:56:12', 'mongadget.png'),
(6, 'test', 'http://test.com', 'test', 'test', 11, 1, '2024-02-03 11:46:09', '2024-02-03 11:46:09', 'http://res.cloudinary.com/dhb6r9eoo/image/upload/v1706964368/dhzurvf84m9h4tekg69s.jpg'),
(8, 'test3', 'http://test3.com', 'test3', 'test3', 11, 1, '2024-02-04 12:56:07', '2024-02-04 12:56:07', 'test3.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `boutique_categorie`
--

CREATE TABLE `boutique_categorie` (
  `boutique_id` bigint(20) UNSIGNED NOT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `boutique_categorie`
--

INSERT INTO `boutique_categorie` (`boutique_id`, `categorie_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8);

-- --------------------------------------------------------

--
-- Structure de la table `boutique_types`
--

CREATE TABLE `boutique_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `boutique_types`
--

INSERT INTO `boutique_types` (`id`, `name`, `icon`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Local', 'http://res.cloudinary.com/dhb6r9eoo/image/upload/v1706962735/lkghqavsexvn7vsctnmo.png', 'Local Stores', NULL, '2023-05-18 10:18:13'),
(2, 'Woocommerce', 'http://res.cloudinary.com/dhb6r9eoo/image/upload/v1706961946/mc9tgcieet8a2hypxhai.png', 'Woocommerce sites', NULL, '2023-05-18 10:18:03'),
(3, 'Shopify', 'http://res.cloudinary.com/dhb6r9eoo/image/upload/v1706962785/vh4cmuyihs9ghhujhzih.png', 'Shopify Sites', NULL, '2023-05-18 10:18:23');

-- --------------------------------------------------------

--
-- Structure de la table `business_expenses`
--

CREATE TABLE `business_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `boutique_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `business_expenses`
--

INSERT INTO `business_expenses` (`id`, `montant`, `date`, `note`, `status`, `boutique_id`, `category_id`, `created_at`, `updated_at`) VALUES
(3, 1000, '2023-06-30', 'note', 'pending', 4, 3, '2023-07-14 12:08:21', '2023-07-14 12:08:21'),
(4, 1111, '2023-06-29', 'note456', 'canceled', 1, 3, '2023-07-21 15:01:58', '2023-07-21 15:01:58'),
(5, 9000, '2023-10-13', 'note567', 'approved', 4, 9, '2023-10-29 01:17:54', '2023-10-29 01:17:54');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'None', '2023-05-21 15:19:22', '2023-05-21 15:19:22'),
(2, 'Telephones', '2023-05-21 15:19:30', '2023-05-21 15:19:30'),
(3, 'Accessoire', '2023-05-21 15:19:37', '2023-05-26 19:22:06'),
(4, 'Mac os', '2023-05-21 15:19:52', '2023-05-21 15:19:52'),
(5, 'Ordinateurs', '2023-05-21 15:20:13', '2023-11-21 15:03:29'),
(6, 'Vetements', '2023-05-21 15:20:57', '2023-05-21 15:20:57'),
(7, 'Test', '2023-05-24 21:14:36', '2023-05-24 21:14:36'),
(8, 'Vetrines', '2023-05-25 10:21:56', '2023-11-21 15:00:03');

-- --------------------------------------------------------

--
-- Structure de la table `category_expenses`
--

CREATE TABLE `category_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type_depense_id` int(11) DEFAULT NULL,
  `parent_category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category_expenses`
--

INSERT INTO `category_expenses` (`id`, `titre`, `created_at`, `updated_at`, `type_depense_id`, `parent_category_id`) VALUES
(3, 'facebook ads', NULL, NULL, 1, 2),
(4, 'salaire', NULL, NULL, 2, 1),
(5, 'youtub ads', NULL, '2023-07-17 15:21:38', 2, 2),
(9, 'Local office', '2023-07-17 15:40:15', '2023-07-17 15:40:15', 1, 1),
(10, 'Abonnement telephone', '2023-07-17 15:40:46', '2023-07-17 15:40:46', 2, 2),
(11, 'Sms service', '2023-07-19 08:37:49', '2023-07-19 08:39:28', 2, 2),
(12, 'Sms', '2023-07-21 14:15:04', '2023-07-21 14:15:04', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `pays` varchar(255) NOT NULL,
  `boutique_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ville` varchar(255) NOT NULL,
  `type_payement` varchar(255) DEFAULT NULL,
  `is_blacklisted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `prenom`, `nom`, `email`, `telephone`, `adresse`, `pays`, `boutique_id`, `created_at`, `updated_at`, `ville`, `type_payement`, `is_blacklisted`) VALUES
(1, 'fanidii', 'kamal', 'mc67631685@gmail.com', '0601631300', 'rue adarissa', 'BR', 1, '2023-05-12 18:09:53', '2024-02-04 14:00:01', 'Rabat', 'Payement a la livraison', 0),
(2, 'client', 'client', 'client2@gmail.com', '212601631300', 'rue abdelmoumen', 'MA', 1, '2023-05-12 18:00:53', '2024-02-04 14:00:01', 'Casablanca', 'Payement a la livraison', 0),
(42, 'clienta', 'clientb', 'client1@gmail.com', '212601631300', 'adress1', 'MA', 1, '2023-05-29 13:46:08', '2024-02-04 14:00:01', 'Rabat', 'Payement par en ligne', 0),
(43, 'clientc', 'clientd', 'client4@gmail.com', '2120601631300', 'adress2', 'BR', 1, '2023-05-29 13:46:08', '2024-02-04 14:00:01', 'Marrakech', 'Payement par carte bancaire', 0),
(44, 'cliente', 'clientf', 'client5@gmail.com', '2120601631300', 'adress3', 'MA', 1, '2023-05-29 13:46:08', '2024-02-04 14:00:01', 'Casablanca', 'Payement a la livraison', 0);

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'processing',
  `total` double(8,2) NOT NULL DEFAULT 0.00,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `statut_livraison_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `bon_de_commande` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `status`, `total`, `client_id`, `created_at`, `updated_at`, `statut_livraison_id`, `bon_de_commande`) VALUES
(1, 'completed', 5120.00, 43, '2023-05-17 16:44:23', '2023-08-11 15:00:29', 1, ''),
(2, 'completed', 20000.00, 1, '2023-05-18 09:39:18', '2023-08-11 15:01:03', 3, ''),
(9, 'pending', 9000.00, 42, '2023-05-27 21:58:37', '2023-08-10 10:03:23', 1, ''),
(10, 'completed', 2000.00, 2, '2023-06-14 18:37:59', '2023-10-31 22:33:34', 5, ''),
(11, 'canceled', 4000.00, 1, '2023-08-11 12:19:29', '2023-08-11 12:19:29', 1, ''),
(12, 'completed', 2000.00, 1, '2023-08-11 12:20:10', '2024-06-14 15:01:02', 4, ''),
(48, 'processing', 11500.00, 43, '2023-09-01 06:37:17', '2023-09-01 06:37:17', 1, 'BC64f194ad36b61.pdf'),
(50, 'processing', 25000.00, 2, '2023-09-01 07:08:31', '2023-09-01 07:08:31', 1, 'BC64f19bffc2362.pdf'),
(51, 'processing', 6000.00, 42, '2023-09-14 08:32:13', '2023-09-14 08:32:13', 1, 'BC6502d31d7b1a7.pdf'),
(63, 'processing', 8000.00, 1, '2023-09-15 09:57:39', '2023-09-15 09:57:39', 1, 'BC650438a37995e.pdf'),
(64, 'refunded', 2000.00, 1, '2023-09-15 10:03:42', '2023-10-31 23:26:28', 1, 'BC65043a0e2b620.pdf'),
(65, 'processing', 7500.00, 1, '2023-09-15 10:06:35', '2023-09-15 10:06:35', 1, 'BC65043abbb40f9.pdf'),
(66, 'processing', 2000.00, 1, '2023-09-15 10:14:36', '2023-09-15 10:14:36', 1, 'BC65043c9ce0475.pdf'),
(68, 'completed', 2000.00, 1, '2023-09-15 10:24:13', '2024-06-14 15:01:33', 1, 'BC65043eddd7f22.pdf'),
(69, 'processing', 2000.00, 1, '2023-09-15 10:28:45', '2023-09-15 10:28:45', 1, 'BC65043fedb3e29.pdf'),
(79, 'completed', 6000.00, 1, '2024-01-29 15:11:53', '2024-01-29 15:23:56', 1, 'BC65b7ce4917726.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `commande_produit`
--

CREATE TABLE `commande_produit` (
  `commande_id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 1,
  `prix` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande_produit`
--

INSERT INTO `commande_produit` (`commande_id`, `produit_id`, `quantite`, `prix`, `created_at`, `updated_at`) VALUES
(9, 4, 4, 2000.00, '2023-08-10 10:03:23', '2023-08-10 10:03:23'),
(11, 1, 2, 2000.00, '2023-08-11 12:19:29', '2023-08-11 12:19:29'),
(1, 1, 1, 2000.00, '2023-08-11 15:00:29', '2023-08-11 15:00:29'),
(1, 4, 1, 2000.00, '2023-08-11 15:00:29', '2023-08-11 15:00:29'),
(2, 4, 5, 2000.00, '2023-08-11 15:01:03', '2023-08-11 15:01:03'),
(2, 1, 5, 2000.00, '2023-08-11 15:01:03', '2023-08-11 15:01:03'),
(48, 1, 2, 2000.00, '2023-09-01 06:37:17', '2023-09-01 06:37:17'),
(48, 25, 1, 7500.00, '2023-09-01 06:37:17', '2023-09-01 06:37:17'),
(50, 1, 1, 2000.00, '2023-09-01 07:08:31', '2023-09-01 07:08:31'),
(50, 26, 1, 2000.00, '2023-09-01 07:08:31', '2023-09-01 07:08:31'),
(50, 4, 3, 2000.00, '2023-09-01 07:08:31', '2023-09-01 07:08:31'),
(50, 25, 2, 7500.00, '2023-09-01 07:08:31', '2023-09-01 07:08:31'),
(51, 1, 1, 2000.00, '2023-09-14 08:32:13', '2023-09-14 08:32:13'),
(51, 26, 2, 2000.00, '2023-09-14 08:32:13', '2023-09-14 08:32:13'),
(63, 1, 1, 2000.00, '2023-09-15 09:57:39', '2023-09-15 09:57:39'),
(63, 5, 2, 3000.00, '2023-09-15 09:57:39', '2023-09-15 09:57:39'),
(65, 25, 1, 7500.00, '2023-09-15 10:06:35', '2023-09-15 10:06:35'),
(66, 4, 1, 2000.00, '2023-09-15 10:14:36', '2023-09-15 10:14:36'),
(69, 1, 1, 2000.00, '2023-09-15 10:28:45', '2023-09-15 10:28:45'),
(10, 1, 1, 2000.00, '2023-10-31 22:33:34', '2023-10-31 22:33:34'),
(64, 1, 1, 2000.00, '2023-10-31 23:26:28', '2023-10-31 23:26:28'),
(12, 4, 1, 2000.00, '2024-06-14 15:01:02', '2024-06-14 15:01:02'),
(68, 4, 1, 2000.00, '2024-06-14 15:01:33', '2024-06-14 15:01:33'),
(79, 1, 1, 2000.00, '2024-01-29 15:23:56', '2024-01-29 15:23:56'),
(79, 4, 2, 2000.00, '2024-01-29 15:23:56', '2024-01-29 15:23:56');

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `total` double NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'ferme',
  `payement_status` varchar(255) NOT NULL DEFAULT 'paye',
  `is_direct` tinyint(1) NOT NULL DEFAULT 0,
  `facture_type_id` int(11) NOT NULL,
  `boutique_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `factures`
--

INSERT INTO `factures` (`id`, `total`, `status`, `payement_status`, `is_direct`, `facture_type_id`, `boutique_id`, `created_at`, `updated_at`) VALUES
(23, 510, 'ferme', 'paye', 1, 7, 4, '2023-06-16 13:29:34', '2023-06-16 13:29:34'),
(29, 4200, 'ouvert', 'incomplet', 1, 2, 4, '2023-06-21 17:02:02', '2023-07-21 14:21:01'),
(31, 1800, 'ouvert', 'incomplet', 1, 4, 4, '2023-06-21 17:04:54', '2023-06-21 17:04:54'),
(34, 27000, 'ouvert', 'incomplet', 0, 14, 4, '2023-06-23 09:19:04', '2023-06-23 09:27:39'),
(35, 13350, 'ouvert', 'incomplet', 0, 15, 1, '2023-06-23 11:25:03', '2023-06-23 11:25:03'),
(37, 1000, 'ouvert', 'paye', 1, 5, 1, '2023-08-12 11:12:18', '2023-08-15 12:48:19'),
(38, 4000, 'ouvert', 'paye', 1, 6, 1, '2023-08-12 11:22:51', '2024-01-29 14:54:58'),
(39, 36000, 'ouvert', 'incomplet', 0, 17, 1, '2023-08-15 12:40:19', '2023-08-15 12:40:19'),
(40, 18000, 'ouvert', 'incomplet', 1, 7, 1, '2023-08-15 12:41:44', '2024-01-14 16:31:42'),
(41, 530, 'ferme', 'paye', 0, 18, 4, '2023-08-15 14:21:31', '2023-08-15 14:21:31'),
(42, 800, 'ferme', 'paye', 0, 19, 4, '2023-08-15 14:36:50', '2023-08-15 14:36:50'),
(44, 8100, 'ouvert', 'incomplet', 0, 21, 1, '2023-08-21 08:43:42', '2023-08-21 08:43:42'),
(45, 580, 'ferme', 'paye', 0, 22, 4, '2023-08-21 09:25:58', '2023-08-21 09:25:58'),
(47, 80910, 'ferme', 'paye', 0, 24, 4, '2023-08-28 08:45:06', '2023-08-28 08:48:26'),
(94, 12000, 'ouvert', 'incomplet', 1, 54, 1, '2024-02-04 12:36:39', '2024-02-04 12:36:39'),
(95, 6148, 'ouvert', 'paye', 1, 55, 2, '2024-02-04 12:58:28', '2024-02-04 13:00:04');

-- --------------------------------------------------------

--
-- Structure de la table `facture_direct`
--

CREATE TABLE `facture_direct` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `total` double NOT NULL DEFAULT 0,
  `pdf` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `facture_direct`
--

INSERT INTO `facture_direct` (`id`, `client`, `email`, `total`, `pdf`, `created_at`, `updated_at`) VALUES
(2, 'Mariam Coulibaly', 'yassinejrayfy35@gmail.com', 4200, 'F64933b1ab6d72.pdf', '2023-06-21 17:02:02', '2023-06-21 17:02:02'),
(4, 'Kissmanth chancelvina', 'assanikiss@gmail.com', 1800, 'F64933bc6a0220.pdf', '2023-06-21 17:04:54', '2023-06-21 17:04:54'),
(5, 'client client', 'client2@gmail.com', 1000, 'F64d777224c5c0.pdf', '2023-08-12 11:12:18', '2023-08-12 11:12:18'),
(6, 'fanidii kamal', 'fanidi@gmail.com', 4000, 'F64d7799bc4104.pdf', '2023-08-12 11:22:51', '2023-08-12 11:22:51'),
(7, 'client client', 'client2@gmail.com', 18000, 'F64db8098b1dbd.pdf', '2023-08-15 12:41:44', '2023-08-15 12:41:44'),
(9, 'Kissmanth chancelvina', 'assanikiss@gmail.com', 420, 'F64ec79c331a89.pdf', '2023-08-28 09:41:07', '2023-08-28 09:41:07'),
(54, 'fanidii kamal', 'mc67631685@gmail.com', 12000, 'F65bf92e7c374e.pdf', '2024-02-04 12:36:39', '2024-02-04 12:36:39'),
(55, 'Mohamed Madou', 'lgharibmohamed84@gmail.com', 6148, 'F65bf9804bc32b.pdf', '2024-02-04 12:58:28', '2024-02-04 12:58:28');

-- --------------------------------------------------------

--
-- Structure de la table `facture_indirect`
--

CREATE TABLE `facture_indirect` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facture_type_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'pr',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `facture_indirect`
--

INSERT INTO `facture_indirect` (`id`, `facture_type_id`, `type`, `created_at`, `updated_at`) VALUES
(14, 5, 'tr', '2023-06-23 09:19:04', '2023-06-23 09:19:04'),
(15, 23, 'tr', '2023-06-23 11:25:03', '2023-06-23 11:25:03'),
(17, 25, 'tr', '2023-08-15 12:40:19', '2023-08-15 12:40:19'),
(18, 4515, 'pr', '2023-08-15 14:21:31', '2023-08-15 14:21:31'),
(19, 4510, 'pr', '2023-08-15 14:36:50', '2023-08-15 14:36:50'),
(21, 29, 'tr', '2023-08-21 08:43:42', '2023-08-21 08:43:42'),
(22, 4517, 'pr', '2023-08-21 09:25:58', '2023-08-21 09:25:58'),
(24, 27, 'tr', '2023-08-28 08:45:06', '2023-08-28 08:45:06');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `name`, `adresse`, `telephone`, `type_id`, `created_at`, `updated_at`, `boutique_id`) VALUES
(1, 'Mariam Coulibaly', 'Kpg. Sukajadi No. 821', '0606060606', 1, '2023-05-22 14:34:06', '2023-05-22 14:34:06', 1),
(3, 'Mahamat Cherif', 'Yirimadio', '9999999999999', 1, '2023-05-28 16:56:30', '2023-05-28 16:56:30', 1),
(4, 'Awa doumbia', 'adresse1', '0678905543', 1, '2023-05-28 16:56:53', '2023-05-28 16:56:53', 1),
(5, 'Baba kone', 'Rue accra, ocean', '0678321223', 2, '2023-05-28 16:57:23', '2023-05-28 16:57:23', 1);

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur_marques`
--

CREATE TABLE `fournisseur_marques` (
  `fournisseur_id` bigint(20) UNSIGNED NOT NULL,
  `marque_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseur_marques`
--

INSERT INTO `fournisseur_marques` (`fournisseur_id`, `marque_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-05-22 14:40:45', '2023-05-22 14:40:45'),
(1, 2, '2023-05-22 14:40:30', '2023-05-22 14:40:30'),
(1, 5, '2023-06-09 14:24:04', '2023-06-09 14:24:04'),
(3, 1, '2023-05-28 16:58:15', '2023-05-28 16:58:15'),
(3, 3, '2023-06-23 10:58:54', '2023-06-23 10:58:54'),
(3, 4, '2023-05-28 16:58:03', '2023-05-28 16:58:03'),
(4, 2, '2023-05-28 16:58:32', '2023-05-28 16:58:32'),
(4, 3, '2023-05-28 16:58:43', '2023-05-28 16:58:43'),
(4, 4, '2023-05-28 16:58:56', '2023-05-28 16:58:56'),
(4, 5, '2023-05-28 19:08:18', '2023-05-28 19:08:18'),
(5, 1, '2023-05-28 19:03:03', '2023-05-28 19:03:03'),
(5, 2, '2023-05-28 16:59:17', '2023-05-28 16:59:17'),
(5, 3, '2023-05-28 16:59:41', '2023-05-28 16:59:41'),
(5, 5, '2023-05-28 19:08:29', '2023-05-28 19:08:29');

-- --------------------------------------------------------

--
-- Structure de la table `livreurs`
--

CREATE TABLE `livreurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` int(11) NOT NULL,
  `matricule` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `societeTransport_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livreurs`
--

INSERT INTO `livreurs` (`id`, `adresse`, `telephone`, `matricule`, `status`, `societeTransport_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Casablanca', 991633456, 'MT001', NULL, 2, 10, '2023-05-23 16:20:29', '2023-06-12 12:04:40'),
(3, 'Kpg. Sukajadi No. 821', 909090908, 'MT003', NULL, 3, 8, '2023-06-12 10:31:20', '2023-06-12 10:31:20'),
(4, 'Casablanca', 606060606, 'MT002', NULL, 2, 9, '2023-06-12 12:05:39', '2023-06-12 12:05:39'),
(5, 'Casablanca', 678905543, 'MT0058', NULL, 4, 12, '2023-07-07 08:42:31', '2023-08-12 18:45:04'),
(6, 'Marrakech', 606060606, 'MT099', NULL, 4, 13, '2023-08-13 19:45:16', '2023-08-13 19:45:16');

-- --------------------------------------------------------

--
-- Structure de la table `livreur_commandes`
--

CREATE TABLE `livreur_commandes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `livreur_id` bigint(20) UNSIGNED NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `statut_livraison_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livreur_commandes`
--

INSERT INTO `livreur_commandes` (`id`, `order_id`, `livreur_id`, `accepted`, `created_at`, `updated_at`, `statut_livraison_id`) VALUES
(1, 4514, 1, 1, '2023-06-12 12:22:38', '2023-08-10 23:08:57', 2),
(2, 4514, 4, 0, '2023-07-07 07:44:18', '2023-08-09 17:05:26', 1),
(3, 1889, 1, 1, '2023-07-07 08:16:34', '2023-08-10 11:12:04', 3),
(4, 1889, 4, 0, '2023-07-07 08:23:47', '2023-07-07 08:26:27', 1),
(5, 10, 5, 1, '2023-07-07 08:42:43', '2023-08-10 22:55:41', 5),
(6, 4515, 3, 0, '2023-07-21 14:23:46', '2023-07-31 07:16:15', 1),
(7, 2, 5, 1, '2023-07-28 09:36:54', '2023-08-10 22:57:05', 3),
(8, 12, 5, 1, '2023-08-15 12:32:21', '2023-08-15 13:05:10', 4),
(9, 4636, 1, -1, '2023-10-31 15:29:06', '2023-10-31 15:46:58', NULL),
(10, 4627, 1, 1, '2023-11-18 14:25:02', '2023-11-18 14:27:10', 3);

-- --------------------------------------------------------

--
-- Structure de la table `marques`
--

CREATE TABLE `marques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marques`
--

INSERT INTO `marques` (`id`, `name`, `description`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Lenovo', 'Marque lenovo', 'https://logodownload.org/wp-content/uploads/2014/09/lenovo-logo-0.png', '2023-05-22 14:34:34', '2023-06-19 09:26:04'),
(2, 'Samsung', 'Marque samsung', 'https://1000logos.net/wp-content/uploads/2017/06/Samsung-Logo-2.png', '2023-05-22 14:35:45', '2023-05-22 14:35:45'),
(3, 'Dell', 'Marque Dell', 'https://www.cip-paca.org/wp-content/uploads/2016/06/dell-logo.jpg', '2023-05-22 14:36:19', '2023-06-19 09:13:37'),
(4, 'Apple', 'Marque Apple', 'https://logos-marques.com/wp-content/uploads/2021/03/Apple-logo.png', '2023-05-22 14:36:42', '2023-05-22 14:36:42'),
(5, 'Hp', NULL, 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/HP_logo_2012.svg/1200px-HP_logo_2012.svg.png', '2023-05-28 19:07:37', '2023-08-11 11:32:33'),
(8, 'Robe', NULL, NULL, '2023-06-19 09:24:36', '2023-06-19 09:24:36');

-- --------------------------------------------------------

--
-- Structure de la table `messageries`
--

CREATE TABLE `messageries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_messagerie` varchar(255) NOT NULL,
  `template_id` bigint(20) UNSIGNED DEFAULT NULL,
  `api_messagerie_id` bigint(20) UNSIGNED DEFAULT NULL,
  `statut_livraison_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `recepteur` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messageries`
--

INSERT INTO `messageries` (`id`, `status_messagerie`, `template_id`, `api_messagerie_id`, `statut_livraison_id`, `created_at`, `updated_at`, `recepteur`, `titre`, `boutique_id`) VALUES
(1, 'en cours', 1, 2, 5, '2023-08-04 08:45:46', '2023-08-04 09:11:40', 'Client', 'Pas de reponse', 4),
(3, 'en cours', 4, 2, 6, '2023-08-04 14:30:17', '2023-08-07 10:43:49', 'Client', 'Colis perdu', 1),
(4, 'en cours', 1, 2, 5, '2023-08-07 08:50:08', '2023-08-07 08:50:08', 'Fournisseur', 'pas de reponse', 1),
(7, 'en cours', 9, 2, 6, '2023-08-15 12:29:34', '2023-08-15 12:29:34', 'Client', 'Rembourser', 4);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(37, '2014_10_12_000000_create_users_table', 1),
(38, '2014_10_12_100000_create_password_resets_table', 1),
(45, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(46, '2023_03_30_002504_create_boutiques_table', 1),
(47, '2023_05_07_122116_create_boutique_types_table', 1),
(48, '2023_05_10_165521_create_clients_table', 1),
(49, '2023_05_10_165540_create_commandes_table', 1),
(50, '2023_05_10_165549_create_produits_table', 1),
(51, '2023_05_10_165653_create_commande_produit_table', 1),
(58, '2023_05_10_171455_create_categories_table', 1),
(85, '2019_08_19_000000_create_failed_jobs_table', 1),
(86, '2023_05_10_171550_create_produit_categorie_table', 1),
(87, '2023_05_17_160323_create_boutique_categorie_table', 1),
(93, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(94, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(95, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(96, '2016_06_01_000004_create_oauth_clients_table', 2),
(97, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(115, '2023_06_02_111912_create_factures_table', 3),
(116, '2023_06_02_111933_create_payements_table', 3),
(117, '2023_05_22_160725_create_types_table', 4),
(118, '2023_05_22_160933_create_fournisseurs_table', 4),
(119, '2023_05_22_161023_create_marques_table', 4),
(120, '2023_05_22_161120_create_fournisseur_marques_table', 4),
(121, '2023_05_23_100501_transactions_create_table', 4),
(122, '2023_06_08_125638_create_societetransport_table', 5),
(123, '2023_06_08_220629_create_societetransports_table', 6),
(124, '2023_06_08_221515_create_societe_transports_table', 7),
(125, '2023_06_09_072911_create_livreurs_table', 8),
(126, '2023_06_11_075249_create_livreur_commandes_table', 9),
(127, '2023_06_12_090015_create_livreurs_table', 10),
(128, '2023_06_12_090130_create_livreur_commandes_table', 10),
(131, '2023_06_16_113159_create_facture_indirect_table', 11),
(132, '2023_06_16_113517_create_facture_direct_table', 11),
(133, '2023_06_19_104419_create_point_ventes_table', 12),
(134, '2023_06_19_145354_create_point_ventes_table', 13),
(135, '2023_06_20_134514_add_is_direct_column_to_factures_table', 14),
(136, '2023_06_23_114137_add_marque_id_column_to_produits_table', 15),
(137, '2023_06_23_124208_add_visible_column_to_transactions_table', 16),
(138, '2023_06_26_123532_add_boutique_id_column_to_marques_table', 17),
(139, '2023_07_07_154301_create_type_depenses_table', 17),
(140, '2023_07_07_154541_create_category_depenses_table', 17),
(141, '2023_07_07_154612_create_depenses_table', 17),
(142, '2023_07_09_174307_add_user_id_column_to_depenses_table', 18),
(143, '2023_07_10_132518_create_provided_table', 19),
(144, '2023_07_10_132630_create_category_expenses_table', 19),
(145, '2023_07_10_132850_create_provided_categorys_table', 19),
(146, '2023_07_10_132933_create_business_expenses_table', 19),
(147, '2023_07_10_132945_create_team_expenses_table', 19),
(148, '2023_07_10_154339_add_type_depense_id_column_to_category_expenses_table', 20),
(149, '2023_07_10_155649_add_type_depense_id_column_to_category_expenses_table', 21),
(150, '2023_07_10_161911_add_category_id_column_to_team_expenses_table', 22),
(151, '2023_07_13_105333_create_parent_categorys_table', 23),
(152, '2023_07_13_110159_add_parent_id_column_to_category_expenses_table', 24),
(153, '2023_07_13_110429_add_parent_id_column_to_provided_categorys_table', 24),
(154, '2023_07_13_111358_create_provided_parent_categorys_table', 25),
(155, '2023_07_13_162539_add_parent_category_id_column_to_category_expenses', 26),
(156, '2023_07_13_163214_drop_parent_id_column_from_category_expenses', 27),
(157, '2023_07_13_163425_add_parent_category_id_column_to_category_expenses', 28),
(158, '2023_07_13_163507_drop_parent_id_column_from_category_expenses', 28),
(159, '2023_07_24_130052_create_notifications_table', 29),
(160, '2023_07_24_164019_add_is_read_column_to_notifications_table', 30),
(161, '2023_07_28_092140_add_is_admin_read_column_to_notifications_table', 31),
(162, '2023_07_28_093634_add_is_admin_read_column_to_notifications_table', 32),
(166, '2023_07_31_101021_create_statut_livraisons_table', 33),
(167, '2023_07_31_101117_create_templates_table', 33),
(168, '2023_07_31_101228_create_api_messageries_table', 33),
(169, '2023_07_31_101808_create_messageries_table', 33),
(170, '2023_07_31_105216_add_statut_livraison_id_column_to_commandes_table', 33),
(171, '2023_07_31_105237_add_statut_livraison_id_column_to_livreur_commandes_table', 33),
(172, '2023_07_31_111251_add_recepteur_column_to_messageries_table', 34),
(173, '2023_07_31_115554_add_titre_column_to_messageries_table', 35),
(174, '2023_07_31_120540_add_boutique_id_column_to_messageries_table', 36),
(175, '2023_08_04_110305_drop_statut_livraison_id_column_from_commandes', 37),
(176, '2023_08_04_110431_add_statut_livraison_id_column_from_commande_produit_table', 38),
(177, '2023_08_04_112126_drop_statut_livraison_id_column_from_commande_produit', 39),
(178, '2023_08_04_112624_add_statut_livraison_id_column_from_commande_produit_table', 40),
(179, '2023_08_04_120540_drop_statut_livraison_id_column_from_commande_produit', 41),
(180, '2023_08_04_120707_add_statut_livraison_id_column_from_commandes_table', 42),
(181, '2023_08_11_131504_add_is_blacklisted_column_to_clients_table', 43),
(182, '2023_08_15_101722_create_produit_supprimes_table', 44),
(183, '2023_08_21_230436_add_bon_de_commande_column_to_commandes_table', 45),
(184, '2023_08_28_085715_add_produit_name_column_to_transactions_table', 46),
(185, '2023_10_18_114456_add_logo_to_boutiques_table', 47),
(186, '2024_01_14_091608_add_livreur_name_to_notifications_table', 48),
(187, '2024_02_01_102333_add_boutique_id_column_to_fournisseurs_table', 49);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_read` varchar(255) NOT NULL DEFAULT 'false',
  `is_admin_read` tinyint(1) NOT NULL DEFAULT 0,
  `livreur_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `created_at`, `updated_at`, `is_read`, `is_admin_read`, `livreur_name`) VALUES
(1, 1, 'A accepté la commande 4514', '2023-07-24 14:26:09', '2024-01-14 14:53:53', '1', 1, 'Baba Diallo'),
(6, 1, 'A accepté la commande 4515', '2023-07-31 07:16:15', '2024-01-14 14:53:53', '1', 1, 'Yassine Ouatassi'),
(8, 1, 'A refusé la commande 4514 .', '2023-08-09 18:33:36', '2024-01-14 14:23:34', '1', 1, 'Baba Diallo'),
(9, 1, 'A refusé la commande 4514 .', '2023-08-09 18:35:43', '2024-01-14 14:23:34', '1', 1, 'Baba Diallo'),
(10, 1, 'A accepté la commande 1889 .', '2023-08-09 18:38:22', '2024-01-14 14:23:34', '1', 1, 'Baba Diallo'),
(11, 1, 'A accepté la commande 4514 .', '2023-08-09 18:39:51', '2024-01-14 14:23:34', '1', 1, 'Baba Diallo'),
(12, 1, 'A accepté la commande 1889 .', '2023-08-09 18:41:58', '2024-01-14 14:23:34', '1', 1, 'Baba Diallo'),
(13, 2, 'A accepté la commande 10.', '2023-08-09 18:43:29', '2023-08-10 23:09:54', '1', 1, 'Ines'),
(14, 2, 'A accepté la commande 10 .', '2023-08-09 18:44:35', '2023-08-10 23:09:54', '1', 1, 'Ines'),
(25, 2, 'A accepté la commande 2 .', '2023-08-10 22:54:39', '2023-08-10 23:14:04', '1', 1, 'Ines'),
(26, 2, 'A accepté la commande 12 .', '2023-08-15 12:32:55', '2023-08-15 13:09:44', 'false', 1, 'Ines'),
(29, 1, 'A refusé la commande 4636 .', '2023-10-31 15:47:09', '2024-01-14 14:23:34', '1', 1, 'Baba Diallo'),
(30, 1, 'A accepté la commande 4627 .', '2023-11-18 14:26:01', '2024-01-14 14:23:34', '1', 1, 'Baba Diallo');

-- --------------------------------------------------------

--
-- Structure de la table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('060674d252939e6db332fad14ff8960b0e0712195f5bf4ffc29172d76f0157f4fef47bb5c27b5051', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:43:13', '2023-07-28 09:43:13', '2024-07-28 10:43:13'),
('0b4634c0969dae86e66df42717032e47996021752979d7f46c8c84b2d4d733fb9d8d2e805836958b', 8, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:27:18', '2023-07-21 14:27:18', '2024-07-21 15:27:18'),
('128d448072e91c5e45337b5135bca8a23d956f20f0f243cc44bad83e80a5a6b72193f34b22dc3151', 12, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:37:06', '2023-07-28 09:37:06', '2024-07-28 10:37:06'),
('14742ccc510828f1d23fabe82c15b1f711f97b12b6ccedb2240832cd876137c9f2799fa0b39184f1', 2, 1, 'MyAppToken', '[]', 0, '2023-07-31 06:13:03', '2023-07-31 06:13:03', '2024-07-31 07:13:03'),
('1b735fb2a8082001159b32a2d53af4abc7093b9009c5df0896654a460ca388ab9a4264409a0537bb', 2, 1, 'MyAppToken', '[]', 0, '2023-08-15 12:59:46', '2023-08-15 12:59:46', '2024-08-15 13:59:46'),
('1b78c443dfde010cb91462519a531da4d19fb951b5514da89e20cfad45ff3740f3c02975b4c7ee85', 2, 1, 'MyAppToken', '[]', 0, '2023-08-15 12:33:12', '2023-08-15 12:33:12', '2024-08-15 13:33:12'),
('201ca513d757511bfccb3abf08abcec6fa1b5ee999794861f030e4e1d4629d66d703ee2c2362bfa6', 12, 1, 'MyAppToken', '[]', 0, '2023-08-09 17:32:15', '2023-08-09 17:32:15', '2024-08-09 18:32:15'),
('2483a3c09569a16bfc66b970377f4b123d4c4440d0a8e96551ed0232d3440e39353f7791e91042ad', 12, 1, 'MyAppToken', '[]', 0, '2023-08-07 13:33:44', '2023-08-07 13:33:44', '2024-08-07 14:33:44'),
('2590e3d1514b97b96ae79efb28f976bc4e9ee6caf4ebeedd449c2dbb292376a21e4be7dbb4b4c71e', 8, 1, 'MyAppToken', '[]', 0, '2023-07-21 09:11:54', '2023-07-21 09:11:54', '2024-07-21 10:11:54'),
('2b8f14ad94a9e85af6aad5918ac0505a8853f059fa558bd4e9d2367414e114138cd790fe5484e04e', 2, 1, 'MyAppToken', '[]', 0, '2023-06-23 10:26:41', '2023-06-23 10:26:41', '2024-06-23 11:26:41'),
('2cb22f0191552ba1d90e311c998c2cfcd062cc21e44af9f08e8b24944abc08d6a0b52cae87633936', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:57:03', '2023-07-28 09:57:03', '2024-07-28 10:57:03'),
('31a34a58a345d6ac121e164a379a7cf4c032cacb06a9cbb99ea3bf22abf2c5d17d669548fa49cdb4', 12, 1, 'MyAppToken', '[]', 0, '2023-08-10 09:52:42', '2023-08-10 09:52:42', '2024-08-10 10:52:42'),
('339722a090edbd052d4bf5ce9f7a98713ffe70d85221fab61199e27a4559defb602c6d2f31b124b2', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 06:26:42', '2023-07-28 06:26:42', '2024-07-28 07:26:42'),
('3516226ebfc45b939bb7ea7010c812d8b1ddbe1ad655f3594ee8febd79dcd96f7ba26cb94b277c3c', 9, 1, 'MyAppToken', '[]', 0, '2023-07-07 07:44:43', '2023-07-07 07:44:43', '2024-07-07 08:44:43'),
('3d680fed2fa0d5a976e49bddd2b56002ce8b0e9670a05cc1046285c4e77f4f654eda9e9a1fba7dd2', 12, 1, 'MyAppToken', '[]', 0, '2023-07-07 09:29:44', '2023-07-07 09:29:44', '2024-07-07 10:29:44'),
('3eeeb7627f7607b82714de74f01ca1815dd0dcc2240a736af2a74b919c80dfbb39465db926898558', 9, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:40:10', '2023-07-07 08:40:10', '2024-07-07 09:40:10'),
('422e72092f931335fd8cac9816500ade60f202e0f1b1b0199040e39215420902338b6b7a68562f67', 2, 1, 'MyAppToken', '[]', 0, '2023-06-23 11:24:47', '2023-06-23 11:24:47', '2024-06-23 12:24:47'),
('6092c5883b47a84b39f1b265db58212dbeb8008da318d11eb8aabaa21ae900769de42576baf320df', 9, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:24:31', '2023-07-07 08:24:31', '2024-07-07 09:24:31'),
('6197f90dfe4761da1f32c6c0b00253059083a837a5efa3a9ada876fc32dfedcb7ec0a7d66488e8e1', 2, 1, 'MyAppToken', '[]', 0, '2023-10-31 18:44:00', '2023-10-31 18:44:00', '2024-10-31 18:44:00'),
('63fa6f53f089f55a6f6897fa165cfce5789a23311d0876b630d308c8a9956e0cacd142e058b851bd', 2, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:35:25', '2023-07-21 14:35:25', '2024-07-21 15:35:25'),
('6703fa1e21f40b2a1b3ce399e85b4a27f8a2c54c93f17dd4cda8a16006a6fe1e769cd2d242e760ac', 12, 1, 'MyAppToken', '[]', 0, '2023-08-15 13:04:51', '2023-08-15 13:04:51', '2024-08-15 14:04:51'),
('68d7082157b927bf3e2efa9661cc42c753f6d36d05d569fda23f2ceb521e112cb9d06a97e1773275', 2, 1, 'MyAppToken', '[]', 0, '2023-06-22 10:50:02', '2023-06-22 10:50:02', '2024-06-22 11:50:02'),
('6ac6a76757dec895166a923356e519dc2f76f6d2494d1962be52d567437f42622db9fb3b45f4ac99', 8, 1, 'MyAppToken', '[]', 0, '2023-07-31 07:15:59', '2023-07-31 07:15:59', '2024-07-31 08:15:59'),
('6c9889f883b5cae0d33b932dbdbaa0ffb7f4d15e3d7e46723193656a64f8b868eae9be143b7a7f74', 12, 1, 'MyAppToken', '[]', 0, '2023-07-21 06:37:56', '2023-07-21 06:37:56', '2024-07-21 07:37:56'),
('6cc97128a803ad4a3abf87089a60c6587b461c41ee25c7f61b23190e8788d9ce36c30ed92397a3fd', 2, 1, 'MyAppToken', '[]', 0, '2023-07-24 20:45:35', '2023-07-24 20:45:35', '2024-07-24 21:45:35'),
('7286e2e47f53f5b1d52edf4d387422b2bf2ca1b85921453f6d40074c609b8972169502f1836a6acc', 12, 1, 'MyAppToken', '[]', 0, '2023-08-10 10:03:59', '2023-08-10 10:03:59', '2024-08-10 11:03:59'),
('78ad7b1ac161b7384384a54a6beec2cf4fca311a056d960998c160841fc8fa24a7dcfe48fb42609d', 12, 1, 'MyAppToken', '[]', 0, '2023-08-07 12:50:39', '2023-08-07 12:50:39', '2024-08-07 13:50:39'),
('79cac7c9e5a31ec49eabd71d1ed04eeeda1cd2ef4df05eb2d2be28af5c75c2b1cabefee27b1aaae9', 12, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:42:53', '2023-07-07 08:42:53', '2024-07-07 09:42:53'),
('7ebdd76219c7336352dc5774d7609922ebceeb02bba6824098dc9096a1192722e308d32ee43f2394', 12, 1, 'MyAppToken', '[]', 0, '2023-08-09 18:43:13', '2023-08-09 18:43:13', '2024-08-09 19:43:13'),
('8385b9d7c313b21df6f22b20234b81d03d0d9a23d9182776a2f64939bef407951ee27dad76727c86', 12, 1, 'MyAppToken', '[]', 0, '2023-08-10 11:19:40', '2023-08-10 11:19:40', '2024-08-10 12:19:40'),
('8955f5781d03464b36ef4b5134996579193b0bc59bc0d666d4ec8e158b24f046bd7d54a62af6275e', 1, 1, 'MyAppToken', '[]', 0, '2024-01-14 15:51:17', '2024-01-14 15:51:17', '2025-01-14 16:51:17'),
('942a675c20b8a2d821d866e35d3eba1f0a5a1e12152de14b78797ecb780e41c9013d3ce4a388bca6', 12, 1, 'MyAppToken', '[]', 0, '2023-08-15 12:56:14', '2023-08-15 12:56:14', '2024-08-15 13:56:14'),
('95b85c2735c99a34013627a853ed8038fd83d074bc620abf45c6fbfc461f87cb42f4f702a0b7c98b', 12, 1, 'MyAppToken', '[]', 0, '2023-07-07 09:56:29', '2023-07-07 09:56:29', '2024-07-07 10:56:29'),
('985a797da9ea73721eccbb264e886c4f38a980e8fddef40197670ad74631d528e99002bdecdff348', 12, 1, 'MyAppToken', '[]', 0, '2023-07-07 09:21:22', '2023-07-07 09:21:22', '2024-07-07 10:21:22'),
('9e45e39fb43883c2dd114ada0fd1f3331b4cfb64188e5dddb3380a5c38fb4649d3f3348be66c2fed', 12, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:44:33', '2023-07-07 08:44:33', '2024-07-07 09:44:33'),
('a03350e9bf281489ea37b707dde005d9d350ae5fba8c995578d5defcff638cb89e08039cf0bfa556', 11, 1, 'MyAppToken', '[]', 0, '2024-02-04 14:12:34', '2024-02-04 14:12:34', '2025-02-04 15:12:34'),
('a1283e02db9bb39d8c481f7a0d2c75bfb02a9e6874c2a88e8db1c3b5e28d6e97791b781795d7cd80', 2, 1, 'MyAppToken', '[]', 0, '2023-08-10 23:09:27', '2023-08-10 23:09:27', '2024-08-11 00:09:27'),
('aa5523e55ff59f9637928eb0e4a96ad6829b29ddb08b98a99ba54da547a7400cfce510e835d6dcbb', 12, 1, 'MyAppToken', '[]', 0, '2023-08-09 21:59:33', '2023-08-09 21:59:33', '2024-08-09 22:59:33'),
('ac16c976109149b2a429d685961040172454c9eb6b72881142390ad5ac51d5812e443075a664a219', 2, 1, 'MyAppToken', '[]', 0, '2023-06-23 12:22:20', '2023-06-23 12:22:20', '2024-06-23 13:22:20'),
('b1af3f68b49759ba8ea2e40bfa623c70f7108aa0e7ff6baccdf424a31714aa3715d0d144ee7b8701', 12, 1, 'MyAppToken', '[]', 0, '2023-08-15 12:32:46', '2023-08-15 12:32:46', '2024-08-15 13:32:46'),
('b47a6c05a4628664d121fc1e4e6cb409d4cab5cd1eb91eea22ed5428d6fdf60e0fda2f6eb95a5e96', 12, 1, 'MyAppToken', '[]', 0, '2023-08-09 17:06:22', '2023-08-09 17:06:22', '2024-08-09 18:06:22'),
('b583cf0abce39730d0e764553885e48b3553b2f9291b4c5349c2055718c44a3eb224203279b84c4c', 9, 1, 'MyAppToken', '[]', 0, '2023-06-26 15:46:15', '2023-06-26 15:46:15', '2024-06-26 16:46:15'),
('c1d58134be73275df6f64005cc8c6eacd7d0c807b5538673b188f619d9ac2254b603637192cc962a', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 08:51:55', '2023-07-28 08:51:55', '2024-07-28 09:51:55'),
('c52be555453e25ecb2172566b8d3dd4503425a35e59fdc692138e19dcb0cb164dbe007c2f41b19ef', 12, 1, 'MyAppToken', '[]', 0, '2023-07-21 15:03:14', '2023-07-21 15:03:14', '2024-07-21 16:03:14'),
('c5a86449744f3905aecb4bed595c77c2bdcc58c958eed57a74f342763ae76ad67684ca6c2179ee3c', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:38:23', '2023-07-28 09:38:23', '2024-07-28 10:38:23'),
('c7d53fbc920a0d3422de7d3eb3f107f4ace88ab0d8dadb6e48ae8783fbd859dab1aa82759ddb0de7', 12, 1, 'MyAppToken', '[]', 0, '2023-07-24 20:44:13', '2023-07-24 20:44:13', '2024-07-24 21:44:13'),
('ccdaaa699b1d2d4c9d002eea8ab9be50b040c1470b2b111aebc3f4c7225998daed5db2f0bc95c251', 12, 1, 'MyAppToken', '[]', 0, '2023-07-21 09:10:47', '2023-07-21 09:10:47', '2024-07-21 10:10:47'),
('d12f64c7bdf3972724287c712410e691fbe7504554cd2c2e26296497d901afbadce479a8b356774d', 2, 1, 'MyAppToken', '[]', 0, '2023-06-26 15:45:56', '2023-06-26 15:45:56', '2024-06-26 16:45:56'),
('d32f1951e2ad9fb0666ea0f0102cee7abba648bcd90cc7e50a8dad5f419171d517063666f97a34b5', 12, 1, 'MyAppToken', '[]', 0, '2023-08-10 11:12:47', '2023-08-10 11:12:47', '2024-08-10 12:12:47'),
('e1dd7aaa38aababdaa5f8d20b0c10fb1bfd879a23dc846b9fbd6c50bd3f8695e071eb4c1227c1e51', 12, 1, 'MyAppToken', '[]', 0, '2023-08-10 20:19:16', '2023-08-10 20:19:16', '2024-08-10 21:19:16'),
('f3d120d57b36369787d6d89a737019d4715c1cddd823c4848c5d0a2ad9ad8f92da395233db5f0d78', 12, 1, 'MyAppToken', '[]', 0, '2023-08-09 15:36:22', '2023-08-09 15:36:22', '2024-08-09 16:36:22'),
('f74893ceb8cbb7cb61793420ff26228b6751d3099fd7ddb9c7149b6f76ee679e10f6b914c787e56d', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 06:28:36', '2023-07-28 06:28:36', '2024-07-28 07:28:36'),
('fae3c908f3cde2cbc120e33041949a678aaaa588e0d84d9d145ea9359cbe006daf32914d81308c6e', 12, 1, 'MyAppToken', '[]', 0, '2023-08-08 09:22:46', '2023-08-08 09:22:46', '2024-08-08 10:22:46'),
('fd00a5845c1dddcae020f6bf86b0759c345dfd2103b3c792e0de2a26e0fb21f338a01e0c07784389', 8, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:44:23', '2023-07-21 14:44:23', '2024-07-21 15:44:23'),
('fdb8271130139648598fb827e72baf381b5444262d2a5569fec046dd99c03629c09550ccf19790e7', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 08:49:31', '2023-07-28 08:49:31', '2024-07-28 09:49:31');

-- --------------------------------------------------------

--
-- Structure de la table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'T5881zpOhpP1TIx6ouRMUhbZNMedP1lP9eHgxdkS', NULL, 'http://localhost', 1, 0, 0, '2023-06-17 07:56:37', '2023-06-17 07:56:37'),
(2, NULL, 'Laravel Password Grant Client', 'KkK5viAP7AMSYmbZnI4uhZjAixLKVdpmD7TEkeqz', 'users', 'http://localhost', 0, 1, 0, '2023-06-17 07:56:37', '2023-06-17 07:56:37');

-- --------------------------------------------------------

--
-- Structure de la table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-06-17 07:56:37', '2023-06-17 07:56:37');

-- --------------------------------------------------------

--
-- Structure de la table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parent_categorys`
--

CREATE TABLE `parent_categorys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parent_categorys`
--

INSERT INTO `parent_categorys` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Service', NULL, NULL),
(2, 'Losing product', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payements`
--

CREATE TABLE `payements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `montant` double NOT NULL,
  `facture_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `payements`
--

INSERT INTO `payements` (`id`, `montant`, `facture_id`, `created_at`, `updated_at`) VALUES
(4, 510, 23, '2023-06-16 13:29:34', '2023-06-16 13:29:34'),
(7, 2000, 29, '2023-06-21 17:07:44', '2023-06-21 17:07:44'),
(8, 200, 29, '2023-06-21 17:08:18', '2023-06-21 17:08:18'),
(19, 100, 31, '2023-06-22 08:35:02', '2023-06-22 08:35:02'),
(20, 200, 31, '2023-06-22 08:35:07', '2023-06-22 08:35:07'),
(24, 10, 31, '2023-06-22 08:46:16', '2023-06-22 08:46:16'),
(26, 200, 31, '2023-06-23 08:11:18', '2023-06-23 08:11:18'),
(28, 10000, 35, '2023-06-23 11:25:21', '2023-06-23 11:25:21'),
(29, 1000, 29, '2023-07-21 14:21:11', '2023-07-21 14:21:11'),
(30, 4000, 38, '2023-08-12 11:23:15', '2023-08-12 11:23:15'),
(31, 1000, 37, '2023-08-15 12:48:19', '2023-08-15 12:48:19'),
(33, 8000, 40, '2023-08-15 12:48:43', '2023-08-15 12:48:43'),
(34, 530, 41, '2023-08-15 14:21:31', '2023-08-15 14:21:31'),
(35, 800, 42, '2023-08-15 14:36:50', '2023-08-15 14:36:50'),
(36, 580, 45, '2023-08-21 09:25:58', '2023-08-21 09:25:58'),
(38, 10000, 47, '2023-08-28 08:48:07', '2023-08-28 08:48:07'),
(39, 70000, 47, '2023-08-28 08:48:15', '2023-08-28 08:48:15'),
(40, 910, 47, '2023-08-28 08:48:22', '2023-08-28 08:48:22'),
(42, 2500, 40, '2024-01-14 16:28:57', '2024-01-14 16:28:57'),
(44, 4500, 95, '2024-02-04 12:59:57', '2024-02-04 12:59:57'),
(45, 1648, 95, '2024-02-04 13:00:04', '2024-02-04 13:00:04');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `point_ventes`
--

CREATE TABLE `point_ventes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client` varchar(255) NOT NULL,
  `telephone` int(11) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `type_payement` varchar(255) DEFAULT NULL,
  `type_echange_commercial` varchar(255) DEFAULT NULL,
  `total_commande` int(11) NOT NULL DEFAULT 1,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `boutique_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `point_ventes`
--

INSERT INTO `point_ventes` (`id`, `client`, `telephone`, `ville`, `type_payement`, `type_echange_commercial`, `total_commande`, `order_id`, `boutique_id`, `customer_id`, `created_at`, `updated_at`) VALUES
(17, 'Coulibaly Korotoumou', 66791234, 'Bamako', 'Paiement à la livraison', 'B2C', 1, 4517, 4, 21, '2023-06-20 13:32:35', '2023-06-20 13:32:35'),
(21, 'kamal fanidii', 606060606, 'Rabat', 'cash', 'B2B', 1, 2, 1, 1, '2023-06-21 06:31:13', '2023-06-26 15:34:56'),
(23, 'client client', 606060606, 'Casablanca', 'Payement a la livraison', 'B2C', 1, 10, 1, 2, '2023-06-26 14:02:38', '2023-06-26 14:02:38');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `permalien` varchar(255) DEFAULT NULL,
  `stock_status` varchar(255) NOT NULL DEFAULT 'instock',
  `pub_status` varchar(255) NOT NULL DEFAULT 'publish',
  `quantite` int(11) NOT NULL DEFAULT 1,
  `prix` double(8,2) NOT NULL DEFAULT 0.00,
  `boutique_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `marque_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `sku`, `permalien`, `stock_status`, `pub_status`, `quantite`, `prix`, `boutique_id`, `created_at`, `updated_at`, `marque_id`) VALUES
(1, 'Iphone6', 'iphone 6', 'iphone6', NULL, 'instock', 'publish', 28, 2000.00, 1, '2023-05-17 16:29:06', '2023-08-28 07:58:34', 4),
(2, 'mac os', 'mac os', 'mac os', NULL, 'instock', 'pending', 37, 100.00, 1, '2023-05-14 08:40:34', '2023-08-28 08:00:44', 3),
(4, 'chemise', 'chemise', 'chemise', NULL, 'instock', 'publish', 40, 2000.00, 1, '2023-05-14 08:35:25', '2023-05-19 14:45:44', 8),
(5, 'sac', 'sac', 'sac', NULL, 'instock', 'publish', 35, 3000.00, 1, '2023-05-14 08:35:25', '2023-08-28 08:08:23', 2),
(25, 'Hp Victus', 'Pc portable', 'victus', 'gamerlin', 'instock', 'publish', 109, 7500.00, 1, '2023-06-04 19:53:35', '2023-08-28 08:04:37', 3),
(26, 'chemise', 'chemise', 'chemise', NULL, 'instock', 'publish', 40, 2000.00, 1, '2023-05-14 08:35:25', '2023-05-19 14:45:44', 8),
(28, 'Ordinateur Portable', 'Ordinateur Portable', 'PC0001', 'pc_portable', 'outofstock', 'publish', 0, 10000.00, 1, '2023-11-21 12:33:53', '2023-11-21 12:33:53', 4);

-- --------------------------------------------------------

--
-- Structure de la table `produit_categorie`
--

CREATE TABLE `produit_categorie` (
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit_categorie`
--

INSERT INTO `produit_categorie` (`produit_id`, `categorie_id`) VALUES
(2, 4),
(5, 1),
(1, 5),
(1, 2),
(1, 4),
(25, 5),
(4, 6),
(28, 5);

-- --------------------------------------------------------

--
-- Structure de la table `produit_supprimes`
--

CREATE TABLE `produit_supprimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit_supprimes`
--

INSERT INTO `produit_supprimes` (`id`, `produit_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 6, 'pefzuifuze', '2023-08-15 09:34:01', '2023-08-15 09:34:01'),
(2, 4579, 'test', '2023-08-15 10:20:56', '2023-08-15 10:20:56'),
(3, 4794, 'Tree Oil 30ml', '2023-11-09 15:05:42', '2023-11-09 15:05:42'),
(4, 4795, 'Oil Free Moisturizer 100ml', '2023-11-09 15:06:05', '2023-11-09 15:06:05'),
(5, 4787, 'HP Pavilion 15-DK1056WM', '2023-11-09 15:06:17', '2023-11-09 15:06:17'),
(6, 4785, 'Microsoft Surface Laptop 4', '2023-11-09 15:06:30', '2023-11-09 15:06:30'),
(7, 4788, 'perfume Oil', '2023-11-09 15:06:38', '2023-11-09 15:06:38'),
(8, 4783, 'MacBook Pro', '2023-11-09 15:06:47', '2023-11-09 15:06:47'),
(9, 4790, 'Fog Scent Xpressio Perfume', '2023-11-09 15:06:56', '2023-11-09 15:06:56'),
(10, 4786, 'Infinix INBOOK', '2023-11-09 15:07:05', '2023-11-09 15:07:05'),
(11, 4796, 'Skin Beauty Serum.', '2023-11-09 15:07:14', '2023-11-09 15:07:14'),
(12, 4807, 'Key Holder', '2023-11-09 15:07:33', '2023-11-09 15:07:33'),
(13, 4778, 'iPhone 9', '2023-11-09 15:07:44', '2023-11-09 15:07:44'),
(14, 4805, '3D Embellishment Art Lamp', '2023-11-09 15:07:53', '2023-11-09 15:07:53'),
(15, 4792, 'Eau De Perfume Spray', '2023-11-09 15:08:02', '2023-11-09 15:08:02'),
(16, 4211, 'Robe classe de soirée', '2023-11-09 15:08:11', '2023-11-09 15:08:11'),
(17, 4789, 'Brown Perfume', '2023-11-09 15:08:21', '2023-11-09 15:08:21'),
(18, 4793, 'Hyaluronic Acid Serum', '2023-11-09 15:08:31', '2023-11-09 15:08:31'),
(19, 4784, 'Samsung Galaxy Book', '2023-11-09 15:08:43', '2023-11-09 15:08:43'),
(20, 4802, 'Gulab Powder 50 Gram', '2023-11-09 15:08:52', '2023-11-09 15:08:52'),
(21, 4780, 'Samsung Universe 9', '2023-11-09 15:09:02', '2023-11-09 15:09:02'),
(22, 4801, 'cereals muesli fruit nuts', '2023-11-09 15:09:17', '2023-11-09 15:09:17'),
(23, 4779, 'iPhone X', '2023-11-09 15:09:30', '2023-11-09 15:09:30'),
(24, 4782, 'Huawei P30', '2023-11-09 15:09:40', '2023-11-09 15:09:40'),
(25, 4791, 'Non-Alcoholic Concentrated Perfume Oil', '2023-11-09 15:09:54', '2023-11-09 15:09:54'),
(26, 4781, 'OPPOF19', '2023-11-09 15:10:09', '2023-11-09 15:10:09'),
(27, 4798, '- Daal Masoor 500 grams', '2023-11-09 15:10:21', '2023-11-09 15:10:21'),
(28, 4800, 'Orange Essence Food Flavou', '2023-11-09 15:10:34', '2023-11-09 15:10:34'),
(29, 4797, 'Freckle Treatment Cream- 15gm', '2023-11-09 15:10:47', '2023-11-09 15:10:47'),
(30, 4803, 'Plant Hanger For Home', '2023-11-09 15:10:59', '2023-11-09 15:10:59'),
(31, 4799, 'Elbow Macaroni - 400 gm', '2023-11-09 15:11:15', '2023-11-09 15:11:15'),
(32, 4804, 'Flying Wooden Bird', '2023-11-09 15:11:33', '2023-11-09 15:11:33'),
(33, 4806, 'Handcraft Chinese style', '2023-11-09 15:11:47', '2023-11-09 15:11:47');

-- --------------------------------------------------------

--
-- Structure de la table `provideds`
--

CREATE TABLE `provideds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `provideds`
--

INSERT INTO `provideds` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Fournis par mon entreprise', NULL, NULL),
(2, 'Fourni par un membre', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `provided_parent_categorys`
--

CREATE TABLE `provided_parent_categorys` (
  `provided_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `provided_parent_categorys`
--

INSERT INTO `provided_parent_categorys` (`provided_id`, `parent_id`) VALUES
(1, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `societe_transports`
--

CREATE TABLE `societe_transports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `telephone` int(11) NOT NULL,
  `boutique_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `societe_transports`
--

INSERT INTO `societe_transports` (`id`, `name`, `adresse`, `telephone`, `boutique_id`, `created_at`, `updated_at`) VALUES
(2, 'Glovo', 'Casablanca', 606060606, 4, '2023-06-08 21:48:17', '2023-06-08 22:13:18'),
(3, 'Amana', 'Rabat', 678905543, 4, '2023-06-09 08:15:27', '2023-06-09 08:15:27'),
(4, 'express', 'rabat', 678321223, 1, '2023-06-23 12:21:49', '2023-06-23 12:21:49'),
(5, 'Magnetic', 'Tanger', 678905543, 1, '2023-08-13 19:48:53', '2023-08-13 19:48:53');

-- --------------------------------------------------------

--
-- Structure de la table `statut_livraisons`
--

CREATE TABLE `statut_livraisons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `statut_livraisons`
--

INSERT INTO `statut_livraisons` (`id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pas commencer', NULL, NULL),
(2, 'En cours', NULL, NULL),
(3, 'Perdu', NULL, NULL),
(4, 'Livrer', NULL, NULL),
(5, 'Pas de reponse', NULL, NULL),
(6, 'Rembourser', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `team_expenses`
--

CREATE TABLE `team_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `boutique_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `provided_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `team_expenses`
--

INSERT INTO `team_expenses` (`id`, `montant`, `date`, `note`, `status`, `boutique_id`, `user_id`, `provided_id`, `created_at`, `updated_at`, `category_id`) VALUES
(2, 4000, '2023-07-03', 'note2', 'canceled', 4, 9, 1, NULL, '2023-07-14 08:32:42', 4),
(3, 900, '2023-07-07', 'note4', 'pending', 4, 12, 2, '2023-07-13 16:14:28', '2023-07-21 15:06:36', 5),
(7, 2900, '2023-07-08', 'note45', 'pending', 4, 2, 2, '2023-07-14 09:01:38', '2023-07-14 09:01:57', 4),
(8, 900, '2023-07-01', 'note450', 'canceled', 4, 9, 2, '2023-07-14 12:31:42', '2023-07-21 15:06:53', 5),
(9, 2500, '2023-07-14', 'payement livreur', 'approved', 4, 10, 1, '2023-07-14 12:32:20', '2023-07-14 12:32:20', 4),
(11, 2340, '2023-06-28', 'Payement', 'pending', 4, 10, 2, '2023-07-19 10:34:10', '2023-07-19 10:34:10', 9),
(12, 1456, '2023-07-02', 'ujj', 'approved', 4, 10, 2, '2023-07-21 14:13:24', '2023-07-21 14:14:20', 4),
(13, 899, '2023-07-21', 'note4', 'pending', 4, 10, 2, '2023-07-21 14:32:39', '2023-07-21 14:32:39', 9),
(14, 9000, '2023-07-08', 'note345', 'pending', 4, 8, 2, '2023-07-21 15:00:45', '2023-07-21 15:00:45', 12),
(15, 789, '2023-06-26', 'note789', 'approved', 1, 12, 2, '2023-07-21 15:02:41', '2023-07-21 15:02:41', 10),
(16, 300, '2023-10-30', 'note2222', 'canceled', 4, 13, 1, '2023-10-29 01:15:21', '2023-10-29 01:16:07', 10),
(17, 9000, '2023-10-31', 'note5555', 'pending', 4, 11, 1, '2023-10-31 10:03:16', '2023-10-31 10:03:16', 4),
(18, 9999, '2023-11-01', 'iol', 'pending', 4, 10, 2, '2023-10-31 16:00:53', '2023-10-31 16:00:53', 12);

-- --------------------------------------------------------

--
-- Structure de la table `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `texte` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `templates`
--

INSERT INTO `templates` (`id`, `titre`, `texte`, `created_at`, `updated_at`) VALUES
(1, 'Pas de reponse', 'Bonjour cher {{nom_client}}, le livreur  {{nom_livreur}} n\'a pas donner suite a la livraison votre commande. Reference:{{reference_commande}}', '2023-08-02 10:30:10', '2023-08-02 10:30:10'),
(4, 'Rembourser', 'La commande  {{reference_commande}} a ete rembourser', '2023-08-02 10:49:02', '2023-08-02 10:49:02'),
(5, 'Colis perdu', 'La commande  {{reference_commande}} a ete perdu par le livreur  {{nom_livreur}}', '2023-08-04 14:29:06', '2023-08-04 14:29:06'),
(7, 'Non livrer', 'La commande n\'a pas ete livrer', '2023-08-12 20:16:22', '2023-08-12 20:16:22'),
(8, 'Commande rembourser', 'La commande  {{reference_commande}} a ete rembourser', '2023-08-15 12:27:29', '2023-08-15 12:27:29'),
(9, 'Commande rembourser 2', 'La commande  {{reference_commande}} a ete rembourser pour le client {{nom_client}}', '2023-08-15 12:29:12', '2023-08-15 12:29:12');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fournisseur_id` bigint(20) UNSIGNED NOT NULL,
  `marque_id` bigint(20) UNSIGNED NOT NULL,
  `boutique_id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 1,
  `prix` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `produit_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `fournisseur_id`, `marque_id`, `boutique_id`, `produit_id`, `quantite`, `prix`, `total`, `created_at`, `updated_at`, `visible`, `produit_name`) VALUES
(23, 4, 2, 1, 5, 15, 890.00, 13350.00, '2023-06-23 11:17:41', '2023-06-23 11:57:30', 1, 'sac'),
(25, 3, 4, 1, 1, 8, 4500.00, 36000.00, '2023-06-23 11:35:36', '2023-06-23 11:35:36', 1, 'Iphone6'),
(27, 1, 1, 4, 4367, 90, 899.00, 80910.00, '2023-07-14 12:21:43', '2023-07-14 12:21:43', 1, 'Perfect Harmony'),
(29, 4, 5, 1, 6, 9, 900.00, 8100.00, '2023-08-15 09:33:05', '2023-08-15 09:33:05', 1, 'pefzuifuze'),
(31, 3, 3, 4, 4579, 1, 9000.00, 9000.00, '2023-08-15 10:20:03', '2023-08-15 10:20:03', 1, 'test'),
(32, 4, 5, 4, 4204, 9, 899.00, 8091.00, '2023-08-15 14:45:19', '2023-08-15 14:45:19', 0, 'Ensemble noir sexy'),
(33, 3, 1, 4, 4149, 9999, 99.00, 989901.00, '2023-08-21 11:12:05', '2023-08-21 11:12:05', 1, 'Veste et pantalon large'),
(36, 4, 3, 1, 25, 9, 99.00, 891.00, '2023-08-28 08:04:37', '2023-08-28 08:04:37', 1, 'Hp Victus'),
(37, 1, 2, 1, 5, 5, 100.00, 500.00, '2023-08-28 08:08:23', '2023-08-28 08:08:23', 1, 'sac'),
(38, 3, 1, 4, 4367, 67, 34.00, 2278.00, '2023-08-28 08:19:23', '2023-08-28 08:19:23', 1, 'Perfect Harmony');

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `types`
--

INSERT INTO `types` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Agreer', NULL, NULL),
(2, 'Non agreer\r\n', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `type_depenses`
--

CREATE TABLE `type_depenses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_depenses`
--

INSERT INTO `type_depenses` (`id`, `name`) VALUES
(1, 'Business Expense'),
(2, 'Team Expense');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'profile.jpg',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `type`, `image`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'JRAYFY YASSINE', 'mc67631685@gmail.com', NULL, '$2y$10$LbD.DDueoIw837JvvNUaUONcLkkMNck..JojhU3WlxZmskOHGh8q2', 'admin', 'profile.jpg', 1, 'LXqMekTjUzVSCkgcHduXx7APZFThLfCyIgtTQcB08w2XamoH5Qtf0uZsM6Ew', '2023-05-17 16:09:59', '2023-07-21 10:39:03'),
(2, 'admin', 'mariam1801.coulibaly@gmail.com', NULL, '$2y$10$Bi8N0ThssGy8em61Ve..7u27LeaKlMtwBQNHKJ.qO2hIRxkmzLpEe', 'admin', 'profile.jpg', 1, NULL, '2023-05-17 17:05:35', '2023-07-21 14:34:50'),
(8, 'Mariam Diallo', 'mariam@gmail.com', NULL, '$2y$10$PU7rT2eSnUy0HHvwnTrL3.REkMrMJvHw6Dyuu0eEYkIS6W9HEmPKS', 'livreur', 'profile.jpg', 1, NULL, '2023-06-11 21:08:30', '2023-06-19 08:42:00'),
(9, 'Hawa Doumbia', 'hawa@gmail.com', NULL, '$2y$10$kAqTyaiVUlgV.YGl1zHMC.zTO4ZbxVHFaiutVeit0Qr1JN67PlT36', 'livreur', 'profile.jpg', 1, NULL, '2023-06-12 09:14:29', '2023-06-12 09:22:39'),
(10, 'Baba Diallo', 'baba@gmail.com', NULL, '$2y$10$Ex8uO1ye3zqKz4Bas3GKsO9rrLM5nydT00pVD9/I0bWG.YJgAUBDS', 'livreur', 'profile.jpg', 1, NULL, '2023-06-12 09:23:20', '2023-06-14 18:05:01'),
(11, 'Utilisateur', 'mariamcoulibaly@gmail.com', NULL, '$2y$10$2VyyzVYMeoG68Jdm24SSue99s/BDZvV7MfShU//MVuqPpoCemSCT6', 'super_admin', '1705247555.jpeg', 1, NULL, '2023-06-19 08:40:43', '2024-01-14 14:52:35'),
(12, 'Ines', 'ines@gmail.com', NULL, '$2y$10$IV.FJ5uNqPfpi3Lma9Xuu.3x4iPxb5kL2T2Rok3oHWfYXvl9gZ5O6', 'livreur', 'profile.jpg', 1, NULL, '2023-07-07 08:42:07', '2023-07-07 08:42:07'),
(13, 'Oumaima', 'oumaima@gmail.com', NULL, '$2y$10$N9R8VJlTvCjiW20PFCXSYOpawsPAERMXLkHiZTWJsx9Xt33OyV7nS', 'livreur', 'profile.jpg', 1, NULL, '2023-08-13 19:44:49', '2023-08-13 19:44:49'),
(14, 'Ouatassi', 'ouatassi@gmail.com', NULL, '$2y$10$dJcttWN/KAxfc.foX5rbHuTAilY8vr3CWEqKNtnslS4WhRUFLSj0m', NULL, 'profile.jpg', 1, NULL, '2023-10-31 16:20:38', '2023-10-31 16:20:38');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `api_messageries`
--
ALTER TABLE `api_messageries`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `boutiques`
--
ALTER TABLE `boutiques`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `boutiques_name_unique` (`name`);

--
-- Index pour la table `boutique_categorie`
--
ALTER TABLE `boutique_categorie`
  ADD KEY `boutique_categorie_boutique_id_foreign` (`boutique_id`),
  ADD KEY `boutique_categorie_categorie_id_foreign` (`categorie_id`);

--
-- Index pour la table `boutique_types`
--
ALTER TABLE `boutique_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `boutique_types_name_unique` (`name`);

--
-- Index pour la table `business_expenses`
--
ALTER TABLE `business_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_expenses_category_id_foreign` (`category_id`),
  ADD KEY `business_expenses_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_nom_unique` (`nom`);

--
-- Index pour la table `category_expenses`
--
ALTER TABLE `category_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_expenses_type_depense_id_foreign` (`type_depense_id`),
  ADD KEY `category_expenses_parent_category_id_foreign` (`parent_category_id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commandes_statut_livraison_id_foreign` (`statut_livraison_id`);

--
-- Index pour la table `commande_produit`
--
ALTER TABLE `commande_produit`
  ADD KEY `commande_produit_commande_id_foreign` (`commande_id`),
  ADD KEY `commande_produit_produit_id_foreign` (`produit_id`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factures_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `facture_direct`
--
ALTER TABLE `facture_direct`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facture_indirect`
--
ALTER TABLE `facture_indirect`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fournisseurs_type_id_foreign` (`type_id`),
  ADD KEY `fournisseurs_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `fournisseur_marques`
--
ALTER TABLE `fournisseur_marques`
  ADD PRIMARY KEY (`fournisseur_id`,`marque_id`),
  ADD KEY `fournisseur_marques_marque_id_foreign` (`marque_id`);

--
-- Index pour la table `livreurs`
--
ALTER TABLE `livreurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `livreurs_societetransport_id_foreign` (`societeTransport_id`),
  ADD KEY `livreurs_user_id_foreign` (`user_id`);

--
-- Index pour la table `livreur_commandes`
--
ALTER TABLE `livreur_commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `livreur_commandes_livreur_id_foreign` (`livreur_id`),
  ADD KEY `livreur_commandes_statut_livraison_id_foreign` (`statut_livraison_id`);

--
-- Index pour la table `marques`
--
ALTER TABLE `marques`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marques_name_unique` (`name`);

--
-- Index pour la table `messageries`
--
ALTER TABLE `messageries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messageries_template_id_foreign` (`template_id`),
  ADD KEY `messageries_api_messagerie_id_foreign` (`api_messagerie_id`),
  ADD KEY `messageries_statut_livraison_id_foreign` (`statut_livraison_id`),
  ADD KEY `messageries_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Index pour la table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Index pour la table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Index pour la table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Index pour la table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Index pour la table `parent_categorys`
--
ALTER TABLE `parent_categorys`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `payements`
--
ALTER TABLE `payements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payements_facture_id_foreign` (`facture_id`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `point_ventes`
--
ALTER TABLE `point_ventes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `point_ventes_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produits_boutique_id_foreign` (`boutique_id`),
  ADD KEY `produits_marque_id_foreign` (`marque_id`);

--
-- Index pour la table `produit_categorie`
--
ALTER TABLE `produit_categorie`
  ADD KEY `produit_categorie_produit_id_foreign` (`produit_id`),
  ADD KEY `produit_categorie_categorie_id_foreign` (`categorie_id`);

--
-- Index pour la table `produit_supprimes`
--
ALTER TABLE `produit_supprimes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `provideds`
--
ALTER TABLE `provideds`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `provided_parent_categorys`
--
ALTER TABLE `provided_parent_categorys`
  ADD PRIMARY KEY (`provided_id`,`parent_id`),
  ADD KEY `provided_parent_categorys_parent_id_foreign` (`parent_id`);

--
-- Index pour la table `societe_transports`
--
ALTER TABLE `societe_transports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `societe_transports_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `statut_livraisons`
--
ALTER TABLE `statut_livraisons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `team_expenses`
--
ALTER TABLE `team_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_expenses_user_id_foreign` (`user_id`),
  ADD KEY `team_expenses_boutique_id_foreign` (`boutique_id`),
  ADD KEY `team_expenses_provided_id_foreign` (`provided_id`),
  ADD KEY `team_expenses_category_id_foreign` (`category_id`);

--
-- Index pour la table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_fournisseur_id_foreign` (`fournisseur_id`),
  ADD KEY `transactions_marque_id_foreign` (`marque_id`),
  ADD KEY `transactions_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_depenses`
--
ALTER TABLE `type_depenses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `api_messageries`
--
ALTER TABLE `api_messageries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `boutiques`
--
ALTER TABLE `boutiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `boutique_types`
--
ALTER TABLE `boutique_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `business_expenses`
--
ALTER TABLE `business_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `category_expenses`
--
ALTER TABLE `category_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT pour la table `facture_direct`
--
ALTER TABLE `facture_direct`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `facture_indirect`
--
ALTER TABLE `facture_indirect`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `livreurs`
--
ALTER TABLE `livreurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `livreur_commandes`
--
ALTER TABLE `livreur_commandes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `marques`
--
ALTER TABLE `marques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `messageries`
--
ALTER TABLE `messageries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `parent_categorys`
--
ALTER TABLE `parent_categorys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `payements`
--
ALTER TABLE `payements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `point_ventes`
--
ALTER TABLE `point_ventes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `produit_supprimes`
--
ALTER TABLE `produit_supprimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `provideds`
--
ALTER TABLE `provideds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `societe_transports`
--
ALTER TABLE `societe_transports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `statut_livraisons`
--
ALTER TABLE `statut_livraisons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `team_expenses`
--
ALTER TABLE `team_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `type_depenses`
--
ALTER TABLE `type_depenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `boutique_categorie`
--
ALTER TABLE `boutique_categorie`
  ADD CONSTRAINT `boutique_categorie_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`),
  ADD CONSTRAINT `boutique_categorie_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `business_expenses`
--
ALTER TABLE `business_expenses`
  ADD CONSTRAINT `business_expenses_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category_expenses` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `category_expenses`
--
ALTER TABLE `category_expenses`
  ADD CONSTRAINT `category_expenses_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `parent_categorys` (`id`),
  ADD CONSTRAINT `category_expenses_type_depense_id_foreign` FOREIGN KEY (`type_depense_id`) REFERENCES `type_depenses` (`id`);

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_statut_livraison_id_foreign` FOREIGN KEY (`statut_livraison_id`) REFERENCES `statut_livraisons` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commande_produit`
--
ALTER TABLE `commande_produit`
  ADD CONSTRAINT `commande_produit_commande_id_foreign` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commande_produit_produit_id_foreign` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `factures_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD CONSTRAINT `fournisseurs_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`),
  ADD CONSTRAINT `fournisseurs_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `fournisseur_marques`
--
ALTER TABLE `fournisseur_marques`
  ADD CONSTRAINT `fournisseur_marques_fournisseur_id_foreign` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fournisseur_marques_marque_id_foreign` FOREIGN KEY (`marque_id`) REFERENCES `marques` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `livreurs`
--
ALTER TABLE `livreurs`
  ADD CONSTRAINT `livreurs_societetransport_id_foreign` FOREIGN KEY (`societeTransport_id`) REFERENCES `societe_transports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `livreurs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `livreur_commandes`
--
ALTER TABLE `livreur_commandes`
  ADD CONSTRAINT `livreur_commandes_livreur_id_foreign` FOREIGN KEY (`livreur_id`) REFERENCES `livreurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `livreur_commandes_statut_livraison_id_foreign` FOREIGN KEY (`statut_livraison_id`) REFERENCES `statut_livraisons` (`id`);

--
-- Contraintes pour la table `messageries`
--
ALTER TABLE `messageries`
  ADD CONSTRAINT `messageries_api_messagerie_id_foreign` FOREIGN KEY (`api_messagerie_id`) REFERENCES `api_messageries` (`id`),
  ADD CONSTRAINT `messageries_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`),
  ADD CONSTRAINT `messageries_statut_livraison_id_foreign` FOREIGN KEY (`statut_livraison_id`) REFERENCES `statut_livraisons` (`id`),
  ADD CONSTRAINT `messageries_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`);

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payements`
--
ALTER TABLE `payements`
  ADD CONSTRAINT `payements_facture_id_foreign` FOREIGN KEY (`facture_id`) REFERENCES `factures` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `point_ventes`
--
ALTER TABLE `point_ventes`
  ADD CONSTRAINT `point_ventes_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`),
  ADD CONSTRAINT `produits_marque_id_foreign` FOREIGN KEY (`marque_id`) REFERENCES `marques` (`id`);

--
-- Contraintes pour la table `produit_categorie`
--
ALTER TABLE `produit_categorie`
  ADD CONSTRAINT `produit_categorie_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produit_categorie_produit_id_foreign` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `provided_parent_categorys`
--
ALTER TABLE `provided_parent_categorys`
  ADD CONSTRAINT `provided_parent_categorys_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `parent_categorys` (`id`),
  ADD CONSTRAINT `provided_parent_categorys_provided_id_foreign` FOREIGN KEY (`provided_id`) REFERENCES `provideds` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `societe_transports`
--
ALTER TABLE `societe_transports`
  ADD CONSTRAINT `societe_transports_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `team_expenses`
--
ALTER TABLE `team_expenses`
  ADD CONSTRAINT `team_expenses_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category_expenses` (`id`),
  ADD CONSTRAINT `team_expenses_provided_id_foreign` FOREIGN KEY (`provided_id`) REFERENCES `provideds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_fournisseur_id_foreign` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseur_marques` (`fournisseur_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_marque_id_foreign` FOREIGN KEY (`marque_id`) REFERENCES `fournisseur_marques` (`marque_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
