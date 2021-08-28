-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2021 at 05:44 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mostame`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(4) NOT NULL,
  `full_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `user_name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `password` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `user_name`, `password`, `created_at`) VALUES
(1, 'Ahmed', 'admin', '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', '2021-06-20 03:16:27'),
(2, 'Ahmed Elsayed', 'ahmed', '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', '2021-06-20 03:16:27'),
(3, 'Ahmed Elsayed', 'aa', 'dksjkdjskdj', '2021-06-20 03:16:27'),
(4, 'Ahmed Elsayed', 'ba', 'dksjkdjskdj', '2021-06-20 03:16:27'),
(6, 'Ahmed Elsayed', 'ffb', 'dksjkdjskdj', '2021-06-20 03:16:27'),
(9, 'Ahmed Elsayed', 'aba', 'dksjkdjskdj', '2021-06-20 03:16:27'),
(10, 'Ahmed Elsayed', 'ojf', 'dksjkdjskdj', '2021-06-20 03:16:27'),
(11, 'Ahmed Elsayed', 'bm', 'dksjkdjskdj', '2021-06-20 03:16:27'),
(12, 'Ahmed Elsayed', 'ori', 'dksjkdjskdj', '2021-06-20 03:16:27'),
(13, 'Ahmed Elsayed', 'qp', 'dksjkdjskdj', '2021-06-20 03:16:27'),
(14, 'Ahmed Elsayed', 'mjk', 'dksjkdjskdj', '2021-06-20 03:16:27'),
(15, 'test', 'testt', '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', '2021-06-20 05:01:12'),
(16, 'testq', 'test', '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', '2021-06-20 05:01:24');

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int(5) NOT NULL,
  `question_id` int(5) NOT NULL,
  `answer_content` text CHARACTER SET utf8 NOT NULL,
  `is_right` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `answer_content`, `is_right`) VALUES
(10, 4, 'بخير', 1),
(11, 4, 'مش كويس', 0),
(12, 5, 'تست', 1),
(13, 5, 'تست 2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `code`
--

CREATE TABLE `code` (
  `id` int(11) NOT NULL,
  `code` varchar(5) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `expire_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `code`
--

INSERT INTO `code` (`id`, `code`, `user_id`, `status`, `expire_at`) VALUES
(7, '65e71', 20, 0, '2021-07-19 00:00:00'),
(8, '60df9', 21, 0, '2021-07-19 00:00:00'),
(9, '5a2c0', 22, 1, '2021-07-19 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `msg` text NOT NULL,
  `is_reply` tinyint(1) NOT NULL DEFAULT 0,
  `send_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `full_name`, `email`, `subject`, `msg`, `is_reply`, `send_at`) VALUES
(2, 'Ahmed Elsayed', 'aled14123@gmail.com', 'يسبسيبكينمسكبمن', 'يبمنسبمنسيمبنمسينبكيستبكمسيتكبمن', 1, '2021-07-18 09:57:15'),
(4, 'Ahmed Elsayed', 'aled14123@gmail.com', 'dsdfsdf', 'fkdjfkdjfk', 1, '2021-06-14 23:31:52'),
(9, 'Ahmed', 'dev.ahmed.elsied@gmail.com', 'asdasd', 'dsadfad', 0, '2021-05-28 23:46:01'),
(10, 'Ahmed Elsayed', 'dev.ahmed.elsied@gmail.com', 'يسبيسبمينسبم', 'بمينسمبنسيمبنيمبن', 0, '2021-05-28 23:50:54'),
(11, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:53:56'),
(12, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18'),
(13, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18'),
(14, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18'),
(15, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18'),
(16, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18'),
(17, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18'),
(18, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18'),
(19, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18'),
(20, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18'),
(21, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18'),
(22, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18'),
(23, 'ahmed', 'aled@gmail.com', 'sldjfljf', 'lfkdlfkdlfkdlfkldkfl', 0, '2021-06-18 03:54:18');

-- --------------------------------------------------------

--
-- Table structure for table `conversation`
--

CREATE TABLE `conversation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `listener_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `listener_rate` tinyint(1) DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `conversation`
--

INSERT INTO `conversation` (`id`, `user_id`, `listener_id`, `status`, `listener_rate`, `created_at`, `deleted_at`) VALUES
(22, 1, 8, 0, 4, '2021-07-08 02:39:41', '2021-07-28 12:46:06'),
(23, 1, 8, 0, 4, '2021-07-10 10:19:38', '2021-07-28 12:46:06'),
(24, 8, 9, 0, 0, '2021-07-15 06:24:16', '2021-07-15 06:24:25'),
(25, 14, 8, 0, 1, '2021-07-15 06:35:46', '2021-07-28 12:46:06'),
(26, 14, 8, 0, 1, '2021-07-15 06:41:05', '2021-07-28 12:46:06'),
(27, 14, 8, 0, 1, '2021-07-15 06:41:29', '2021-07-28 12:46:06'),
(28, 14, 8, 0, 0, '2021-07-15 06:41:57', '2021-07-28 12:46:06'),
(29, 11, 8, 0, 0, '2021-07-15 06:42:14', '2021-07-28 12:46:06'),
(31, 12, 22, 1, 0, '2021-07-18 10:21:36', NULL),
(32, 16, 8, 0, 0, '2021-07-27 11:00:09', '2021-07-28 12:46:06'),
(33, 9, 8, 0, 0, '2021-07-27 11:00:24', '2021-07-28 12:46:06'),
(34, 13, 8, 0, 0, '2021-07-27 11:00:43', '2021-07-28 12:46:06'),
(35, 15, 8, 0, 0, '2021-07-27 11:00:55', '2021-07-28 12:46:06'),
(36, 9, 8, 0, 0, '2021-07-27 11:01:02', '2021-07-28 12:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` bigint(20) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message_content` text NOT NULL,
  `send_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `conversation_id`, `sender_id`, `message_content`, `send_at`) VALUES
(76, 36, 9, 'dsd', '2021-07-28 00:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `problem`
--

CREATE TABLE `problem` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `conversation_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `closed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `problem`
--

INSERT INTO `problem` (`id`, `user_id`, `conversation_id`, `status`, `created_at`, `closed_at`) VALUES
(44, 1, 22, 1, '2021-07-15 00:03:17', '2021-07-14 22:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `problem_content`
--

CREATE TABLE `problem_content` (
  `id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `message_content` text NOT NULL,
  `msg_from` tinyint(1) DEFAULT NULL,
  `send_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(5) NOT NULL,
  `question_content` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `question_content`) VALUES
(4, 'كيف الحال؟'),
(5, 'سؤال 2');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` tinyint(4) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `content`) VALUES
(1, 'logo.png'),
(2, 'ابحث عن مٌستَمع الآن\r\nنحن هنا من أجلك'),
(3, 'إذا كان لديك تحدٍ في الحياة ولا يبدو أنك تستطيع حله\r\nبنفسك ، يمكن أن تساعدك الاستشارة!\r\nكيف تتعامل مع المشاكل؟\r\nالطبيعي أن تجد شخص ما للتحدث معه\r\n, ولكن هذا ليس متاحاََ دائما\r\nإذا كان بإمكانك البوح عن مشاكلك ، فلمن سوف تبوح؟\r\nبطبيعة الحال ، تتحدث إلى الأصدقاء والعائلة.\r\nبالإضافة إلى الأشخاص المقربين منك ،\r\nلكن هناك طرق أخرى للحصول على الدعم.\r\nمثل مقابلة مستمع على الإنترنت لا يعرف من أنت يمكن أن يساعدك عندما تعاني.'),
(4, 'الشروط والأحكام هنا'),
(5, 'رسالة انتهاء المحادثهه');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings_ltr`
--

CREATE TABLE `site_settings_ltr` (
  `id` tinyint(4) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_settings_ltr`
--

INSERT INTO `site_settings_ltr` (`id`, `content`) VALUES
(1, 'Find A Listener Now\r\nWe&#039;re here for you'),
(2, 'If you have a life challenge and you can&#039;t seem to solve it\r\non your own, counseling can help!\r\nHow do you cope when you have problems?\r\nThe instinct is to find someone to talk about your problems with\r\n, but that&#039;s not always possible.\r\nIf you could let loose about your issues, who would tell?\r\nNaturally, you talk to friends and family.\r\nIn addition to confiding in the people close to you,\r\nthere are other ways to find support.\r\nlike meeting an online listener who doesn&#039;t know who you are can help you when you&#039;re suffering.'),
(3, 'Mostame\r\n\r\nWelcome to Mostame!\r\nThank you for using our products and services (&ldquo;Services&rdquo;). The Services are provided by Mostame . By using our Services, you agree to these Terms, including the Privacy Policy, which is incorporated by reference. Please read them carefully.\r\n\r\nUsing our Services\r\nDon&rsquo;t misuse or abuse our Services. Don&rsquo;t interfere with our Services or try to access them in a way other than what we provide. You can use our Services only as permitted by law. We may suspend, ban, or stop providing our Services to you if you do not follow our Terms, Privacy Policy, or other policies or if we are investigating suspected misconduct.\r\n\r\nUsing our Services does not give you ownership of any intellectual property rights in our Services or the content you may access. You may not use content from our Services unless you have obtained permission from its owner or are otherwise permitted by law. These Terms do not grant you the right to use any branding or logos from our Services without written consent from Mostame. Do not remove, obscure, or alter any legal notices displayed in or along with our Services.\r\n\r\nOur Services may display some content that does not belong to Mostame. This content is the sole responsibility of the individual who makes it available. We may review content to determine whether it is illegal or violates any of our policies, and we will remove or refuse to display content that we believe violates our policies or the law. We do not necessarily review all content and you should not assume that we do.\r\n\r\nIn connection with your use of our Services, we may send you announcements, administrative messages, and other information. You may opt out of some of these communications. Some of our Services are available on mobile devices. Do not use our Services in a way that distracts you and prevents or diminishes your ability to obey traffic and safety laws.\r\n\r\nListening and Therapy Services\r\nDO NOT USE OUR SERVICE FOR EMERGENCIES. MOSTAME LISTENERS ARE NOT TRAINED OR QUALIFIED TO ASSIST THOSE IN CRISIS. ALL CRISIS CHATS WILL BE TERMINATED IMMEDIATELY\r\n\r\nYou acknowledge and agree that Listeners and Therapists are neither employees nor agents nor representatives of Mostame, and Mostame assumes no responsibility for any act or omission of any such Listener or Therapist.\r\n\r\nYou also acknowledge and agree that you take full responsibility for the decision to access a Listener or Therapist through the Site and to continue to interact with the Listener or Therapist, and that the role of Mostame is strictly limited to providing access to such Listeners for your consideration\r\n\r\nYour relationship relating to the Listening Services is strictly with the Listener or Therapist. We are not involved in any way with the actual substance of that relationship or any part of the Listening or Therapy Service (whether provided through the Platform or not). We may also use aggregated data from chat transcripts to conduct research and development. In reviewing this information, Mostame will maintain all applicable confidentiality/HIPAA/privacy standards.\r\nMostame makes no representation or warranty whatsoever as to (a) the accuracy or availability of the Listening Platform or the Sites, (b) the willingness or ability of the Listener to listen, (c) the willingness or ability of any Listener to give advice, (d) whether the Member shall find a Listener or useful or satisfactory, (e) whether the Member shall find a Listener&#039;s advice relevant, useful, accurate or satisfactory, (f) whether the listening of the Listener or will be helpful, (g) whether the advice of the Listener will be responsive or relevant to the Member&rsquo;s question, or (h) whether the Listener&#039;s advice will otherwise be suitable to the Member&rsquo;s needs\r\n\r\nMostame does not verify the skills, degrees, qualifications, credentials or background of any Listeners.\r\n\r\nMostame DOES NOT WARRANT THE VALIDITY, ACCURACY, OR AVAILABILITY OF ANY CONTENT OR ADVICE PROVIDED BY LISTENERS OR THERAPISTS AND MOSTAME WILL NOT BE LIABLE FOR ANY DAMAGES SUSTAINED BY MEMBER DUE TO RELIANCE ON ANY SUCH INFORMATION OR ADVICE.\r\n\r\nChatbots\r\nMostame utilizes cutting-edge technology including complex algorithms and machine learning to deliver limited, interactive chat features with our Chatbots.\r\n\r\nYou understand and agree that, although a Chatbot may have been accessed through Mostame, Mostame cannot predict or assess the Chatbot&rsquo;s competence of, or appropriateness for your needs. You also acknowledge and agree that you take full responsibility for the decision to access a Chatbot through the Site and to continue to interact with the Chatbot, and that the role of Mostame is strictly limited to providing access to such Chatbots for your consideration.\r\n\r\nMOSTAME DOES NOT WARRANT THE VALIDITY, ACCURACY, OR AVAILABILITY OF ANY CONTENT OR ADVICE PROVIDED BY CHATBOTS AND MOSTAME WILL NOT BE LIABLE FOR ANY DAMAGES SUSTAINED BY MEMBER DUE TO RELIANCE ON ANY SUCH INFORMATION OR ADVICE.\r\n\r\nYour Mostame Account\r\nYou need a Mostame account in order to use our Services. You may create your own Mostame member and/or listener account. You may hold only one member and one listener account. To protect your Mostame account, keep your password confidential. You are responsible for any activity that happens on or through your Mostame account. If you discover any unauthorized use of your password or Mostame account, contact the Mostame Help Center.\r\n\r\nPrivacy\r\nThe Mostame Privacy Policy explains how we treat your personal data and protect your privacy when you use our Services. By using our Services, you agree that Mostame can use your data in accordance with our Privacy Policy.\r\n\r\ndescription of the alleged infringement\r\nidentification of the copyrighted work\r\nyour name and contact information (email address and phone number)\r\nsigned statement that you are either the copyright owner or the person authorized to act on behalf of the copyright owner.\r\nYour Content in Our Services\r\nSome of our Services allow you to upload, submit, store, send or receive content. Mostame shall maintain the storage and integrity of such data in accordance with our Privacy Policy..\r\n\r\nYou can find out more about how Mostame uses and stores your content in the Privacy Policy. If you submit feedback or suggestions about our Services, we may use your feedback or suggestions without obligation to you.\r\n\r\nAbout Software in Our Services\r\nOur Services may include downloadable software, which may update automatically on your device once a new version or feature is available. Some Services may let you adjust your automatic update settings.\r\n\r\nYou may not copy, modify, distribute, sell, or lease any part of our Services or included software, nor may you reverse engineer or attempt to extract the source code of that software, unless laws prohibit those restrictions or you have our written permission.\r\n\r\nModifying and Terminating Our Services\r\nWe are constantly changing and improving our Services. We may add or remove functionalities or features, and we may suspend or stop a Service altogether.\r\n\r\nYou can stop using our Services at any time. Mostame may also stop providing Services to you, or add or create new limits to our Services at any time.\r\n\r\nWe believe that you own your data. Preserving your access to and control of your data is important. Upon request, we will delete all data related to your account in accordance with our Privacy Policy..\r\n\r\nOur Warranties and Disclaimers\r\nDO NOT USE OUR SERVICE FOR EMERGENCIES. MOSTAME LISTENERS ARE NOT TRAINED OR QUALIFIED TO ASSIST THOSE IN CRISIS. ALL CRISIS CHATS WILL BE TERMINATED IMMEDIATELY.\r\n\r\nWe provide our Services using a reasonable level of care and skill and we hope that you enjoy using them. There are certain things that we do not promise about our Services.\r\n\r\nOTHER THAN AS EXPRESSLY SET OUT IN THESE TERMS, NEITHER MOSTAME NOR ITS AFFILIATES, OFFICERS, DIRECTORS, SHAREHOLDERS, EMPLOYEES, SUB-CONTRACTORS, REPRESENTATIVES, OR AGENTS MAKE ANY COMMITMENTS ABOUT THE CONTENT WITHIN THE SERVICES, THE SPECIFIC FUNCTIONS OF THE SERVICES, OR THEIR RELIABILITY, AVAILABILITY, OR ABILITY TO MEET YOUR NEEDS. WE PROVIDE OUR SERVICES &ldquo;AS IS.&rdquo; WE EXCLUDE ALL WARRANTIES.\r\n\r\nLiability for Our Services\r\nWHEN PERMITTED BY LAW, MOSTAME AND MOSTAME&rsquo; AFFILIATES, OFFICERS, DIRECTORS, SHAREHOLDERS, EMPLOYEES, SUB-CONTRACTORS, REPRESENTATIVES, OR AGENTS WILL NOT BE RESPONSIBLE FOR LOST PROFITS, REVENUES, OR DATA, FINANCIAL LOSSES OR INDIRECT, SPECIAL, CONSEQUENTIAL, EXEMPLARY, OR PUNITIVE DAMAGES.\r\n\r\nTO THE EXTENT PERMITTED BY LAW, THE TOTAL LIABILITY OF MOSTAME AND ITS AFFILIATES, OFFICERS, DIRECTORS, SHAREHOLDERS, EMPLOYEES, SUB-CONTRACTORS, REPRESENTATIVES, AND AGENTS FOR ANY CLAIMS UNDER THESE TERMS, INCLUDING FOR ANY IMPLIED WARRANTIES\r\n\r\nIN ALL CASES, MOSTAME AND ITS AFFILIATES, OFFICERS, DIRECTORS, SHAREHOLDERS, EMPLOYEES, SUB-CONTRACTORS, REPRESENTATIVES, AND AGENTS, WILL NOT BE LIABLE FOR ANY LOSS OR DAMAGE THAT IS NOT REASONABLY FORESEEABLE.\r\n\r\nBusiness Uses of Our Services\r\nIf you are using our Services on behalf of a business or organization, that business or organization accepts these terms. It will hold harmless and indemnify Mostame and its affiliates, officers, directors, shareholders, employees, sub-contractors, representatives, and agents from any claim, suit or action arising from or related to the use of the Services or violation of these terms, including any liability or expense arising from claims, losses, damages, suits, judgements, litigation costs, and attorneys&rsquo; fees.\r\n\r\nAbout These Terms\r\nWe may modify these terms or any additional terms that apply to a Service to, for example, reflect changes to the law or changes to our Services. You should look at the terms regularly. We&rsquo;ll post notice of modifications to these terms on this page and email them to registered users. We&rsquo;ll post notice of modified additional terms in the applicable Service. Changes addressing new functions for a Service or changes made for legal reasons will be effective immediately. If you do not agree to the modified terms for a Service, you should immediately discontinue your use of that Service.\r\n\r\nIf there is a conflict between these terms and the additional terms, the additional terms will control for that conflict.\r\n\r\nThese terms control the relationship between Mostame and you. They do not create any third party beneficiary rights.\r\n\r\nIf you do not comply with these terms, and we don&rsquo;t take action right away, that doesn&rsquo;t mean that we will give up any rights that we may have (such as taking action in the future).'),
(4, 'end of chat heree');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `email` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `type` tinyint(1) NOT NULL,
  `password` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `user_from` tinyint(1) DEFAULT NULL,
  `banned` tinyint(1) DEFAULT 0,
  `available` tinyint(1) DEFAULT 1,
  `joined_at` date NOT NULL DEFAULT current_timestamp(),
  `banned_to` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `full_name`, `email`, `type`, `password`, `gender`, `birthdate`, `city`, `status`, `user_from`, `banned`, `available`, `joined_at`, `banned_to`) VALUES
(1, 'Ahmed Elsayed', 'aled14123@gmail.com', 2, NULL, 0, NULL, NULL, 2, 0, 0, 1, '2021-05-05', NULL),
(8, 'testttt', 'a@ahmed.com', 3, '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', 0, '2021-06-12', 'mansoura', 2, NULL, 0, 1, '2021-06-21', NULL),
(9, 'testt', 'test@test.com', 2, '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', 0, '2021-06-28', 'mansoura', 2, NULL, 0, 1, '2021-06-21', NULL),
(11, 'testtt', 'testt@test.com', 2, '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', 0, '2021-06-28', 'mansoura', 2, NULL, 0, 0, '2021-05-05', NULL),
(12, 'testtttt', 'teesttt@test.com', 1, '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', 0, '2021-06-28', 'mansoura', 2, NULL, 0, 0, '2021-06-21', NULL),
(13, 'testttttt', 'tessttt@test.com', 1, '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', 0, '2021-06-28', 'mansoura', 2, NULL, 0, 1, '2021-06-21', NULL),
(14, 'testtttttt', 'tetsttt@test.com', 2, '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', 0, '2021-06-28', 'mansoura', 2, NULL, 0, 0, '2021-06-21', NULL),
(15, 'testtatt', 'tettt@test.com', 3, '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', 0, '2021-06-28', 'mansoura', 2, NULL, 0, 1, '2021-05-05', NULL),
(16, 'tesatt', 'tesstttt@test.com', 1, '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', 0, '2021-06-28', 'mansoura', 2, NULL, 0, 1, '2021-06-21', NULL),
(17, 'tesatat', 'ttsresttt@test.com', 1, '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', 0, '2021-06-28', 'mansoura', 2, NULL, 1, 1, '2021-06-21', NULL),
(18, 'tesa', 'testtt@ctest.com', 1, '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', 0, '2021-06-28', 'mansoura', 2, NULL, 0, 1, '2021-06-21', NULL),
(19, 'ahmed', 'a@aes.com', 3, '43fba32081ec1c877889e6cf69dfb0b47f9fcb5f', 0, '2021-07-13', 'masr', 2, NULL, 0, 1, '2021-07-06', NULL),
(20, 'ahmed', 'aaa@a.com', 1, '019cae30597e6506bcb2d42c265d106f0a09872f', 0, '2021-07-25', 'mansoura', 2, NULL, 0, 1, '2021-07-18', NULL),
(21, 'final', 'final@a.com', 1, '019cae30597e6506bcb2d42c265d106f0a09872f', 0, '2021-07-04', 'mansoura', 2, NULL, 0, 1, '2021-07-18', NULL),
(22, 'final', 'dev.ahmed.elsied@gmail.com', 3, '019cae30597e6506bcb2d42c265d106f0a09872f', 0, '2021-07-25', 'mansoura', 2, NULL, 0, 0, '2021-07-18', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `listener_id` (`listener_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `problem`
--
ALTER TABLE `problem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `conversation_id` (`conversation_id`);

--
-- Indexes for table `problem_content`
--
ALTER TABLE `problem_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `problem_id` (`problem_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings_ltr`
--
ALTER TABLE `site_settings_ltr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `code`
--
ALTER TABLE `code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `problem`
--
ALTER TABLE `problem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `problem_content`
--
ALTER TABLE `problem_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `site_settings_ltr`
--
ALTER TABLE `site_settings_ltr`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `question` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `code`
--
ALTER TABLE `code`
  ADD CONSTRAINT `user_code` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `conversation`
--
ALTER TABLE `conversation`
  ADD CONSTRAINT `listener` FOREIGN KEY (`listener_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `conv` FOREIGN KEY (`conversation_id`) REFERENCES `conversation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sender` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `problem`
--
ALTER TABLE `problem`
  ADD CONSTRAINT `prob_conv_id` FOREIGN KEY (`conversation_id`) REFERENCES `conversation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_prop` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `problem_content`
--
ALTER TABLE `problem_content`
  ADD CONSTRAINT `prob_id` FOREIGN KEY (`problem_id`) REFERENCES `problem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
