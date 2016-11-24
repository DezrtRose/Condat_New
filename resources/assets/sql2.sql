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

ALTER TABLE `settings` ADD PRIMARY KEY(`id`);

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'company', 'a:1:{s:12:"company_name";s:10:"Enter Company Name";}', '2016-03-23 22:42:20', '2016-03-23 22:42:20'),
(2, 'domain', 'tenant', '2016-03-23 22:42:20', '2016-03-23 22:42:20'),
(3, 'folder', 'hqFzcwYdO5', '2016-03-23 22:42:20', '2016-03-23 22:42:20'),
(4, 'bank', 'a:4:{s:4:"name";s:18:"Common Wealth Bank";s:12:"account_name";s:13:"Jenish Maskey";s:6:"number";s:12:"0430 807 730";s:3:"bsb";s:7:"062 106";}', '2016-07-17 18:58:41', '2016-07-17 18:58:41');

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
(1, 'staff', 'staff members of agency', 9),
(2, 'accountant', 'accountant of agency', 3),
(3, 'admin', 'adminstrator of all system', 12);

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
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `settings_name_unique` (`name`);

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