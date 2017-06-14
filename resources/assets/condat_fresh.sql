-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2016 at 10:40 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `condat_tenant`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `action_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `active_clients`
--

CREATE TABLE IF NOT EXISTS `active_clients` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(155) NOT NULL,
  `token` varchar(70) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `address_id` int(11) NOT NULL,
  `street` varchar(150) DEFAULT NULL COMMENT '	',
  `suburb` varchar(45) DEFAULT NULL,
  `postcode` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `google_map` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(145) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agencies`
--

CREATE TABLE IF NOT EXISTS `agencies` (
  `agency_id` int(11) NOT NULL COMMENT 'consultancy who buys our software is termed as agency',
  `description` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agency_clients`
--

CREATE TABLE IF NOT EXISTS `agency_clients` (
  `agency_client_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agency_institutes`
--

CREATE TABLE IF NOT EXISTS `agency_institutes` (
  `agency_institute_id` int(11) NOT NULL,
  `ams_institute_id` int(11) DEFAULT NULL,
  `cms_institute_id` int(11) DEFAULT NULL,
  `agency_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agency_institute_branches`
--

CREATE TABLE IF NOT EXISTS `agency_institute_branches` (
  `agency_institute_branch_id` int(11) NOT NULL,
  `cms_branch_id` int(11) DEFAULT NULL,
  `agency_id` int(11) NOT NULL,
  `company_branches_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agency_institute_courses`
--

CREATE TABLE IF NOT EXISTS `agency_institute_courses` (
  `agency_institute_course_id` int(11) NOT NULL,
  `cms_course_id` int(11) DEFAULT NULL,
  `agency_id` int(11) NOT NULL,
  `courses_course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agency_subscriptions`
--

CREATE TABLE IF NOT EXISTS `agency_subscriptions` (
  `agency_subscription_id` int(11) NOT NULL,
  `standard_subscription_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `is_current` tinyint(1) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `subscription_status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agency_users`
--

CREATE TABLE IF NOT EXISTS `agency_users` (
  `agency_user_id` int(11) NOT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `level_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE IF NOT EXISTS `agents` (
  `agent_id` int(11) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `email` varchar(55) NOT NULL,
  `address_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `application_notes`
--

CREATE TABLE IF NOT EXISTS `application_notes` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `note_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `application_status`
--

CREATE TABLE IF NOT EXISTS `application_status` (
  `application_status_id` int(11) NOT NULL,
  `course_application_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `date_applied` datetime DEFAULT NULL,
  `date_removed` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `application_status_documents`
--

CREATE TABLE IF NOT EXISTS `application_status_documents` (
  `application_status_document_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `application_status_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `broad_field`
--

CREATE TABLE IF NOT EXISTS `broad_field` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `broad_field`
--

INSERT INTO `broad_field` (`id`, `name`, `description`) VALUES
(1, 'Natural and Physical Sciences', 'Natural and Physical Sciences'),
(2, 'Information Technology', 'Information Technology'),
(3, 'Engineering and Related Technologies', 'Engineering and Related Technologies'),
(4, 'Architecture and Building', 'Architecture and Building'),
(5, 'Agriculture, Environmental and Related Studies', 'Agriculture, Environmental and Related Studies'),
(6, 'Health', 'Health'),
(7, 'Education', 'Education'),
(8, 'Management and Commerce', 'Management and Commerce'),
(9, 'Society and Culture', 'Society and Culture'),
(10, 'Creative Arts', 'Creative Arts'),
(11, 'Food, Hospitality and Personal Services', 'Food, Hospitality and Personal Services'),
(12, 'Mixed Field Programmes', 'Mixed Field Programmes');

-- --------------------------------------------------------

--
-- Table structure for table `ci_other_commissions`
--

CREATE TABLE IF NOT EXISTS `ci_other_commissions` (
  `other_commission_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `gst` float NOT NULL,
  `description` varchar(155) NOT NULL,
  `college_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_tuition_commissions`
--

CREATE TABLE IF NOT EXISTS `ci_tuition_commissions` (
  `tuition_commission_id` int(11) NOT NULL,
  `tuition_fee` float NOT NULL,
  `enrollment_fee` float NOT NULL,
  `material_fee` float NOT NULL,
  `coe_fee` float NOT NULL,
  `other_fee` float NOT NULL,
  `sub_total` float NOT NULL,
  `description` varchar(155) NOT NULL,
  `commission_percent` float NOT NULL,
  `commission_amount` float NOT NULL,
  `commission_gst` float NOT NULL,
  `college_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(11) NOT NULL,
  `added_by` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `referred_by` varchar(155) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_documents`
--

CREATE TABLE IF NOT EXISTS `client_documents` (
  `client_document_id` int(11) NOT NULL COMMENT 'if agent attached documents without applying for courses for e.g. passport, visa copy,marriage certificate\n',
  `document_id` int(11) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_emails`
--

CREATE TABLE IF NOT EXISTS `client_emails` (
  `id` int(11) NOT NULL,
  `email` varchar(155) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: draft, 1: sent, 2: deleted',
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_notes`
--

CREATE TABLE IF NOT EXISTS `client_notes` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `note_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_payments`
--

CREATE TABLE IF NOT EXISTS `client_payments` (
  `client_payment_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date_paid` datetime DEFAULT NULL,
  `payment_method` varchar(45) DEFAULT NULL,
  `description` mediumtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_type` varchar(145) DEFAULT NULL COMMENT 'this is to find if payment is made by student or made to student',
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='invoice items';

-- --------------------------------------------------------

--
-- Table structure for table `client_timeline`
--

CREATE TABLE IF NOT EXISTS `client_timeline` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `timeline_id` int(11) NOT NULL,
  `application_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `college_invoices`
--

CREATE TABLE IF NOT EXISTS `college_invoices` (
  `college_invoice_id` int(11) NOT NULL,
  `course_application_id` int(11) NOT NULL,
  `total_commission` float DEFAULT NULL,
  `total_gst` double(11,2) NOT NULL,
  `final_total` float DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `installment_no` varchar(45) DEFAULT NULL,
  `invoice_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `college_invoice_payments`
--

CREATE TABLE IF NOT EXISTS `college_invoice_payments` (
  `invoice_payments_id` int(11) NOT NULL,
  `ci_payment_id` int(11) NOT NULL,
  `college_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `college_payments`
--

CREATE TABLE IF NOT EXISTS `college_payments` (
  `college_payment_id` int(11) NOT NULL COMMENT 'to track the payment made to college or made by college',
  `amount` decimal(10,2) DEFAULT NULL,
  `date_paid` datetime DEFAULT NULL,
  `payment_method` varchar(45) DEFAULT NULL,
  `description` mediumtext,
  `payment_type` varchar(55) NOT NULL,
  `college_invoice_id` int(11) DEFAULT NULL,
  `course_application_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='invoice items';

-- --------------------------------------------------------

--
-- Table structure for table `commissions`
--

CREATE TABLE IF NOT EXISTS `commissions` (
  `commission_id` int(11) NOT NULL,
  `commission_percent` float DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `company_id` int(11) NOT NULL,
  `name` varchar(145) DEFAULT NULL,
  `phone_id` int(11) NOT NULL,
  `abn` varchar(145) DEFAULT NULL,
  `acn` varchar(145) DEFAULT NULL,
  `website` varchar(45) DEFAULT NULL,
  `invoice_to_name` varchar(145) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_branches`
--

CREATE TABLE IF NOT EXISTS `company_branches` (
  `company_branch_id` int(11) NOT NULL,
  `branch_name` varchar(45) DEFAULT NULL,
  `companies_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_branch_emails`
--

CREATE TABLE IF NOT EXISTS `company_branch_emails` (
  `company_branch_email_id` int(11) NOT NULL,
  `email_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `label` varchar(45) DEFAULT NULL,
  `default` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_branch_phones`
--

CREATE TABLE IF NOT EXISTS `company_branch_phones` (
  `company_branch_phone_id` int(11) NOT NULL,
  `phone_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `label` varchar(45) DEFAULT NULL,
  `default` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_contacts`
--

CREATE TABLE IF NOT EXISTS `company_contacts` (
  `company_contact_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `department` varchar(45) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_default_contacts`
--

CREATE TABLE IF NOT EXISTS `company_default_contacts` (
  `company_default_contact_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `phone_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `controller`
--

CREATE TABLE IF NOT EXISTS `controller` (
  `controller_id` int(11) NOT NULL,
  `name` varchar(145) DEFAULT NULL,
  `description` varchar(145) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `controller_actions`
--

CREATE TABLE IF NOT EXISTS `controller_actions` (
  `id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `controller_id` int(11) NOT NULL,
  `description` varchar(145) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `country_id` int(11) NOT NULL,
  `name` varchar(145) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=501 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `name`, `code`) VALUES
(251, 'Andorra', 'AD'),
(252, 'United Arab Emirates', 'AE'),
(253, 'Afghanistan', 'AF'),
(254, 'Antigua and Barbuda', 'AG'),
(255, 'Anguilla', 'AI'),
(256, 'Albania', 'AL'),
(257, 'Armenia', 'AM'),
(258, 'Angola', 'AO'),
(259, 'Antarctica', 'AQ'),
(260, 'Argentina', 'AR'),
(261, 'American Samoa', 'AS'),
(262, 'Austria', 'AT'),
(263, 'Australia', 'AU'),
(264, 'Aruba', 'AW'),
(265, 'Åland', 'AX'),
(266, 'Azerbaijan', 'AZ'),
(267, 'Bosnia and Herzegovina', 'BA'),
(268, 'Barbados', 'BB'),
(269, 'Bangladesh', 'BD'),
(270, 'Belgium', 'BE'),
(271, 'Burkina Faso', 'BF'),
(272, 'Bulgaria', 'BG'),
(273, 'Bahrain', 'BH'),
(274, 'Burundi', 'BI'),
(275, 'Benin', 'BJ'),
(276, 'Saint Barthélemy', 'BL'),
(277, 'Bermuda', 'BM'),
(278, 'Brunei', 'BN'),
(279, 'Bolivia', 'BO'),
(280, 'Bonaire', 'BQ'),
(281, 'Brazil', 'BR'),
(282, 'Bahamas', 'BS'),
(283, 'Bhutan', 'BT'),
(284, 'Bouvet Island', 'BV'),
(285, 'Botswana', 'BW'),
(286, 'Belarus', 'BY'),
(287, 'Belize', 'BZ'),
(288, 'Canada', 'CA'),
(289, 'Cocos [Keeling] Islands', 'CC'),
(290, 'Democratic Republic of the Congo', 'CD'),
(291, 'Central African Republic', 'CF'),
(292, 'Republic of the Congo', 'CG'),
(293, 'Switzerland', 'CH'),
(294, 'Ivory Coast', 'CI'),
(295, 'Cook Islands', 'CK'),
(296, 'Chile', 'CL'),
(297, 'Cameroon', 'CM'),
(298, 'China', 'CN'),
(299, 'Colombia', 'CO'),
(300, 'Costa Rica', 'CR'),
(301, 'Cuba', 'CU'),
(302, 'Cape Verde', 'CV'),
(303, 'Curacao', 'CW'),
(304, 'Christmas Island', 'CX'),
(305, 'Cyprus', 'CY'),
(306, 'Czech Republic', 'CZ'),
(307, 'Germany', 'DE'),
(308, 'Djibouti', 'DJ'),
(309, 'Denmark', 'DK'),
(310, 'Dominica', 'DM'),
(311, 'Dominican Republic', 'DO'),
(312, 'Algeria', 'DZ'),
(313, 'Ecuador', 'EC'),
(314, 'Estonia', 'EE'),
(315, 'Egypt', 'EG'),
(316, 'Western Sahara', 'EH'),
(317, 'Eritrea', 'ER'),
(318, 'Spain', 'ES'),
(319, 'Ethiopia', 'ET'),
(320, 'Finland', 'FI'),
(321, 'Fiji', 'FJ'),
(322, 'Falkland Islands', 'FK'),
(323, 'Micronesia', 'FM'),
(324, 'Faroe Islands', 'FO'),
(325, 'France', 'FR'),
(326, 'Gabon', 'GA'),
(327, 'United Kingdom', 'GB'),
(328, 'Grenada', 'GD'),
(329, 'Georgia', 'GE'),
(330, 'French Guiana', 'GF'),
(331, 'Guernsey', 'GG'),
(332, 'Ghana', 'GH'),
(333, 'Gibraltar', 'GI'),
(334, 'Greenland', 'GL'),
(335, 'Gambia', 'GM'),
(336, 'Guinea', 'GN'),
(337, 'Guadeloupe', 'GP'),
(338, 'Equatorial Guinea', 'GQ'),
(339, 'Greece', 'GR'),
(340, 'South Georgia and the South Sandwich Islands', 'GS'),
(341, 'Guatemala', 'GT'),
(342, 'Guam', 'GU'),
(343, 'Guinea-Bissau', 'GW'),
(344, 'Guyana', 'GY'),
(345, 'Hong Kong', 'HK'),
(346, 'Heard Island and McDonald Islands', 'HM'),
(347, 'Honduras', 'HN'),
(348, 'Croatia', 'HR'),
(349, 'Haiti', 'HT'),
(350, 'Hungary', 'HU'),
(351, 'Indonesia', 'ID'),
(352, 'Ireland', 'IE'),
(353, 'Israel', 'IL'),
(354, 'Isle of Man', 'IM'),
(355, 'India', 'IN'),
(356, 'British Indian Ocean Territory', 'IO'),
(357, 'Iraq', 'IQ'),
(358, 'Iran', 'IR'),
(359, 'Iceland', 'IS'),
(360, 'Italy', 'IT'),
(361, 'Jersey', 'JE'),
(362, 'Jamaica', 'JM'),
(363, 'Jordan', 'JO'),
(364, 'Japan', 'JP'),
(365, 'Kenya', 'KE'),
(366, 'Kyrgyzstan', 'KG'),
(367, 'Cambodia', 'KH'),
(368, 'Kiribati', 'KI'),
(369, 'Comoros', 'KM'),
(370, 'Saint Kitts and Nevis', 'KN'),
(371, 'North Korea', 'KP'),
(372, 'South Korea', 'KR'),
(373, 'Kuwait', 'KW'),
(374, 'Cayman Islands', 'KY'),
(375, 'Kazakhstan', 'KZ'),
(376, 'Laos', 'LA'),
(377, 'Lebanon', 'LB'),
(378, 'Saint Lucia', 'LC'),
(379, 'Liechtenstein', 'LI'),
(380, 'Sri Lanka', 'LK'),
(381, 'Liberia', 'LR'),
(382, 'Lesotho', 'LS'),
(383, 'Lithuania', 'LT'),
(384, 'Luxembourg', 'LU'),
(385, 'Latvia', 'LV'),
(386, 'Libya', 'LY'),
(387, 'Morocco', 'MA'),
(388, 'Monaco', 'MC'),
(389, 'Moldova', 'MD'),
(390, 'Montenegro', 'ME'),
(391, 'Saint Martin', 'MF'),
(392, 'Madagascar', 'MG'),
(393, 'Marshall Islands', 'MH'),
(394, 'Macedonia', 'MK'),
(395, 'Mali', 'ML'),
(396, 'Myanmar [Burma]', 'MM'),
(397, 'Mongolia', 'MN'),
(398, 'Macao', 'MO'),
(399, 'Northern Mariana Islands', 'MP'),
(400, 'Martinique', 'MQ'),
(401, 'Mauritania', 'MR'),
(402, 'Montserrat', 'MS'),
(403, 'Malta', 'MT'),
(404, 'Mauritius', 'MU'),
(405, 'Maldives', 'MV'),
(406, 'Malawi', 'MW'),
(407, 'Mexico', 'MX'),
(408, 'Malaysia', 'MY'),
(409, 'Mozambique', 'MZ'),
(410, 'Namibia', 'NA'),
(411, 'New Caledonia', 'NC'),
(412, 'Niger', 'NE'),
(413, 'Norfolk Island', 'NF'),
(414, 'Nigeria', 'NG'),
(415, 'Nicaragua', 'NI'),
(416, 'Netherlands', 'NL'),
(417, 'Norway', 'NO'),
(418, 'Nepal', 'NP'),
(419, 'Nauru', 'NR'),
(420, 'Niue', 'NU'),
(421, 'New Zealand', 'NZ'),
(422, 'Oman', 'OM'),
(423, 'Panama', 'PA'),
(424, 'Peru', 'PE'),
(425, 'French Polynesia', 'PF'),
(426, 'Papua New Guinea', 'PG'),
(427, 'Philippines', 'PH'),
(428, 'Pakistan', 'PK'),
(429, 'Poland', 'PL'),
(430, 'Saint Pierre and Miquelon', 'PM'),
(431, 'Pitcairn Islands', 'PN'),
(432, 'Puerto Rico', 'PR'),
(433, 'Palestine', 'PS'),
(434, 'Portugal', 'PT'),
(435, 'Palau', 'PW'),
(436, 'Paraguay', 'PY'),
(437, 'Qatar', 'QA'),
(438, 'Réunion', 'RE'),
(439, 'Romania', 'RO'),
(440, 'Serbia', 'RS'),
(441, 'Russia', 'RU'),
(442, 'Rwanda', 'RW'),
(443, 'Saudi Arabia', 'SA'),
(444, 'Solomon Islands', 'SB'),
(445, 'Seychelles', 'SC'),
(446, 'Sudan', 'SD'),
(447, 'Sweden', 'SE'),
(448, 'Singapore', 'SG'),
(449, 'Saint Helena', 'SH'),
(450, 'Slovenia', 'SI'),
(451, 'Svalbard and Jan Mayen', 'SJ'),
(452, 'Slovakia', 'SK'),
(453, 'Sierra Leone', 'SL'),
(454, 'San Marino', 'SM'),
(455, 'Senegal', 'SN'),
(456, 'Somalia', 'SO'),
(457, 'Suriname', 'SR'),
(458, 'South Sudan', 'SS'),
(459, 'São Tomé and Príncipe', 'ST'),
(460, 'El Salvador', 'SV'),
(461, 'Sint Maarten', 'SX'),
(462, 'Syria', 'SY'),
(463, 'Swaziland', 'SZ'),
(464, 'Turks and Caicos Islands', 'TC'),
(465, 'Chad', 'TD'),
(466, 'French Southern Territories', 'TF'),
(467, 'Togo', 'TG'),
(468, 'Thailand', 'TH'),
(469, 'Tajikistan', 'TJ'),
(470, 'Tokelau', 'TK'),
(471, 'East Timor', 'TL'),
(472, 'Turkmenistan', 'TM'),
(473, 'Tunisia', 'TN'),
(474, 'Tonga', 'TO'),
(475, 'Turkey', 'TR'),
(476, 'Trinidad and Tobago', 'TT'),
(477, 'Tuvalu', 'TV'),
(478, 'Taiwan', 'TW'),
(479, 'Tanzania', 'TZ'),
(480, 'Ukraine', 'UA'),
(481, 'Uganda', 'UG'),
(482, 'U.S. Minor Outlying Islands', 'UM'),
(483, 'United States', 'US'),
(484, 'Uruguay', 'UY'),
(485, 'Uzbekistan', 'UZ'),
(486, 'Vatican City', 'VA'),
(487, 'Saint Vincent and the Grenadines', 'VC'),
(488, 'Venezuela', 'VE'),
(489, 'British Virgin Islands', 'VG'),
(490, 'U.S. Virgin Islands', 'VI'),
(491, 'Vietnam', 'VN'),
(492, 'Vanuatu', 'VU'),
(493, 'Wallis and Futuna', 'WF'),
(494, 'Samoa', 'WS'),
(495, 'Kosovo', 'XK'),
(496, 'Yemen', 'YE'),
(497, 'Mayotte', 'YT'),
(498, 'South Africa', 'ZA'),
(499, 'Zambia', 'ZM'),
(500, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `commission_percent` double(11,2) NOT NULL,
  `broad_field` int(11) DEFAULT NULL COMMENT 'Broad Category ID',
  `level_id` int(11) DEFAULT NULL COMMENT 'Diploma, Bachelor etc..',
  `narrow_field` int(11) DEFAULT NULL COMMENT 'Narrow category mainly for search\n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_application`
--

CREATE TABLE IF NOT EXISTS `course_application` (
  `course_application_id` int(11) NOT NULL,
  `institution_course_id` int(11) NOT NULL,
  `intake_id` int(11) NOT NULL,
  `end_date` date DEFAULT NULL,
  `super_agent_id` int(11) DEFAULT NULL,
  `sub_agent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tuition_fee` float DEFAULT NULL,
  `student_id` varchar(45) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `fee_for_coe` double(11,2) DEFAULT NULL,
  `total_discount` varchar(45) DEFAULT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `sub_agent_commission` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='course application table	';

-- --------------------------------------------------------

--
-- Table structure for table `course_commissions`
--

CREATE TABLE IF NOT EXISTS `course_commissions` (
  `course_commission_id` int(11) NOT NULL,
  `description` text,
  `course_id` int(11) NOT NULL,
  `commissions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_fees`
--

CREATE TABLE IF NOT EXISTS `course_fees` (
  `course_fee_id` int(11) NOT NULL,
  `description` text,
  `fees_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_levels`
--

CREATE TABLE IF NOT EXISTS `course_levels` (
  `level_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_levels`
--

INSERT INTO `course_levels` (`level_id`, `name`, `description`) VALUES
(1, 'English', 'General English, EAP ...'),
(2, 'Advance Diploma', ''),
(3, 'Cerificate I', ''),
(4, 'Certificate II', ''),
(5, 'Certificate III', ''),
(6, 'Certificate IV', ''),
(7, 'Diploma', ''),
(8, 'Bachelor Degree', ''),
(9, 'Associate Degree', ''),
(10, 'Graduate Certificate', ''),
(11, 'Graduate Diploma', ''),
(12, 'Master Degree', ''),
(13, 'Professional Year', ''),
(14, 'Non AQF Award', ''),
(15, 'NAATI', ''),
(16, 'Others', '');

-- --------------------------------------------------------

--
-- Table structure for table `custom_suscriptions`
--

CREATE TABLE IF NOT EXISTS `custom_suscriptions` (
  `custom_suscription_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `aggregated_amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `document_id` int(11) NOT NULL,
  `type` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `shelf_location` varchar(200) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Document table';

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `email_id` int(11) NOT NULL,
  `email` varchar(245) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE IF NOT EXISTS `features` (
  `feature_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `features_controller_actions`
--

CREATE TABLE IF NOT EXISTS `features_controller_actions` (
  `features_controller_action_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL,
  `controller_actions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE IF NOT EXISTS `fees` (
  `fee_id` int(11) NOT NULL,
  `total_tuition_fee` float DEFAULT NULL,
  `enrollment_fee` float DEFAULT NULL,
  `material_fee` float DEFAULT NULL,
  `coe_fee` float DEFAULT NULL,
  `other_fee` float DEFAULT NULL,
  `coe_initial_deposit` float DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_college_invoices`
--

CREATE TABLE IF NOT EXISTS `group_college_invoices` (
  `group_college_invoice_id` int(11) NOT NULL,
  `group_invoices_id` int(11) NOT NULL,
  `college_invoices_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_invoices`
--

CREATE TABLE IF NOT EXISTS `group_invoices` (
  `group_invoice_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `description` text,
  `due_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE IF NOT EXISTS `institutes` (
  `institution_id` int(11) NOT NULL,
  `short_name` varchar(45) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `institute_addresses`
--

CREATE TABLE IF NOT EXISTS `institute_addresses` (
  `institute_address_id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `email` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `institute_courses`
--

CREATE TABLE IF NOT EXISTS `institute_courses` (
  `institute_course_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `description` varchar(145) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `institute_course_branch`
--

CREATE TABLE IF NOT EXISTS `institute_course_branch` (
  `id` int(11) NOT NULL,
  `institute_course_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `description` varchar(145) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `institute_document`
--

CREATE TABLE IF NOT EXISTS `institute_document` (
  `institute_document_id` int(11) NOT NULL,
  `institution_id` int(11) NOT NULL,
  `document_id` int(11) DEFAULT NULL,
  `description` varchar(145) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Institution Documents';


-- --------------------------------------------------------

--
-- Table structure for table `institute_intakes`
--

CREATE TABLE IF NOT EXISTS `institute_intakes` (
  `institute_intake_id` int(11) NOT NULL,
  `intake_id` int(11) DEFAULT NULL,
  `institute_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `institute_phones`
--

CREATE TABLE IF NOT EXISTS `institute_phones` (
  `institute_phone_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `phone_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `intakes`
--

CREATE TABLE IF NOT EXISTS `intakes` (
  `intake_id` int(11) NOT NULL,
  `orientation_date` datetime DEFAULT NULL,
  `intake_date` date DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `intakes` ADD `deleted_at` DATETIME NULL DEFAULT NULL ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL,
  `amount` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `invoice_amount` float DEFAULT NULL,
  `final_total` double(11,2) NOT NULL,
  `total_gst` double(11,2) NOT NULL,
  `description` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `invoice_date` datetime DEFAULT NULL,
  `due_date` date NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_to`
--

CREATE TABLE IF NOT EXISTS `invoice_to` (
  `invoice_to` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `agency_invoice_to_it` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `level_access`
--

CREATE TABLE IF NOT EXISTS `level_access` (
  `level_access_id` int(11) NOT NULL,
  `levels_id` int(11) NOT NULL,
  `features_controller_actions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `narrow_field`
--

CREATE TABLE IF NOT EXISTS `narrow_field` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text,
  `broad_field_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `narrow_field`
--

INSERT INTO `narrow_field` (`id`, `name`, `description`, `broad_field_id`) VALUES
(1, 'Natural and Physical Sciences', 'Natural and Physical Sciences', 1),
(2, 'Mathematical Sciences', 'Mathematical Sciences', 1),
(3, 'Physics and Astronomy', 'Physics and Astronomy', 1),
(4, 'Chemical Sciences', 'Chemical Sciences', 1),
(5, 'Earth Sciences', 'Earth Sciences', 1),
(6, 'Biological Sciences', 'Biological Sciences', 1),
(7, 'Other Natural and Physical Sciences', 'Other Natural and Physical Sciences', 1),
(8, 'Information Technology', 'Information Technology', 2),
(9, 'Computer Science', 'Computer Science', 2),
(10, 'Information Systems', 'Information Systems', 2),
(11, 'Other Information Technology', 'Other Information Technology', 2),
(12, 'Engineering and Related Technologies', 'Engineering and Related Technologies', 3),
(13, 'Manufacturing Engineering and Technology', 'Manufacturing Engineering and Technology', 3),
(14, 'Process and Resources Engineering', 'Process and Resources Engineering', 3),
(15, 'Automotive Engineering and Technology', 'Automotive Engineering and Technology', 3),
(16, 'Mechanical and Industrial Engineering and Technology', 'Mechanical and Industrial Engineering and Technology', 3),
(17, 'Civil Engineering', 'Civil Engineering', 3),
(18, 'Geomatic Engineering', 'Geomatic Engineering', 3),
(19, 'Electrical and Electronic Engineering and Technology', 'Electrical and Electronic Engineering and Technology', 3),
(20, 'Aerospace Engineering and Technology', 'Aerospace Engineering and Technology', 3),
(21, 'Maritime Engineering and Technology', 'Maritime Engineering and Technology', 3),
(22, 'Other Engineering and Related Technologies', 'Other Engineering and Related Technologies', 3),
(23, 'Architecture and Building', 'Architecture and Building', 4),
(24, 'Architecture and Urban Environment', 'Architecture and Urban Environment', 4),
(25, 'Building', 'Building', 4),
(26, 'Agriculture', 'Agriculture', 5),
(27, 'Horticulture and Viticulture', 'Horticulture and Viticulture', 5),
(28, 'Forestry Studies', 'Forestry Studies', 5),
(29, 'Fisheries Studies', 'Fisheries Studies', 5),
(30, 'Environmental Studies', 'Environmental Studies', 5),
(31, 'Other Agriculture, Environmental and Related Studies', 'Other Agriculture, Environmental and Related Studies', 5),
(32, 'Health', 'Health', 6),
(33, 'Medical Studies', 'Medical Studies', 6),
(34, 'Nursing', 'Nursing', 6),
(35, 'Pharmacy', 'Pharmacy', 6),
(36, 'Dental Studies', 'Dental Studies', 6),
(37, 'Optical Science', 'Optical Science', 6),
(38, 'Veterinary Studies', 'Veterinary Studies', 6),
(39, 'Public Health', 'Public Health', 6),
(40, 'Radiography', 'Radiography', 6),
(41, 'Rehabilitation Therapies', 'Rehabilitation Therapies', 6),
(42, 'Complementary Therapies', 'Complementary Therapies', 6),
(43, 'Other Health', 'Other Health', 6),
(44, 'Education', 'Education', 7),
(45, 'Teacher Education', 'Teacher Education', 7),
(46, 'Curriculum and Education Studies', 'Curriculum and Education Studies', 7),
(47, 'Other Education', 'Other Education', 7),
(48, 'Management and Commerce', 'Management and Commerce', 8),
(49, 'Accounting', 'Accounting', 8),
(50, 'Business and Management', 'Business and Management', 8),
(51, 'Sales and Marketing', 'Sales and Marketing', 8),
(52, 'Tourism', 'Tourism', 8),
(53, 'Office Studies', 'Office Studies', 8),
(54, 'Banking, Finance and Related Fields', 'Banking, Finance and Related Fields', 8),
(55, 'Other Management and Commerce', 'Other Management and Commerce', 8),
(56, 'Society and Culture', 'Society and Culture', 9),
(57, 'Political Science and Policy Studies ', 'Political Science and Policy Studies ', 9),
(58, 'Studies in Human Society', 'Studies in Human Society', 9),
(59, 'Human Welfare Studies and Services', 'Human Welfare Studies and Services', 9),
(60, 'Behavioural Science', 'Behavioural Science', 9),
(61, 'Law', 'Law', 9),
(62, 'Justice and Law Enforcement', 'Justice and Law Enforcement', 9),
(63, 'Librarianship, Information Management and Curatorial Studies', 'Librarianship, Information Management and Curatorial Studies', 9),
(64, 'Language and Literature', 'Language and Literature', 9),
(65, 'Philosophy and Religious Studies', 'Philosophy and Religious Studies', 9),
(66, 'Economics and Econometrics', 'Economics and Econometrics', 9),
(67, 'Sport and Recreation', 'Sport and Recreation', 9),
(68, 'Other Society and Culture', 'Other Society and Culture', 9),
(69, 'Creative Arts', 'Creative Arts', 10),
(70, 'Performing Arts ', 'Performing Arts ', 10),
(71, 'Visual Arts and Crafts', 'Visual Arts and Crafts', 10),
(72, 'Graphic and Design Studies', 'Graphic and Design Studies', 10),
(73, 'Communication and Media Studies', 'Communication and Media Studies', 10),
(74, 'Other Creative Arts', 'Other Creative Arts', 10),
(75, 'Food and Hospitality', 'Food and Hospitality', 11),
(76, 'Personal Services', 'Personal Services', 11),
(77, 'General Education Programmes', 'General Education Programmes', 12),
(78, 'Social Skills Programmes', 'Social Skills Programmes', 12),
(79, 'Employment Skills Programmes', 'Employment Skills Programmes', 12),
(80, 'Other Mixed Field Programmes', 'Other Mixed Field Programmes', 12);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `notes_id` int(11) NOT NULL,
  `added_by_user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `remind` tinyint(1) NOT NULL,
  `reminder_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: incomplete, 1: complete',
  `completed_date` datetime DEFAULT NULL,
  `completed_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_invoice_breakdowns`
--

CREATE TABLE IF NOT EXISTS `payment_invoice_breakdowns` (
  `payment_invoice_breakdown_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='invoice items';

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE IF NOT EXISTS `payment_types` (
  `payment_type_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`payment_type_id`, `name`, `description`) VALUES
(1, 'client_agent', 'Client to Agent'),
(2, 'agent_client', 'Agent to Client'),
(3, 'student_college', 'Student to College'),
(4, 'agent_college', 'Agent to College'),
(5, 'college_agent', 'College to Agent');

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `person_id` int(11) NOT NULL,
  `first_name` varchar(145) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(145) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `photo_id` int(11) DEFAULT NULL,
  `sex` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `passport_no` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `person_addresses`
--

CREATE TABLE IF NOT EXISTS `person_addresses` (
  `person_address_id` int(11) NOT NULL COMMENT '	',
  `address_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT NULL COMMENT 'Need to reset the previous current flag ... USE \nStored Procedure'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `person_emails`
--

CREATE TABLE IF NOT EXISTS `person_emails` (
  `person_email_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  `is_primary` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `person_phones`
--

CREATE TABLE IF NOT EXISTS `person_phones` (
  `person_phone_id` int(11) NOT NULL,
  `phone_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `is_primary` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE IF NOT EXISTS `phones` (
  `phone_id` int(11) NOT NULL,
  `number` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `area_code` varchar(45) DEFAULT NULL,
  `country_code` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `photo_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shelf_location` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'company', 'a:1:{s:12:"company_name";s:10:"Enter Company Name";}', '2016-03-23 22:42:20', '2016-03-23 22:42:20'),
(2, 'domain', 'tenant', '2016-03-23 22:42:20', '2016-03-23 22:42:20'),
(3, 'folder', 'hqFzcwYdO5', '2016-03-23 22:42:20', '2016-03-23 22:42:20'),
(4, 'bank', 'a:4:{s:4:"name";s:18:" ";s:12:"account_name";s:13:" ";s:6:"number";s:12:" ";s:3:" ";s:7:" ";}', '2016-07-17 18:58:41', '2016-07-17 18:58:41');

-- --------------------------------------------------------

--
-- Table structure for table `standard_subscriptions`
--

CREATE TABLE IF NOT EXISTS `standard_subscriptions` (
  `standard_subscription_id` int(11) NOT NULL,
  `name` varchar(145) DEFAULT NULL,
  `description` varchar(145) DEFAULT NULL,
  `amount` float DEFAULT NULL COMMENT 'suscription are prechecked with functionalities.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `standard_subscriptions`
--

INSERT INTO `standard_subscriptions` (`standard_subscription_id`, `name`, `description`, `amount`) VALUES
(1, 'basic', 'Basic system will handle client and their invoice details', 500),
(2, 'Standard', 'Standar system will handle client and their invoice details', 1500),
(3, 'premium', 'Premium system will handle client and their invoice details', 2500);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `name`, `description`) VALUES
(1, 'Enquiry', 'Enquiry'),
(2, 'Offer Letter Processing', 'Offer Letter Processing'),
(3, 'Offer Letter Issued', 'Offer Letter Issued'),
(4, 'COE Processing', 'COE Processing'),
(5, 'COE Issued', 'COE Issued'),
(6, 'Enrolled', 'Enrolled'),
(7, 'Completed', 'Completed'),
(8, 'Cancelled', 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `student_application_payments`
--

CREATE TABLE IF NOT EXISTS `student_application_payments` (
  `student_payments_id` int(11) NOT NULL,
  `course_application_id` int(11) NOT NULL,
  `client_payment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_invoices`
--

CREATE TABLE IF NOT EXISTS `student_invoices` (
  `student_invoice_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `application_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subagent_application_payments`
--

CREATE TABLE IF NOT EXISTS `subagent_application_payments` (
  `subagent_payments_id` int(11) NOT NULL,
  `course_application_id` int(11) NOT NULL,
  `client_payment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subagent_invoices`
--

CREATE TABLE IF NOT EXISTS `subagent_invoices` (
  `subagent_invoice_id` int(11) NOT NULL,
  `course_application_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_features`
--

CREATE TABLE IF NOT EXISTS `subscription_features` (
  `subscription_feature_id` int(11) NOT NULL,
  `description` text,
  `custom_suscriptions_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `standard_subscriptions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_payments`
--

CREATE TABLE IF NOT EXISTS `subscription_payments` (
  `subscription_payment_id` int(11) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_type` varchar(45) DEFAULT NULL COMMENT 'dropdown menu (cash /card/ paypal/others)',
  `agency_subscription_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_status`
--

CREATE TABLE IF NOT EXISTS `subscription_status` (
  `subscription_status_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL COMMENT 'trial /paid will be dropdown option'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_status`
--

INSERT INTO `subscription_status` (`subscription_status_id`, `name`) VALUES
(1, 'trial'),
(2, 'full');

-- --------------------------------------------------------

--
-- Table structure for table `superagent_institutes`
--

CREATE TABLE IF NOT EXISTS `superagent_institutes` (
  `superagent_institute_id` int(11) NOT NULL,
  `agents_id` int(11) DEFAULT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `commissions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE IF NOT EXISTS `terms` (
  `term_id` int(11) NOT NULL,
  `year` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timelines`
--

CREATE TABLE IF NOT EXISTS `timelines` (
  `timeline_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `timeline_type_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timeline_types`
--

CREATE TABLE IF NOT EXISTS `timeline_types` (
  `type_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(55) NOT NULL,
  `header` text CHARACTER SET utf8 NOT NULL,
  `body` text,
  `footer` text
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2016 at 10:43 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Dumping data for table `timeline_types`
--

INSERT INTO `timeline_types` (`type_id`, `description`, `image`, `header`, `body`, `footer`) VALUES
(1, 'Client Created', 'fa-user bg-aqua', 'Client Created', NULL, NULL),
(2, 'Notes Added', 'fa-sticky-note bg-blue', '{{NAME}} added a note', '{{DESCRIPTION}}', NULL),
(3, 'Document Uploaded', 'fa-clipboard bg-yellow', '{{NAME}} uploaded a document', '<strong>Description : </strong> {{DESCRIPTION}}<br/>\n<strong>Type : </strong> {{TYPE}}<br/>\n<strong>File Name: </strong> {{FILE_NAME}}', '<a href="{{VIEW_LINK}}" target="_blank" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eye-open"></i> View</a>\n<a href="{{DOWNLOAD_LINK}}" target="_blank" class="btn btn-success btn-xs"><i class="fa fa-download"></i> Download</a>'),
(4, 'Invoice Created', 'fa-book bg-orange', '{{NAME}} created an invoice', '<strong>Description : </strong> {{DESCRIPTION}}<br/>\n<strong>Invoice Date : </strong> {{DATE}}<br/>\n<strong>Invoice Amount : </strong> {{AMOUNT}}', '<a href="{{VIEW_LINK}}" target="_blank" class="btn btn-primary btn-xs btn-flat"><i class="glyphicon glyphicon-eye-open"></i> View Invoice</a>'),
(5, 'Payment Added', 'fa-money bg-purple', '{{NAME}} made a payment', '<strong>Payment Type: </strong> {{TYPE}}<br/>\n<strong>Payment Date : </strong> {{DATE}}<br/>\n<strong>Payment Amount : </strong> {{AMOUNT}}<br/>\n<strong>Description : </strong> {{DESCRIPTION}}<br/>', '<a href="{{VIEW_LINK}}" target="_blank" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-print"></i> Print Receipt</a>'),
(6, 'Application Added', 'fa-graduation-cap bg-maroon', 'Enrolled in {{COURSE}} from {{INSTITUTE}} ', '{{NAME}} created an application. <br/>\n<strong>Tuition fee: </strong>{{TUITION_FEE}}<br/>\n\n<strong>Intake Date: </strong>{{INTAKE_DATE}}<br/>', '<a href="{{VIEW_LINK}}" target="_blank" class="btn btn-primary btn-xs btn-flat"><i class="glyphicon glyphicon-eye-open"></i> View Application</a>'),
(7, 'Application Status Changed', 'fa-exchange bg-gray', 'Application Status Changed by {{NAME}}', 'Application Status Changed From {{STATUS1}} To {{STATUS2}}', '<a href="{{VIEW_LINK}}" target="_blank" class="btn btn-primary btn-xs btn-flat"><i class="glyphicon glyphicon-eye-open"></i> View Application</a>'),
(8, 'Email Sent', 'bg-teal fa-envelope', '{{NAME}} sent an email to {{CLIENT_NAME}}', '<strong>To Email Address : </strong>{{CLIENT_EMAIL}}<br/>\n<strong>Subject : </strong>{{SUBJECT}}<br/>\n<strong>Body : </strong>{{BODY}}\n', NULL);


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(75) NOT NULL,
  `user_type` varchar(45) NOT NULL,
  `password` varchar(245) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : pending, 1 : activated, 2 : suspended, 3 : trasheds',
  `is_active` tinyint(1) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `timezone` varchar(100) DEFAULT NULL,
  `is_disabled` tinyint(1) DEFAULT NULL,
  `suscription_id` int(11) DEFAULT NULL,
  `show_help_intro` tinyint(1) DEFAULT NULL,
  `is_super_admin` tinyint(1) DEFAULT '0',
  `is_system_admin` tinyint(1) DEFAULT '0',
  `role` int(11) NOT NULL,
  `remember_token` varchar(200) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `given_name` varchar(55) NOT NULL,
  `auth_code` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='users';

-- --------------------------------------------------------

--
-- Table structure for table `user_emails`
--

CREATE TABLE IF NOT EXISTS `user_emails` (
  `user_email_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email_id` int(11) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE IF NOT EXISTS `user_levels` (
  `user_level_id` int(11) NOT NULL,
  `name` varchar(145) DEFAULT NULL,
  `description` varchar(145) DEFAULT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`user_level_id`, `name`, `description`, `value`) VALUES
(1, 'staff', 'staff members of agency', 8),
(2, 'accountant', 'accountant of agency', 4),
(3, 'admin', 'adminstrator of all system', 12),
(4, 'Consultant', 'Consultant', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`action_id`);

--
-- Indexes for table `active_clients`
--
ALTER TABLE `active_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`), ADD KEY `fk_country_idx` (`country_id`);

--
-- Indexes for table `agencies`
--
ALTER TABLE `agencies`
  ADD PRIMARY KEY (`agency_id`), ADD KEY `fk_agencies_companies1_idx` (`company_id`);

--
-- Indexes for table `agency_clients`
--
ALTER TABLE `agency_clients`
  ADD PRIMARY KEY (`agency_client_id`), ADD KEY `fk_agency_clients_agencies1_idx` (`agent_id`), ADD KEY `fk_agency_clients_clients1_idx` (`client_id`);

--
-- Indexes for table `agency_institutes`
--
ALTER TABLE `agency_institutes`
  ADD PRIMARY KEY (`agency_institute_id`,`agency_id`), ADD KEY `fk_agency_institutes_agency1_idx` (`agency_id`), ADD KEY `fk_agency_institute_institutes_idx` (`ams_institute_id`);

--
-- Indexes for table `agency_institute_branches`
--
ALTER TABLE `agency_institute_branches`
  ADD PRIMARY KEY (`agency_institute_branch_id`,`agency_id`), ADD KEY `fk_agency_institute_branches_agency1_idx` (`agency_id`), ADD KEY `fk_agency_institute_branches_company_branches1_idx` (`company_branches_id`);

--
-- Indexes for table `agency_institute_courses`
--
ALTER TABLE `agency_institute_courses`
  ADD PRIMARY KEY (`agency_institute_course_id`,`agency_id`), ADD KEY `fk_agency_institute_courses_agency1_idx` (`agency_id`), ADD KEY `fk_agency_institute_courses_courses1_idx` (`courses_course_id`);

--
-- Indexes for table `agency_subscriptions`
--
ALTER TABLE `agency_subscriptions`
  ADD PRIMARY KEY (`agency_subscription_id`), ADD KEY `subscription_id_idx` (`standard_subscription_id`), ADD KEY `agency_id_idx` (`agency_id`), ADD KEY `fk_agency_subscriptions_subscription_status1_idx` (`subscription_status_id`);

--
-- Indexes for table `agency_users`
--
ALTER TABLE `agency_users`
  ADD PRIMARY KEY (`agency_user_id`), ADD KEY `agency_fk_idx` (`agency_id`), ADD KEY `user_fk_idx` (`user_id`) USING BTREE, ADD KEY `fk_agency_users_levels1_idx` (`level_id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`agent_id`);

--
-- Indexes for table `application_notes`
--
ALTER TABLE `application_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_status`
--
ALTER TABLE `application_status`
  ADD PRIMARY KEY (`application_status_id`), ADD KEY `course_application_idx` (`course_application_id`), ADD KEY `status_id_idx` (`status_id`);

--
-- Indexes for table `application_status_documents`
--
ALTER TABLE `application_status_documents`
  ADD PRIMARY KEY (`application_status_document_id`), ADD KEY `application_status_idx` (`application_status_id`), ADD KEY `document_idx` (`document_id`);

--
-- Indexes for table `broad_field`
--
ALTER TABLE `broad_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_other_commissions`
--
ALTER TABLE `ci_other_commissions`
  ADD PRIMARY KEY (`other_commission_id`), ADD KEY `college_invoice_id` (`college_invoice_id`);

--
-- Indexes for table `ci_tuition_commissions`
--
ALTER TABLE `ci_tuition_commissions`
  ADD PRIMARY KEY (`tuition_commission_id`), ADD KEY `college_invoice_id` (`college_invoice_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`), ADD KEY `fk_clients_users1_idx` (`user_id`), ADD KEY `fk_clients_person1_idx` (`person_id`);

--
-- Indexes for table `client_documents`
--
ALTER TABLE `client_documents`
  ADD PRIMARY KEY (`client_document_id`), ADD KEY `fk_documents_idx` (`document_id`);

--
-- Indexes for table `client_emails`
--
ALTER TABLE `client_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_notes`
--
ALTER TABLE `client_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_payments`
--
ALTER TABLE `client_payments`
  ADD PRIMARY KEY (`client_payment_id`);

--
-- Indexes for table `client_timeline`
--
ALTER TABLE `client_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `college_invoices`
--
ALTER TABLE `college_invoices`
  ADD PRIMARY KEY (`college_invoice_id`), ADD KEY `course_application_id_idx` (`course_application_id`);

--
-- Indexes for table `college_invoice_payments`
--
ALTER TABLE `college_invoice_payments`
  ADD PRIMARY KEY (`invoice_payments_id`);

--
-- Indexes for table `college_payments`
--
ALTER TABLE `college_payments`
  ADD PRIMARY KEY (`college_payment_id`), ADD KEY `fk_college_payment_payment_types1_idx` (`payment_type`), ADD KEY `course_invoice_fk_idx` (`college_invoice_id`);

--
-- Indexes for table `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`commission_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `company_branches`
--
ALTER TABLE `company_branches`
  ADD PRIMARY KEY (`company_branch_id`), ADD KEY `fk_institute_branches_companies1_idx` (`companies_id`);

--
-- Indexes for table `company_branch_emails`
--
ALTER TABLE `company_branch_emails`
  ADD PRIMARY KEY (`company_branch_email_id`), ADD KEY `email_fk` (`email_id`), ADD KEY `company_branch_fk_idx` (`company_branch_id`);

--
-- Indexes for table `company_branch_phones`
--
ALTER TABLE `company_branch_phones`
  ADD PRIMARY KEY (`company_branch_phone_id`), ADD KEY `phone_fkey_idx` (`phone_id`), ADD KEY `company_branch_fkey_idx` (`company_branch_id`);

--
-- Indexes for table `company_contacts`
--
ALTER TABLE `company_contacts`
  ADD PRIMARY KEY (`company_contact_id`), ADD KEY `company_branches_fk_idx` (`company_id`), ADD KEY `person_fk_idx` (`person_id`);

--
-- Indexes for table `company_default_contacts`
--
ALTER TABLE `company_default_contacts`
  ADD PRIMARY KEY (`company_default_contact_id`), ADD KEY `fk_company_default_contacts_companies1_idx` (`company_id`), ADD KEY `fk_company_default_contacts_phones1_idx` (`phone_id`);

--
-- Indexes for table `controller`
--
ALTER TABLE `controller`
  ADD PRIMARY KEY (`controller_id`);

--
-- Indexes for table `controller_actions`
--
ALTER TABLE `controller_actions`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_object_permissions_permissions1_idx` (`action_id`), ADD KEY `fk_object_permissions_objects1_idx` (`controller_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`), ADD KEY `broad_field_foreign_key` (`broad_field`), ADD KEY `narrow_field_foreign_key` (`narrow_field`);

--
-- Indexes for table `course_application`
--
ALTER TABLE `course_application`
  ADD PRIMARY KEY (`course_application_id`), ADD KEY `college_course_id_idx` (`institution_course_id`), ADD KEY `superagent_fk_idx` (`super_agent_id`), ADD KEY `subagent_fk_idx` (`sub_agent_id`), ADD KEY `institute_fk_idx` (`institute_id`), ADD KEY `intake_fk_idx` (`intake_id`), ADD KEY `location_id_idx` (`location_id`);

--
-- Indexes for table `course_commissions`
--
ALTER TABLE `course_commissions`
  ADD PRIMARY KEY (`course_commission_id`), ADD KEY `fk_course_commission_agency_institute_courses1_idx` (`course_id`), ADD KEY `fk_course_commission_commissions1_idx` (`commissions_id`);

--
-- Indexes for table `course_fees`
--
ALTER TABLE `course_fees`
  ADD PRIMARY KEY (`course_fee_id`), ADD KEY `fk_course_fees_fees1_idx` (`fees_id`), ADD KEY `fk_course_fees_agency_institute_courses1_idx` (`course_id`);

--
-- Indexes for table `course_levels`
--
ALTER TABLE `course_levels`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `custom_suscriptions`
--
ALTER TABLE `custom_suscriptions`
  ADD PRIMARY KEY (`custom_suscription_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`email_id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feature_id`);

--
-- Indexes for table `features_controller_actions`
--
ALTER TABLE `features_controller_actions`
  ADD PRIMARY KEY (`features_controller_action_id`), ADD KEY `fk_features_controller_actions_features1_idx` (`features_id`), ADD KEY `fk_features_controller_actions_controller_actions1_idx` (`controller_actions_id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`fee_id`);

--
-- Indexes for table `group_college_invoices`
--
ALTER TABLE `group_college_invoices`
  ADD PRIMARY KEY (`group_college_invoice_id`), ADD KEY `fk_group_college_invoices_group_invoices1_idx` (`group_invoices_id`), ADD KEY `fk_group_college_invoices_college_invoices1_idx` (`college_invoices_id`);

--
-- Indexes for table `group_invoices`
--
ALTER TABLE `group_invoices`
  ADD PRIMARY KEY (`group_invoice_id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`institution_id`), ADD KEY `company_fk_idx` (`company_id`);

--
-- Indexes for table `institute_addresses`
--
ALTER TABLE `institute_addresses`
  ADD PRIMARY KEY (`institute_address_id`);

--
-- Indexes for table `institute_courses`
--
ALTER TABLE `institute_courses`
  ADD PRIMARY KEY (`institute_course_id`), ADD KEY `institute_foreign_key_idx` (`institute_id`), ADD KEY `course_foreign_key_idx` (`course_id`);

--
-- Indexes for table `institute_course_branch`
--
ALTER TABLE `institute_course_branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institute_document`
--
ALTER TABLE `institute_document`
CHANGE `institute_document_id` `institute_document_id` INT(11) NOT NULL AUTO_INCREMENT,
  ADD PRIMARY KEY (`institute_document_id`);

--
-- Indexes for table `institute_intakes`
--
ALTER TABLE `institute_intakes`
  ADD PRIMARY KEY (`institute_intake_id`,`institute_id`), ADD KEY `intake0_idx` (`intake_id`), ADD KEY `fk_institutes_idx` (`institute_id`);

--
-- Indexes for table `institute_phones`
--
ALTER TABLE `institute_phones`
  CHANGE `institute_phone_id` `institute_phone_id` INT(11) NOT NULL AUTO_INCREMENT,
  ADD PRIMARY KEY (`institute_phone_id`);

--
-- Indexes for table `intakes`
--
ALTER TABLE `intakes`
  ADD PRIMARY KEY (`intake_id`), ADD KEY `term_fk_idx` (`term_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `level_access`
--
ALTER TABLE `level_access`
  ADD PRIMARY KEY (`level_access_id`), ADD KEY `fk_permissions_levels1_idx` (`levels_id`), ADD KEY `fk_level_access_features_controller_actions1_idx` (`features_controller_actions_id`);

--
-- Indexes for table `narrow_field`
--
ALTER TABLE `narrow_field`
  ADD PRIMARY KEY (`id`), ADD KEY `broad_field_foreign_key` (`broad_field_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`notes_id`);

--
-- Indexes for table `payment_invoice_breakdowns`
--
ALTER TABLE `payment_invoice_breakdowns`
  ADD PRIMARY KEY (`payment_invoice_breakdown_id`), ADD KEY `student_invoices_idx` (`invoice_id`), ADD KEY `payment_fk_idx` (`payment_id`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`payment_type_id`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `person_addresses`
--
ALTER TABLE `person_addresses`
  ADD PRIMARY KEY (`person_address_id`), ADD KEY `person` (`person_id`), ADD KEY `address_idx` (`address_id`);

--
-- Indexes for table `person_emails`
--
ALTER TABLE `person_emails`
  ADD PRIMARY KEY (`person_email_id`), ADD KEY `fk_person_emails_person1_idx` (`person_id`), ADD KEY `fk_person_emails_email1_idx` (`email_id`);

--
-- Indexes for table `person_phones`
--
ALTER TABLE `person_phones`
  ADD PRIMARY KEY (`person_phone_id`), ADD KEY `fk_person_phones_phones1_idx` (`phone_id`), ADD KEY `fk_person_phones_person1_idx` (`person_id`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`phone_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photo_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `settings_name_unique` (`name`), MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `standard_subscriptions`
--
ALTER TABLE `standard_subscriptions`
  ADD PRIMARY KEY (`standard_subscription_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `student_application_payments`
--
ALTER TABLE `student_application_payments`
  ADD PRIMARY KEY (`student_payments_id`);

--
-- Indexes for table `student_invoices`
--
ALTER TABLE `student_invoices`
  ADD PRIMARY KEY (`student_invoice_id`);

--
-- Indexes for table `subagent_application_payments`
--
ALTER TABLE `subagent_application_payments`
  ADD PRIMARY KEY (`subagent_payments_id`);

--
-- Indexes for table `subagent_invoices`
--
ALTER TABLE `subagent_invoices`
  ADD PRIMARY KEY (`subagent_invoice_id`);

--
-- Indexes for table `subscription_features`
--
ALTER TABLE `subscription_features`
  ADD PRIMARY KEY (`subscription_feature_id`), ADD KEY `fk_subscription_functions_custom_suscriptions1_idx` (`custom_suscriptions_id`), ADD KEY `fk_subscription_functions_custome_functionalities1_idx` (`feature_id`), ADD KEY `fk_subscription_functions_standard_subscriptions1_idx` (`standard_subscriptions_id`);

--
-- Indexes for table `subscription_payments`
--
ALTER TABLE `subscription_payments`
  ADD PRIMARY KEY (`subscription_payment_id`), ADD KEY `fk_subscription_payments_agency_subscriptions1_idx` (`agency_subscription_id`);

--
-- Indexes for table `subscription_status`
--
ALTER TABLE `subscription_status`
  ADD PRIMARY KEY (`subscription_status_id`);

--
-- Indexes for table `superagent_institutes`
--
ALTER TABLE `superagent_institutes`
  ADD PRIMARY KEY (`superagent_institute_id`), ADD KEY `fk_agency_institutes_idx` (`institute_id`), ADD KEY `fk_agentcy_agents_idx` (`agents_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`term_id`);

--
-- Indexes for table `timelines`
--
ALTER TABLE `timelines`
  ADD PRIMARY KEY (`timeline_id`);

--
-- Indexes for table `timeline_types`
--
ALTER TABLE `timeline_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`), ADD KEY `fk_person_idx` (`person_id`);

--
-- Indexes for table `user_emails`
--
ALTER TABLE `user_emails`
  ADD PRIMARY KEY (`user_email_id`), ADD KEY `user_id` (`user_id`), ADD KEY `email_id` (`email_id`);

--
-- Indexes for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`user_level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `action_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `active_clients`
--
ALTER TABLE `active_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `agencies`
--
ALTER TABLE `agencies`
  MODIFY `agency_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'consultancy who buys our software is termed as agency';
--
-- AUTO_INCREMENT for table `agency_clients`
--
ALTER TABLE `agency_clients`
  MODIFY `agency_client_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `agency_institutes`
--
ALTER TABLE `agency_institutes`
  MODIFY `agency_institute_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `agency_institute_branches`
--
ALTER TABLE `agency_institute_branches`
  MODIFY `agency_institute_branch_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `agency_institute_courses`
--
ALTER TABLE `agency_institute_courses`
  MODIFY `agency_institute_course_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `agency_subscriptions`
--
ALTER TABLE `agency_subscriptions`
  MODIFY `agency_subscription_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `agency_users`
--
ALTER TABLE `agency_users`
  MODIFY `agency_user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `agent_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `application_notes`
--
ALTER TABLE `application_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `application_status`
--
ALTER TABLE `application_status`
  MODIFY `application_status_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `application_status_documents`
--
ALTER TABLE `application_status_documents`
  MODIFY `application_status_document_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `broad_field`
--
ALTER TABLE `broad_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ci_other_commissions`
--
ALTER TABLE `ci_other_commissions`
  MODIFY `other_commission_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ci_tuition_commissions`
--
ALTER TABLE `ci_tuition_commissions`
  MODIFY `tuition_commission_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_documents`
--
ALTER TABLE `client_documents`
  MODIFY `client_document_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'if agent attached documents without applying for courses for e.g. passport, visa copy,marriage certificate\n';
--
-- AUTO_INCREMENT for table `client_emails`
--
ALTER TABLE `client_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_notes`
--
ALTER TABLE `client_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_payments`
--
ALTER TABLE `client_payments`
  MODIFY `client_payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_timeline`
--
ALTER TABLE `client_timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `college_invoices`
--
ALTER TABLE `college_invoices`
  MODIFY `college_invoice_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `college_invoice_payments`
--
ALTER TABLE `college_invoice_payments`
  MODIFY `invoice_payments_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `college_payments`
--
ALTER TABLE `college_payments`
  MODIFY `college_payment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'to track the payment made to college or made by college',AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `commission_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company_branches`
--
ALTER TABLE `company_branches`
  MODIFY `company_branch_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company_branch_emails`
--
ALTER TABLE `company_branch_emails`
  MODIFY `company_branch_email_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company_branch_phones`
--
ALTER TABLE `company_branch_phones`
  MODIFY `company_branch_phone_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company_contacts`
--
ALTER TABLE `company_contacts`
  MODIFY `company_contact_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company_default_contacts`
--
ALTER TABLE `company_default_contacts`
  MODIFY `company_default_contact_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `controller`
--
ALTER TABLE `controller`
  MODIFY `controller_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_application`
--
ALTER TABLE `course_application`
  MODIFY `course_application_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_fees`
--
ALTER TABLE `course_fees`
  MODIFY `course_fee_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_levels`
--
ALTER TABLE `course_levels`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `email_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `group_college_invoices`
--
ALTER TABLE `group_college_invoices`
  MODIFY `group_college_invoice_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `group_invoices`
--
ALTER TABLE `group_invoices`
  MODIFY `group_invoice_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `institution_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `institute_addresses`
--
ALTER TABLE `institute_addresses`
  MODIFY `institute_address_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `institute_courses`
--
ALTER TABLE `institute_courses`
  MODIFY `institute_course_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `institute_intakes`
--
ALTER TABLE `institute_intakes`
  MODIFY `institute_intake_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `intakes`
--
ALTER TABLE `intakes`
  MODIFY `intake_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `notes_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_invoice_breakdowns`
--
ALTER TABLE `payment_invoice_breakdowns`
  MODIFY `payment_invoice_breakdown_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `person_addresses`
--
ALTER TABLE `person_addresses`
  MODIFY `person_address_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	';
--
-- AUTO_INCREMENT for table `person_emails`
--
ALTER TABLE `person_emails`
  MODIFY `person_email_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `person_phones`
--
ALTER TABLE `person_phones`
  MODIFY `person_phone_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `phone_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_application_payments`
--
ALTER TABLE `student_application_payments`
  MODIFY `student_payments_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_invoices`
--
ALTER TABLE `student_invoices`
  MODIFY `student_invoice_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subagent_application_payments`
--
ALTER TABLE `subagent_application_payments`
  MODIFY `subagent_payments_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subagent_invoices`
--
ALTER TABLE `subagent_invoices`
  MODIFY `subagent_invoice_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `superagent_institutes`
--
ALTER TABLE `superagent_institutes`
  MODIFY `superagent_institute_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `timelines`
--
ALTER TABLE `timelines`
  MODIFY `timeline_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `timeline_types`
--
ALTER TABLE `timeline_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `user_level_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ci_other_commissions`
--
ALTER TABLE `ci_other_commissions`
ADD CONSTRAINT `ci_other_commissions_ibfk_1` FOREIGN KEY (`college_invoice_id`) REFERENCES `college_invoices` (`college_invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ci_tuition_commissions`
--
ALTER TABLE `ci_tuition_commissions`
ADD CONSTRAINT `ci_tuition_commissions_ibfk_1` FOREIGN KEY (`college_invoice_id`) REFERENCES `college_invoices` (`college_invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
