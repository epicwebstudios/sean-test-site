-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Mar 13, 2023 at 08:22 PM
-- Server version: 8.0.32
-- PHP Version: 8.1.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sean_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `301_redirects`
--

CREATE TABLE `301_redirects` (
  `id` int NOT NULL,
  `request` varchar(500) NOT NULL,
  `type` int NOT NULL,
  `redirect_type` int NOT NULL,
  `page` int NOT NULL,
  `url` varchar(350) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` int NOT NULL,
  `ews_id` int NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `first` text NOT NULL,
  `last` text NOT NULL,
  `level` int NOT NULL,
  `status` int NOT NULL,
  `timezone` varchar(150) NOT NULL,
  `lastActivity` int NOT NULL,
  `email` text NOT NULL,
  `force_mfa` int NOT NULL,
  `login_attempts` int NOT NULL,
  `login_reset` varchar(25) NOT NULL,
  `reset_valid_until` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_action_logs`
--

CREATE TABLE `admin_action_logs` (
  `id` int NOT NULL,
  `admin` int NOT NULL,
  `action` text NOT NULL,
  `page` text NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity`
--

CREATE TABLE `admin_activity` (
  `id` int NOT NULL,
  `admin` int NOT NULL,
  `page` text NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_levels`
--

CREATE TABLE `admin_levels` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `status` int NOT NULL,
  `add_page` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_levels`
--

INSERT INTO `admin_levels` (`id`, `name`, `status`, `add_page`) VALUES
(1, 'SuperAdmin', 1, 1),
(2, 'Administrator', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_pages`
--

CREATE TABLE `admin_pages` (
  `id` int NOT NULL,
  `parent` int NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `external` int NOT NULL,
  `target` text NOT NULL,
  `page` text NOT NULL,
  `order` int NOT NULL,
  `module` int NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_pages`
--

INSERT INTO `admin_pages` (`id`, `parent`, `name`, `link`, `external`, `target`, `page`, `order`, `module`, `status`) VALUES
(40, -1, 'Administrator Action Logs', '', 0, '', 'settings/admin_logs/module.php', 0, 0, 1),
(1, 0, 'Home', '', 0, '', 'dashboard/module.php', 1, 0, 1),
(2, 0, 'Settings', '', 0, '', '', 2, 0, 1),
(7, 2, 'Site Settings', '', 0, '', 'settings/settings/module.php', 1, 0, 1),
(8, 2, 'Manage Administrators', '', 0, '', 'settings/administrators/module.php', 2, 0, 1),
(9, 2, 'Manage Administrator Levels', '', 0, '', 'settings/admin_levels/module.php', 3, 0, 1),
(10, 2, 'Manage Administrative Pages', '', 0, '', 'settings/admin_pages/module.php', 4, 0, 1),
(11, 2, 'System Settings', '', 0, '', 'settings/system/module.php', 6, 0, 1),
(3, 0, 'Pages', '', 0, '', '', 3, 0, 1),
(13, 3, 'Manage Pages', '', 0, '', 'pages/pages/module.php', 1, 0, 1),
(14, 3, 'Manage Page Blocks', '', 0, '', 'pages/blocks/module.php', 2, 0, 1),
(4, 0, 'Modules', '', 0, '', '', 4, 0, 1),
(61, 4, 'Frequently Asked Questions', '', 0, '', '', 8, 0, 1),
(62, 61, 'Manage Questions', '', 0, '', 'faq/faq/module.php', 1, 0, 1),
(63, 61, 'Manage Categories', '', 0, '', 'faq/categories/module.php', 2, 0, 1),
(17, 4, 'News', '', 0, '', '', 2, 0, 1),
(18, 4, 'Photo Gallery', '', 0, '', '', 3, 0, 1),
(19, 4, 'Staff Directory', '', 0, '', '', 4, 0, 1),
(20, 4, 'Navigation Menus', '', 0, '', '', 1, 0, 1),
(21, 4, 'Business Locations', '', 0, '', 'locations/module.php', 9, 0, 1),
(66, 5, 'Package Uploader', '', 0, '', 'tools/package_uploader/module.php', 9, 0, 1),
(35, 17, 'Manage Entries', '', 0, '', 'news/entries/module.php', 1, 0, 1),
(36, 18, 'Manage Categories', '', 0, '', 'gallery/categories/module.php', 2, 0, 1),
(37, 18, 'Manage Galleries', '', 0, '', 'gallery/galleries/module.php', 1, 0, 1),
(23, 5, 'SQL Toolbox', '', 0, '', 'tools/sql_toolbox/module.php', 8, 0, 1),
(42, 17, 'Manage Categories', '', 0, '', 'news/categories/module.php', 2, 0, 1),
(43, 4, 'Form Builder', '', 0, '', '', 5, 0, 1),
(44, 43, 'Manage Forms', '', 0, '', 'forms/forms/module.php', 1, 0, 1),
(5, 0, 'Tools', '', 0, '', '', 5, 0, 1),
(65, 20, 'Manage Menu Items', '', 0, '', 'menu/menu_items/module.php', 1, 0, 1),
(26, 5, '.htaccess Editor', '', 0, '', 'tools/htaccess/module.php', 3, 0, 1),
(39, 5, 'SEO Auditor', 'http://www.epicwebstudios.com/audit', 1, '_blank', '', 1, 0, 1),
(27, 5, 'Manage Blocked Users', '', 0, '', 'tools/blocked_users/module.php', 2, 0, 1),
(30, 6, 'Epic Client Center', 'http://clients.epicwebstudios.com', 1, '_blank', '', 2, 0, 1),
(6, 0, 'Support', '', 0, '', '', 6, 0, 1),
(32, 6, 'Help & Support', 'http://www.epicwebstudios.com/support', 1, '_blank', '', 1, 0, 1),
(16, 3, 'Manage Shortcodes', '', 0, '', 'pages/shortcodes/module.php', 4, 0, 1),
(41, -1, 'Edit Your Account', '', 0, '', 'settings/your_account/module.php', 0, 0, 1),
(28, 5, 'Manage Stylesheet Files', '', 0, '', 'tools/stylesheets/module.php', 4, 0, 1),
(15, 3, 'Manage Page Templates', '', 0, '', 'pages/templates/module.php', 3, 0, 1),
(29, 5, 'Manage Cron Jobs', '', 0, '', 'tools/cron_jobs/module.php', 7, 0, 1),
(12, 2, 'Transitional Redirects', '', 0, '', 'settings/transitional_redirects/module.php', 5, 0, 1),
(45, 43, 'Form Submissions', '', 0, '', 'forms/submissions/module.php', 2, 0, 1),
(46, 5, 'Manage Preloading Files', '', 0, '', 'tools/preloaders/module.php', 6, 0, 1),
(47, 19, 'Manage Categories', '', 0, '', 'staff/categories/module.php', 2, 0, 1),
(48, 19, 'Manage Staff Members', '', 0, '', 'staff/staff/module.php', 1, 0, 1),
(49, 5, 'Manage JavaScript Files', '', 0, '', 'tools/javascript/module.php', 5, 0, 1),
(55, 4, 'Manage Identity / Branding', '', 0, '', 'identity/module.php', 10, 0, 1),
(64, 20, 'Manage Menus', '', 0, '', 'menu/menus/module.php', 2, 0, 1),
(52, 4, 'Resources', '', 0, '', '', 6, 0, 1),
(53, 52, 'Manage Resources', '', 0, '', 'resources/resources/module.php', 1, 0, 1),
(54, 52, 'Manage Categories', '', 0, '', 'resources/categories/module.php', 2, 0, 1),
(56, 4, 'Testimonials', '', 0, '', '', 7, 0, 1),
(57, 56, 'Manage Categories', '', 0, '', 'testimonials/categories/module.php', 2, 0, 1),
(58, 56, 'Manage Testimonials', '', 0, '', 'testimonials/testimonials/module.php', 1, 0, 1),
(60, 43, 'Form Lead Captures', '', 0, '', 'forms/leads/module.php', 3, 0, 1),
(67, 17, 'Manage Settings', '', 0, '', 'news/settings/module.php', 3, 0, 1),
(68, 5, 'Revision Manager', '', 0, '', 'tools/revisions/module.php', 10, 0, 1),
(69, 4, 'File Manager', '', 0, '', 'file_manager/module.php', 11, 0, 1),
(70, 4, 'Notification Banners', '', 0, '', 'notification_banners/module.php', 12, 0, 1),
(71, 4, 'Notification Pop-Ups', '', 0, '', 'notification_popups/module.php', 13, 0, 1),
(72, 4, 'Calls to Action (CTA)', '', 0, '', '', 14, 0, 1),
(73, 72, 'Manage CTAs', '', 0, '', 'cta/cta/module.php', 1, 0, 1),
(74, 72, 'Manage Categories', '', 0, '', 'cta/categories/module.php', 2, 0, 1),
(75, 4, 'Social Media', '', 0, '', '', 15, 0, 1),
(76, 75, 'Manage Icons', '', 0, '', 'social/social/module.php', 1, 0, 1),
(77, 75, 'Manage Icon Types', '', 0, '', 'social/types/module.php', 2, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` int NOT NULL,
  `level` int NOT NULL,
  `page` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE `blocked_users` (
  `id` int NOT NULL,
  `ip` text NOT NULL,
  `notes` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crons`
--

CREATE TABLE `crons` (
  `id` int NOT NULL,
  `name` varchar(400) NOT NULL,
  `description` text NOT NULL,
  `file` varchar(150) NOT NULL,
  `min` varchar(25) NOT NULL,
  `hour` varchar(25) NOT NULL,
  `day` varchar(25) NOT NULL,
  `month` varchar(25) NOT NULL,
  `weekday` varchar(25) NOT NULL,
  `type` varchar(150) NOT NULL,
  `command` varchar(250) NOT NULL,
  `status` int NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crons`
--

INSERT INTO `crons` (`id`, `name`, `description`, `file`, `min`, `hour`, `day`, `month`, `weekday`, `type`, `command`, `status`, `order`) VALUES
(1, 'Sitemap Generator', 'This process creates and updates the system sitemap.', 'build-sitemap.php', '0', '*', '*', '*', '*', 'php', '0 * * * * php -q /home/ewscms/public_html/build/cron/build-sitemap.php', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `file_manager`
--

CREATE TABLE `file_manager` (
  `id` int NOT NULL,
  `file_path` longtext NOT NULL,
  `omit` int NOT NULL,
  `disallow_index` int NOT NULL,
  `icon` varchar(250) NOT NULL,
  `color` varchar(7) NOT NULL,
  `thumbnail` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `javascript`
--

CREATE TABLE `javascript` (
  `id` int NOT NULL,
  `url` varchar(250) NOT NULL,
  `position` int NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL,
  `extra` varchar(500) NOT NULL,
  `status` int NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `javascript`
--

INSERT INTO `javascript` (`id`, `url`, `position`, `type`, `extra`, `status`, `order`) VALUES
(1, '//js.ewsapi.com/jquery/jquery-1.10.2.min.js', 0, '', '', 1, 1),
(2, '//js.ewsapi.com/lightbox/lightbox.min.js', 0, '', '', 1, 2),
(3, '//js.ewsapi.com/mediaqueries/ie.mediaqueries.min.js', 0, '', '', 1, 3),
(4, '//js.ewsapi.com/sticky/v1/sticky.min.js', 0, '', '', 1, 4),
(5, 'lazy.js', 0, '', '', 1, 5),
(6, 'functions.js', 0, '', '', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `m_cta`
--

CREATE TABLE `m_cta` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` int NOT NULL,
  `supertitle` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `link_type` int NOT NULL,
  `url` varchar(255) NOT NULL,
  `ref_id` int NOT NULL,
  `button` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `m_cta_buttons`
--

CREATE TABLE `m_cta_buttons` (
  `id` int NOT NULL,
  `link_type` int NOT NULL,
  `url` varchar(255) NOT NULL,
  `ref_id` int NOT NULL,
  `text` varchar(255) NOT NULL,
  `cta_id` int NOT NULL,
  `order` int NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_cta_categories`
--

CREATE TABLE `m_cta_categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image_type` int NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `m_cta_categories`
--

INSERT INTO `m_cta_categories` (`id`, `name`, `image`, `image_type`, `status`) VALUES
(1, 'Uncategorized', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_faqs`
--

CREATE TABLE `m_faqs` (
  `id` int NOT NULL,
  `category` int NOT NULL,
  `name` longtext NOT NULL,
  `description` longtext NOT NULL,
  `status` int NOT NULL,
  `collapsed` int NOT NULL,
  `order` int NOT NULL,
  `permalink` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_faq_categories`
--

CREATE TABLE `m_faq_categories` (
  `id` int NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_faq_categories`
--

INSERT INTO `m_faq_categories` (`id`, `name`, `status`) VALUES
(1, 'Frequently Asked Questions', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_forms`
--

CREATE TABLE `m_forms` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `button_text` varchar(100) NOT NULL,
  `log_field` int NOT NULL,
  `description` text NOT NULL,
  `thank_you` int NOT NULL,
  `email_to` varchar(300) NOT NULL,
  `lead_capture` int NOT NULL,
  `recaptcha` int NOT NULL,
  `recaptcha_site_key` varchar(128) NOT NULL,
  `recaptcha_secret_key` varchar(128) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_form_fields`
--

CREATE TABLE `m_form_fields` (
  `id` int NOT NULL,
  `form` int NOT NULL,
  `label` varchar(250) NOT NULL,
  `type` int NOT NULL,
  `placeholder` varchar(250) NOT NULL,
  `values` text NOT NULL,
  `notes` varchar(200) NOT NULL,
  `width` int NOT NULL,
  `height` int NOT NULL,
  `alignment` int NOT NULL,
  `columns` int NOT NULL,
  `validation` int NOT NULL,
  `element` varchar(5) NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_form_leads`
--

CREATE TABLE `m_form_leads` (
  `id` int NOT NULL,
  `form` int NOT NULL,
  `submission_id` int NOT NULL,
  `fields` longtext NOT NULL,
  `on_page` varchar(250) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `browser` varchar(200) NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_form_results`
--

CREATE TABLE `m_form_results` (
  `id` int NOT NULL,
  `form` int NOT NULL,
  `log_value` text NOT NULL,
  `fields` longtext NOT NULL,
  `ip` varchar(20) NOT NULL,
  `browser` varchar(300) NOT NULL,
  `date` int NOT NULL,
  `referral` varchar(250) NOT NULL,
  `on_page` varchar(250) NOT NULL,
  `emailed_to` text NOT NULL,
  `email_contents` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_identity_colors`
--

CREATE TABLE `m_identity_colors` (
  `id` int NOT NULL,
  `package` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `type` int NOT NULL,
  `color_hex` varchar(7) NOT NULL,
  `color_rgb` varchar(250) NOT NULL,
  `color_cmyk` varchar(250) NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_identity_fonts`
--

CREATE TABLE `m_identity_fonts` (
  `id` int NOT NULL,
  `package` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `file` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_identity_logos`
--

CREATE TABLE `m_identity_logos` (
  `id` int NOT NULL,
  `package` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `thumb` varchar(250) NOT NULL,
  `jpg` varchar(250) NOT NULL,
  `png` varchar(250) NOT NULL,
  `ai` varchar(250) NOT NULL,
  `psd` varchar(250) NOT NULL,
  `eps` varchar(250) NOT NULL,
  `pdf` varchar(250) NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_identity_packages`
--

CREATE TABLE `m_identity_packages` (
  `id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` int NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_identity_packages`
--

INSERT INTO `m_identity_packages` (`id`, `name`, `description`, `status`, `order`) VALUES
(1, 'Identity', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_locations`
--

CREATE TABLE `m_locations` (
  `id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(100) NOT NULL,
  `address_2` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(15) NOT NULL,
  `lat` varchar(25) NOT NULL,
  `lng` varchar(25) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `fax` varchar(30) NOT NULL,
  `tollfree` varchar(30) NOT NULL,
  `email` varchar(200) NOT NULL,
  `hours` longtext NOT NULL,
  `hours_text` varchar(512) NOT NULL,
  `status` int NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_menus`
--

CREATE TABLE `m_menus` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `order` int NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_menus`
--

INSERT INTO `m_menus` (`id`, `name`, `description`, `order`, `status`) VALUES
(1, 'Main Navigation', 'This is the main navigation menu for the website.', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_menu_items`
--

CREATE TABLE `m_menu_items` (
  `id` int NOT NULL,
  `menu_id` int NOT NULL,
  `parent_id` int NOT NULL,
  `mobile_only` int NOT NULL,
  `label` varchar(100) NOT NULL,
  `link_type` int NOT NULL,
  `ref_id` int NOT NULL,
  `url` varchar(200) NOT NULL,
  `target` varchar(15) NOT NULL,
  `status` int NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_news_categories`
--

CREATE TABLE `m_news_categories` (
  `id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_news_categories`
--

INSERT INTO `m_news_categories` (`id`, `name`, `status`) VALUES
(1, 'News & Releases', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_news_entries`
--

CREATE TABLE `m_news_entries` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `category` int NOT NULL,
  `date` int NOT NULL,
  `summary` text NOT NULL,
  `entry` text NOT NULL,
  `canonical` varchar(250) NOT NULL,
  `status` int NOT NULL,
  `permalink` text NOT NULL,
  `og_title` varchar(200) NOT NULL,
  `og_description` varchar(500) NOT NULL,
  `og_image` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_news_photos`
--

CREATE TABLE `m_news_photos` (
  `id` int NOT NULL,
  `entry` int NOT NULL,
  `filename` text NOT NULL,
  `caption` text NOT NULL,
  `default` int NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_news_settings`
--

CREATE TABLE `m_news_settings` (
  `id` int NOT NULL,
  `per_page` int NOT NULL,
  `share_options` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_news_settings`
--

INSERT INTO `m_news_settings` (`id`, `per_page`, `share_options`) VALUES
(1, 10, '1,2');

-- --------------------------------------------------------

--
-- Table structure for table `m_notification_banners`
--

CREATE TABLE `m_notification_banners` (
  `id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `date_start` int NOT NULL,
  `date_end` int NOT NULL,
  `content` longtext NOT NULL,
  `bg_type` int NOT NULL,
  `bg_color_1` varchar(7) NOT NULL,
  `bg_color_2` varchar(7) NOT NULL,
  `text_color` varchar(7) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_notification_popups`
--

CREATE TABLE `m_notification_popups` (
  `id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `date_start` int NOT NULL,
  `date_end` int NOT NULL,
  `display_type` int NOT NULL,
  `content` longtext NOT NULL,
  `bg_type` int NOT NULL,
  `bg_color_1` varchar(7) NOT NULL,
  `bg_color_2` varchar(7) NOT NULL,
  `text_color` varchar(7) NOT NULL,
  `close_btn_text` varchar(100) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_photo_categories`
--

CREATE TABLE `m_photo_categories` (
  `id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_photo_categories`
--

INSERT INTO `m_photo_categories` (`id`, `name`, `status`) VALUES
(1, 'Photo Gallery', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_photo_galleries`
--

CREATE TABLE `m_photo_galleries` (
  `id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `category` int NOT NULL,
  `status` int NOT NULL,
  `order` int NOT NULL,
  `permalink` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_photo_photos`
--

CREATE TABLE `m_photo_photos` (
  `id` int NOT NULL,
  `gallery` int NOT NULL,
  `filename` varchar(200) NOT NULL,
  `caption` text NOT NULL,
  `order` int NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_resources`
--

CREATE TABLE `m_resources` (
  `id` int NOT NULL,
  `category` int NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `date` int NOT NULL,
  `link_type` int NOT NULL,
  `filename` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_resource_categories`
--

CREATE TABLE `m_resource_categories` (
  `id` int NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_resource_categories`
--

INSERT INTO `m_resource_categories` (`id`, `name`, `status`) VALUES
(1, 'Resources', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_slider`
--

CREATE TABLE `m_slider` (
  `id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `photo` varchar(250) NOT NULL,
  `title` varchar(200) NOT NULL,
  `caption` text NOT NULL,
  `link_type` int NOT NULL,
  `ref_id` int NOT NULL,
  `url` varchar(250) NOT NULL,
  `target` varchar(20) NOT NULL,
  `status` int NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_social`
--

CREATE TABLE `m_social` (
  `id` int NOT NULL,
  `type` int NOT NULL,
  `link` varchar(255) NOT NULL,
  `order` int NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_social_types`
--

CREATE TABLE `m_social_types` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  `icon_tag` varchar(255) NOT NULL,
  `icon_unicode` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_social_types`
--

INSERT INTO `m_social_types` (`id`, `name`, `alt`, `icon_tag`, `icon_unicode`) VALUES
(1, 'Facebook', 'Facebook', 'facebook', 'f09a'),
(2, 'GMB', 'Google My Business', 'google', 'f1a0'),
(3, 'Twitter', 'Twitter', 'twitter', 'f099'),
(4, 'Tumblr', 'Tumblr', 'tumblr', 'f173'),
(5, 'Pinterest', 'Pinterest', 'pinterest-p', 'f231'),
(6, 'Instagram', 'Instagram', 'instagram', 'f16d'),
(7, 'YouTube', 'YouTube', 'youtube-play', 'f16a'),
(8, 'YouTube (Classic)', 'YouTube', 'youtube', 'f167'),
(9, 'Facebook (Official)', 'Facebook', 'facebook-official', 'f230'),
(10, 'Facebook (Square)', 'Facebook', 'facebook-square', 'f082'),
(11, 'Pinterest (Square)', 'Pinterest', 'pinterest-square', 'f0d3'),
(12, 'Pinterest (Circle)', 'Pinterest', 'pinterest', 'f0d2'),
(13, 'Tumblr (Square)', 'Tumblr', 'tumblr-square', 'f174'),
(14, 'Twitter (Square)', 'Twitter', 'twitter-square', 'f081'),
(15, 'GMB (Map Pin)', 'Google My Business', 'map-marker', 'f041'),
(16, 'LinkedIn', 'LinkedIn', 'linkedin', 'f0e1'),
(17, 'LinkedIn (Square)', 'LinkedIn', 'linkedin-square', 'f08c');

-- --------------------------------------------------------

--
-- Table structure for table `m_staff`
--

CREATE TABLE `m_staff` (
  `id` int NOT NULL,
  `category` int NOT NULL,
  `permalink` varchar(250) NOT NULL,
  `first` varchar(100) NOT NULL,
  `middle` varchar(100) NOT NULL,
  `last` varchar(100) NOT NULL,
  `position` varchar(150) NOT NULL,
  `department` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `fax` varchar(30) NOT NULL,
  `bio` text NOT NULL,
  `social` longtext NOT NULL,
  `photo` varchar(200) NOT NULL,
  `status` int NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_staff_categories`
--

CREATE TABLE `m_staff_categories` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_staff_categories`
--

INSERT INTO `m_staff_categories` (`id`, `name`, `status`) VALUES
(1, 'Staff Directory', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_testimonials`
--

CREATE TABLE `m_testimonials` (
  `id` int NOT NULL,
  `name` varchar(250) NOT NULL,
  `category` int NOT NULL,
  `quote` text NOT NULL,
  `summary` varchar(200) NOT NULL,
  `rating` float(10,2) NOT NULL,
  `author` varchar(250) NOT NULL,
  `location` varchar(250) NOT NULL,
  `organization` varchar(250) NOT NULL,
  `misc` varchar(250) NOT NULL,
  `website` varchar(250) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_testimonial_categories`
--

CREATE TABLE `m_testimonial_categories` (
  `id` int NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_testimonial_categories`
--

INSERT INTO `m_testimonial_categories` (`id`, `name`, `status`) VALUES
(1, 'Testimonials', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  `head` longtext NOT NULL,
  `body_open` longtext NOT NULL,
  `body_close` longtext NOT NULL,
  `template` int NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `canonical` varchar(250) NOT NULL,
  `left_block` int NOT NULL,
  `right_block` int NOT NULL,
  `protect` int NOT NULL,
  `password` text NOT NULL,
  `e_password` text NOT NULL,
  `status` int NOT NULL,
  `modified` int NOT NULL,
  `module` int NOT NULL,
  `spider` int NOT NULL,
  `og_title` varchar(200) NOT NULL,
  `og_description` varchar(500) NOT NULL,
  `og_image` varchar(150) NOT NULL,
  `banner` int NOT NULL,
  `banner_type` int NOT NULL,
  `banner_overlay` int NOT NULL,
  `banner_image` varchar(255) NOT NULL,
  `banner_title` varchar(255) NOT NULL,
  `banner_supertitle` varchar(255) NOT NULL,
  `banner_subtitle` varchar(255) NOT NULL,
  `banner_button` tinyint(1) NOT NULL,
  `banner_video_type` int NOT NULL,
  `banner_video_file` varchar(255) NOT NULL,
  `banner_video_url` varchar(255) NOT NULL,
  `banner_video_thumbnail` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `link`, `title`, `content`, `head`, `body_open`, `body_close`, `template`, `keywords`, `description`, `canonical`, `left_block`, `right_block`, `protect`, `password`, `e_password`, `status`, `modified`, `module`, `spider`, `og_title`, `og_description`, `og_image`, `banner`, `banner_type`, `banner_overlay`, `banner_image`, `banner_title`, `banner_supertitle`, `banner_subtitle`, `banner_button`, `banner_video_type`, `banner_video_file`, `banner_video_url`, `banner_video_thumbnail`) VALUES
(1, 'Homepage', 'home', 'Homepage', '<div class=\"section\">\r\n<div class=\"wrapper\">\r\n<h1>Homepage</h1>\r\n<p>Page content goes here.</p>\r\n</div>\r\n</div>', '', '', '', 1, '', '', '', 0, 0, 0, '', '', 1, 1538761223, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', 0, 0, '', '', ''),
(2, 'Page Not Found', 'error', 'Page Not Found', '<div class=\"section\">\r\n<div class=\"tc wrapper\">\r\n<h1>We\'re Sorry...</h1>\r\n<p>The page you have attempted to access cannot be found.</p>\r\n<p>Please check the URL and try again at a later time.</p>\r\n<p><a href=\"../\" class=\"btn\">Return to Homepage</a></p>\r\n</div>\r\n</div>', '', '', '', 2, '', '', '', 0, 0, 0, '', '', 3, 1539089272, 0, 1, '', '', '', 0, 0, 0, '', '', '', '', 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pages_banner_buttons`
--

CREATE TABLE `pages_banner_buttons` (
  `id` int NOT NULL,
  `page_id` int NOT NULL,
  `text` varchar(255) NOT NULL,
  `link_type` int NOT NULL,
  `url` varchar(255) NOT NULL,
  `ref_id` int NOT NULL,
  `anchor` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `page_blocks`
--

CREATE TABLE `page_blocks` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `content` text NOT NULL,
  `description` text NOT NULL,
  `status` int NOT NULL,
  `module` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_blocks`
--

INSERT INTO `page_blocks` (`id`, `name`, `content`, `description`, `status`, `module`) VALUES
(1, 'Test Block 1', '<p>test block 1</p>', '', 1, 0),
(2, 'Test Block 2', '<p>Test block 2</p>', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `page_permissions`
--

CREATE TABLE `page_permissions` (
  `id` int NOT NULL,
  `level` int NOT NULL,
  `page` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `page_templates`
--

CREATE TABLE `page_templates` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `filename` varchar(150) NOT NULL,
  `banner_dimensions` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_templates`
--

INSERT INTO `page_templates` (`id`, `name`, `description`, `filename`, `banner_dimensions`) VALUES
(1, 'Homepage', 'Default homepage template.', 'homepage.php', '{\"width\":\"1920\",\"height\":\"###\"}'),
(2, 'Subpage', 'Default subpage template.', 'subpage.php', '{\"width\":\"1920\",\"height\":\"###\"}');

-- --------------------------------------------------------

--
-- Table structure for table `page_template_blocks`
--

CREATE TABLE `page_template_blocks` (
  `id` int NOT NULL,
  `template` int NOT NULL,
  `block` int NOT NULL,
  `location` int NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `preloaders`
--

CREATE TABLE `preloaders` (
  `id` int NOT NULL,
  `filename` text NOT NULL,
  `status` int NOT NULL,
  `order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `preloaders`
--

INSERT INTO `preloaders` (`id`, `filename`, `status`, `order`) VALUES
(1, 'modules/forms/process/process.php', 1, 2),
(2, 'modules/locations/functions.php', 1, 3),
(3, 'modules/redirects/module.php', 1, 1),
(4, 'modules/menu/src/functions.php', 1, 4),
(5, 'modules/notification_banners/functions.php', 1, 5),
(6, 'modules/notification_popups/functions.php', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `revisions`
--

CREATE TABLE `revisions` (
  `id` int NOT NULL,
  `p_id` int NOT NULL,
  `table` varchar(150) NOT NULL,
  `records` longtext NOT NULL,
  `admin` int NOT NULL,
  `rev_key` varchar(50) NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `url` text NOT NULL,
  `name` text NOT NULL,
  `title` text NOT NULL,
  `cleanURLs` int NOT NULL,
  `description` text NOT NULL,
  `favicon` text NOT NULL,
  `theme_color` varchar(7) NOT NULL,
  `image` text NOT NULL,
  `email` text NOT NULL,
  `offline` int NOT NULL,
  `offline_msg` text NOT NULL,
  `allow_exec` int NOT NULL,
  `php_path` varchar(100) NOT NULL,
  `viewport` longtext NOT NULL,
  `max_login_attempts` int NOT NULL,
  `revision_limit` int NOT NULL,
  `head` longtext NOT NULL,
  `foot` longtext NOT NULL,
  `body_open` longtext NOT NULL,
  `body_close` longtext NOT NULL,
  `ps_minify_css` int NOT NULL,
  `ps_minify_js` int NOT NULL,
  `allow_index` int NOT NULL,
  `file_browser` longtext NOT NULL,
  `banner_image` varchar(255) NOT NULL,
  `banner_lazy` tinyint(1) NOT NULL,
  `user_agents` varchar(255) NOT NULL,
  `sticky_header` tinyint(1) NOT NULL,
  `logo_header` varchar(255) NOT NULL,
  `logo_footer` varchar(255) NOT NULL,
  `timezone` varchar(150) NOT NULL,
  `email_settings` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `url`, `name`, `title`, `cleanURLs`, `description`, `favicon`, `theme_color`, `image`, `email`, `offline`, `offline_msg`, `allow_exec`, `php_path`, `viewport`, `max_login_attempts`, `revision_limit`, `head`, `foot`, `body_open`, `body_close`, `ps_minify_css`, `ps_minify_js`, `allow_index`, `file_browser`, `banner_image`, `banner_lazy`, `user_agents`, `sticky_header`, `logo_header`, `logo_footer`, `timezone`, `email_settings`) VALUES
(1, 'http://192.168.1.47:3000', '', '', 1, '', '', '', '', 'no-reply@yourdomain.com', 0, 'Our website is currently undergoing routine maintenance. Please check back soon.', 0, '', '{\"width\":\"device-width\",\"height\":\"\",\"initial_scale\":\"1.0\",\"min_scale\":\"1.0\",\"max_scale\":\"3.0\",\"scalable\":\"yes\"}', 5, 100, '', '', '', '', 1, 1, 0, '{\"display_type\":\"grid\",\"image_types\":\"jpg, jpeg, png, gif, webm, svg, bmp, tiff\",\"media_types\":\"mp4, mov, mpeg, mpg, m4v, avi, wma, flv, webm\",\"file_types\":\"doc, docx, rtf, pdf, xls, xlsx, txt, csv, xml, ppt, pptx, psd, ai, zip\",\"allow_folder_creation\":\"1\",\"allow_file_upload\":\"1\",\"allow_rename\":\"1\",\"allow_delete\":\"1\",\"allow_overwrite\":\"1\"}', '', 0, 'Validator.nu,W3C_Validator,SiteAuditBot,AhrefsBot,rogerbot,Screaming Frog SEO Spider,GTmetrix,90.0.4430.212,PTST,TiggeritoBot,Chrome-Lighthouse', 0, '', '', 'America/New_York', '{\"name\":\"\",\"email\":\"no-reply@yourdomain.com\",\"smtp\":\"0\",\"host\":\"\",\"port\":\"587\",\"encryption\":\"tls\",\"username\":\"\",\"password\":\"\"}');

-- --------------------------------------------------------

--
-- Table structure for table `shortcodes`
--

CREATE TABLE `shortcodes` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` int NOT NULL,
  `table` varchar(100) NOT NULL,
  `id_col` varchar(50) NOT NULL,
  `name_col` varchar(50) NOT NULL,
  `tag` varchar(100) NOT NULL,
  `b_replace` text NOT NULL,
  `e_replace` text NOT NULL,
  `replace` text NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shortcodes`
--

INSERT INTO `shortcodes` (`id`, `name`, `type`, `table`, `id_col`, `name_col`, `tag`, `b_replace`, `e_replace`, `replace`, `status`) VALUES
(1, 'News Module', 1, 'm_news_categories', 'id', 'name', 'news-module', '#? $_GET[\'news_category_id\'] = \'', '\'; require BASE_DIR.\"/modules/news/module.php\"; ?#', '', 1),
(2, 'Form Module', 1, 'm_forms', 'id', 'name', 'form-module', '#? $_GET[\'form_id\'] = \'', '\'; require BASE_DIR.\"/modules/forms/module.php\"; ?#', '', 1),
(3, 'Staff Module', 1, 'm_staff_categories', 'id', 'name', 'staff-module', '#? $_GET[\'staff_category_id\'] = \'', '\'; require BASE_DIR.\"/modules/staff/module.php\"; ?#', '', 1),
(4, 'Gallery Module (Category)', 1, 'm_photo_categories', 'id', 'name', 'gallery-module-category', '#? $category_id = \'', '\'; require BASE_DIR.\"/modules/gallery/module.php\"; ?#', '', 1),
(5, 'Gallery Module (Gallery)', 1, 'm_photo_galleries', 'id', 'name', 'gallery-module', '#? $gallery_id = \'', '\'; require BASE_DIR.\"/modules/gallery/module.php\"; ?#', '', 1),
(6, 'Resources Module (Table)', 1, 'm_resource_categories', 'id', 'name', 'resources-module-table', '#? $_GET[\'resources_display_type\'] = \'table\'; $_GET[\'resources_category_id\'] = \"', '\"; require BASE_DIR.\"/modules/resources/module.php\"; ?#', '', 1),
(7, 'Resources Module (Feed)', 1, 'm_resource_categories', 'id', 'name', 'resources-module-feed', '#? $_GET[\'resources_display_type\'] = \'feed\'; $_GET[\'resources_category_id\'] = \"', '\"; require BASE_DIR.\"/modules/resources/module.php\"; ?#', '', 1),
(8, 'Identity Package', 1, 'm_identity_packages', 'id', 'name', 'identity-package', '#? $_GET[\'identity_package_id\'] = \'', '\'; require BASE_DIR.\"/modules/identity/module.php\"; ?#', '', 1),
(9, 'Testimonial Module (Single - Random)', 1, 'm_testimonial_categories', 'id', 'name', 'testimonial-module', '#? $category_id = \"', '\"; require BASE_DIR.\"/modules/testimonials/module.php\"; ?#', '', 1),
(10, 'Testimonial Module (Feed)', 1, 'm_testimonial_categories', 'id', 'name', 'testimonial-feed', '#? $display_type = \"feed\"; $category_id = \"', '\"; require BASE_DIR.\"/modules/testimonials/module.php\"; ?#', '', 1),
(11, 'Form Module (No Labels)', 1, 'm_forms', 'id', 'name', 'form-module-labeless', '#? $_GET[\'form_id\'] = \'', '\'; $_GET[\'form_labeless\'] = \'1\'; require BASE_DIR.\"/modules/forms/module.php\"; ?#', '', 1),
(12, 'Resources Module (Grid)', 1, 'm_resource_categories', 'id', 'name', 'resources-module-grid', '#? $_GET[\'resources_display_type\'] = \'grid\'; $_GET[\'resources_category_id\'] = \"', '\"; require BASE_DIR.\"/modules/resources/module.php\"; ?#', '', 1),
(13, 'FAQ Module', 1, 'm_faq_categories', 'id', 'name', 'faq-module', '#? $_GET[\'faq_category_id\'] = \'', '\'; require BASE_DIR.\"/modules/faq/module.php\"; ?#', '', 1),
(14, 'CTA Module', 1, 'm_cta_categories', 'id', 'name', 'cta-module', '#? $cta_category_id = \'', '\'; require BASE_DIR . \'/modules/cta/module.php\' ?#', '', 1),
(15, 'CTA Module (Single)', 1, 'm_cta', 'id', 'name', 'cta-module-single', '#? $cta_view = \'single\'; $cta_id = \'', '\'; require BASE_DIR.\"/modules/cta/module.php\"; ?#', '', 1),
(16, 'Social Module', 2, '', '', '', 'social-module', '', '', '#? require BASE_DIR . \'/modules/social/module.php\' ?#', 1),
(17, 'Gallery Module (Gallery) - Slider', 1, 'm_photo_galleries', 'id', 'name', 'gallery-module-slider', '#? $gallery_id = \'', '\'; $use_slider = true; require BASE_DIR.\"/modules/gallery/module.php\"; ?#', '', 1),
(18, 'Testimonial Module (Feed) - Slider', 1, 'm_testimonial_categories', 'id', 'name', 'testimonial-feed-slider', '#? $use_slider = true; $display_type = \'feed\'; $category_id = \'', '\'; require BASE_DIR.\"/modules/testimonials/module.php\"; ?#', '', 1),
(19, 'Testimonial Module (Single)', 1, 'testimonial-single', 'id', 'name', 'testimonial-single', '#? $testimonial_id = \"', '\"; require BASE_DIR.\"/modules/testimonials/module.php\"; ?#', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stylesheets`
--

CREATE TABLE `stylesheets` (
  `id` int NOT NULL,
  `url` text NOT NULL,
  `limit` text NOT NULL,
  `editor` int NOT NULL,
  `type` int NOT NULL DEFAULT '0',
  `before` text NOT NULL,
  `position` int NOT NULL,
  `order` int NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stylesheets`
--

INSERT INTO `stylesheets` (`id`, `url`, `limit`, `editor`, `type`, `before`, `position`, `order`, `status`) VALUES
(1, '//css.ewsapi.com/icons/icons.min.css', '1', 1, 0, '', 0, 1, 1),
(2, '//css.ewsapi.com/reset/reset.min.css', '1', 1, 0, '', 0, 2, 1),
(3, '//css.ewsapi.com/global/global.v4.css', '1', 1, 0, '', 0, 3, 1),
(4, 'default.modules.css', '1', 0, 0, '', 0, 4, 1),
(5, 'stylesheet.css', '1', 1, 0, '', 0, 5, 1),
(6, 'responsive.css', '1', 0, 0, '', 0, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stylesheet_limitations`
--

CREATE TABLE `stylesheet_limitations` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stylesheet_limitations`
--

INSERT INTO `stylesheet_limitations` (`id`, `name`, `value`) VALUES
(1, 'No limitations (all browsers)', ''),
(2, 'IE only (all versions)', '[if IE]'),
(3, 'All browsers other than IE', '[if !IE]'),
(4, 'IE 7 only', '[if IE 7]'),
(5, 'IE 6 only', '[if IE 6]'),
(6, 'IE 5.5 only', '[if IE 5.5000]'),
(7, 'IE 5 only', '[if IE 5]'),
(8, 'IE 8 and lower', '[if lte IE 8]'),
(9, 'IE 7 and lower', '[if lte IE 7]'),
(10, 'IE 6 and lower', '[if lte IE 6]'),
(11, 'IE 8 and higher', '[if gte IE 8]'),
(12, 'IE 7 and higher', '[if gte IE 7]'),
(13, 'IE 6 and higher', '[if gte IE 6]');

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE `system` (
  `id` int NOT NULL,
  `cache_refresh` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`id`, `cache_refresh`) VALUES
(1, 1628281837);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `301_redirects`
--
ALTER TABLE `301_redirects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_action_logs`
--
ALTER TABLE `admin_action_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_activity`
--
ALTER TABLE `admin_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_levels`
--
ALTER TABLE `admin_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_pages`
--
ALTER TABLE `admin_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crons`
--
ALTER TABLE `crons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_manager`
--
ALTER TABLE `file_manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `javascript`
--
ALTER TABLE `javascript`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_cta`
--
ALTER TABLE `m_cta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_cta_buttons`
--
ALTER TABLE `m_cta_buttons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_cta_categories`
--
ALTER TABLE `m_cta_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_faqs`
--
ALTER TABLE `m_faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_faq_categories`
--
ALTER TABLE `m_faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_forms`
--
ALTER TABLE `m_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_form_fields`
--
ALTER TABLE `m_form_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_form_leads`
--
ALTER TABLE `m_form_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_form_results`
--
ALTER TABLE `m_form_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_identity_colors`
--
ALTER TABLE `m_identity_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_identity_fonts`
--
ALTER TABLE `m_identity_fonts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_identity_logos`
--
ALTER TABLE `m_identity_logos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_identity_packages`
--
ALTER TABLE `m_identity_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_locations`
--
ALTER TABLE `m_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_menus`
--
ALTER TABLE `m_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_menu_items`
--
ALTER TABLE `m_menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_news_categories`
--
ALTER TABLE `m_news_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_news_entries`
--
ALTER TABLE `m_news_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_news_photos`
--
ALTER TABLE `m_news_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_news_settings`
--
ALTER TABLE `m_news_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_notification_banners`
--
ALTER TABLE `m_notification_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_notification_popups`
--
ALTER TABLE `m_notification_popups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_photo_categories`
--
ALTER TABLE `m_photo_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_photo_galleries`
--
ALTER TABLE `m_photo_galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_photo_photos`
--
ALTER TABLE `m_photo_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_resources`
--
ALTER TABLE `m_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_resource_categories`
--
ALTER TABLE `m_resource_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_slider`
--
ALTER TABLE `m_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_social`
--
ALTER TABLE `m_social`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_social_types`
--
ALTER TABLE `m_social_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_staff`
--
ALTER TABLE `m_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_staff_categories`
--
ALTER TABLE `m_staff_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_testimonials`
--
ALTER TABLE `m_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_testimonial_categories`
--
ALTER TABLE `m_testimonial_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages_banner_buttons`
--
ALTER TABLE `pages_banner_buttons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_blocks`
--
ALTER TABLE `page_blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_permissions`
--
ALTER TABLE `page_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_templates`
--
ALTER TABLE `page_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_template_blocks`
--
ALTER TABLE `page_template_blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preloaders`
--
ALTER TABLE `preloaders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `revisions`
--
ALTER TABLE `revisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shortcodes`
--
ALTER TABLE `shortcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stylesheets`
--
ALTER TABLE `stylesheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stylesheet_limitations`
--
ALTER TABLE `stylesheet_limitations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `301_redirects`
--
ALTER TABLE `301_redirects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_action_logs`
--
ALTER TABLE `admin_action_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_activity`
--
ALTER TABLE `admin_activity`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_levels`
--
ALTER TABLE `admin_levels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_pages`
--
ALTER TABLE `admin_pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blocked_users`
--
ALTER TABLE `blocked_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crons`
--
ALTER TABLE `crons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `file_manager`
--
ALTER TABLE `file_manager`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `javascript`
--
ALTER TABLE `javascript`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `m_cta`
--
ALTER TABLE `m_cta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_cta_buttons`
--
ALTER TABLE `m_cta_buttons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_cta_categories`
--
ALTER TABLE `m_cta_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_faqs`
--
ALTER TABLE `m_faqs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_faq_categories`
--
ALTER TABLE `m_faq_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_forms`
--
ALTER TABLE `m_forms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_form_fields`
--
ALTER TABLE `m_form_fields`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_form_leads`
--
ALTER TABLE `m_form_leads`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_form_results`
--
ALTER TABLE `m_form_results`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_identity_colors`
--
ALTER TABLE `m_identity_colors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_identity_fonts`
--
ALTER TABLE `m_identity_fonts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_identity_logos`
--
ALTER TABLE `m_identity_logos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_identity_packages`
--
ALTER TABLE `m_identity_packages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_locations`
--
ALTER TABLE `m_locations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_menus`
--
ALTER TABLE `m_menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_menu_items`
--
ALTER TABLE `m_menu_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_news_categories`
--
ALTER TABLE `m_news_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_news_entries`
--
ALTER TABLE `m_news_entries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_news_photos`
--
ALTER TABLE `m_news_photos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_news_settings`
--
ALTER TABLE `m_news_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_notification_banners`
--
ALTER TABLE `m_notification_banners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_notification_popups`
--
ALTER TABLE `m_notification_popups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_photo_categories`
--
ALTER TABLE `m_photo_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_photo_galleries`
--
ALTER TABLE `m_photo_galleries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_photo_photos`
--
ALTER TABLE `m_photo_photos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_resources`
--
ALTER TABLE `m_resources`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_resource_categories`
--
ALTER TABLE `m_resource_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_slider`
--
ALTER TABLE `m_slider`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_social`
--
ALTER TABLE `m_social`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_social_types`
--
ALTER TABLE `m_social_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `m_staff`
--
ALTER TABLE `m_staff`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_staff_categories`
--
ALTER TABLE `m_staff_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_testimonials`
--
ALTER TABLE `m_testimonials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_testimonial_categories`
--
ALTER TABLE `m_testimonial_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pages_banner_buttons`
--
ALTER TABLE `pages_banner_buttons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_blocks`
--
ALTER TABLE `page_blocks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `page_permissions`
--
ALTER TABLE `page_permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_templates`
--
ALTER TABLE `page_templates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `page_template_blocks`
--
ALTER TABLE `page_template_blocks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `preloaders`
--
ALTER TABLE `preloaders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `revisions`
--
ALTER TABLE `revisions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shortcodes`
--
ALTER TABLE `shortcodes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `stylesheets`
--
ALTER TABLE `stylesheets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stylesheet_limitations`
--
ALTER TABLE `stylesheet_limitations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `system`
--
ALTER TABLE `system`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
