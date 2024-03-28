-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : database:3306
-- Généré le : mar. 17 oct. 2023 à 08:50
-- Version du serveur : 11.1.2-MariaDB-1:11.1.2+maria~ubu2204
-- Version de PHP : 8.2.8

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `boutiques`
--

INSERT INTO `boutiques` (`id`, `name`, `store_url`, `consumer_key`, `consumer_secret`, `user_id`, `type_id`, `created_at`, `updated_at`) VALUES
(1, 'Local', 'https://www.google.com', 'ck_0e0e0e0e0e0e0e0e0e0e0e0e0e', 'cs_0e0e0e0e0e0e0e0e0e0e0e0e0e', 2, 1, NULL, '2023-05-25 21:18:23'),
(2, 'Mongadget', 'https://mongadget.ma', 'ck_9870b42d64ae42a4c2037447e6ce0faf390c593b', 'cs_ab065b8d89f8b89bd7855c4630d0cb4a47878dbd', 1, 2, NULL, '2023-06-22 11:09:53'),
(4, 'Miimstore', 'https://miimstore.com', 'ck_21400bab70a48dbf4d7a0b068781c06467cf8474', 'cs_adfce4c995a2c6dab57bcb9cebe9fb1280bfabb2', 1, 2, '2023-05-22 13:40:39', '2023-07-07 07:36:02');

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
(1, 'Local', 'local.png', 'Local Stores', NULL, '2023-05-18 10:18:13'),
(2, 'Woocommerce', 'woocommerce.png', 'Woocommerce sites', NULL, '2023-05-18 10:18:03'),
(3, 'Shopify', 'shopify.png', 'Shopify Sites', NULL, '2023-05-18 10:18:23');

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
(4, 1111, '2023-06-29', 'note456', 'canceled', 1, 3, '2023-07-21 15:01:58', '2023-07-21 15:01:58');

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
(5, 'Ordinateurs', '2023-05-21 15:20:13', '2023-05-21 15:20:13'),
(6, 'Vetements', '2023-05-21 15:20:57', '2023-05-21 15:20:57'),
(7, 'Test', '2023-05-24 21:14:36', '2023-05-24 21:14:36'),
(8, 'Vetrines', '2023-05-25 10:21:56', '2023-05-25 10:21:56');

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
(3, 'facebook ads', NULL, '2023-10-16 15:28:56', 1, 2),
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
(1, 'fanidii', 'kamal', 'mc67631685@gmail.com', '0601631300', 'rue adarissa', 'BR', 1, '2023-05-12 18:09:53', '2023-10-16 15:37:09', 'Rabat', 'Payement a la livraison', 0),
(2, 'client', 'client', 'client2@gmail.com', '212601631300', 'rue abdelmoumen', 'MA', 1, '2023-05-12 18:00:53', '2023-10-16 15:37:10', 'Casablanca', 'Payement a la livraison', 0),
(42, 'clienta', 'clientb', 'client1@gmail.com', '212601631300', 'adress1', 'MA', 1, '2023-05-29 13:46:08', '2023-10-16 15:37:10', 'Rabat', 'Payement par en ligne', 0),
(43, 'clientc', 'clientd', 'client4@gmail.com', '2120601631300', 'adress2', 'BR', 1, '2023-05-29 13:46:08', '2023-10-16 15:37:10', 'Marrakech', 'Payement par carte bancaire', 0),
(44, 'cliente', 'clientf', 'client5@gmail.com', '2120601631300', 'adress3', 'MA', 1, '2023-05-29 13:46:08', '2023-10-16 15:37:10', 'Casablanca', 'Payement a la livraison', 0);

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
(10, 'processing', 2000.00, 2, '2023-06-14 18:37:59', '2023-08-10 22:55:41', 5, ''),
(11, 'canceled', 4000.00, 1, '2023-08-11 12:19:29', '2023-08-11 12:19:29', 1, ''),
(12, 'processing', 2000.00, 1, '2023-08-11 12:20:10', '2023-08-15 13:05:10', 4, ''),
(48, 'processing', 11500.00, 43, '2023-09-01 06:37:17', '2023-09-01 06:37:17', 1, 'BC64f194ad36b61.pdf'),
(50, 'processing', 25000.00, 2, '2023-09-01 07:08:31', '2023-09-01 07:08:31', 1, 'BC64f19bffc2362.pdf'),
(51, 'processing', 6000.00, 42, '2023-09-14 08:32:13', '2023-09-14 08:32:13', 1, 'BC6502d31d7b1a7.pdf'),
(63, 'processing', 8000.00, 1, '2023-09-15 09:57:39', '2023-09-15 09:57:39', 1, 'BC650438a37995e.pdf'),
(64, 'processing', 2000.00, 1, '2023-09-15 10:03:42', '2023-09-15 10:03:42', 1, 'BC65043a0e2b620.pdf'),
(65, 'processing', 7500.00, 1, '2023-09-15 10:06:35', '2023-09-15 10:06:35', 1, 'BC65043abbb40f9.pdf'),
(66, 'processing', 2000.00, 1, '2023-09-15 10:14:36', '2023-10-16 15:38:20', 2, 'BC65043c9ce0475.pdf'),
(68, 'processing', 2000.00, 1, '2023-09-15 10:24:13', '2023-09-15 10:24:13', 1, 'BC65043eddd7f22.pdf'),
(69, 'processing', 2000.00, 1, '2023-09-15 10:28:45', '2023-09-15 10:28:45', 1, 'BC65043fedb3e29.pdf'),
(73, 'completed', 38000.00, 44, '2023-10-16 15:25:04', '2023-10-16 15:25:04', 1, 'BC652d55d07b98c.pdf');

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
(10, 1, 1, 2000.00, '2023-07-07 08:40:44', '2023-07-07 08:40:44'),
(9, 4, 4, 2000.00, '2023-08-10 10:03:23', '2023-08-10 10:03:23'),
(11, 1, 2, 2000.00, '2023-08-11 12:19:29', '2023-08-11 12:19:29'),
(1, 1, 1, 2000.00, '2023-08-11 15:00:29', '2023-08-11 15:00:29'),
(1, 4, 1, 2000.00, '2023-08-11 15:00:29', '2023-08-11 15:00:29'),
(2, 4, 5, 2000.00, '2023-08-11 15:01:03', '2023-08-11 15:01:03'),
(2, 1, 5, 2000.00, '2023-08-11 15:01:03', '2023-08-11 15:01:03'),
(12, 4, 1, 2000.00, '2023-08-15 12:32:11', '2023-08-15 12:32:11'),
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
(64, 1, 1, 2000.00, '2023-09-15 10:03:42', '2023-09-15 10:03:42'),
(65, 25, 1, 7500.00, '2023-09-15 10:06:35', '2023-09-15 10:06:35'),
(68, 4, 1, 2000.00, '2023-09-15 10:24:13', '2023-09-15 10:24:13'),
(69, 1, 1, 2000.00, '2023-09-15 10:28:45', '2023-09-15 10:28:45'),
(73, 1, 1, 2000.00, '2023-10-16 15:25:04', '2023-10-16 15:25:04'),
(73, 4, 3, 2000.00, '2023-10-16 15:25:04', '2023-10-16 15:25:04'),
(73, 25, 4, 7500.00, '2023-10-16 15:25:04', '2023-10-16 15:25:04'),
(66, 4, 1, 2000.00, '2023-10-16 15:37:15', '2023-10-16 15:37:15');

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
(38, 4000, 'ouvert', 'paye', 1, 6, 1, '2023-08-12 11:22:51', '2023-08-12 11:23:15'),
(39, 36000, 'ouvert', 'incomplet', 0, 17, 1, '2023-08-15 12:40:19', '2023-08-15 12:40:19'),
(40, 18000, 'ferme', 'incomplet', 1, 7, 1, '2023-08-15 12:41:44', '2023-08-15 12:49:45'),
(41, 530, 'ferme', 'paye', 0, 18, 4, '2023-08-15 14:21:31', '2023-08-15 14:21:31'),
(42, 800, 'ferme', 'paye', 0, 19, 4, '2023-08-15 14:36:50', '2023-08-15 14:36:50'),
(44, 8100, 'ouvert', 'incomplet', 0, 21, 1, '2023-08-21 08:43:42', '2023-08-21 08:43:42'),
(45, 580, 'ferme', 'paye', 0, 22, 4, '2023-08-21 09:25:58', '2023-08-21 09:25:58'),
(47, 80910, 'ferme', 'paye', 0, 24, 4, '2023-08-28 08:45:06', '2023-08-28 08:48:26'),
(49, 420, 'ouvert', 'paye', 1, 9, 4, '2023-08-28 09:41:07', '2023-08-28 09:47:58');

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
(9, 'Kissmanth chancelvina', 'assanikiss@gmail.com', 420, 'F64ec79c331a89.pdf', '2023-08-28 09:41:07', '2023-08-28 09:41:07');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `name`, `adresse`, `telephone`, `type_id`, `created_at`, `updated_at`) VALUES
(1, 'Mariam Coulibaly', 'Kpg. Sukajadi No. 821', '0606060606', 1, '2023-05-22 14:34:06', '2023-05-22 14:34:06'),
(3, 'Mahamat Cherif', 'Yirimadio', '9999999999999', 1, '2023-05-28 16:56:30', '2023-05-28 16:56:30'),
(4, 'Awa doumbia', 'adresse1', '0678905543', 1, '2023-05-28 16:56:53', '2023-05-28 16:56:53'),
(5, 'Baba kone', 'Rue accra, ocean', '0678321223', 2, '2023-05-28 16:57:23', '2023-05-28 16:57:23');

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
(9, 66, 6, 1, '2023-10-16 15:37:26', '2023-10-16 15:38:20', 2);

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
(184, '2023_08_28_085715_add_produit_name_column_to_transactions_table', 46);

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
  `is_admin_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `created_at`, `updated_at`, `is_read`, `is_admin_read`) VALUES
(1, 1, 'La commande 4514 a été mise à jour par le livreur 1.', '2023-07-24 14:26:09', '2023-08-10 23:12:50', '1', 1),
(6, 1, 'La commande 4515 a été accepter par le livreur Mariam Diallo.', '2023-07-31 07:16:15', '2023-08-10 23:12:50', '1', 1),
(8, 1, 'La commande 4514 a été accepter par le livreur Baba Diallo.', '2023-08-09 18:33:36', '2023-08-10 23:12:50', '1', 1),
(9, 1, 'La commande 4514 a été accepter par le livreur Baba Diallo.', '2023-08-09 18:35:43', '2023-08-10 23:12:50', '1', 1),
(10, 1, 'La commande 1889 a été accepter par le livreur Baba Diallo.', '2023-08-09 18:38:22', '2023-08-10 23:12:50', '1', 1),
(11, 1, 'La commande 4514 a été accepter par le livreur Baba Diallo.', '2023-08-09 18:39:51', '2023-08-10 23:12:50', '1', 1),
(12, 1, 'La commande 1889 a été accepter par le livreur Baba Diallo.', '2023-08-09 18:41:58', '2023-08-10 23:12:50', '1', 1),
(13, 2, 'La commande 10 a été accepter par le livreur Ines.', '2023-08-09 18:43:29', '2023-08-10 23:09:54', '1', 1),
(14, 2, 'La commande 10 a été accepter par le livreur Ines.', '2023-08-09 18:44:35', '2023-08-10 23:09:54', '1', 1),
(15, 2, 'La commande 10 a été accepter par le livreur Ines.', '2023-08-09 18:45:30', '2023-08-10 23:09:54', '1', 1),
(19, 2, 'La commande 10 a été accepter par le livreur Ines.', '2023-08-10 20:32:17', '2023-08-10 23:14:04', '1', 1),
(25, 2, 'La commande 2 a été accepter par le livreur Ines.', '2023-08-10 22:54:39', '2023-08-10 23:14:04', '1', 1),
(26, 2, 'La commande 12 a été accepter par le livreur Ines.', '2023-08-15 12:32:55', '2023-08-15 13:09:44', 'false', 1),
(27, 2, 'La commande 12 a été accepter par le livreur Ines.', '2023-08-15 12:57:04', '2023-08-15 13:09:44', 'false', 1),
(28, 2, 'La commande 12 a été accepter par le livreur Ines.', '2023-08-15 12:59:23', '2023-08-15 13:09:44', 'false', 1),
(29, 2, 'La commande 66 a été accepter par le livreur Oumaima.', '2023-10-16 15:38:19', '2023-10-16 15:39:09', 'false', 1);

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
('00055b04a7cd921b95eb87f64373a57b0315ff498728506143d1813970d8ae65f583be62e33116e3', 10, 1, 'MyAppToken', '[]', 0, '2023-07-24 14:35:11', '2023-07-24 14:35:11', '2024-07-24 15:35:11'),
('005ea5c81a2546b4c676514933c9f523e0587d04b129bbe780eff78c63de1d91e844028eb85a3ac7', 11, 1, 'MyAppToken', '[]', 0, '2023-07-16 08:49:03', '2023-07-16 08:49:03', '2024-07-16 09:49:03'),
('00bde29ef1076ed7c1c1e4f53325611178a341b16de4403aed24af53ffee8f57a4601d2e05a50bce', 11, 1, 'MyAppToken', '[]', 0, '2023-08-02 08:51:18', '2023-08-02 08:51:18', '2024-08-02 09:51:18'),
('00bfa15b5dd9acdf50c9d1d25fdc7af07d042af8b11bfbfced82f3508e13d0cb1a1f485363af6ff9', 11, 1, 'MyAppToken', '[]', 0, '2023-08-21 18:16:27', '2023-08-21 18:16:27', '2024-08-21 19:16:27'),
('0195fd203b3893a925fc2873eaa68ff9d7e1314e9249b322a535575e8741bd11a618f91b33adc005', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 15:01:17', '2023-07-21 15:01:17', '2024-07-21 16:01:17'),
('020ebb2ef6b64869d203b743de972de7fb64a7071b621df8af429ef813069a55a486114d8717f112', 10, 1, 'MyAppToken', '[]', 0, '2023-07-07 09:42:09', '2023-07-07 09:42:09', '2024-07-07 10:42:09'),
('02dc86819d14c818396a9f01e412bc8839625ce6f38e9f2476290832f8d6f5ba24df4a70da001e65', 1, 1, 'MyAppToken', '[]', 0, '2023-07-21 12:46:48', '2023-07-21 12:46:48', '2024-07-21 13:46:48'),
('037a0d78f3fa018cb2954af17087caebc41b6284000e664a0c05bff43f607f31c693c2f789fa4b3b', 11, 1, 'MyAppToken', '[]', 0, '2023-07-13 07:54:25', '2023-07-13 07:54:25', '2024-07-13 08:54:25'),
('0398fbb668749f83c4486af11ad10950abd6a2238f090d3a269ea9d3ac93e9a449cc8fd3865a9f0b', 1, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:56:18', '2023-07-28 09:56:18', '2024-07-28 10:56:18'),
('040c8fd8c472ab8f17e1df7d4d096f0c772ebc6d2102ae44fdc8210852041ba112be372e972f1255', 11, 1, 'MyAppToken', '[]', 0, '2023-08-15 12:51:27', '2023-08-15 12:51:27', '2024-08-15 13:51:27'),
('048d5eee680f7286057b8bee8a005a69ab0d21cb940c7a6d1a3aaabe00b7b469b477197ab9e84443', 10, 1, 'MyAppToken', '[]', 0, '2023-08-07 14:55:31', '2023-08-07 14:55:31', '2024-08-07 15:55:31'),
('054e915b0ddc4d708482b03c05756a6df9dea116ad163b1ef8002ee2270a376668a7c723ed8b1092', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 06:35:56', '2023-07-21 06:35:56', '2024-07-21 07:35:56'),
('055d94d1015c2815b026a27bb0ee62c06cf7960b10fe810d85dc746c39d16f5ea7afe8c4dd549d4d', 1, 1, 'MyAppToken', '[]', 0, '2023-07-28 06:28:12', '2023-07-28 06:28:12', '2024-07-28 07:28:12'),
('060674d252939e6db332fad14ff8960b0e0712195f5bf4ffc29172d76f0157f4fef47bb5c27b5051', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:43:13', '2023-07-28 09:43:13', '2024-07-28 10:43:13'),
('06f6da74a3cd551eca187aeba1388f3c99a65d932744ad21d51c0d9c4bea5afaf7ff265f965df101', 11, 1, 'MyAppToken', '[]', 0, '2023-08-01 07:24:47', '2023-08-01 07:24:47', '2024-08-01 08:24:47'),
('0729903779b88c60f7b86486dd938277a64ede82bdb333d28a86daf42f2e617cf2773fe98829604a', 11, 1, 'MyAppToken', '[]', 0, '2023-08-12 10:51:24', '2023-08-12 10:51:24', '2024-08-12 11:51:24'),
('0a86e564748681d35b5f2ca8d1539083945a78e4904993a447fb0922c55eb501a9ffc290908ec456', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 09:12:14', '2023-07-21 09:12:14', '2024-07-21 10:12:14'),
('0b4634c0969dae86e66df42717032e47996021752979d7f46c8c84b2d4d733fb9d8d2e805836958b', 8, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:27:18', '2023-07-21 14:27:18', '2024-07-21 15:27:18'),
('10a9547d10040474fe767ab7eeeb9a8c8c97a3f8f2a5a56954786569c94d11206ad9a47e7aed65cc', 11, 1, 'MyAppToken', '[]', 0, '2023-07-31 09:36:18', '2023-07-31 09:36:18', '2024-07-31 10:36:18'),
('115e2671809c4996531a17cbfeb06c3ac5c3431531e1d5e319c64f32c7176ea04be9247d3fed4d61', 11, 1, 'MyAppToken', '[]', 0, '2023-08-07 14:50:46', '2023-08-07 14:50:46', '2024-08-07 15:50:46'),
('128d448072e91c5e45337b5135bca8a23d956f20f0f243cc44bad83e80a5a6b72193f34b22dc3151', 12, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:37:06', '2023-07-28 09:37:06', '2024-07-28 10:37:06'),
('134fa516b2f30fa4a72b5030e2bd78098b4876315cfefa848392ef74607066bce9c412bf712a1366', 1, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:38:10', '2023-07-28 09:38:10', '2024-07-28 10:38:10'),
('14742ccc510828f1d23fabe82c15b1f711f97b12b6ccedb2240832cd876137c9f2799fa0b39184f1', 2, 1, 'MyAppToken', '[]', 0, '2023-07-31 06:13:03', '2023-07-31 06:13:03', '2024-07-31 07:13:03'),
('15c111245e553e7d279354564347eec1ec9769f460c10a0c2aa1deaa5f1c18e3d9df67cec441ecb2', 11, 1, 'MyAppToken', '[]', 0, '2023-09-04 10:16:36', '2023-09-04 10:16:36', '2024-09-04 11:16:36'),
('17f8b9045058d8c6f676ae533fdce93bd0881a470ef5ab0f79b17660d9a28087f42804136c530f11', 10, 1, 'MyAppToken', '[]', 0, '2023-07-31 10:33:53', '2023-07-31 10:33:53', '2024-07-31 11:33:53'),
('1b35b1500a4d8d6acedcf009b76d379ed758a80196c5ff079fa779fd403d385719a5d3f26e85e405', 11, 1, 'MyAppToken', '[]', 0, '2023-07-11 08:08:32', '2023-07-11 08:08:32', '2024-07-11 09:08:32'),
('1b735fb2a8082001159b32a2d53af4abc7093b9009c5df0896654a460ca388ab9a4264409a0537bb', 2, 1, 'MyAppToken', '[]', 0, '2023-08-15 12:59:46', '2023-08-15 12:59:46', '2024-08-15 13:59:46'),
('1b78c443dfde010cb91462519a531da4d19fb951b5514da89e20cfad45ff3740f3c02975b4c7ee85', 2, 1, 'MyAppToken', '[]', 0, '2023-08-15 12:33:12', '2023-08-15 12:33:12', '2024-08-15 13:33:12'),
('1c33dd38cee31b096db4e96f2e05e2c5f07c3b7d8cec4f4d90f858f41824d9a667e9fe27ffd52a69', 1, 1, 'MyAppToken', '[]', 0, '2023-06-23 13:50:07', '2023-06-23 13:50:07', '2024-06-23 14:50:07'),
('1cd7ea2bc2dd1d19d6afad038c13c4a418a83a6a4f9b733d7c6ed2e916d16698a8af689ad2c18caf', 1, 1, 'MyAppToken', '[]', 0, '2023-07-24 12:31:31', '2023-07-24 12:31:31', '2024-07-24 13:31:31'),
('1d9b7d546f08cbac82ce0c7da0fddb85f95f66b6c2dcc44ab630d4dcc35d2e1bec47d0542cb4a184', 1, 1, 'MyAppToken', '[]', 0, '2023-07-21 12:43:17', '2023-07-21 12:43:17', '2024-07-21 13:43:17'),
('1e79cddbb022451f6cc511e579fa0a1810f3e72d36318f2488bcabc579f29d15fc4e4a1d09c664c3', 11, 1, 'MyAppToken', '[]', 0, '2023-07-28 06:52:36', '2023-07-28 06:52:36', '2024-07-28 07:52:36'),
('1f6a08fb8091f3bd556a2c1179af31288173811204af39191f66dbb8f7bebb2c66a29f5e33e94f97', 11, 1, 'MyAppToken', '[]', 0, '2023-09-14 08:19:09', '2023-09-14 08:19:09', '2024-09-14 09:19:09'),
('201ca513d757511bfccb3abf08abcec6fa1b5ee999794861f030e4e1d4629d66d703ee2c2362bfa6', 12, 1, 'MyAppToken', '[]', 0, '2023-08-09 17:32:15', '2023-08-09 17:32:15', '2024-08-09 18:32:15'),
('21ab52c605e5cde2167508c889f067c170b66167494f1107cb5829f88c56c870a2afb98697993ac3', 1, 1, 'MyAppToken', '[]', 0, '2023-06-21 16:44:42', '2023-06-21 16:44:42', '2024-06-21 17:44:42'),
('2483a3c09569a16bfc66b970377f4b123d4c4440d0a8e96551ed0232d3440e39353f7791e91042ad', 12, 1, 'MyAppToken', '[]', 0, '2023-08-07 13:33:44', '2023-08-07 13:33:44', '2024-08-07 14:33:44'),
('2590e3d1514b97b96ae79efb28f976bc4e9ee6caf4ebeedd449c2dbb292376a21e4be7dbb4b4c71e', 8, 1, 'MyAppToken', '[]', 0, '2023-07-21 09:11:54', '2023-07-21 09:11:54', '2024-07-21 10:11:54'),
('263fcdae0bd4dea9d5b1140bac7841ffb74a52001d1102037899129f5283e27d6e6a47940d5ff2c0', 11, 1, 'MyAppToken', '[]', 0, '2023-07-31 10:34:28', '2023-07-31 10:34:28', '2024-07-31 11:34:28'),
('2657f5dee98772e7927fdf28ddf08e8f385479c915fa165c16507ed6e662b962ed3ee0f61fd301a5', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 12:44:28', '2023-07-21 12:44:28', '2024-07-21 13:44:28'),
('26c30b771bae71bb481dc999a578b210e14a199f3a6439842b6c01d4dc65f0e6e08417aa391d54ad', 1, 1, 'MyAppToken', '[]', 0, '2023-06-26 09:58:23', '2023-06-26 09:58:23', '2024-06-26 10:58:23'),
('275f1225b8c6e323e492afaba3c3022fef9796d84d9d44fa08e3244f0258f77ea094bb884b6d8438', 11, 1, 'MyAppToken', '[]', 0, '2023-10-16 16:46:06', '2023-10-16 16:46:06', '2024-10-16 16:46:06'),
('27818e669cf9a7e74374ad4844ec5327f4b75e512c98ec1341504c5e6862acb7c8a9363a0c8cb0fa', 11, 1, 'MyAppToken', '[]', 0, '2023-09-01 10:37:00', '2023-09-01 10:37:00', '2024-09-01 11:37:00'),
('27d56d6971e63eb9f0b1d82852518339f732c5d7309fcc6961b797765fcd0792c2d671a80843978a', 11, 1, 'MyAppToken', '[]', 0, '2023-08-04 06:04:19', '2023-08-04 06:04:19', '2024-08-04 07:04:19'),
('2964ee9cb76fe4ecaec174b264e3093a4ea0082784a48c23c7d2a18fa47ad8ece9c75070c8e15c80', 1, 1, 'MyAppToken', '[]', 0, '2023-07-24 14:37:18', '2023-07-24 14:37:18', '2024-07-24 15:37:18'),
('2b8f14ad94a9e85af6aad5918ac0505a8853f059fa558bd4e9d2367414e114138cd790fe5484e04e', 2, 1, 'MyAppToken', '[]', 0, '2023-06-23 10:26:41', '2023-06-23 10:26:41', '2024-06-23 11:26:41'),
('2cb22f0191552ba1d90e311c998c2cfcd062cc21e44af9f08e8b24944abc08d6a0b52cae87633936', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:57:03', '2023-07-28 09:57:03', '2024-07-28 10:57:03'),
('2dd8138ee82d4cb17b58a788aab490b146bc43498e7df3b0b5c7661db8a72ffccf1f195caf97acba', 11, 1, 'MyAppToken', '[]', 0, '2023-10-16 15:38:54', '2023-10-16 15:38:54', '2024-10-16 15:38:54'),
('2e5f5f4f5b411b0267066ca68fb87050552b4cfd3ab394a658febb3643332fd506da391a2f0efa47', 11, 1, 'MyAppToken', '[]', 0, '2023-07-17 07:44:12', '2023-07-17 07:44:12', '2024-07-17 08:44:12'),
('2ecf811917af83a2f6c651ce4009d62f9dbd14b4e2368acb83a0e6906f489414476bdd387c2cfa17', 11, 1, 'MyAppToken', '[]', 0, '2023-07-25 06:39:45', '2023-07-25 06:39:45', '2024-07-25 07:39:45'),
('2f2400c256654ad644bb6f75c474d81197801f373f058184698358794bb3e1cc1b44d1deff79a83d', 10, 1, 'MyAppToken', '[]', 0, '2023-07-07 07:42:05', '2023-07-07 07:42:05', '2024-07-07 08:42:05'),
('300085e244e2eb0c9fb836b11110667902d04740380f3a53ea0ae90526dc4b5896c33ee8d34328a1', 11, 1, 'MyAppToken', '[]', 0, '2023-08-10 11:13:58', '2023-08-10 11:13:58', '2024-08-10 12:13:58'),
('31a34a58a345d6ac121e164a379a7cf4c032cacb06a9cbb99ea3bf22abf2c5d17d669548fa49cdb4', 12, 1, 'MyAppToken', '[]', 0, '2023-08-10 09:52:42', '2023-08-10 09:52:42', '2024-08-10 10:52:42'),
('339722a090edbd052d4bf5ce9f7a98713ffe70d85221fab61199e27a4559defb602c6d2f31b124b2', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 06:26:42', '2023-07-28 06:26:42', '2024-07-28 07:26:42'),
('33dd4c7d49f6d584b29a03cf7ceb6a25e965154fc691a7bddb4d8a8b1bca0c7ca28907bfd0d9fee6', 11, 1, 'MyAppToken', '[]', 0, '2023-08-15 12:33:56', '2023-08-15 12:33:56', '2024-08-15 13:33:56'),
('3516226ebfc45b939bb7ea7010c812d8b1ddbe1ad655f3594ee8febd79dcd96f7ba26cb94b277c3c', 9, 1, 'MyAppToken', '[]', 0, '2023-07-07 07:44:43', '2023-07-07 07:44:43', '2024-07-07 08:44:43'),
('379f1a5dd61474a3b8a23ec8814bf33f8a1c758b18cc25ce1fb09575287822bbcb6e2f0020a1fc44', 1, 1, 'MyAppToken', '[]', 0, '2023-06-22 10:59:07', '2023-06-22 10:59:07', '2024-06-22 11:59:07'),
('37a39100fb9a4321d76bcaad59089e034283d2feb636161899bd9a466e787d8dcfb4f33fcbaea414', 10, 1, 'MyAppToken', '[]', 0, '2023-08-09 21:03:42', '2023-08-09 21:03:42', '2024-08-09 22:03:42'),
('3b191c93d7e3650328a39d8a8b2789b8799118188c83a010440eb9eed2cb3aa027fb2623ff4fdae8', 10, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:12:26', '2023-07-21 14:12:26', '2024-07-21 15:12:26'),
('3b311bc5af50fcfbcbcac907339c49604e0f39ff2bac9b9a017d6a11b615bf83f439d83ebb1b2f6e', 11, 1, 'MyAppToken', '[]', 0, '2023-07-14 06:24:16', '2023-07-14 06:24:16', '2024-07-14 07:24:16'),
('3c74b3d52beb9c0e3c93037b69779c4b8a7570074364736a6bf407c711fb902c3fdba1a31c1b5319', 11, 1, 'MyAppToken', '[]', 0, '2023-07-07 10:42:48', '2023-07-07 10:42:48', '2024-07-07 11:42:48'),
('3d680fed2fa0d5a976e49bddd2b56002ce8b0e9670a05cc1046285c4e77f4f654eda9e9a1fba7dd2', 12, 1, 'MyAppToken', '[]', 0, '2023-07-07 09:29:44', '2023-07-07 09:29:44', '2024-07-07 10:29:44'),
('3e89029c6345c974ffb553016e66a4072a70000f2ec0c09bfb10ec5563f9c29aa6202bccb5acd1fb', 11, 1, 'MyAppToken', '[]', 0, '2023-08-10 23:13:38', '2023-08-10 23:13:38', '2024-08-11 00:13:38'),
('3eeeb7627f7607b82714de74f01ca1815dd0dcc2240a736af2a74b919c80dfbb39465db926898558', 9, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:40:10', '2023-07-07 08:40:10', '2024-07-07 09:40:10'),
('407cffd20d536e819f9b525c19baa697bebdfe0a53c0bc2b8dd20eff25d8330a5c5f9336f85bac75', 10, 1, 'MyAppToken', '[]', 0, '2023-07-19 08:39:56', '2023-07-19 08:39:56', '2024-07-19 09:39:56'),
('40ad1ca093027f591f864a4815545cc35938674ee70fbb30237a1c200ad1ad42818f1fa8d36cae5c', 11, 1, 'MyAppToken', '[]', 0, '2023-06-23 11:21:45', '2023-06-23 11:21:45', '2024-06-23 12:21:45'),
('422e72092f931335fd8cac9816500ade60f202e0f1b1b0199040e39215420902338b6b7a68562f67', 2, 1, 'MyAppToken', '[]', 0, '2023-06-23 11:24:47', '2023-06-23 11:24:47', '2024-06-23 12:24:47'),
('45c49ea952239a598115044b71c5042768a1f287c354b0968056b4866541b70d14fefc1f723d53f6', 11, 1, 'MyAppToken', '[]', 0, '2023-07-07 13:59:48', '2023-07-07 13:59:48', '2024-07-07 14:59:48'),
('46b38486559a8d77ae32118d79d5f40698818c56cd61c68cf8e0dc14946d060744f9971e65448d4d', 11, 1, 'MyAppToken', '[]', 0, '2023-07-19 08:34:25', '2023-07-19 08:34:25', '2024-07-19 09:34:25'),
('47b281417b13ae0941739693c309a25719906c33e1422782974854cd385a0ecda6d3f954398360fb', 11, 1, 'MyAppToken', '[]', 0, '2023-08-15 13:09:24', '2023-08-15 13:09:24', '2024-08-15 14:09:24'),
('4822fd9a979471a666ca8e2e86b0fd77fda4177265e0749c2216276579983dcf74df22dc8a27ce84', 10, 1, 'MyAppToken', '[]', 0, '2023-08-13 23:24:24', '2023-08-13 23:24:24', '2024-08-14 00:24:24'),
('4c2bb48f031d84962de23512225e5adf28e199a48d56f42f3bc438c051a77500ea268ba2ae34519b', 11, 1, 'MyAppToken', '[]', 0, '2023-08-07 07:46:05', '2023-08-07 07:46:05', '2024-08-07 08:46:05'),
('4e13a504c11bbe47445b73d551cd8040770255a26edf6b3136e24a5fb851cc38a2836f81d956fc83', 1, 1, 'MyAppToken', '[]', 0, '2023-07-07 07:33:52', '2023-07-07 07:33:52', '2024-07-07 08:33:52'),
('4f6d5be42d2fa3e4c0629a23b7904147e53b06c0bb15f84c42a9e32725997aea16951ca2ac751d8e', 11, 1, 'MyAppToken', '[]', 0, '2023-08-11 09:01:07', '2023-08-11 09:01:07', '2024-08-11 10:01:07'),
('516e2977ba933b59477219571cd87da1af5aaa4a8c085db154d76a6ae182115060c1216cff34969a', 11, 1, 'MyAppToken', '[]', 0, '2023-07-07 07:45:43', '2023-07-07 07:45:43', '2024-07-07 08:45:43'),
('517eee0ef5d054d30f7b6ad43e9ff10472e1086b57ce9b1128dc3d9242f439b48aa3ca11e1065076', 1, 1, 'MyAppToken', '[]', 0, '2023-07-28 08:51:37', '2023-07-28 08:51:37', '2024-07-28 09:51:37'),
('5285055f3d5a28122f47231371543006eb5bdb9ff49174c8e28414ded7009b0cb6e33d662e0f8af9', 1, 1, 'MyAppToken', '[]', 0, '2023-07-07 07:34:50', '2023-07-07 07:34:50', '2024-07-07 08:34:50'),
('561024a81bf7f95c281c825c91086f3d05314c46f02dbc27a9c8e79cd5c11d7b08829562aaa6b2af', 11, 1, 'MyAppToken', '[]', 0, '2023-07-19 07:06:44', '2023-07-19 07:06:44', '2024-07-19 08:06:44'),
('56d339a9fa96e35a98ce873cc3991c375e4cbf6cf6145fac44b393cd6c9ff893fd9df0aba9a9ebcc', 11, 1, 'MyAppToken', '[]', 0, '2023-07-28 06:44:55', '2023-07-28 06:44:55', '2024-07-28 07:44:55'),
('5b727d852a8e67acc57eafc445d24ad540dceb4f28861abd93021a1e150dd54fb7300ee098dbe20d', 1, 1, 'MyAppToken', '[]', 0, '2023-07-24 11:43:10', '2023-07-24 11:43:10', '2024-07-24 12:43:10'),
('5c155dd4121014d9e48896954d8d357d94ed4720554a2fd0b32e3bcac268241ecaf19d24440cd904', 11, 1, 'MyAppToken', '[]', 0, '2023-08-14 18:27:05', '2023-08-14 18:27:05', '2024-08-14 19:27:05'),
('5d42377ce9d763febd0d873f7b3b6c3c5daf747c8732642bdf29e78957d3c7ed95b6985b06c6d0cf', 11, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:43:49', '2023-07-07 08:43:49', '2024-07-07 09:43:49'),
('5da4bb1eed5cf6652e596202f3c3cae38e053477da2deb1adce3bdb8c9b997d04d328423feef1ec7', 13, 1, 'MyAppToken', '[]', 0, '2023-10-16 16:35:03', '2023-10-16 16:35:03', '2024-10-16 16:35:03'),
('5ea878b04d63eaf0b7e27237fcf7aedba133aeaca184e55113f4cd252b498a1f8d01838f9f6d76c6', 1, 1, 'MyAppToken', '[]', 0, '2023-07-21 10:39:18', '2023-07-21 10:39:18', '2024-07-21 11:39:18'),
('5eeb44080f20bf6773bcf5d2e44a9473e9f404a37081853ac71da09caa8ec1bc725d0d38b5ec2c9a', 10, 1, 'MyAppToken', '[]', 0, '2023-07-07 09:29:18', '2023-07-07 09:29:18', '2024-07-07 10:29:18'),
('5fc4356444525ce3b7ffeff88c1bc229bb593e0651a13c0d0086d245854b1c596190c303a99c9652', 1, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:33:25', '2023-07-21 14:33:25', '2024-07-21 15:33:25'),
('6092c5883b47a84b39f1b265db58212dbeb8008da318d11eb8aabaa21ae900769de42576baf320df', 9, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:24:31', '2023-07-07 08:24:31', '2024-07-07 09:24:31'),
('62180212486166bc6d2f2cf7efe8565cd45b7f96a88fb6905d5a3ffa97ea9c6034134dec15742ac6', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:13:40', '2023-07-21 14:13:40', '2024-07-21 15:13:40'),
('62e220be6f72a1bb42f93f8402f24c64a57a8a5ff49e0cbb97900ff912f7438e051e7f4d2059b36c', 10, 1, 'MyAppToken', '[]', 0, '2023-07-21 06:30:07', '2023-07-21 06:30:07', '2024-07-21 07:30:07'),
('63fa6f53f089f55a6f6897fa165cfce5789a23311d0876b630d308c8a9956e0cacd142e058b851bd', 2, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:35:25', '2023-07-21 14:35:25', '2024-07-21 15:35:25'),
('660034b700f707c0b1accd974df990558bfff52f87be57c9e96145865bfc62b5a177c9eec1067f8c', 11, 1, 'MyAppToken', '[]', 0, '2023-07-27 08:13:43', '2023-07-27 08:13:43', '2024-07-27 09:13:43'),
('6703fa1e21f40b2a1b3ce399e85b4a27f8a2c54c93f17dd4cda8a16006a6fe1e769cd2d242e760ac', 12, 1, 'MyAppToken', '[]', 0, '2023-08-15 13:04:51', '2023-08-15 13:04:51', '2024-08-15 14:04:51'),
('6832dc217ad932bd474b88dd14c6f6c1290a2e5381ccdf7e5e1af5a054c16e31ad0f19a7c0f69b5e', 1, 1, 'MyAppToken', '[]', 0, '2023-07-24 20:35:58', '2023-07-24 20:35:58', '2024-07-24 21:35:58'),
('68d560f39508f4d841754360d425c6fcd76c766c9dec2ecdb949f59a59e898ae7a75a669a1d3b9c1', 11, 1, 'MyAppToken', '[]', 0, '2023-07-12 06:51:46', '2023-07-12 06:51:46', '2024-07-12 07:51:46'),
('68d7082157b927bf3e2efa9661cc42c753f6d36d05d569fda23f2ceb521e112cb9d06a97e1773275', 2, 1, 'MyAppToken', '[]', 0, '2023-06-22 10:50:02', '2023-06-22 10:50:02', '2024-06-22 11:50:02'),
('6950311d0243a5796a76519e419542b50a48c3b09bb29ce1a9f9efac4da994e1440e22105a54421a', 1, 1, 'MyAppToken', '[]', 0, '2023-07-28 08:40:52', '2023-07-28 08:40:52', '2024-07-28 09:40:52'),
('6a7bb0ee49405aeb9992d4f897f8c7aedb2440261bc3e1fc07a229129e712dc20f982b1e2b119d5e', 11, 1, 'MyAppToken', '[]', 0, '2023-08-13 17:29:53', '2023-08-13 17:29:53', '2024-08-13 18:29:53'),
('6aae9fcd0e14d5712d39123ad1e500ff79ef7fde13b991c27766f8dda48c17cf9339cbf84b09f9ba', 11, 1, 'MyAppToken', '[]', 0, '2023-08-28 05:54:39', '2023-08-28 05:54:39', '2024-08-28 06:54:39'),
('6ac6a76757dec895166a923356e519dc2f76f6d2494d1962be52d567437f42622db9fb3b45f4ac99', 8, 1, 'MyAppToken', '[]', 0, '2023-07-31 07:15:59', '2023-07-31 07:15:59', '2024-07-31 08:15:59'),
('6af6713225983907153d32f0b0f3e6e51bf604b28eae6baf8f8ed3e5f776c238894d27a4055d2456', 11, 1, 'MyAppToken', '[]', 0, '2023-08-21 22:33:49', '2023-08-21 22:33:49', '2024-08-21 23:33:49'),
('6c9889f883b5cae0d33b932dbdbaa0ffb7f4d15e3d7e46723193656a64f8b868eae9be143b7a7f74', 12, 1, 'MyAppToken', '[]', 0, '2023-07-21 06:37:56', '2023-07-21 06:37:56', '2024-07-21 07:37:56'),
('6cc97128a803ad4a3abf87089a60c6587b461c41ee25c7f61b23190e8788d9ce36c30ed92397a3fd', 2, 1, 'MyAppToken', '[]', 0, '2023-07-24 20:45:35', '2023-07-24 20:45:35', '2024-07-24 21:45:35'),
('6d736cf30e935fdaf9ac976678ca01dad392764d5ae43c17cc3bf8f79e26bcbdc5c3c7adc710473f', 1, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:42:23', '2023-07-28 09:42:23', '2024-07-28 10:42:23'),
('7027cb1c937a4cbfdf73d3f1114fd69dae1883465c2555fea8e0112ddffab88641ab86a8ca64fbf7', 10, 1, 'MyAppToken', '[]', 0, '2023-08-09 17:09:11', '2023-08-09 17:09:11', '2024-08-09 18:09:11'),
('71d6aabb35f498553432a9703dd7affbadb2d1278c06045797c8d9f0d604ccf9f2f9fcb152d0534d', 11, 1, 'MyAppToken', '[]', 0, '2023-08-12 21:02:45', '2023-08-12 21:02:45', '2024-08-12 22:02:45'),
('71e203e771fe71c577d05f063442333c5c19cd1943d0fdb6e851f161af8317eca69458729ec58b38', 10, 1, 'MyAppToken', '[]', 0, '2023-07-07 10:13:43', '2023-07-07 10:13:43', '2024-07-07 11:13:43'),
('7286e2e47f53f5b1d52edf4d387422b2bf2ca1b85921453f6d40074c609b8972169502f1836a6acc', 12, 1, 'MyAppToken', '[]', 0, '2023-08-10 10:03:59', '2023-08-10 10:03:59', '2024-08-10 11:03:59'),
('783a8f5e904f6b5c5f8c6a8e0c473c8b5b1444efa1c380dd4d6feada1b8c4789b446fc4c273f5d2d', 11, 1, 'MyAppToken', '[]', 0, '2023-07-09 12:55:05', '2023-07-09 12:55:05', '2024-07-09 13:55:05'),
('78ad7b1ac161b7384384a54a6beec2cf4fca311a056d960998c160841fc8fa24a7dcfe48fb42609d', 12, 1, 'MyAppToken', '[]', 0, '2023-08-07 12:50:39', '2023-08-07 12:50:39', '2024-08-07 13:50:39'),
('79cac7c9e5a31ec49eabd71d1ed04eeeda1cd2ef4df05eb2d2be28af5c75c2b1cabefee27b1aaae9', 12, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:42:53', '2023-07-07 08:42:53', '2024-07-07 09:42:53'),
('7ab0ec4025d371b8ee5a0b7ad6a98e2d8c04b351d8b557f0ec7eded4c069a6c2614c223b1a3719db', 10, 1, 'MyAppToken', '[]', 0, '2023-08-14 18:26:05', '2023-08-14 18:26:05', '2024-08-14 19:26:05'),
('7ebdd76219c7336352dc5774d7609922ebceeb02bba6824098dc9096a1192722e308d32ee43f2394', 12, 1, 'MyAppToken', '[]', 0, '2023-08-09 18:43:13', '2023-08-09 18:43:13', '2024-08-09 19:43:13'),
('7eff6519aa9d96b6f77187557f862d2c158e8afc725d48b1d5e1dfbedb71bacae361224bdea1c911', 1, 1, 'MyAppToken', '[]', 0, '2023-07-24 14:26:53', '2023-07-24 14:26:53', '2024-07-24 15:26:53'),
('805920909d91bebf490f05bb96f80bb2f53164e44d40bd032ae06d37aa40f941b594fafe4de68fd2', 1, 1, 'MyAppToken', '[]', 0, '2023-06-22 10:20:49', '2023-06-22 10:20:49', '2024-06-22 11:20:49'),
('81280867372250d2b43878ea8d301522745b8bf59840a4330a0fcb8ccc16c0d0c057cdcf9d7ce7f4', 11, 1, 'MyAppToken', '[]', 0, '2023-08-13 08:58:14', '2023-08-13 08:58:14', '2024-08-13 09:58:14'),
('818e83ebcd165ff170bd9e21ae03c92b954fda2b90892b02760209f691f8f128d3e6f31c3b69e1e1', 10, 1, 'MyAppToken', '[]', 0, '2023-08-09 17:54:39', '2023-08-09 17:54:39', '2024-08-09 18:54:39'),
('81cc56fcb0b3f0ac18b9dee605ca3810be5d483fcd98c30281719a63bbd039d13e4dd5791d5506a3', 11, 1, 'MyAppToken', '[]', 0, '2023-07-09 14:25:02', '2023-07-09 14:25:02', '2024-07-09 15:25:02'),
('82cb54908f31b629d900904a1ecc6077d55eaf55cd91451f5ffb6cf50dedf3ef1b8345524db90075', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:41:52', '2023-07-21 14:41:52', '2024-07-21 15:41:52'),
('8385b9d7c313b21df6f22b20234b81d03d0d9a23d9182776a2f64939bef407951ee27dad76727c86', 12, 1, 'MyAppToken', '[]', 0, '2023-08-10 11:19:40', '2023-08-10 11:19:40', '2024-08-10 12:19:40'),
('864f922034cf49bef2da77d66be85713e8f32e237cee6e2267ebec61498393915100df34b73853d4', 10, 1, 'MyAppToken', '[]', 0, '2023-07-19 10:44:01', '2023-07-19 10:44:01', '2024-07-19 11:44:01'),
('86593c77c4d23de6d3dccee6aa63e737a7d55a3fba5fee5007461e1e1d740f6e44c1195b0b2efece', 11, 1, 'MyAppToken', '[]', 0, '2023-08-21 08:41:02', '2023-08-21 08:41:02', '2024-08-21 09:41:02'),
('872497e1efbf9f412173d5ba19538a0070074ff494afe10bc7e6fbbb46cb466a1b2bffb9741b05bd', 10, 1, 'MyAppToken', '[]', 0, '2023-07-21 10:15:00', '2023-07-21 10:15:00', '2024-07-21 11:15:00'),
('87c6f4fc3a1b0959187630f34b10dbb5b41adcc99e5108c150fdba78ee24cdab50c0058f01f526e5', 11, 1, 'MyAppToken', '[]', 0, '2023-06-23 10:24:43', '2023-06-23 10:24:43', '2024-06-23 11:24:43'),
('8b4f7dbf9d09088ddf13a8b289fae5d8f314adb937718e2eb51e185685735c5227d8781c838cbec9', 11, 1, 'MyAppToken', '[]', 0, '2023-07-28 08:13:00', '2023-07-28 08:13:00', '2024-07-28 09:13:00'),
('8f52f7db59d1c84f1c58467c754dae0fa1ac9e7fcd0f7b7a75b3cce9369cd9052aa47863c44fb2ef', 11, 1, 'MyAppToken', '[]', 0, '2023-07-11 15:34:18', '2023-07-11 15:34:18', '2024-07-11 16:34:18'),
('8fc56e2984cf1da5225d3ebc12e06d857330e9df32d7d42bf39ef4b00ec9561f7804ebe4b3f26b41', 1, 1, 'MyAppToken', '[]', 0, '2023-07-28 08:50:27', '2023-07-28 08:50:27', '2024-07-28 09:50:27'),
('90236c8c2295ca01439cba388ef3d0e0fbf9301efde98993acb47298d8d4824cd5fd590356908759', 10, 1, 'MyAppToken', '[]', 0, '2023-08-09 16:51:07', '2023-08-09 16:51:07', '2024-08-09 17:51:07'),
('903fa8bc8f7dd21c91855d2cc386e5d00381568f661ddfaa5af811ddfdb2229e2384bf9c75d13068', 10, 1, 'MyAppToken', '[]', 0, '2023-07-24 15:00:05', '2023-07-24 15:00:05', '2024-07-24 16:00:05'),
('91782a9c833b3c636438e870d03b953fa5a66e2dd75ff9b83a45ec19641f71ee256449eb70040b13', 13, 1, 'MyAppToken', '[]', 0, '2023-10-16 15:38:01', '2023-10-16 15:38:01', '2024-10-16 15:38:01'),
('91dfc7c31865b3bb9bdc67762350a72393bb4ccdd4bf1423bc9aba753b9e992b73f47527e40d39e8', 1, 1, 'MyAppToken', '[]', 0, '2023-08-10 23:12:33', '2023-08-10 23:12:33', '2024-08-11 00:12:33'),
('93b26c9f3bcd436de7019fe6defe7c790f45373ec8e9f502e45c361e7cf7f18bb64db2053e0abbc7', 10, 1, 'MyAppToken', '[]', 0, '2023-06-22 10:53:40', '2023-06-22 10:53:40', '2024-06-22 11:53:40'),
('942a675c20b8a2d821d866e35d3eba1f0a5a1e12152de14b78797ecb780e41c9013d3ce4a388bca6', 12, 1, 'MyAppToken', '[]', 0, '2023-08-15 12:56:14', '2023-08-15 12:56:14', '2024-08-15 13:56:14'),
('94aabe34fe2ab27be3828780f5c244b6cad7d5f30edc9a03966e0f10a9cbf57a8362efff0d87ebd2', 11, 1, 'MyAppToken', '[]', 0, '2023-07-27 06:09:51', '2023-07-27 06:09:51', '2024-07-27 07:09:51'),
('95b85c2735c99a34013627a853ed8038fd83d074bc620abf45c6fbfc461f87cb42f4f702a0b7c98b', 12, 1, 'MyAppToken', '[]', 0, '2023-07-07 09:56:29', '2023-07-07 09:56:29', '2024-07-07 10:56:29'),
('971567b7505a3506b38f4d49240841fcdc2402f58c6c73391cde33d13c4a4cdaa3af7628da199a03', 11, 1, 'MyAppToken', '[]', 0, '2023-07-28 08:50:45', '2023-07-28 08:50:45', '2024-07-28 09:50:45'),
('985a797da9ea73721eccbb264e886c4f38a980e8fddef40197670ad74631d528e99002bdecdff348', 12, 1, 'MyAppToken', '[]', 0, '2023-07-07 09:21:22', '2023-07-07 09:21:22', '2024-07-07 10:21:22'),
('998b56e2a92c802a33e95e4e021325de91b3c97583e4805fbfe851141d46588fcf7cd781602d02d5', 1, 1, 'MyAppToken', '[]', 0, '2023-06-23 12:23:46', '2023-06-23 12:23:46', '2024-06-23 13:23:46'),
('9d7cc633f15070dd7f04119d24839b1d26478b5861abf88bc6dc1762cf86ddc20259cac6cd55c953', 11, 1, 'MyAppToken', '[]', 0, '2023-07-31 07:16:36', '2023-07-31 07:16:36', '2024-07-31 08:16:36'),
('9dfc94ae982843bb440885b4c77c53a0d8ad18d56247c98e8fd429972d27ac4209306dc27957a1a1', 11, 1, 'MyAppToken', '[]', 0, '2023-07-13 13:21:40', '2023-07-13 13:21:40', '2024-07-13 14:21:40'),
('9e45e39fb43883c2dd114ada0fd1f3331b4cfb64188e5dddb3380a5c38fb4649d3f3348be66c2fed', 12, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:44:33', '2023-07-07 08:44:33', '2024-07-07 09:44:33'),
('a089a677ac6e78127a2e302c746586972cc8e2a5dca5a67d870511385be316823fce6ce1f86b9d34', 13, 1, 'MyAppToken', '[]', 0, '2023-10-16 16:43:06', '2023-10-16 16:43:06', '2024-10-16 16:43:06'),
('a1283e02db9bb39d8c481f7a0d2c75bfb02a9e6874c2a88e8db1c3b5e28d6e97791b781795d7cd80', 2, 1, 'MyAppToken', '[]', 0, '2023-08-10 23:09:27', '2023-08-10 23:09:27', '2024-08-11 00:09:27'),
('a1421a9099a6bb32441f7ca270e9af9be9f5e1ec33ee91b61a99d8583c0d12991421283ef3e514d1', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:34:27', '2023-07-21 14:34:27', '2024-07-21 15:34:27'),
('a16714ff70fb4a1c86cc0a6246810e8b3dd33b03e0bac8727b8d52fde0635164a3307e87a4de6eea', 11, 1, 'MyAppToken', '[]', 0, '2023-08-02 16:09:51', '2023-08-02 16:09:51', '2024-08-02 17:09:51'),
('a1c92bab5426891bb9a1c545f497dc4651f03db69b695d363fa30bf1d56881fef3a4dd9c6316b988', 10, 1, 'MyAppToken', '[]', 0, '2023-07-19 07:24:42', '2023-07-19 07:24:42', '2024-07-19 08:24:42'),
('a1d3f0edd6370d9ab44e7dcf0492233648202a3416873f1eb23756bc08a5e4945b7ac9f4445e0cd6', 13, 1, 'MyAppToken', '[]', 0, '2023-10-16 16:47:45', '2023-10-16 16:47:45', '2024-10-16 16:47:45'),
('a471851e32c46ced2e76010c4cded7c137cea900798dc5cdecc08181a9d45369f121cd1f545ee67e', 10, 1, 'MyAppToken', '[]', 0, '2023-07-21 10:18:22', '2023-07-21 10:18:22', '2024-07-21 11:18:22'),
('a52a49e990b157201418d56c4cfc38961239c31f821e240e980523f9f5ef65635fe6bd5d1f390720', 1, 1, 'MyAppToken', '[]', 0, '2023-07-28 08:11:28', '2023-07-28 08:11:28', '2024-07-28 09:11:28'),
('a55ccdfd154a136e95236a0c5ac861ffe7f88c1eae5101db8f405f3056898cd94f5524664b2304ac', 10, 1, 'MyAppToken', '[]', 0, '2023-08-09 17:33:25', '2023-08-09 17:33:25', '2024-08-09 18:33:25'),
('a5c53c93fdd57451c292dd08eae717a4a77ae435b50c5b9e97b30f260a024f9c24e06ad35b27f921', 11, 1, 'MyAppToken', '[]', 0, '2023-09-15 09:15:46', '2023-09-15 09:15:46', '2024-09-15 10:15:46'),
('a6845d64f72e232a7d05a3437f4683e50903c9e0fe02d8ff61b5fb2dcbf0a5d8934992d75663fe4e', 11, 1, 'MyAppToken', '[]', 0, '2023-07-07 07:43:14', '2023-07-07 07:43:14', '2024-07-07 08:43:14'),
('a7909ee42d1342e33e488736185706159267f3380275fa50c4329a5dfe10836d1568fa0a04af0bd4', 11, 1, 'MyAppToken', '[]', 0, '2023-07-28 06:27:26', '2023-07-28 06:27:26', '2024-07-28 07:27:26'),
('aa5523e55ff59f9637928eb0e4a96ad6829b29ddb08b98a99ba54da547a7400cfce510e835d6dcbb', 12, 1, 'MyAppToken', '[]', 0, '2023-08-09 21:59:33', '2023-08-09 21:59:33', '2024-08-09 22:59:33'),
('aaae9a4e997e56813a73c9d0d7a613b2bfeb5361db0c87ffb83c17b7ff97a43ff53653ce0972d1e0', 1, 1, 'MyAppToken', '[]', 0, '2023-07-28 06:26:14', '2023-07-28 06:26:14', '2024-07-28 07:26:14'),
('aaea915bc5bd0eb21e5ebc854c1540316ee347c656c7da741ccf441becc71b165ce07c7c888eeca6', 11, 1, 'MyAppToken', '[]', 0, '2023-08-15 08:32:34', '2023-08-15 08:32:34', '2024-08-15 09:32:34'),
('ac16c976109149b2a429d685961040172454c9eb6b72881142390ad5ac51d5812e443075a664a219', 2, 1, 'MyAppToken', '[]', 0, '2023-06-23 12:22:20', '2023-06-23 12:22:20', '2024-06-23 13:22:20'),
('aebc2f7373288fc487815d6284b258b00247d4e710dcb88ee199267fa81cb83bc52f306985958774', 11, 1, 'MyAppToken', '[]', 0, '2023-07-28 07:02:13', '2023-07-28 07:02:13', '2024-07-28 08:02:13'),
('aee3b8e6227367efc428dec7a6d49c8c89cef667f1b8c1d7b0887e228f681f4f551d692df8b10c29', 10, 1, 'MyAppToken', '[]', 0, '2023-08-08 09:19:38', '2023-08-08 09:19:38', '2024-08-08 10:19:38'),
('af358e01f577fa6694f5fdc4ede0f3a54c05dabb97bd17b344d204d772b0bc6108e6e2db2d22f4ab', 11, 1, 'MyAppToken', '[]', 0, '2023-09-01 06:01:46', '2023-09-01 06:01:46', '2024-09-01 07:01:46'),
('afab4a2f57f8fb5acc6db4dfbde14a7813365151131b3874ab281d8f5a9e61d1bc0b0e7b80876b68', 11, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:23:18', '2023-07-07 08:23:18', '2024-07-07 09:23:18'),
('b0ebe44b7d9972c9eb061bd2823c65509bec902e3196000c25fc102bc5e5e2d22b7ac6f99ac45bfa', 10, 1, 'MyAppToken', '[]', 0, '2023-07-24 12:32:38', '2023-07-24 12:32:38', '2024-07-24 13:32:38'),
('b1af3f68b49759ba8ea2e40bfa623c70f7108aa0e7ff6baccdf424a31714aa3715d0d144ee7b8701', 12, 1, 'MyAppToken', '[]', 0, '2023-08-15 12:32:46', '2023-08-15 12:32:46', '2024-08-15 13:32:46'),
('b1d20744febfd293dc8952d5113b8dd5281800d7740e77033624724bcdb8787a7bd6d1e8de141265', 10, 1, 'MyAppToken', '[]', 0, '2023-08-10 23:08:28', '2023-08-10 23:08:28', '2024-08-11 00:08:28'),
('b26d91d1713526db32d23aa46569f00b7f3725883af2e7c86f3a3654f615c848644927d5abc09609', 11, 1, 'MyAppToken', '[]', 0, '2023-07-24 06:25:25', '2023-07-24 06:25:25', '2024-07-24 07:25:25'),
('b47a6c05a4628664d121fc1e4e6cb409d4cab5cd1eb91eea22ed5428d6fdf60e0fda2f6eb95a5e96', 12, 1, 'MyAppToken', '[]', 0, '2023-08-09 17:06:22', '2023-08-09 17:06:22', '2024-08-09 18:06:22'),
('b4b08542246d9e5094c552a3b36ef5326f48d95703245260c075c6a2fa388c2197bc99640b83b1b1', 1, 1, 'MyAppToken', '[]', 0, '2023-06-22 07:45:42', '2023-06-22 07:45:42', '2024-06-22 08:45:42'),
('b4c123e17274729d0b452f69aab60d5fcaccf85edce7971fc2745ba1aab2db04ac4332d7ebfc28df', 11, 1, 'MyAppToken', '[]', 0, '2023-07-10 06:27:16', '2023-07-10 06:27:16', '2024-07-10 07:27:16'),
('b583cf0abce39730d0e764553885e48b3553b2f9291b4c5349c2055718c44a3eb224203279b84c4c', 9, 1, 'MyAppToken', '[]', 0, '2023-06-26 15:46:15', '2023-06-26 15:46:15', '2024-06-26 16:46:15'),
('b64c7000657b75f39711aad537983ac3d33cb05b9f160eb2bafd75533aa35e58a609dd33e2674a98', 1, 1, 'MyAppToken', '[]', 0, '2023-06-22 20:40:50', '2023-06-22 20:40:50', '2024-06-22 21:40:50'),
('b6f800c93c928c6607245d134610739d39f8a175d57d50f3455b15bd81d0de56f53a2574436809f0', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:18:34', '2023-07-21 14:18:34', '2024-07-21 15:18:34'),
('b811c251fd51d2e27647b2af6840590f93bc1e1ba4d51be16e0f6a5fba29abbed8ff87cb83d1e9e9', 10, 1, 'MyAppToken', '[]', 0, '2023-08-07 13:31:12', '2023-08-07 13:31:12', '2024-08-07 14:31:12'),
('b8c516031bb706d5681a18858a529633b322edaee087fe68a9785b0fa3a0111e4a0e64fcb869986b', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:11:31', '2023-07-21 14:11:31', '2024-07-21 15:11:31'),
('b8e6247782658627571414c0816d7b43bf0b630ed43da6d378905a62bd3c6ee0ad5b7a7cd9b99930', 11, 1, 'MyAppToken', '[]', 0, '2023-09-01 14:18:08', '2023-09-01 14:18:08', '2024-09-01 15:18:08'),
('b9a3869ef04f386ccdb7e39ae926b2b8e312183dced95c8daacdc4bc71e9a554376597c6946baaf0', 10, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:31:50', '2023-07-21 14:31:50', '2024-07-21 15:31:50'),
('bb038599a85ee51b7c2dfd61449dc038815ae32195230528299dba4303809ffc24f25c99189dc88e', 10, 1, 'MyAppToken', '[]', 0, '2023-07-20 07:10:11', '2023-07-20 07:10:11', '2024-07-20 08:10:11'),
('c1d58134be73275df6f64005cc8c6eacd7d0c807b5538673b188f619d9ac2254b603637192cc962a', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 08:51:55', '2023-07-28 08:51:55', '2024-07-28 09:51:55'),
('c1d837f104d39af6ee432eb7bbc2ac21289a8199fdc02d07c2be410d4f36f5ac794f549c35afe6f4', 1, 1, 'MyAppToken', '[]', 0, '2023-06-26 15:46:30', '2023-06-26 15:46:30', '2024-06-26 16:46:30'),
('c1da046d72c4bd8bc31cdeda9658dfdbf28cd32044d09814d9dadafde4e4363ef2885b14f780448c', 11, 1, 'MyAppToken', '[]', 0, '2023-07-10 13:16:24', '2023-07-10 13:16:24', '2024-07-10 14:16:24'),
('c3c76de53d265cb29737c1b8d9cd6d0f0dca235e8aea088f4a4e7faab457e99c274231e158aaa6d9', 1, 1, 'MyAppToken', '[]', 0, '2023-06-23 15:14:06', '2023-06-23 15:14:06', '2024-06-23 16:14:06'),
('c52be555453e25ecb2172566b8d3dd4503425a35e59fdc692138e19dcb0cb164dbe007c2f41b19ef', 12, 1, 'MyAppToken', '[]', 0, '2023-07-21 15:03:14', '2023-07-21 15:03:14', '2024-07-21 16:03:14'),
('c5a86449744f3905aecb4bed595c77c2bdcc58c958eed57a74f342763ae76ad67684ca6c2179ee3c', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:38:23', '2023-07-28 09:38:23', '2024-07-28 10:38:23'),
('c5f2fd16ace40497e38dac1f4ba243ceadf591bea7daf02fb24aee313bd8a8539674fe858e933d0d', 11, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:38:52', '2023-07-28 09:38:52', '2024-07-28 10:38:52'),
('c7d53fbc920a0d3422de7d3eb3f107f4ace88ab0d8dadb6e48ae8783fbd859dab1aa82759ddb0de7', 12, 1, 'MyAppToken', '[]', 0, '2023-07-24 20:44:13', '2023-07-24 20:44:13', '2024-07-24 21:44:13'),
('ca7c303c8c21425fb4b0d311d179bf781ce4d322bd53f269a966263d88938213d2e28e9967019465', 11, 1, 'MyAppToken', '[]', 0, '2023-07-19 10:43:08', '2023-07-19 10:43:08', '2024-07-19 11:43:08'),
('cc63c23f7d46a2170647d6369c963c693954eb1c62d2a10ccb042a1dc13f2a70b0820dbb61909622', 10, 1, 'MyAppToken', '[]', 0, '2023-07-21 10:45:49', '2023-07-21 10:45:49', '2024-07-21 11:45:49'),
('ccdaaa699b1d2d4c9d002eea8ab9be50b040c1470b2b111aebc3f4c7225998daed5db2f0bc95c251', 12, 1, 'MyAppToken', '[]', 0, '2023-07-21 09:10:47', '2023-07-21 09:10:47', '2024-07-21 10:10:47'),
('cd0c0939221b3e6289cbdf012feae07e72ea88091fce0225c4eaaf3231d371ae17225df9df63d3ea', 11, 1, 'MyAppToken', '[]', 0, '2023-08-01 21:19:08', '2023-08-01 21:19:08', '2024-08-01 22:19:08'),
('ce24ca318c5f1c2dfb4bcccaeed36a5436015f5260e62244895b505cb93501c593fd1e1caaf07db9', 11, 1, 'MyAppToken', '[]', 0, '2023-07-31 06:13:18', '2023-07-31 06:13:18', '2024-07-31 07:13:18'),
('cee0ac4b80d604024ba0c5a7b3685d71591a5d6b4cb8c853fafd6263cf3c98a55ca2ae88dc5e5465', 1, 1, 'MyAppToken', '[]', 0, '2023-06-22 20:42:59', '2023-06-22 20:42:59', '2024-06-22 21:42:59'),
('d07e234aadd4129ba6fcaceab8f321a6293cc59f9bcc004ec688b1987a15a8e22d9835f0650b1661', 1, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:41:20', '2023-07-28 09:41:20', '2024-07-28 10:41:20'),
('d12f64c7bdf3972724287c712410e691fbe7504554cd2c2e26296497d901afbadce479a8b356774d', 2, 1, 'MyAppToken', '[]', 0, '2023-06-26 15:45:56', '2023-06-26 15:45:56', '2024-06-26 16:45:56'),
('d1517e30cc9f5008674eb88e25def42275c4529ec58b99bbd998b92103b53c0e1bd74db5aea4fda3', 1, 1, 'MyAppToken', '[]', 0, '2023-06-23 08:04:18', '2023-06-23 08:04:18', '2024-06-23 09:04:18'),
('d203294e18ea8c9116a80b04dbb284ed584c28061d839c8630312dbdf7d286d3d5857a25c5d8e0e6', 11, 1, 'MyAppToken', '[]', 0, '2023-08-16 09:10:05', '2023-08-16 09:10:05', '2024-08-16 10:10:05'),
('d32f1951e2ad9fb0666ea0f0102cee7abba648bcd90cc7e50a8dad5f419171d517063666f97a34b5', 12, 1, 'MyAppToken', '[]', 0, '2023-08-10 11:12:47', '2023-08-10 11:12:47', '2024-08-10 12:12:47'),
('d80f360ff631c372f0797a9c801e4b0548a8ddf76a1e2d75690d75d3b774c547b6d5de9a58d46657', 11, 1, 'MyAppToken', '[]', 0, '2023-07-28 08:52:11', '2023-07-28 08:52:11', '2024-07-28 09:52:11'),
('db3ad206340be7d84d91a3008f52d61940596bda2985687e4e11dcb89044b60059d68d44887a52be', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 15:05:16', '2023-07-21 15:05:16', '2024-07-21 16:05:16'),
('db75e165c4551f1d85ff91e5c7d615e87695310ccd0c296f8498c3ce1aa58ba6871b755d52f4d56d', 10, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:17:04', '2023-07-07 08:17:04', '2024-07-07 09:17:04'),
('dbb22da82f16cbf88dd443fb23e1eed0319b81145557189bb41c5ff4a59c2d7e30ed23143dd8a9fa', 10, 1, 'MyAppToken', '[]', 0, '2023-07-21 09:05:11', '2023-07-21 09:05:11', '2024-07-21 10:05:11'),
('de090ce1f223351f8af20fcc10f46631d760a2dece4b6d9fd66294f8f0a20fabcd405ce5514eb7d5', 11, 1, 'MyAppToken', '[]', 0, '2023-08-12 21:03:23', '2023-08-12 21:03:23', '2024-08-12 22:03:23'),
('dfddd01e1ded09da8beace72515b8e94975d6e5cf73ed4bd54549bc527980a41f21c784cf182f1e9', 1, 1, 'MyAppToken', '[]', 0, '2023-06-22 13:11:35', '2023-06-22 13:11:35', '2024-06-22 14:11:35'),
('e1dd7aaa38aababdaa5f8d20b0c10fb1bfd879a23dc846b9fbd6c50bd3f8695e071eb4c1227c1e51', 12, 1, 'MyAppToken', '[]', 0, '2023-08-10 20:19:16', '2023-08-10 20:19:16', '2024-08-10 21:19:16'),
('e2015f988c429d5e1a16b50a225301bd01c0510a69e1f0361b6d7f392d31f57d0d99963715f5cd4c', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 10:38:05', '2023-07-21 10:38:05', '2024-07-21 11:38:05'),
('e26ab7d3b2aba4d34e5f615ce745c4c5590c9781fbdef4514ece9514d7c6aa545c8ce2db780deb4e', 10, 1, 'MyAppToken', '[]', 0, '2023-08-09 17:33:47', '2023-08-09 17:33:47', '2024-08-09 18:33:47'),
('e292629a0aff20f947b00db064154dc9a373fc416640dfb76d64b7cde4cade62f270c2dcb57b31fd', 11, 1, 'MyAppToken', '[]', 0, '2023-07-24 08:51:53', '2023-07-24 08:51:53', '2024-07-24 09:51:53'),
('e63e7a3e44c58e6d27e36d01828e6122d4bceacc84cb797f7f7fba36c60b5b4085647018ad284994', 11, 1, 'MyAppToken', '[]', 0, '2023-08-09 17:42:01', '2023-08-09 17:42:01', '2024-08-09 18:42:01'),
('e870d6c610475df29a76aa4cf138e751cceb567de09fb7b05e83d3f227f562e65c8bdc85ab365a2e', 10, 1, 'MyAppToken', '[]', 0, '2023-07-21 06:32:56', '2023-07-21 06:32:56', '2024-07-21 07:32:56'),
('e93ca5a89c75f7a419f0aee36ae8103390f102e98dd4f3b056e05a6121c962a0f271d66c8caf12f5', 11, 1, 'MyAppToken', '[]', 0, '2023-08-10 10:01:25', '2023-08-10 10:01:25', '2024-08-10 11:01:25'),
('ed1d16c2510ab10f1f59c667adfc0ebb8bb07d4740e5f216dcdae92dcebc0262a856995bd99c9949', 11, 1, 'MyAppToken', '[]', 0, '2023-08-12 18:28:38', '2023-08-12 18:28:38', '2024-08-12 19:28:38'),
('ed811c6cfa66318f2ce05a0f8021dbbd4a22672520991ebb3f5787ecb11fc679f603381b8471dfc1', 11, 1, 'MyAppToken', '[]', 0, '2023-10-16 15:09:17', '2023-10-16 15:09:17', '2024-10-16 15:09:17'),
('ee3737c7cae8e792dbf7e51c97c30a975fcea3a1cadd17e3c36aefc24108023b89582595924155cf', 11, 1, 'MyAppToken', '[]', 0, '2023-07-28 09:44:33', '2023-07-28 09:44:33', '2024-07-28 10:44:33'),
('efd76699d78b50872cdf62f062705b8f565d5cc752beb02938cd3e6e8454f9d1d4c60d61bbea185d', 1, 1, 'MyAppToken', '[]', 0, '2023-07-24 15:04:19', '2023-07-24 15:04:19', '2024-07-24 16:04:19'),
('f09a015561ae76511611d5350d7741242f08caca1ac48c672d08a460076c42fb4382300aba881306', 11, 1, 'MyAppToken', '[]', 0, '2023-07-07 08:40:20', '2023-07-07 08:40:20', '2024-07-07 09:40:20'),
('f0f75341a63991437bdf749a48708f689c52dc547d87f98ee3e20684272b9597402b18b9130117d7', 11, 1, 'MyAppToken', '[]', 0, '2023-08-08 09:21:27', '2023-08-08 09:21:27', '2024-08-08 10:21:27'),
('f1fac0e671e53369e981d1131ca6ded8c24014c3a5e8ffbfd55f22e81d0c2db44f2d43885cab8146', 1, 1, 'MyAppToken', '[]', 0, '2023-07-21 11:28:28', '2023-07-21 11:28:28', '2024-07-21 12:28:28'),
('f35076a38ec0f3c20691fe8bf98174817f8c9bc062b41db4821bf56ffaf7f5276cea4bc401c15185', 11, 1, 'MyAppToken', '[]', 0, '2023-07-21 06:34:29', '2023-07-21 06:34:29', '2024-07-21 07:34:29'),
('f3d120d57b36369787d6d89a737019d4715c1cddd823c4848c5d0a2ad9ad8f92da395233db5f0d78', 12, 1, 'MyAppToken', '[]', 0, '2023-08-09 15:36:22', '2023-08-09 15:36:22', '2024-08-09 16:36:22'),
('f6303a157038d18b8293e2c0c9affc46bd713158df193ba30402090a2a0912190d0428571f06a599', 11, 1, 'MyAppToken', '[]', 0, '2023-07-07 07:35:28', '2023-07-07 07:35:28', '2024-07-07 08:35:28'),
('f74893ceb8cbb7cb61793420ff26228b6751d3099fd7ddb9c7149b6f76ee679e10f6b914c787e56d', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 06:28:36', '2023-07-28 06:28:36', '2024-07-28 07:28:36'),
('f7c1ac74101fcae9b7da6c39089b28872e9a71b1d76dbd9942d727d78f739ec21363595c62d49ac8', 1, 1, 'MyAppToken', '[]', 0, '2023-06-22 17:39:14', '2023-06-22 17:39:14', '2024-06-22 18:39:14'),
('f888196f1942f573afe13d571f8d1427830839a5d113492254babf49cff947a9cf902b06158c38ab', 10, 1, 'MyAppToken', '[]', 0, '2023-08-10 10:56:44', '2023-08-10 10:56:44', '2024-08-10 11:56:44'),
('f95ffbe5a08a222877ad62835c6d1029611436b1c4fa7973533a5169140e11e1076325b0aa4b22c7', 11, 1, 'MyAppToken', '[]', 0, '2023-07-09 15:12:20', '2023-07-09 15:12:20', '2024-07-09 16:12:20'),
('fae3c908f3cde2cbc120e33041949a678aaaa588e0d84d9d145ea9359cbe006daf32914d81308c6e', 12, 1, 'MyAppToken', '[]', 0, '2023-08-08 09:22:46', '2023-08-08 09:22:46', '2024-08-08 10:22:46'),
('fcc2936feb211a6d7e9565bf37cae804c06eb77ef807ce400b67fceeb209d2caa037c4a96b50eded', 11, 1, 'MyAppToken', '[]', 0, '2023-08-13 01:00:33', '2023-08-13 01:00:33', '2024-08-13 02:00:33'),
('fd00a5845c1dddcae020f6bf86b0759c345dfd2103b3c792e0de2a26e0fb21f338a01e0c07784389', 8, 1, 'MyAppToken', '[]', 0, '2023-07-21 14:44:23', '2023-07-21 14:44:23', '2024-07-21 15:44:23'),
('fdb8271130139648598fb827e72baf381b5444262d2a5569fec046dd99c03629c09550ccf19790e7', 2, 1, 'MyAppToken', '[]', 0, '2023-07-28 08:49:31', '2023-07-28 08:49:31', '2024-07-28 09:49:31'),
('fdbc6128c97d1dde6b5d01a449a8a9c920d3991a955415414f611c6ecbe5a505252f6f3ff42feb29', 10, 1, 'MyAppToken', '[]', 0, '2023-07-07 09:18:56', '2023-07-07 09:18:56', '2024-07-07 10:18:56'),
('fe427e51e6c804b61e0902adf21d6a5e0f3c93ca4faf12adf4260086630a37aa5c7281f3fa44dccb', 11, 1, 'MyAppToken', '[]', 0, '2023-07-28 06:28:56', '2023-07-28 06:28:56', '2024-07-28 07:28:56'),
('ff36980e5151add8c4ebf120f849623ab93e7b54947a2b19600db8e2b01ce7c47a326385e7cf830b', 1, 1, 'MyAppToken', '[]', 0, '2023-07-24 21:01:17', '2023-07-24 21:01:17', '2024-07-24 22:01:17'),
('ff855f91f969f7860294c7db8368df346f40fc9d941517da7982e262c27e452c93f416a85aa39fa0', 11, 1, 'MyAppToken', '[]', 0, '2023-07-11 10:33:34', '2023-07-11 10:33:34', '2024-07-11 11:33:34');

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
(32, 500, 40, '2023-08-15 12:48:36', '2023-08-15 12:48:36'),
(33, 8000, 40, '2023-08-15 12:48:43', '2023-08-15 12:48:43'),
(34, 530, 41, '2023-08-15 14:21:31', '2023-08-15 14:21:31'),
(35, 800, 42, '2023-08-15 14:36:50', '2023-08-15 14:36:50'),
(36, 580, 45, '2023-08-21 09:25:58', '2023-08-21 09:25:58'),
(38, 10000, 47, '2023-08-28 08:48:07', '2023-08-28 08:48:07'),
(39, 70000, 47, '2023-08-28 08:48:15', '2023-08-28 08:48:15'),
(40, 910, 47, '2023-08-28 08:48:22', '2023-08-28 08:48:22'),
(41, 420, 49, '2023-08-28 09:47:58', '2023-08-28 09:47:58');

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
(26, 'chemise', 'chemise', 'chemise', NULL, 'instock', 'publish', 40, 2000.00, 1, '2023-05-14 08:35:25', '2023-05-19 14:45:44', 8);

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
(4, 6);

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
(2, 4579, 'test', '2023-08-15 10:20:56', '2023-08-15 10:20:56');

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
(15, 789, '2023-06-26', 'note789', 'approved', 1, 12, 2, '2023-07-21 15:02:41', '2023-07-21 15:02:41', 10);

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
  `type` varchar(255) NOT NULL DEFAULT 'super_admin',
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
(1, 'JRAYFY YASSINE', 'mc67631685@gmail.com', NULL, '$2y$10$LbD.DDueoIw837JvvNUaUONcLkkMNck..JojhU3WlxZmskOHGh8q2', 'admin', 'profile.jpg', 1, 'PKb3qmXlpzPUH945Fr3yOk1mPTWt68Eu0pL91lor8Wz4NwbYDCvbsuZGfF7F', '2023-05-17 16:09:59', '2023-07-21 10:39:03'),
(2, 'admin', 'mariam1801.coulibaly@gmail.com', NULL, '$2y$10$Bi8N0ThssGy8em61Ve..7u27LeaKlMtwBQNHKJ.qO2hIRxkmzLpEe', 'admin', 'profile.jpg', 1, NULL, '2023-05-17 17:05:35', '2023-07-21 14:34:50'),
(8, 'Mariam Diallo', 'mariam@gmail.com', NULL, '$2y$10$PU7rT2eSnUy0HHvwnTrL3.REkMrMJvHw6Dyuu0eEYkIS6W9HEmPKS', 'livreur', 'profile.jpg', 1, NULL, '2023-06-11 21:08:30', '2023-06-19 08:42:00'),
(9, 'Hawa Doumbia', 'hawa@gmail.com', NULL, '$2y$10$kAqTyaiVUlgV.YGl1zHMC.zTO4ZbxVHFaiutVeit0Qr1JN67PlT36', 'livreur', 'profile.jpg', 1, NULL, '2023-06-12 09:14:29', '2023-06-12 09:22:39'),
(10, 'Baba Diallo', 'baba@gmail.com', NULL, '$2y$10$Ex8uO1ye3zqKz4Bas3GKsO9rrLM5nydT00pVD9/I0bWG.YJgAUBDS', 'livreur', 'profile.jpg', 1, NULL, '2023-06-12 09:23:20', '2023-06-14 18:05:01'),
(11, 'Mariam Coulibaly', 'mariamcoulibaly@gmail.com', NULL, '$2y$10$2VyyzVYMeoG68Jdm24SSue99s/BDZvV7MfShU//MVuqPpoCemSCT6', 'super_admin', '1691955049.jpeg', 1, NULL, '2023-06-19 08:40:43', '2023-08-13 18:30:49'),
(12, 'Ines', 'ines@gmail.com', NULL, '$2y$10$IV.FJ5uNqPfpi3Lma9Xuu.3x4iPxb5kL2T2Rok3oHWfYXvl9gZ5O6', 'livreur', 'profile.jpg', 1, NULL, '2023-07-07 08:42:07', '2023-07-07 08:42:07'),
(13, 'Oumaima', 'oumaima@gmail.com', NULL, '$2y$10$N9R8VJlTvCjiW20PFCXSYOpawsPAERMXLkHiZTWJsx9Xt33OyV7nS', 'livreur', 'profile.jpg', 1, NULL, '2023-08-13 19:44:49', '2023-08-13 19:44:49');

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
  ADD KEY `fournisseurs_type_id_foreign` (`type_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `boutique_types`
--
ALTER TABLE `boutique_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `business_expenses`
--
ALTER TABLE `business_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `facture_direct`
--
ALTER TABLE `facture_direct`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `produit_supprimes`
--
ALTER TABLE `produit_supprimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
