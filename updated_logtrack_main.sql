-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2025 at 05:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logtrack_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('SuperAdmin','Admin') DEFAULT 'Admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `apprehended_logs`
--

CREATE TABLE `apprehended_logs` (
  `id` int(11) NOT NULL,
  `report_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `municipality_id` int(11) DEFAULT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `offense_category_id` int(11) DEFAULT NULL,
  `offense_type_id` int(11) DEFAULT NULL,
  `offense_custom` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `date_time` datetime NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('Active','Closed') NOT NULL DEFAULT 'Active',
  `officer_name` varchar(255) DEFAULT NULL,
  `witness_name` varchar(255) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `conform_by` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `qr_filename` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apprehended_logs`
--

INSERT INTO `apprehended_logs` (`id`, `report_id`, `district_id`, `municipality_id`, `barangay_id`, `offense_category_id`, `offense_type_id`, `offense_custom`, `qr_code`, `date_time`, `remarks`, `status`, `officer_name`, `witness_name`, `issue_date`, `conform_by`, `created_by`, `created_at`, `qr_filename`) VALUES
(129, NULL, 1, 2, 182, NULL, NULL, 'xzx', NULL, '2025-09-09 23:37:00', 'dsd', 'Active', '	Juan Dela Cruz', '	Juan Dela Cruz', '2025-09-08', '	Barangay Captain', NULL, '2025-09-09 15:47:04', '129.png'),
(130, NULL, 1, 2, 173, 4, 13, 'Community-Based & Sustainable Forestry, EO 23 – Logging moratorium violation (natural forests)', NULL, '2025-09-09 23:49:00', 'qwqw', 'Active', '	Juan Dela Cruz', '	Juan Dela Cruz', '2025-09-08', '	Barangay Captain', NULL, '2025-09-09 15:49:54', '130.png'),
(131, NULL, 6, 34, 281, 2, 9, 'RA 9175 – Chainsaw Act (2002), Sec. 7(d) – Illegal use of chainsaw for logging', NULL, '2025-09-10 20:36:00', 'hjhjh', 'Active', '	Juan Dela Cruz', '	Juan Dela Cruz', '2025-09-08', '	Barangay Captain', NULL, '2025-09-10 12:36:07', '131.png'),
(132, NULL, 1, 13, 434, 4, 13, 'Community-Based & Sustainable Forestry, EO 23 – Logging moratorium violation (natural forests)', NULL, '2025-09-11 21:34:00', 'qwqw', 'Active', '	Juan Dela Cruz', '	Juan Dela Cruz', '2025-09-11', '	Barangay Captain', NULL, '2025-09-11 13:36:00', '132.png'),
(133, NULL, 1, 2, 194, 4, 13, 'Community-Based & Sustainable Forestry, EO 23 – Logging moratorium violation (natural forests)', NULL, '2025-09-11 21:39:00', 'jkjk', 'Closed', '	Juan Dela Cruz', '	Juan Dela Cruz', '2025-09-11', '	Barangay Captain', NULL, '2025-09-11 13:39:58', '133.png'),
(134, NULL, 1, 2, 194, 2, 8, 'RA 9175 – Chainsaw Act (2002), Sec. 7(c) – Tampering engine/serial number', NULL, '2025-09-16 11:48:00', 'jjk', 'Closed', '	Juan Dela Cruz', '	Juan Dela Cruz', '2025-09-11', '	Barangay Captain', NULL, '2025-09-16 03:48:45', '134.png'),
(135, NULL, 2, 10, 140, 4, 13, 'Community-Based & Sustainable Forestry, EO 23 – Logging moratorium violation (natural forests)', NULL, '2025-09-20 23:12:00', 'qwqwwq', 'Active', '	Juan Dela Cruz', '	Juan Dela Cruz', '2025-09-11', '	Barangay Captain', NULL, '2025-09-20 15:12:31', '135.png');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `id` int(11) NOT NULL,
  `municipality_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`id`, `municipality_id`, `name`) VALUES
(1, 16, 'Amistad'),
(2, 16, 'Antonino'),
(3, 16, 'Apanay'),
(4, 16, 'Aurora'),
(5, 16, 'Bagnos'),
(6, 16, 'Bagong Sikat'),
(7, 16, 'Bantug-Petines'),
(8, 16, 'Bonifacio'),
(9, 16, 'Burgos'),
(10, 16, 'Calaocan'),
(11, 16, 'Callao'),
(12, 16, 'Dagupan'),
(13, 16, 'Inanama'),
(14, 16, 'Linglingay'),
(15, 16, 'M. H. del Pilar'),
(16, 16, 'Mabini'),
(17, 16, 'Magsaysay'),
(18, 16, 'Mataas na Kahoy'),
(19, 16, 'Paddad'),
(20, 16, 'Rizal'),
(21, 16, 'Rizaluna'),
(22, 16, 'Salvacion'),
(23, 16, 'San Antonio'),
(24, 16, 'San Fernando'),
(25, 16, 'San Francisco'),
(26, 16, 'San Juan'),
(27, 16, 'San Pablo'),
(28, 16, 'San Pedro'),
(29, 16, 'Santa Cruz'),
(30, 16, 'Santa Maria'),
(31, 16, 'Santo Domingo'),
(32, 16, 'Santo Tomas'),
(33, 16, 'Victoria'),
(34, 16, 'Zamora'),
(35, 17, 'Allangigan'),
(36, 17, 'Aniog'),
(37, 17, 'Baniket'),
(38, 17, 'Bannawag'),
(39, 17, 'Bantug'),
(40, 17, 'Barangcuag'),
(41, 17, 'Baui'),
(42, 17, 'Bonifacio'),
(43, 17, 'Buenavista'),
(44, 17, 'Bunnay'),
(45, 17, 'Calabayan-Minanga'),
(46, 17, 'Calaccab'),
(47, 17, 'Calaocan'),
(48, 17, 'Campanario'),
(49, 17, 'Canangan'),
(50, 17, 'Centro I'),
(51, 17, 'Centro II'),
(52, 17, 'Centro III'),
(53, 17, 'Consular'),
(54, 17, 'Cumu'),
(55, 17, 'Dalakip'),
(56, 17, 'Dalenat'),
(57, 17, 'Dipaluda'),
(58, 17, 'Duroc'),
(59, 17, 'Esperanza'),
(60, 17, 'Fugaru'),
(61, 17, 'Ingud Norte'),
(62, 17, 'Ingud Sur'),
(63, 17, 'Kalusutan'),
(64, 17, 'La Suerte'),
(65, 17, 'Liwliwa'),
(66, 17, 'Lomboy'),
(67, 17, 'Loria'),
(68, 17, 'Lourdes'),
(69, 17, 'Mabuhay'),
(70, 17, 'Macalauat'),
(71, 17, 'Macaniao'),
(72, 17, 'Malannao'),
(73, 17, 'Malasin'),
(74, 17, 'Mangandingay'),
(75, 17, 'Minanga Proper'),
(76, 17, 'Pappat'),
(77, 17, 'Pissay'),
(78, 17, 'Ramona'),
(79, 17, 'Rancho Bassit'),
(80, 17, 'Rang-ayan'),
(81, 17, 'Salay'),
(82, 17, 'San Ambrocio'),
(83, 17, 'San Guillermo'),
(84, 17, 'San Isidro'),
(85, 17, 'San Marcelo'),
(86, 17, 'San Roque'),
(87, 17, 'San Vicente'),
(88, 17, 'Santo Niño'),
(89, 17, 'Saranay'),
(90, 17, 'Sinabbaran'),
(91, 17, 'Victory'),
(92, 17, 'Viga'),
(93, 17, 'Villa Domingo'),
(94, 26, 'Apiat'),
(95, 26, 'Bagnos'),
(96, 26, 'Bagong Tanza'),
(97, 26, 'Ballesteros'),
(98, 26, 'Bannagao'),
(99, 26, 'Bannawag'),
(100, 26, 'Bolinao'),
(101, 26, 'Caipilan'),
(102, 26, 'Camarunggayan'),
(103, 26, 'Dalig-Kalinga'),
(104, 26, 'Diamantina'),
(105, 26, 'Divisoria'),
(106, 26, 'Esperanza East'),
(107, 26, 'Esperanza West'),
(108, 26, 'Kalabaza'),
(109, 26, 'Macatal'),
(110, 26, 'Malasin'),
(111, 26, 'Nampicuan'),
(112, 26, 'Panecien'),
(113, 26, 'Rizaluna'),
(114, 26, 'San Andres'),
(115, 26, 'San Jose'),
(116, 26, 'San Juan'),
(117, 26, 'San Pedro-San Pablo'),
(118, 26, 'San Rafael'),
(119, 26, 'San Ramon'),
(120, 26, 'Santa Rita'),
(121, 26, 'Santa Rosa'),
(122, 26, 'Saranay'),
(123, 26, 'Sili'),
(124, 26, 'Victoria'),
(125, 26, 'Villa Fugu'),
(126, 26, 'Villa Nuesa'),
(127, 10, 'Andabuen'),
(128, 10, 'Ara'),
(129, 10, 'Balliao'),
(130, 10, 'Binogtungan'),
(131, 10, 'Capuseran'),
(132, 10, 'Dagupan'),
(133, 10, 'Danipa'),
(134, 10, 'District I'),
(135, 10, 'District II'),
(136, 10, 'Gomez'),
(137, 10, 'Guilingan'),
(138, 10, 'La Salette'),
(139, 10, 'Lucban'),
(140, 10, 'Makindol'),
(141, 10, 'Maluno Norte'),
(142, 10, 'Maluno Sur'),
(143, 10, 'Nacalma'),
(144, 10, 'New Magsaysay'),
(145, 10, 'Placer'),
(146, 10, 'Punit'),
(147, 10, 'San Carlos'),
(148, 10, 'San Francisco'),
(149, 10, 'Santa Cruz'),
(150, 10, 'Santiago'),
(151, 10, 'Sevillana'),
(152, 10, 'Sinipit'),
(153, 10, 'Villaluz'),
(154, 10, 'Yeban Norte'),
(155, 10, 'Yeban Sur'),
(156, 27, 'Bacnor East'),
(157, 27, 'Bacnor West'),
(158, 27, 'Caliguian'),
(159, 27, 'Catabban'),
(160, 27, 'Cullalabo San Antonio'),
(161, 27, 'Cullalabo del Norte'),
(162, 27, 'Cullalabo del Sur'),
(163, 27, 'Dalig'),
(164, 27, 'Malasin'),
(165, 27, 'Masigun'),
(166, 27, 'Raniag'),
(167, 27, 'San Bonifacio'),
(168, 27, 'San Miguel'),
(169, 27, 'San Roque'),
(170, 2, 'Aggub'),
(171, 2, 'Anao'),
(172, 2, 'Angancasilian'),
(173, 2, 'Balasig'),
(174, 2, 'Cansan'),
(175, 2, 'Casibarag Norte'),
(176, 2, 'Casibarag Sur'),
(177, 2, 'Catabayungan'),
(178, 2, 'Centro'),
(179, 2, 'Cubag'),
(180, 2, 'Garita'),
(181, 2, 'Luquilu'),
(182, 2, 'Mabangug'),
(183, 2, 'Magassi'),
(184, 2, 'Masipi East'),
(185, 2, 'Masipi West'),
(186, 2, 'Ngarag'),
(187, 2, 'Pilig Abajo'),
(188, 2, 'Pilig Alto'),
(189, 2, 'San Antonio'),
(190, 2, 'San Bernardo'),
(191, 2, 'San Juan'),
(192, 2, 'Saui'),
(193, 2, 'Tallag'),
(194, 2, 'Ugad'),
(195, 2, 'Union'),
(196, 18, 'Calaocan'),
(197, 18, 'Canan'),
(198, 18, 'Centro'),
(199, 18, 'Culing Centro'),
(200, 18, 'Culing East'),
(201, 18, 'Culing West'),
(202, 18, 'Del Corpuz'),
(203, 18, 'Del Pilar'),
(204, 18, 'Diamantina'),
(205, 18, 'La Paz'),
(206, 18, 'Luzon'),
(207, 18, 'Macalaoat'),
(208, 18, 'Magdalena'),
(209, 18, 'Magsaysay'),
(210, 18, 'Namnama'),
(211, 18, 'Nueva Era'),
(212, 18, 'Paraiso'),
(213, 18, 'Rang-ay'),
(214, 18, 'Sampaloc'),
(215, 18, 'San Andres'),
(216, 18, 'Saranay'),
(217, 18, 'Tandul'),
(218, 34, 'Alicaocao'),
(219, 34, 'Alinam'),
(220, 34, 'Amobocan'),
(221, 34, 'Andarayan'),
(222, 34, 'Baculod'),
(223, 34, 'Baringin Norte'),
(224, 34, 'Baringin Sur'),
(225, 34, 'Buena Suerte'),
(226, 34, 'Bugallon'),
(227, 34, 'Buyon'),
(228, 34, 'Cabaruan'),
(229, 34, 'Cabugao'),
(230, 34, 'Carabatan Bacareno'),
(231, 34, 'Carabatan Chica'),
(232, 34, 'Carabatan Grande'),
(233, 34, 'Carabatan Punta'),
(234, 34, 'Casalatan'),
(235, 34, 'Cassap Fuera'),
(236, 34, 'Catalina'),
(237, 34, 'Culalabat'),
(238, 34, 'Dabburab'),
(239, 34, 'De Vera'),
(240, 34, 'Dianao'),
(241, 34, 'Disimuray'),
(242, 34, 'District I'),
(243, 34, 'District II'),
(244, 34, 'District III'),
(245, 34, 'Duminit'),
(246, 34, 'Faustino'),
(247, 34, 'Gagabutan'),
(248, 34, 'Gappal'),
(249, 34, 'Guayabal'),
(250, 34, 'Labinab'),
(251, 34, 'Linglingay'),
(252, 34, 'Mabantad'),
(253, 34, 'Maligaya'),
(254, 34, 'Manaoag'),
(255, 34, 'Marabulig I'),
(256, 34, 'Marabulig II'),
(257, 34, 'Minante I'),
(258, 34, 'Minante II'),
(259, 34, 'Naganacan'),
(260, 34, 'Nagcampegan'),
(261, 34, 'Nagrumbuan'),
(262, 34, 'Nungnungan I'),
(263, 34, 'Nungnungan II'),
(264, 34, 'Pinoma'),
(265, 34, 'Rizal'),
(266, 34, 'Rogus'),
(267, 34, 'San Antonio'),
(268, 34, 'San Fermin'),
(269, 34, 'San Francisco'),
(270, 34, 'San Isidro'),
(271, 34, 'San Luis'),
(272, 34, 'San Pablo'),
(273, 34, 'Santa Luciana'),
(274, 34, 'Santa Maria'),
(275, 34, 'Sillawit'),
(276, 34, 'Sinippil'),
(277, 34, 'Tagaran'),
(278, 34, 'Turayong'),
(279, 34, 'Union'),
(280, 34, 'Villa Concepcion'),
(281, 34, 'Villa Luna'),
(282, 34, 'Villaflor'),
(283, 22, 'Aguinaldo'),
(284, 22, 'Anonang'),
(285, 22, 'Calimaturod'),
(286, 22, 'Camarao'),
(287, 22, 'Capirpiriwan'),
(288, 22, 'Caquilingan'),
(289, 22, 'Dallao'),
(290, 22, 'Gayong'),
(291, 22, 'Laurel'),
(292, 22, 'Magsaysay'),
(293, 22, 'Malapat'),
(294, 22, 'Osmeña'),
(295, 22, 'Quezon'),
(296, 22, 'Quirino'),
(297, 22, 'Rizaluna'),
(298, 22, 'Roxas Poblacion'),
(299, 22, 'Sagat'),
(300, 22, 'San Juan'),
(301, 22, 'Taliktik'),
(302, 22, 'Tanggal'),
(303, 22, 'Tarinsing'),
(304, 22, 'Turod Norte'),
(305, 22, 'Turod Sur'),
(306, 22, 'Villamarzo'),
(307, 22, 'Villamiemban'),
(308, 22, 'Wigan'),
(309, 3, 'Aga'),
(310, 3, 'Andarayan'),
(311, 3, 'Aneg'),
(312, 3, 'Bayabo'),
(313, 3, 'Calinaoan Sur'),
(314, 3, 'Caloocan'),
(315, 3, 'Capitol'),
(316, 3, 'Carmencita'),
(317, 3, 'Concepcion'),
(318, 3, 'Maui'),
(319, 3, 'Quibal'),
(320, 3, 'Ragan Almacen'),
(321, 3, 'Ragan Norte'),
(322, 3, 'Ragan Sur'),
(323, 3, 'Rizal'),
(324, 3, 'San Andres'),
(325, 3, 'San Antonio'),
(326, 3, 'San Isidro'),
(327, 3, 'San Jose'),
(328, 3, 'San Juan'),
(329, 3, 'San Macario'),
(330, 3, 'San Nicolas'),
(331, 3, 'San Patricio'),
(332, 3, 'San Roque'),
(333, 3, 'Santo Rosario'),
(334, 3, 'Santor'),
(335, 3, 'Villa Luz'),
(336, 3, 'Villa Pereda'),
(337, 3, 'Visitacion'),
(338, 23, 'Ayod'),
(339, 23, 'Bucal Norte'),
(340, 23, 'Bucal Sur'),
(341, 23, 'Dibulo'),
(342, 23, 'Digumased'),
(343, 23, 'Dimaluade'),
(344, 4, 'Bicobian'),
(345, 4, 'Dibulos'),
(346, 4, 'Dicambangan'),
(347, 4, 'Dicaroyan'),
(348, 4, 'Dicatian'),
(349, 4, 'Dilakit'),
(350, 4, 'Dimapnat'),
(351, 4, 'Dimapula'),
(352, 4, 'Dimasalansan'),
(353, 4, 'Dipudo'),
(354, 4, 'Ditarum'),
(355, 4, 'Sapinit'),
(356, 35, 'Angoluan'),
(357, 35, 'Annafunan'),
(358, 35, 'Arabiat'),
(359, 35, 'Aromin'),
(360, 35, 'Babaran'),
(361, 35, 'Bacradal'),
(362, 35, 'Benguet'),
(363, 35, 'Buneg'),
(364, 35, 'Busilelao'),
(365, 35, 'Cabugao'),
(366, 35, 'Caniguing'),
(367, 35, 'Carulay'),
(368, 35, 'Castillo'),
(369, 35, 'Dammang East'),
(370, 35, 'Dammang West'),
(371, 35, 'Diasan'),
(372, 35, 'Dicaraoyan'),
(373, 35, 'Dugayong'),
(374, 35, 'Fugu'),
(375, 35, 'Garit Norte'),
(376, 35, 'Garit Sur'),
(377, 35, 'Gucab'),
(378, 35, 'Gumbauan'),
(379, 35, 'Ipil'),
(380, 35, 'Libertad'),
(381, 35, 'Mabbayad'),
(382, 35, 'Mabuhay'),
(383, 35, 'Madadamian'),
(384, 35, 'Magleticia'),
(385, 35, 'Malibago'),
(386, 35, 'Maligaya'),
(387, 35, 'Malitao'),
(388, 35, 'Narra'),
(389, 35, 'Nilumisu'),
(390, 35, 'Pag-asa'),
(391, 35, 'Pangal Norte'),
(392, 35, 'Pangal Sur'),
(393, 35, 'Rumang-ay'),
(394, 35, 'Salay'),
(395, 35, 'Salvacion'),
(396, 35, 'San Antonio Minit'),
(397, 35, 'San Antonio Ugad'),
(398, 35, 'San Carlos'),
(399, 35, 'San Fabian'),
(400, 35, 'San Felipe'),
(401, 35, 'San Juan'),
(402, 35, 'San Manuel'),
(403, 35, 'San Miguel'),
(404, 35, 'San Salvador'),
(405, 35, 'Santa Ana'),
(406, 35, 'Santa Cruz'),
(407, 35, 'Santa Maria'),
(408, 35, 'Santa Monica'),
(409, 35, 'Santo Domingo'),
(410, 35, 'Silauan Norte'),
(411, 35, 'Silauan Sur'),
(412, 35, 'Sinabbaran'),
(413, 35, 'Soyung'),
(414, 35, 'Taggappan'),
(415, 35, 'Tuguegarao'),
(416, 35, 'Villa Campo'),
(417, 35, 'Villa Fermin'),
(418, 35, 'Villa Rey'),
(419, 35, 'Villa Victoria'),
(420, 11, 'Barcolan'),
(421, 11, 'Buenavista'),
(422, 11, 'Dammao'),
(423, 11, 'District I'),
(424, 11, 'District II'),
(425, 11, 'District III'),
(426, 11, 'Furao'),
(427, 11, 'Guibang'),
(428, 11, 'Lenzon'),
(429, 11, 'Linglingay'),
(430, 11, 'Mabini'),
(431, 11, 'Pintor'),
(432, 11, 'Rizal'),
(433, 11, 'Songsong'),
(434, 11, 'Union'),
(435, 11, 'Upi'),
(436, 1, 'Aggasian'),
(437, 1, 'Alibagu'),
(438, 1, 'Allinguigan 1st'),
(439, 1, 'Allinguigan 2nd'),
(440, 1, 'Allinguigan 3rd'),
(441, 1, 'Arusip'),
(442, 1, 'Baculod'),
(443, 1, 'Bagong Silang'),
(444, 1, 'Bagumbayan'),
(445, 1, 'Baligatan'),
(446, 1, 'Ballacong'),
(447, 1, 'Bangag'),
(448, 1, 'Batong-Labang'),
(449, 1, 'Bigao'),
(450, 1, 'Cabannungan 1st'),
(451, 1, 'Cabannungan 2nd'),
(452, 1, 'Cabeseria 10'),
(453, 1, 'Cabeseria 14 and 16'),
(454, 1, 'Cabeseria 17 and 21'),
(455, 1, 'Cabeseria 19'),
(456, 1, 'Cabeseria 2'),
(457, 1, 'Cabeseria 22'),
(458, 1, 'Cabeseria 23'),
(459, 1, 'Cabeseria 25'),
(460, 1, 'Cabeseria 27'),
(461, 1, 'Cabeseria 3'),
(462, 1, 'Cabeseria 4'),
(463, 1, 'Cabeseria 5'),
(464, 1, 'Cabeseria 6 & 24'),
(465, 1, 'Cabeseria 7'),
(466, 1, 'Cabeseria 9 and 11'),
(467, 1, 'Cadu'),
(468, 1, 'Calamagui 1st'),
(469, 1, 'Calamagui 2nd'),
(470, 1, 'Camunatan'),
(471, 1, 'Capellan'),
(472, 1, 'Capo'),
(473, 1, 'Carikkikan Norte'),
(474, 1, 'Carikkikan Sur'),
(475, 1, 'Centro Poblacion'),
(476, 1, 'Centro-San Antonio'),
(477, 1, 'Fugu'),
(478, 1, 'Fuyo'),
(479, 1, 'Gayong-Gayong Norte'),
(480, 1, 'Gayong-Gayong Sur'),
(481, 1, 'Guinatan'),
(482, 1, 'Imelda Bliss Village'),
(483, 1, 'Lullutan'),
(484, 1, 'Malalam'),
(485, 1, 'Malasin'),
(486, 1, 'Manaring'),
(487, 1, 'Mangcuram'),
(488, 1, 'Marana I'),
(489, 1, 'Marana II'),
(490, 1, 'Marana III'),
(491, 1, 'Minabang'),
(492, 1, 'Morado'),
(493, 1, 'Naguilian Norte'),
(494, 1, 'Naguilian Sur'),
(495, 1, 'Namnama'),
(496, 1, 'Nanaguan'),
(497, 1, 'Osmeña'),
(498, 1, 'Paliueg'),
(499, 1, 'Pasa'),
(500, 1, 'Pilar'),
(501, 1, 'Quimalabasa'),
(502, 1, 'Rang-ayan'),
(503, 1, 'Rugao'),
(504, 1, 'Salindingan'),
(505, 1, 'San Andres'),
(506, 1, 'San Felipe'),
(507, 1, 'San Ignacio'),
(508, 1, 'San Isidro'),
(509, 1, 'San Juan'),
(510, 1, 'San Lorenzo'),
(511, 1, 'San Pablo'),
(512, 1, 'San Rodrigo'),
(513, 1, 'San Vicente'),
(514, 1, 'Santa Barbara'),
(515, 1, 'Santa Catalina'),
(516, 1, 'Santa Isabel Norte'),
(517, 1, 'Santa Isabel Sur'),
(518, 1, 'Santa Maria'),
(519, 1, 'Santa Victoria'),
(520, 1, 'Santo Tomas'),
(521, 1, 'Siffu'),
(522, 1, 'Sindon Bayabo'),
(523, 1, 'Sindon Maride'),
(524, 1, 'Sipay'),
(525, 1, 'Tangcul'),
(526, 1, 'Villa Imelda'),
(527, 14, 'Banquero'),
(528, 14, 'Binarsang'),
(529, 14, 'Cutog Grande'),
(530, 14, 'Cutog Pequeño'),
(531, 14, 'Dangan'),
(532, 14, 'District I'),
(533, 14, 'District II'),
(534, 14, 'Labinab Grande'),
(535, 14, 'Labinab Pequeño'),
(536, 14, 'Mallalatang Grande'),
(537, 14, 'Mallalatang Tunggui'),
(538, 14, 'Napaccu Grande'),
(539, 14, 'Napaccu Pequeño'),
(540, 14, 'Salucong'),
(541, 14, 'Santiago'),
(542, 14, 'Santor'),
(543, 14, 'Sinippil'),
(544, 14, 'Tallungan'),
(545, 14, 'Turod'),
(546, 14, 'Villador'),
(547, 32, 'Anao'),
(548, 32, 'Bantug'),
(549, 32, 'Doña Concha'),
(550, 32, 'Imbiao'),
(551, 32, 'Lanting'),
(552, 32, 'Lucban'),
(553, 32, 'Luna'),
(554, 32, 'Marcos'),
(555, 32, 'Masigun'),
(556, 32, 'Matusalem'),
(557, 32, 'Muñoz East'),
(558, 32, 'Muñoz West'),
(559, 32, 'Quiling'),
(560, 32, 'Rang-ayan'),
(561, 32, 'Rizal'),
(562, 32, 'San Antonio'),
(563, 32, 'San Jose'),
(564, 32, 'San Luis'),
(565, 32, 'San Pedro'),
(566, 32, 'San Placido'),
(567, 32, 'San Rafael'),
(568, 32, 'Simimbaan'),
(569, 32, 'Sinamar'),
(570, 32, 'Sotero Nuesa'),
(571, 32, 'Villa Concepcion'),
(572, 32, 'Vira'),
(573, 25, 'Bautista'),
(574, 25, 'Calaocan'),
(575, 25, 'Dabubu Grande'),
(576, 25, 'Dabubu Pequeño'),
(577, 25, 'Dappig'),
(578, 25, 'Laoag'),
(579, 25, 'Mapalad'),
(580, 25, 'Masaya Centro'),
(581, 25, 'Masaya Norte'),
(582, 25, 'Masaya Sur'),
(583, 25, 'Nemmatan'),
(584, 25, 'Palacian'),
(585, 25, 'Panang'),
(586, 25, 'Quimalabasa Norte'),
(587, 25, 'Quimalabasa Sur'),
(588, 25, 'Rang-ay'),
(589, 25, 'Salay'),
(590, 25, 'San Antonio'),
(591, 25, 'Santo Niño'),
(592, 25, 'Santos'),
(593, 25, 'Sinaoangan Norte'),
(594, 25, 'Sinaoangan Sur'),
(595, 25, 'Virgoneza'),
(596, 36, 'Anonang'),
(597, 36, 'Aringay'),
(598, 36, 'Burgos'),
(599, 36, 'Calaoagan'),
(600, 36, 'Centro 1'),
(601, 36, 'Centro 2'),
(602, 36, 'Colorado'),
(603, 36, 'Dietban'),
(604, 36, 'Dingading'),
(605, 36, 'Dipacamo'),
(606, 36, 'Estrella'),
(607, 36, 'Guam'),
(608, 36, 'Nakar'),
(609, 36, 'Palawan'),
(610, 36, 'Progreso'),
(611, 36, 'Rizal'),
(612, 36, 'San Francisco Norte'),
(613, 36, 'San Francisco Sur'),
(614, 36, 'San Mariano Norte'),
(615, 36, 'San Mariano Sur'),
(616, 36, 'San Rafael'),
(617, 36, 'Sinalugan'),
(618, 36, 'Villa Remedios'),
(619, 36, 'Villa Rose'),
(620, 36, 'Villa Sanchez'),
(621, 36, 'Villa Teresita'),
(622, 37, 'Camarag'),
(623, 37, 'Cebu'),
(624, 37, 'Gomez'),
(625, 37, 'Gud'),
(626, 37, 'Nagbukel'),
(627, 37, 'Patanad'),
(628, 37, 'Quezon'),
(629, 37, 'Ramos East'),
(630, 37, 'Ramos West'),
(631, 37, 'Rizal East'),
(632, 37, 'Rizal West'),
(633, 37, 'Victoria'),
(634, 37, 'Villaflor'),
(635, 33, 'Agliam'),
(636, 33, 'Babanuang'),
(637, 33, 'Cabaritan'),
(638, 33, 'Caraniogan'),
(639, 33, 'District 1'),
(640, 33, 'District 2'),
(641, 33, 'District 3'),
(642, 33, 'District 4'),
(643, 33, 'Eden'),
(644, 33, 'Malalinta'),
(645, 33, 'Mararigue'),
(646, 33, 'Nueva Era'),
(647, 33, 'Pisang'),
(648, 33, 'San Francisco'),
(649, 33, 'Sandiat Centro'),
(650, 33, 'Sandiat East'),
(651, 33, 'Sandiat West'),
(652, 33, 'Santa Cruz'),
(653, 33, 'Villanueva'),
(654, 15, 'Alibadabad'),
(655, 15, 'Balagan'),
(656, 15, 'Binatug'),
(657, 15, 'Bitabian'),
(658, 15, 'Buyasan'),
(659, 15, 'Cadsalan'),
(660, 15, 'Casala'),
(661, 15, 'Cataguing'),
(662, 15, 'Daragutan East'),
(663, 15, 'Daragutan West'),
(664, 15, 'Del Pilar'),
(665, 15, 'Dibuluan'),
(666, 15, 'Dicamay'),
(667, 15, 'Dipusu'),
(668, 15, 'Disulap'),
(669, 15, 'Disusuan'),
(670, 15, 'Gangalan'),
(671, 15, 'Ibujan'),
(672, 15, 'Libertad'),
(673, 15, 'Macayucayu'),
(674, 15, 'Mallabo'),
(675, 15, 'Marannao'),
(676, 15, 'Minanga'),
(677, 15, 'Old San Mariano'),
(678, 15, 'Palutan'),
(679, 15, 'Panninan'),
(680, 15, 'San Jose'),
(681, 15, 'San Pablo'),
(682, 15, 'San Pedro'),
(683, 15, 'Santa Filomina'),
(684, 15, 'Tappa'),
(685, 15, 'Ueg'),
(686, 15, 'Zamora'),
(687, 15, 'Zone I'),
(688, 15, 'Zone II'),
(689, 15, 'Zone III'),
(690, 20, 'Bacareña'),
(691, 20, 'Bagong Sikat'),
(692, 20, 'Barangay I'),
(693, 20, 'Barangay II'),
(694, 20, 'Barangay III'),
(695, 20, 'Barangay IV'),
(696, 20, 'Bella Luz'),
(697, 20, 'Dagupan'),
(698, 20, 'Daramuangan Norte'),
(699, 20, 'Daramuangan Sur'),
(700, 20, 'Estrella'),
(701, 20, 'Gaddanan'),
(702, 20, 'Malasin'),
(703, 20, 'Mapuroc'),
(704, 20, 'Marasat Grande'),
(705, 20, 'Marasat Pequeño'),
(706, 20, 'Old Centro I'),
(707, 20, 'Old Centro II'),
(708, 20, 'Salinungan East'),
(709, 20, 'Salinungan West'),
(710, 20, 'San Andres'),
(711, 20, 'San Antonio'),
(712, 20, 'San Ignacio'),
(713, 20, 'San Manuel'),
(714, 20, 'San Marcos'),
(715, 20, 'San Roque'),
(716, 20, 'Sinamar Norte'),
(717, 20, 'Sinamar Sur'),
(718, 20, 'Victoria'),
(719, 20, 'Villa Cruz'),
(720, 20, 'Villa Gamiao'),
(721, 20, 'Villa Magat'),
(722, 20, 'Villafuerte'),
(723, 6, 'Annanuman'),
(724, 6, 'Auitan'),
(725, 6, 'Ballacayu'),
(726, 6, 'Binguang'),
(727, 6, 'Bungad'),
(728, 6, 'Caddangan/Limbauan'),
(729, 6, 'Calamagui'),
(730, 6, 'Caralucud'),
(731, 6, 'Dalena'),
(732, 6, 'Guminga'),
(733, 6, 'Minanga Norte'),
(734, 6, 'Minanga Sur'),
(735, 6, 'Poblacion'),
(736, 6, 'San Jose'),
(737, 6, 'Simanu Norte'),
(738, 6, 'Simanu Sur'),
(739, 6, 'Tupa'),
(740, 7, 'Bangad'),
(741, 7, 'Buenavista'),
(742, 7, 'Calamagui East'),
(743, 7, 'Calamagui North'),
(744, 7, 'Calamagui West'),
(745, 7, 'Divisoria'),
(746, 7, 'Lingaling'),
(747, 7, 'Mozzozzin North'),
(748, 7, 'Mozzozzin Sur'),
(749, 7, 'Naganacan'),
(750, 7, 'Poblacion 1'),
(751, 7, 'Poblacion 2'),
(752, 7, 'Poblacion 3'),
(753, 7, 'Quinagabian'),
(754, 7, 'San Antonio'),
(755, 7, 'San Isidro East'),
(756, 7, 'San Isidro West'),
(757, 7, 'San Rafael East'),
(758, 7, 'San Rafael West'),
(759, 7, 'Villabuena'),
(760, 21, 'Abra'),
(761, 21, 'Ambalatungan'),
(762, 21, 'Balintocatoc'),
(763, 21, 'Baluarte'),
(764, 21, 'Bannawag Norte'),
(765, 21, 'Batal'),
(766, 21, 'Buenavista'),
(767, 21, 'Cabulay'),
(768, 21, 'Calao East'),
(769, 21, 'Calao West'),
(770, 21, 'Calaocan'),
(771, 21, 'Centro East'),
(772, 21, 'Centro West'),
(773, 21, 'Divisoria'),
(774, 21, 'Dubinan East'),
(775, 21, 'Dubinan West'),
(776, 21, 'Luna'),
(777, 21, 'Mabini'),
(778, 21, 'Malvar'),
(779, 21, 'Nabbuan'),
(780, 21, 'Naggasican'),
(781, 21, 'Patul'),
(782, 21, 'Plaridel'),
(783, 21, 'Rizal'),
(784, 21, 'Rosario'),
(785, 21, 'Sagana'),
(786, 21, 'Salvador'),
(787, 21, 'San Andres'),
(788, 21, 'San Isidro'),
(789, 21, 'San Jose'),
(790, 21, 'Santa Rosa'),
(791, 21, 'Sinili'),
(792, 21, 'Sinsayon'),
(793, 21, 'Victory Norte'),
(794, 21, 'Victory Sur'),
(795, 21, 'Villa Gonzaga'),
(796, 21, 'Villasis'),
(797, 8, 'Ammugauan'),
(798, 8, 'Antagan'),
(799, 8, 'Bagabag'),
(800, 8, 'Bagutari'),
(801, 8, 'Balelleng'),
(802, 8, 'Barumbong'),
(803, 8, 'Biga Occidental'),
(804, 8, 'Biga Oriental'),
(805, 8, 'Bolinao-Culalabo'),
(806, 8, 'Bubug'),
(807, 8, 'Calanigan Norte'),
(808, 8, 'Calanigan Sur'),
(809, 8, 'Calinaoan Centro'),
(810, 8, 'Calinaoan Malasin'),
(811, 8, 'Calinaoan Norte'),
(812, 8, 'Cañogan Abajo Norte'),
(813, 8, 'Cañogan Abajo Sur'),
(814, 8, 'Cañogan Alto'),
(815, 8, 'Centro'),
(816, 8, 'Colunguan'),
(817, 8, 'Malapagay'),
(818, 8, 'San Rafael Abajo'),
(819, 8, 'San Rafael Alto'),
(820, 8, 'San Roque'),
(821, 8, 'San Vicente'),
(822, 8, 'Uauang-Galicia'),
(823, 8, 'Uauang-Tuliao'),
(824, 9, 'Annafunan'),
(825, 9, 'Antagan I'),
(826, 9, 'Antagan II'),
(827, 9, 'Arcon'),
(828, 9, 'Balug'),
(829, 9, 'Banig'),
(830, 9, 'Bantug'),
(831, 9, 'Barangay District 1'),
(832, 9, 'Barangay District 2'),
(833, 9, 'Barangay District 3'),
(834, 9, 'Barangay District 4'),
(835, 9, 'Bayabo East'),
(836, 9, 'Caligayan'),
(837, 9, 'Camasi'),
(838, 9, 'Carpentero'),
(839, 9, 'Compania'),
(840, 9, 'Cumabao'),
(841, 9, 'Fermeldy'),
(842, 9, 'Fugu Abajo'),
(843, 9, 'Fugu Norte'),
(844, 9, 'Fugu Sur'),
(845, 9, 'Lalauanan'),
(846, 9, 'Lanna'),
(847, 9, 'Lapogan'),
(848, 9, 'Lingaling'),
(849, 9, 'Liwanag'),
(850, 9, 'Malamag East'),
(851, 9, 'Malamag West'),
(852, 9, 'Maligaya'),
(853, 9, 'Minanga'),
(854, 9, 'Moldero'),
(855, 9, 'Namnama'),
(856, 9, 'Paragu'),
(857, 9, 'Pilitan'),
(858, 9, 'San Mateo'),
(859, 9, 'San Pedro'),
(860, 9, 'San Vicente'),
(861, 9, 'Santa'),
(862, 9, 'Santa Catalina'),
(863, 9, 'Santa Visitacion'),
(864, 9, 'Santo Niño'),
(865, 9, 'Sinippil'),
(866, 9, 'Sisim Abajo'),
(867, 9, 'Sisim Alto'),
(868, 9, 'Tunggui'),
(869, 9, 'Ugad'),
(870, 5, 'Aplaya'),
(871, 5, 'Canadam'),
(872, 5, 'Diana'),
(873, 5, 'Eleonor'),
(874, 5, 'Fely'),
(875, 5, 'Lita'),
(876, 5, 'Malasin'),
(877, 5, 'Minanga'),
(878, 5, 'Reina Mercedes'),
(879, 5, 'Santa Marina'),
(880, 12, 'Aguinaldo'),
(881, 12, 'Bagong Sikat'),
(882, 12, 'Burgos'),
(883, 12, 'Cabaruan'),
(884, 12, 'Flores'),
(885, 12, 'La Union'),
(886, 12, 'Magsaysay'),
(887, 12, 'Manaring'),
(888, 12, 'Mansibang'),
(889, 12, 'Minallo'),
(890, 12, 'Minanga'),
(891, 12, 'Palattao'),
(892, 12, 'Quezon'),
(893, 12, 'Quinalabasa'),
(894, 12, 'Quirino'),
(895, 12, 'Rangayan'),
(896, 12, 'Rizal'),
(897, 12, 'Roxas'),
(898, 12, 'San Manuel'),
(899, 12, 'Santa Victoria'),
(900, 12, 'Santo Tomas'),
(901, 12, 'Sunlife'),
(902, 12, 'Surcoc'),
(903, 12, 'Tomines'),
(904, 12, 'Villa Paz'),
(905, 13, 'Alomanay'),
(906, 13, 'Bisag'),
(907, 13, 'Culasi'),
(908, 13, 'Dialaoyao'),
(909, 13, 'Dicabisagan East'),
(910, 13, 'Dicabisagan West'),
(911, 13, 'Dicadyuan'),
(912, 13, 'Diddadungan'),
(913, 13, 'Didiyan'),
(914, 13, 'Dimalicu-licu'),
(915, 13, 'Dimasari'),
(916, 13, 'Dimatican'),
(917, 13, 'Maligaya'),
(918, 13, 'Marikit'),
(919, 13, 'San Isidro'),
(920, 13, 'Santa Jacinta'),
(921, 13, 'Villa Robles'),
(922, 19, 'Ambatali'),
(923, 19, 'Bantug'),
(924, 19, 'Bugallon Norte'),
(925, 19, 'Bugallon Proper'),
(926, 19, 'Burgos'),
(927, 19, 'General Aguinaldo'),
(928, 19, 'Nagbacalan'),
(929, 19, 'Oscariz'),
(930, 19, 'Pabil'),
(931, 19, 'Pagrang-ayan'),
(932, 19, 'Planas'),
(933, 19, 'Purok ni Bulan'),
(934, 19, 'Raniag'),
(935, 19, 'San Antonio'),
(936, 19, 'San Miguel'),
(937, 19, 'San Sebastian'),
(938, 19, 'Villa Beltran'),
(939, 19, 'Villa Carmen'),
(940, 19, 'Villa Marcos'),
(941, 24, 'Abulan'),
(942, 24, 'Addalam'),
(943, 24, 'Arubub'),
(944, 24, 'Bannawag'),
(945, 24, 'Bantay'),
(946, 24, 'Barangay I'),
(947, 24, 'Barangay II'),
(948, 24, 'Barangcuag'),
(949, 24, 'Dalibubon'),
(950, 24, 'Daligan'),
(951, 24, 'Diarao'),
(952, 24, 'Dibuluan'),
(953, 24, 'Dicamay I'),
(954, 24, 'Dicamay II'),
(955, 24, 'Dipangit'),
(956, 24, 'Disimpit'),
(957, 24, 'Divinan'),
(958, 24, 'Dumawing'),
(959, 24, 'Fugu'),
(960, 24, 'Lacab'),
(961, 24, 'Linamanan'),
(962, 24, 'Linomot'),
(963, 24, 'Malannit'),
(964, 24, 'Minuri'),
(965, 24, 'Namnama'),
(966, 24, 'Napaliong'),
(967, 24, 'Palagao'),
(968, 24, 'Papan Este'),
(969, 24, 'Papan Weste'),
(970, 24, 'Payac'),
(971, 24, 'Pongpongan'),
(972, 24, 'San Antonio'),
(973, 24, 'San Isidro'),
(974, 24, 'San Jose'),
(975, 24, 'San Roque'),
(976, 24, 'San Sebastian'),
(977, 24, 'San Vicente'),
(978, 24, 'Santa Isabel'),
(979, 24, 'Santo Domingo'),
(980, 24, 'Tupax'),
(981, 24, 'Usol'),
(982, 24, 'Villa Bello'),
(983, 28, 'Bustamante'),
(984, 28, 'Centro 1'),
(985, 28, 'Centro 2'),
(986, 28, 'Centro 3'),
(987, 28, 'Concepcion'),
(988, 28, 'Dadap'),
(989, 28, 'Harana'),
(990, 28, 'Lalog 1'),
(991, 28, 'Lalog 2'),
(992, 28, 'Luyao'),
(993, 28, 'Macañao'),
(994, 28, 'Macugay'),
(995, 28, 'Mambabanga'),
(996, 28, 'Pulay'),
(997, 28, 'Puroc'),
(998, 28, 'San Isidro'),
(999, 28, 'San Miguel'),
(1000, 28, 'Santo Domingo'),
(1001, 28, 'Union Kalinga'),
(1002, 29, 'Binmonton'),
(1003, 29, 'Casili'),
(1004, 29, 'Centro I'),
(1005, 29, 'Centro II'),
(1006, 29, 'Holy Friday'),
(1007, 29, 'Maligaya'),
(1008, 29, 'Manano'),
(1009, 29, 'Olango'),
(1010, 29, 'Rang-ayan'),
(1011, 29, 'San Jose Norte I'),
(1012, 29, 'San Jose Norte II'),
(1013, 29, 'San Jose Sur'),
(1014, 29, 'San Pedro'),
(1015, 29, 'San Ramon'),
(1016, 29, 'Siempre Viva Norte'),
(1017, 29, 'Siempre Viva Sur'),
(1018, 29, 'Trinidad'),
(1019, 29, 'Victoria'),
(1020, 30, 'Abut'),
(1021, 30, 'Alunan'),
(1022, 30, 'Arellano'),
(1023, 30, 'Aurora'),
(1024, 30, 'Barucboc Norte'),
(1025, 30, 'Calangigan'),
(1026, 30, 'Dunmon'),
(1027, 30, 'Estrada'),
(1028, 30, 'Lepanto'),
(1029, 30, 'Mangga'),
(1030, 30, 'Minagbag'),
(1031, 30, 'Samonte'),
(1032, 30, 'San Juan'),
(1033, 30, 'Santos'),
(1034, 30, 'Turod'),
(1035, 31, 'Binarzang'),
(1036, 31, 'Cabaruan'),
(1037, 31, 'Camaal'),
(1038, 31, 'Dolores'),
(1039, 31, 'Luna'),
(1040, 31, 'Manaoag'),
(1041, 31, 'Rizal'),
(1042, 31, 'San Isidro'),
(1043, 31, 'San Jose'),
(1044, 31, 'San Juan'),
(1045, 31, 'San Mateo'),
(1046, 31, 'San Vicente'),
(1047, 31, 'Santa Catalina'),
(1048, 31, 'Santa Lucia'),
(1049, 31, 'Santiago'),
(1050, 31, 'Santo Domingo'),
(1051, 31, 'Sinait'),
(1052, 31, 'Suerte'),
(1053, 31, 'Villa Bulusan'),
(1054, 31, 'Villa Miguel'),
(1055, 31, 'Vintar');

-- --------------------------------------------------------

--
-- Table structure for table `disposed_conveyance`
--

CREATE TABLE `disposed_conveyance` (
  `id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `kind` varchar(100) DEFAULT NULL,
  `plate_no` varchar(50) DEFAULT NULL,
  `engine_chassis_no` varchar(255) DEFAULT NULL,
  `estimated_value` decimal(12,2) DEFAULT NULL,
  `driver_owner_info` varchar(255) DEFAULT NULL,
  `owner_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disposed_conveyance`
--

INSERT INTO `disposed_conveyance` (`id`, `log_id`, `kind`, `plate_no`, `engine_chassis_no`, `estimated_value`, `driver_owner_info`, `owner_address`) VALUES
(34, 80, 'van', 'ABC-1234', 'EN456789 / CH789456', 12.00, 'sa', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `disposed_equipment`
--

CREATE TABLE `disposed_equipment` (
  `id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `equipment_details` varchar(255) DEFAULT NULL,
  `features` varchar(255) DEFAULT NULL,
  `estimated_value` decimal(12,2) DEFAULT NULL,
  `owner_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disposed_equipment`
--

INSERT INTO `disposed_equipment` (`id`, `log_id`, `equipment_details`, `features`, `estimated_value`, `owner_address`) VALUES
(33, 80, 'Chainsaw - Stihl MS361', 'machine', 1.00, 'sa');

-- --------------------------------------------------------

--
-- Table structure for table `disposed_forest_products`
--

CREATE TABLE `disposed_forest_products` (
  `id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `species_form` varchar(255) DEFAULT NULL,
  `no_of_pieces` int(11) DEFAULT NULL,
  `volume` decimal(10,2) DEFAULT NULL,
  `estimated_value` decimal(12,2) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `owner_info` varchar(255) DEFAULT NULL,
  `owner_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disposed_logs`
--

CREATE TABLE `disposed_logs` (
  `id` int(11) NOT NULL,
  `original_log_id` int(11) NOT NULL,
  `district_id` int(11) DEFAULT NULL,
  `municipality_id` int(11) DEFAULT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `offense_category_id` int(11) DEFAULT NULL,
  `offense_type_id` int(11) DEFAULT NULL,
  `offense_custom` varchar(255) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `officer_name` varchar(255) DEFAULT NULL,
  `witness_name` varchar(255) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `conform_by` varchar(255) DEFAULT NULL,
  `disposed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `disposed_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disposed_logs`
--

INSERT INTO `disposed_logs` (`id`, `original_log_id`, `district_id`, `municipality_id`, `barangay_id`, `offense_category_id`, `offense_type_id`, `offense_custom`, `date_time`, `remarks`, `officer_name`, `witness_name`, `issue_date`, `conform_by`, `disposed_at`, `disposed_by`) VALUES
(80, 126, 2, 10, 141, 4, 12, 'Community-Based & Sustainable Forestry, EO 263 – CBFM violations (community-based forest management)', '2025-09-09 23:35:00', 'Ss', '	Juan Dela Cruz', '	Juan Dela Cruz', '2025-09-08', '	Barangay Captain', '2025-09-14 16:16:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`) VALUES
(1, '1st District'),
(2, '2nd District'),
(3, '3rd District'),
(4, '4th District'),
(5, '5th District'),
(6, '6th District');

-- --------------------------------------------------------

--
-- Table structure for table `log_conveyance`
--

CREATE TABLE `log_conveyance` (
  `id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `kind` varchar(100) DEFAULT NULL,
  `plate_no` varchar(50) DEFAULT NULL,
  `engine_chassis_no` varchar(255) DEFAULT NULL,
  `estimated_value` decimal(12,2) DEFAULT NULL,
  `driver_owner_info` text DEFAULT NULL,
  `owner_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_conveyance`
--

INSERT INTO `log_conveyance` (`id`, `log_id`, `kind`, `plate_no`, `engine_chassis_no`, `estimated_value`, `driver_owner_info`, `owner_address`) VALUES
(40, 129, 'van', 'ABC-1234', 'EN456789 / CH789456', 12.00, 'ad', NULL),
(41, 130, 'van', 'ABC-1234', 'EN456789 / CH789456', 12.00, 'q', NULL),
(42, 131, 'van', 'ABC-1234', 'EN456789 / CH789456', 12.00, 'i', NULL),
(55, 132, 'van', 'none', 'EN456789 / CH789456', 1.00, 'q', NULL),
(57, 134, 'van', 'none', 'EN456789 / CH789456', 1.00, 'k', NULL),
(68, 133, 'van', 'none', 'EN456789 / CH789456', 1.00, 'aaa', NULL),
(69, 135, 'van', 'none', 'EN456789 / CH789456', 1.00, 'c', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `log_equipment`
--

CREATE TABLE `log_equipment` (
  `id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `equipment_details` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL,
  `estimated_value` decimal(12,2) DEFAULT NULL,
  `owner_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_equipment`
--

INSERT INTO `log_equipment` (`id`, `log_id`, `equipment_details`, `features`, `estimated_value`, `owner_address`) VALUES
(39, 129, 'Chainsaw - Stihl MS361', 'machine', 1.00, 'asd'),
(40, 130, 'Chainsaw - Stihl MS361', 'machine', 1.00, 'q'),
(41, 131, 'Chainsaw - Stihl MS361', 'machine', 1.00, 'j'),
(49, 132, 'Chainsaw - Stihl MS361', 'machine', 1.00, '<br /><b>Warning</b>:  Undefined array key '),
(51, 134, 'Chainsaw - Stihl MS361', 'machine', 1.00, 'k'),
(62, 133, 'Chainsaw - Stihl MS361', 'machine', 1.00, '<br /><b>Warning</b>:  Undefined array key '),
(63, 135, 'Chainsaw - Stihl MS361', 'machine', 1.00, 'c');

-- --------------------------------------------------------

--
-- Table structure for table `log_forest_products`
--

CREATE TABLE `log_forest_products` (
  `id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `species_custom` varchar(150) DEFAULT NULL,
  `form` varchar(100) DEFAULT NULL,
  `form_custom` varchar(100) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `size_custom` varchar(100) DEFAULT NULL,
  `species_form` varchar(255) DEFAULT NULL,
  `no_of_pieces` int(11) DEFAULT NULL,
  `volume` decimal(10,2) DEFAULT NULL,
  `estimated_value` decimal(12,2) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `owner_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_forest_products`
--

INSERT INTO `log_forest_products` (`id`, `log_id`, `species_custom`, `form`, `form_custom`, `size`, `size_custom`, `species_form`, `no_of_pieces`, `volume`, `estimated_value`, `origin`, `owner_info`) VALUES
(52, 132, '', 'Round Logs', '', 'L', '', 'Narra', 1, 12.00, 1.00, '1', 'q'),
(54, 134, '', 'Round Logs', '', 'L', '', 'Narra', 1, 12.00, 1.00, '1', 'k'),
(65, 133, '', 'Round Logs', '', 'M', '', 'Batikuling', 1, 12.00, 1.00, '1', 'aa'),
(66, 135, '', 'Lumber', '', 'S', '', 'Ipil', 1, 12.00, 1.00, '1', 'qq');

-- --------------------------------------------------------

--
-- Table structure for table `municipalities`
--

CREATE TABLE `municipalities` (
  `id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `municipalities`
--

INSERT INTO `municipalities` (`id`, `district_id`, `name`) VALUES
(1, 1, 'City of Ilagan'),
(2, 1, 'Cabagan'),
(3, 1, 'Delfin Albano'),
(4, 1, 'Divilacan'),
(5, 1, 'Maconacon'),
(6, 1, 'San Pablo'),
(7, 1, 'Santa Maria'),
(8, 1, 'Santo Tomas'),
(9, 1, 'Tumauini'),
(10, 2, 'Benito Soliven'),
(11, 2, 'Gamu'),
(12, 2, 'Naguilian'),
(13, 2, 'Palanan'),
(14, 2, 'Reina Mercedes'),
(15, 2, 'San Mariano'),
(16, 3, 'Alicia'),
(17, 3, 'Angadanan'),
(18, 3, 'Cabatuan'),
(19, 3, 'Ramon'),
(20, 3, 'San Mateo'),
(21, 4, 'City of Santiago'),
(22, 4, 'Cordon'),
(23, 4, 'Dinapigue'),
(24, 4, 'Jones'),
(25, 4, 'San Agustin'),
(26, 5, 'Aurora'),
(27, 5, 'Burgos'),
(28, 5, 'Luna'),
(29, 5, 'Mallig'),
(30, 5, 'Quezon'),
(31, 5, 'Quirino'),
(32, 5, 'Roxas'),
(33, 5, 'San Manuel'),
(34, 6, 'City of Cauayan'),
(35, 6, 'Echague'),
(36, 6, 'San Guillermo'),
(37, 6, 'San Isidro');

-- --------------------------------------------------------

--
-- Table structure for table `offense_categories`
--

CREATE TABLE `offense_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offense_categories`
--

INSERT INTO `offense_categories` (`id`, `name`) VALUES
(1, 'PD 705 – Revised Forestry Code'),
(2, 'RA 9175 – Chainsaw Act (2002)'),
(3, 'Protected Areas & Wildlife'),
(4, 'Community-Based & Sustainable Forestry'),
(5, 'Indigenous Rights'),
(6, 'Environmental Overlaps');

-- --------------------------------------------------------

--
-- Table structure for table `offense_types`
--

CREATE TABLE `offense_types` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offense_types`
--

INSERT INTO `offense_types` (`id`, `category_id`, `name`) VALUES
(1, 1, 'Sec. 77 – Illegal cutting/gathering/possession of timber'),
(2, 1, 'Sec. 78 – Unlawful occupation/destruction of forest land (kaingin)'),
(3, 1, 'Sec. 79 – Grazing without permit'),
(4, 1, 'Sec. 80 – Unauthorized survey in forest lands'),
(5, 1, 'Sec. 81 – Tampering/removing government timber marks'),
(6, 2, 'Sec. 7(a) – Possession of chainsaw without permit'),
(7, 2, 'Sec. 7(b) – Illegal importation/manufacture of chainsaw'),
(8, 2, 'Sec. 7(c) – Tampering engine/serial number'),
(9, 2, 'Sec. 7(d) – Illegal use of chainsaw for logging'),
(10, 3, 'NIPAS Act (RA 7586, amended by RA 11038) – Illegal activity in protected areas'),
(11, 3, 'RA 9147 – Wildlife Act – Illegal collection, hunting, or trade of flora/fauna'),
(12, 4, 'EO 263 – CBFM violations (community-based forest management)'),
(13, 4, 'EO 23 – Logging moratorium violation (natural forests)'),
(14, 4, 'EO 26 / EO 193 – Violation of National Greening Program regulations'),
(15, 5, 'RA 8371 – IPRA (1997) – Violation of ancestral domain rights in forestry areas'),
(16, 6, 'PD 1586 – No Environmental Impact Statement (EIS) for forestry projects'),
(17, 6, 'RA 8749 – Clean Air Act – Burning/kaingin violations'),
(18, 6, 'RA 9003 – Solid Waste Management – improper disposal in forest areas'),
(19, 6, 'RA 9729 – Climate Change Act – forestry-related climate violations');

-- --------------------------------------------------------

--
-- Table structure for table `personnel_summary`
--

CREATE TABLE `personnel_summary` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `report_date` date NOT NULL,
  `regular_personnel` int(11) DEFAULT 0,
  `contractual_personnel` int(11) DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personnel_summary`
--

INSERT INTO `personnel_summary` (`id`, `staff_id`, `report_date`, `regular_personnel`, `contractual_personnel`, `remarks`, `created_at`) VALUES
(1, NULL, '2025-02-01', 16200, 2850, NULL, '2025-07-30 14:52:57'),
(2, NULL, '2025-01-01', 0, 0, NULL, '2025-09-23 01:43:59'),
(4, NULL, '2025-10-01', 0, 0, NULL, '2025-09-23 02:54:58'),
(6, NULL, '2025-09-01', 0, 0, NULL, '2025-09-23 02:55:28'),
(8, NULL, '2025-09-01', 0, 0, NULL, '2025-09-23 04:20:21'),
(9, NULL, '2025-09-01', 0, 0, NULL, '2025-09-23 04:22:34'),
(10, NULL, '2025-09-01', 0, 0, NULL, '2025-09-23 12:51:55'),
(11, NULL, '2025-09-01', 0, 0, NULL, '2025-09-23 13:45:05'),
(12, NULL, '2025-09-01', 0, 0, NULL, '2025-09-24 14:36:08'),
(13, NULL, '2025-09-01', 0, 0, NULL, '2025-09-24 14:47:34'),
(14, NULL, '2025-09-01', 0, 0, NULL, '2025-09-27 14:09:45'),
(15, NULL, '2025-09-01', 0, 0, NULL, '2025-09-27 14:19:16'),
(16, NULL, '2025-09-01', 0, 0, NULL, '2025-09-27 14:30:12'),
(17, NULL, '2025-10-01', 0, 0, NULL, '2025-10-03 15:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `pnp_case_assignments`
--

CREATE TABLE `pnp_case_assignments` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `status` enum('Pending','Ongoing','Completed') DEFAULT 'Pending',
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pnp_password_resets`
--

CREATE TABLE `pnp_password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pnp_password_resets`
--

INSERT INTO `pnp_password_resets` (`id`, `user_id`, `otp_code`, `created_at`) VALUES
(1, 6, '899164', '2025-09-04 05:07:18'),
(2, 5, '335951', '2025-09-04 05:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `pnp_users`
--

CREATE TABLE `pnp_users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `id_document` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pnp_users`
--

INSERT INTO `pnp_users` (`id`, `first_name`, `last_name`, `email`, `contact`, `address`, `password`, `status`, `id_document`, `created_at`) VALUES
(1, 'sheina', 'gumiran', 'sheinagumiran3@gmail.com', '0909909090', 'ugad cabagan isabela', '$2y$10$03FIU0/h7IQoEUquw7ik3uiMJZ.EFZQnSlcNKGzWaGfNpqOOSeuAi', 'Approved', '1756821433_3 Register.png', '2025-09-02 13:57:13'),
(3, 'Eduardo', 'Gago', 'eduardotalaue10@gmail.com', '09090909090', 'Catabayungan Cabagan ISabela', '$2y$10$JpYYan6Gui8rVpUoLcln3exkDbpuUvHWkDX8C0wbu9u1Yg.ZHot/S', 'Approved', '1756904902_IMG_20250204_133642.jpg', '2025-09-03 13:08:22'),
(5, 'jayjay', 'canceran', 'jayjay@123', '909909090', 'ugad cabagan isabela', '$2y$10$93BgStP3XMpMeC1GCoZ3qu9DL9qBok26PqA07cFvWk59vYZFpiQj6', 'Rejected', '1756905598_2x2 angel - Copy.jpg', '2025-09-03 13:19:58'),
(6, 'aj', 'cammagay', 'ajcammagay@gmail.com', '94675432180', 'Catabayungan Cabagan ISabela', '$2y$10$fmRoiOk/tXF3mB52xhEj6uwr.3XdiDbHZWC3xpgfE2ZtkNs00jGt2', 'Approved', '1756960851_Picture1 - Copy.jpg', '2025-09-04 04:40:51'),
(7, 'sample', 'sample', 'sample@gmail.com', '09878768732', 'Cubag Cabagan Isabela', '$2y$10$awxToYVZ6xP8tSEhsSp/0u8p1VyGdtz2u45B9VilRjBAovfVaSOwS', 'Approved', '1757514728_2023-01-06.png', '2025-09-10 14:32:08'),
(8, 'Cardo', 'dalisay', 'cardodalisay@gmail.com', '09123456789', 'magassi cabagan Isabela', '$2y$10$0niF6PPDbH44jQ1kHIIOm.pCdOQskfVgfH0hXxUXw0.EU.BeHYvQS', 'Pending', '1757593249_monkeyrizz.jpg', '2025-09-11 12:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Acknowledged','Forwarded','Verified') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports_history`
--

CREATE TABLE `reports_history` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `generated_by` varchar(100) NOT NULL,
  `date_generated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports_history`
--

INSERT INTO `reports_history` (`id`, `type`, `filename`, `generated_by`, `date_generated`) VALUES
(1, 'logcase', 'logcase_report_20251002_031259.pdf', '1', '2025-10-02 01:12:59'),
(2, 'logcase', 'logcase_report_20251002_031301.pdf', '1', '2025-10-02 01:13:01'),
(3, 'logcase', 'logcase_report_20251002_031302.pdf', '1', '2025-10-02 01:13:02'),
(4, 'logcase', 'logcase_report_20251002_031302.pdf', '1', '2025-10-02 01:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `report_metadata`
--

CREATE TABLE `report_metadata` (
  `id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `prepared_by` varchar(150) DEFAULT NULL,
  `reviewed_by` varchar(150) DEFAULT NULL,
  `attested_by` varchar(150) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rmc_target` int(11) DEFAULT 0,
  `nursery_target` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report_metadata`
--

INSERT INTO `report_metadata` (`id`, `report_date`, `prepared_by`, `reviewed_by`, `attested_by`, `remarks`, `created_at`, `rmc_target`, `nursery_target`) VALUES
(1, '2025-02-01', 'Duane', 'Duane', 'Duean', NULL, '2025-07-30 14:52:57', 0, 0),
(2, '2025-01-01', '', '', '', NULL, '2025-09-23 01:43:59', 200, 0),
(3, '2025-10-01', '', '', '', NULL, '2025-09-23 02:54:58', 0, 0),
(4, '2025-09-01', '', '', '', NULL, '2025-09-23 02:55:28', 0, 0),
(5, '2025-09-01', '', '', '', NULL, '2025-09-23 04:20:21', 200, 0),
(6, '2025-09-01', '', '', '', NULL, '2025-09-23 04:22:34', 0, 0),
(7, '2025-09-01', '', '', '', NULL, '2025-09-23 12:51:55', 0, 200),
(8, '2025-09-01', '', '', '', NULL, '2025-09-23 13:45:05', 0, 0),
(9, '2025-09-01', '', '', '', NULL, '2025-09-24 14:36:08', 0, 0),
(10, '2025-09-01', '', '', '', NULL, '2025-09-24 14:47:34', 0, 0),
(11, '2025-09-01', '', '', '', NULL, '2025-09-27 14:09:45', 0, 500),
(12, '2025-09-01', '', '', '', NULL, '2025-09-27 14:19:16', 0, 500),
(13, '2025-09-01', '', '', '', NULL, '2025-09-27 14:30:12', 0, 500),
(14, '2025-10-01', '', '', '', NULL, '2025-10-03 15:12:06', 300, 0);

-- --------------------------------------------------------

--
-- Table structure for table `seedling_inventory`
--

CREATE TABLE `seedling_inventory` (
  `id` int(11) NOT NULL,
  `category` enum('RMC-2014-01','TCP Replacement','Nursery Maintenance') NOT NULL,
  `report_date` date NOT NULL,
  `species` varchar(100) NOT NULL,
  `previous_stock` int(11) DEFAULT 0,
  `produced_this_month` int(11) DEFAULT 0,
  `seedling_received_this_month` int(11) DEFAULT 0,
  `disposed_this_month` int(11) DEFAULT 0,
  `mortality_this_month` int(11) DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stock_to_date` int(11) GENERATED ALWAYS AS (`previous_stock` + `produced_this_month` + `seedling_received_this_month` - `disposed_this_month` - `mortality_this_month`) STORED,
  `target` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seedling_inventory`
--

INSERT INTO `seedling_inventory` (`id`, `category`, `report_date`, `species`, `previous_stock`, `produced_this_month`, `seedling_received_this_month`, `disposed_this_month`, `mortality_this_month`, `remarks`, `created_by`, `created_at`, `updated_at`, `target`) VALUES
(6, 'RMC-2014-01', '2025-01-01', 'narra', 10, 50, 0, 25, 25, '0', 1, '2025-09-23 01:43:59', '2025-09-23 01:43:59', 0),
(7, 'RMC-2014-01', '2025-01-01', 'ipil', 10, 50, 0, 10, 10, '0', 1, '2025-09-23 01:43:59', '2025-09-23 01:43:59', 0),
(8, 'RMC-2014-01', '2025-01-01', 'molave', 10, 50, 0, 10, 10, '0', 1, '2025-09-23 01:43:59', '2025-09-23 01:43:59', 0),
(9, 'RMC-2014-01', '2025-01-01', 'paper tree', 10, 50, 0, 10, 10, '0', 1, '2025-09-23 01:43:59', '2025-09-23 01:43:59', 0),
(12, 'RMC-2014-01', '2025-09-01', 'narra', 1, 50, 0, 5, 5, '', 1, '2025-09-23 04:20:21', '2025-09-23 04:20:21', 0),
(13, 'RMC-2014-01', '2025-09-01', 'ipil', 1, 50, 0, 5, 5, '', 1, '2025-09-23 04:20:21', '2025-09-23 04:20:21', 0),
(14, 'RMC-2014-01', '2025-09-01', 'mango', 1, 50, 0, 5, 5, '', 1, '2025-09-23 04:20:21', '2025-09-23 04:20:21', 0),
(15, 'RMC-2014-01', '2025-09-01', 'paper tree', 1, 50, 0, 5, 5, '', 1, '2025-09-23 04:20:21', '2025-09-23 04:20:21', 0),
(32, 'TCP Replacement', '2025-09-01', 'Bamboo', 10, 100, 0, 20, 5, '', 1, '2025-09-24 14:47:34', '2025-09-24 14:47:34', 0),
(33, 'TCP Replacement', '2025-09-01', 'Acacia', 50, 200, 0, 50, 5, '', 1, '2025-09-24 14:47:34', '2025-09-24 14:47:34', 0),
(34, 'TCP Replacement', '2025-09-01', 'Ipil-ipil', 50, 300, 0, 50, 5, '', 1, '2025-09-24 14:47:34', '2025-09-24 14:47:34', 0),
(35, 'TCP Replacement', '2025-09-01', 'Tuai', 50, 100, 0, 10, 5, '', 1, '2025-09-24 14:47:34', '2025-09-24 14:47:34', 0),
(42, 'Nursery Maintenance', '2025-09-01', 'Acacia', 50, 100, 0, 20, 30, '', 1, '2025-09-27 14:30:12', '2025-09-27 14:30:12', 0),
(43, 'Nursery Maintenance', '2025-09-01', 'Mahogany', 50, 100, 0, 20, 20, '', 1, '2025-09-27 14:30:12', '2025-09-27 14:30:12', 0),
(44, 'Nursery Maintenance', '2025-09-01', 'Narra', 50, 100, 0, 20, 20, '', 1, '2025-09-27 14:30:12', '2025-09-27 14:30:12', 0),
(45, 'RMC-2014-01', '2025-10-01', 'Acacia', 123, 50, 0, 12, 21, '0', 1, '2025-10-03 15:12:06', '2025-10-03 15:12:06', 300),
(46, 'RMC-2014-01', '2025-10-01', 'Molave', 123, 100, 0, 12, 21, '0', 1, '2025-10-03 15:12:06', '2025-10-03 15:12:06', 300),
(47, 'RMC-2014-01', '2025-10-01', 'Bamboo', 123, 100, 0, 12, 21, '0', 1, '2025-10-03 15:12:06', '2025-10-03 15:12:06', 300);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `employment_type` enum('Regular','Contractual') NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `fullname`, `email`, `password`, `contact_number`, `position`, `employment_type`, `date_registered`) VALUES
(1, 'airon cammagay', 'ajcammagay@gmail.com', '$2y$10$HjbgscNLSBfmpljsSHZEg.r/jyfy/76P.tWwE9dCeyFyu4fsLShGO', '09467432180', 'clerk', 'Contractual', '2025-08-05 15:49:57'),
(2, 'eduardo', 'eduardotalaue10@gmail.com', '$2y$10$AT6hqcaajXjT6ln2mMplnOyaSmVyw7MBuX0KSSiWMC86lKfXPleBO', '09090909090', 'clerk', 'Regular', '2025-08-12 07:15:55'),
(4, 'airon cammagay', 'aironcammagay@gmail.com', '$2y$10$TTuOjz/yvRS/7IHtny6dpOc8KPY0mu2PoNxmerw5cinyYH637SFO.', '94675432180', 'clerk', 'Regular', '2025-09-26 09:02:56'),
(5, 'Kupal', 'paccaranganmarklarenz@gmail.com', '$2y$10$iTlVLzDBqSjfhjqWgaWg9uVs2.2YCEcj.xj9rszdVQ2rp84EQdfdK', '09123456789', 'janitor', 'Regular', '2025-09-29 05:53:17');

-- --------------------------------------------------------

--
-- Table structure for table `staff_contributions`
--

CREATE TABLE `staff_contributions` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `species` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status` enum('pending','verified','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_contributions`
--

INSERT INTO `staff_contributions` (`id`, `staff_id`, `report_date`, `species`, `quantity`, `total`, `status`, `created_at`, `verified`) VALUES
(1, 4, '2025-01-01', 'ipil', 50, 300, 'verified', '2025-09-26 13:12:55', 0),
(2, 4, '2025-01-01', 'molave', 50, 300, 'verified', '2025-09-26 13:12:55', 0),
(3, 4, '2025-01-01', 'narra', 50, 300, 'verified', '2025-09-26 13:12:55', 0),
(4, 4, '2025-01-01', 'tuai', 50, 300, 'verified', '2025-09-26 13:12:55', 0),
(5, 4, '2025-01-01', 'bamboo', 50, 300, 'verified', '2025-09-26 13:12:55', 0),
(6, 4, '2025-01-01', 'mahoganny', 50, 300, 'verified', '2025-09-26 13:12:55', 0),
(7, 5, '2025-01-01', 'ipil', 50, 300, 'pending', '2025-09-29 05:54:43', 0),
(8, 5, '2025-01-01', 'molave', 50, 300, 'pending', '2025-09-29 05:54:43', 0),
(9, 5, '2025-01-01', 'narra', 50, 300, 'pending', '2025-09-29 05:54:43', 0),
(10, 5, '2025-01-01', 'tuai', 50, 300, 'pending', '2025-09-29 05:54:43', 0),
(11, 5, '2025-01-01', 'bamboo', 50, 300, 'pending', '2025-09-29 05:54:43', 0),
(12, 5, '2025-01-01', 'tree', 50, 300, 'pending', '2025-09-29 05:54:43', 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff_otp_verification`
--

CREATE TABLE `staff_otp_verification` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_otp_verification`
--

INSERT INTO `staff_otp_verification` (`id`, `email`, `otp_code`, `created_at`) VALUES
(15, 'eduardotalaue10@gmail.com', '592544', '2025-08-12 15:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','pnp_admin','pnp_officer','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'System Admin', 'admin', NULL, '$2y$10$N0pV8SnQu74b2W2Pu6gaCOKwojNOEbRmdk0Bbk522VuUicFp/so6G', 'admin', '2025-07-07 03:01:43'),
(2, 'sample ', 'sample', NULL, '$2y$10$dbG2cz3818ixlLTK/iFke.7AcRfOHkl5MXyB//sVHUs08OZqBp6.i', 'admin', '2025-07-17 05:59:18'),
(3, 'PNP Account', 'pnp', NULL, '<hashed-password>', '', '2025-08-30 07:22:42');

-- --------------------------------------------------------

--
-- Table structure for table `users_backup`
--

CREATE TABLE `users_backup` (
  `id` int(11) NOT NULL DEFAULT 0,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','pnp_admin','pnp_officer','user') NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `id_document` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_backup`
--

INSERT INTO `users_backup` (`id`, `first_name`, `last_name`, `name`, `email`, `contact`, `address`, `password`, `role`, `status`, `id_document`, `created_at`) VALUES
(1, NULL, NULL, 'System Admin', NULL, NULL, NULL, '$2y$10$N0pV8SnQu74b2W2Pu6gaCOKwojNOEbRmdk0Bbk522VuUicFp/so6G', 'admin', 'Pending', NULL, '2025-07-07 11:01:43'),
(2, NULL, NULL, 'sample ', NULL, NULL, NULL, '$2y$10$dbG2cz3818ixlLTK/iFke.7AcRfOHkl5MXyB//sVHUs08OZqBp6.i', 'admin', 'Pending', NULL, '2025-07-17 13:59:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `apprehended_logs`
--
ALTER TABLE `apprehended_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qr_code` (`qr_code`),
  ADD UNIQUE KEY `qr_code_2` (`qr_code`),
  ADD KEY `fk_apprehended_report` (`report_id`),
  ADD KEY `fk_logs_district` (`district_id`),
  ADD KEY `fk_logs_municipality` (`municipality_id`),
  ADD KEY `fk_logs_barangay` (`barangay_id`),
  ADD KEY `fk_logs_offense_category` (`offense_category_id`),
  ADD KEY `fk_logs_offense_type` (`offense_type_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `municipality_id` (`municipality_id`);

--
-- Indexes for table `disposed_conveyance`
--
ALTER TABLE `disposed_conveyance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_id` (`log_id`);

--
-- Indexes for table `disposed_equipment`
--
ALTER TABLE `disposed_equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_id` (`log_id`);

--
-- Indexes for table `disposed_forest_products`
--
ALTER TABLE `disposed_forest_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_id` (`log_id`);

--
-- Indexes for table `disposed_logs`
--
ALTER TABLE `disposed_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_disposed_district` (`district_id`),
  ADD KEY `fk_disposed_municipality` (`municipality_id`),
  ADD KEY `fk_disposed_barangay` (`barangay_id`),
  ADD KEY `fk_disposed_offense_category` (`offense_category_id`),
  ADD KEY `fk_disposed_offense_type` (`offense_type_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_conveyance`
--
ALTER TABLE `log_conveyance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_id` (`log_id`);

--
-- Indexes for table `log_equipment`
--
ALTER TABLE `log_equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_id` (`log_id`);

--
-- Indexes for table `log_forest_products`
--
ALTER TABLE `log_forest_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_id` (`log_id`);

--
-- Indexes for table `municipalities`
--
ALTER TABLE `municipalities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `offense_categories`
--
ALTER TABLE `offense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offense_types`
--
ALTER TABLE `offense_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `personnel_summary`
--
ALTER TABLE `personnel_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pnp_case_assignments`
--
ALTER TABLE `pnp_case_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_case_report` (`report_id`),
  ADD KEY `fk_case_assigned_by` (`assigned_by`),
  ADD KEY `fk_case_assigned_to` (`assigned_to`);

--
-- Indexes for table `pnp_password_resets`
--
ALTER TABLE `pnp_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pnp_users`
--
ALTER TABLE `pnp_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reports_history`
--
ALTER TABLE `reports_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_metadata`
--
ALTER TABLE `report_metadata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seedling_inventory`
--
ALTER TABLE `seedling_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `staff_contributions`
--
ALTER TABLE `staff_contributions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_otp_verification`
--
ALTER TABLE `staff_otp_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `apprehended_logs`
--
ALTER TABLE `apprehended_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1056;

--
-- AUTO_INCREMENT for table `disposed_conveyance`
--
ALTER TABLE `disposed_conveyance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `disposed_equipment`
--
ALTER TABLE `disposed_equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `disposed_forest_products`
--
ALTER TABLE `disposed_forest_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `disposed_logs`
--
ALTER TABLE `disposed_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `log_conveyance`
--
ALTER TABLE `log_conveyance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `log_equipment`
--
ALTER TABLE `log_equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `log_forest_products`
--
ALTER TABLE `log_forest_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `municipalities`
--
ALTER TABLE `municipalities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `offense_categories`
--
ALTER TABLE `offense_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `offense_types`
--
ALTER TABLE `offense_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `personnel_summary`
--
ALTER TABLE `personnel_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pnp_case_assignments`
--
ALTER TABLE `pnp_case_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pnp_password_resets`
--
ALTER TABLE `pnp_password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pnp_users`
--
ALTER TABLE `pnp_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports_history`
--
ALTER TABLE `reports_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `report_metadata`
--
ALTER TABLE `report_metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `seedling_inventory`
--
ALTER TABLE `seedling_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff_contributions`
--
ALTER TABLE `staff_contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `staff_otp_verification`
--
ALTER TABLE `staff_otp_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apprehended_logs`
--
ALTER TABLE `apprehended_logs`
  ADD CONSTRAINT `fk_apprehended_report` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_logs_barangay` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_logs_district` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_logs_municipality` FOREIGN KEY (`municipality_id`) REFERENCES `municipalities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_logs_offense_category` FOREIGN KEY (`offense_category_id`) REFERENCES `offense_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_logs_offense_type` FOREIGN KEY (`offense_type_id`) REFERENCES `offense_types` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `barangays`
--
ALTER TABLE `barangays`
  ADD CONSTRAINT `barangays_ibfk_1` FOREIGN KEY (`municipality_id`) REFERENCES `municipalities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disposed_logs`
--
ALTER TABLE `disposed_logs`
  ADD CONSTRAINT `fk_disposed_barangay` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_disposed_district` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_disposed_municipality` FOREIGN KEY (`municipality_id`) REFERENCES `municipalities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_disposed_offense_category` FOREIGN KEY (`offense_category_id`) REFERENCES `offense_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_disposed_offense_type` FOREIGN KEY (`offense_type_id`) REFERENCES `offense_types` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `log_conveyance`
--
ALTER TABLE `log_conveyance`
  ADD CONSTRAINT `log_conveyance_ibfk_1` FOREIGN KEY (`log_id`) REFERENCES `apprehended_logs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `log_equipment`
--
ALTER TABLE `log_equipment`
  ADD CONSTRAINT `log_equipment_ibfk_1` FOREIGN KEY (`log_id`) REFERENCES `apprehended_logs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `log_forest_products`
--
ALTER TABLE `log_forest_products`
  ADD CONSTRAINT `log_forest_products_ibfk_1` FOREIGN KEY (`log_id`) REFERENCES `apprehended_logs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `municipalities`
--
ALTER TABLE `municipalities`
  ADD CONSTRAINT `municipalities_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offense_types`
--
ALTER TABLE `offense_types`
  ADD CONSTRAINT `offense_types_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `offense_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pnp_case_assignments`
--
ALTER TABLE `pnp_case_assignments`
  ADD CONSTRAINT `fk_case_assigned_by` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_case_assigned_to` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_case_report` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
