-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2024 at 10:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mini_edukasi_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `autosave`
--

CREATE TABLE `autosave` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `autosave`
--

INSERT INTO `autosave` (`id`, `user_id`, `level_id`, `kategori_id`) VALUES
(73, 17, 2, 5),
(74, 17, 3, 5),
(75, 17, 3, 5),
(76, 17, 4, 5),
(77, 17, 4, 5),
(78, 17, 4, 5),
(79, 17, 4, 5),
(80, 17, 4, 5),
(110, 21, 2, 5),
(111, 21, 5, 5),
(120, 21, 2, 5),
(121, 21, 3, 5),
(125, 21, 5, 5),
(126, 21, 2, 3),
(130, 24, 2, 9),
(131, 24, 2, 9),
(132, 24, 3, 9),
(205, 26, 2, 4),
(224, 26, 2, 9),
(225, 26, 3, 9),
(227, 26, 5, 9),
(228, 26, 5, 7),
(263, 26, 2, 3),
(301, 26, 2, 8),
(303, 26, 2, 3),
(308, 26, 2, 3),
(309, 26, 3, 3),
(328, 26, 2, 3),
(355, 26, 2, 3),
(357, 26, 5, 3),
(374, 26, 5, 5),
(392, 26, 2, 4),
(393, 26, 3, 4),
(428, 26, 2, 4),
(429, 26, 2, 4),
(431, 26, 2, 4),
(432, 26, 3, 4),
(447, 26, 2, 9),
(448, 26, 2, 8),
(449, 26, 2, 8),
(460, 21, 5, 3),
(461, 21, 2, 9),
(462, 21, 3, 9),
(463, 21, 5, 9),
(495, 21, 5, 4),
(513, 21, 2, 4),
(541, 21, 2, 4),
(552, 21, 5, 5),
(553, 21, 5, 5),
(554, 21, 5, 5),
(555, 21, 5, 5),
(556, 21, 5, 5),
(557, 21, 5, 5),
(558, 21, 5, 5),
(559, 21, 5, 5),
(560, 21, 5, 5),
(561, 21, 5, 5),
(562, 21, 5, 5),
(563, 21, 5, 5),
(564, 21, 5, 5),
(565, 21, 5, 5),
(566, 21, 5, 5),
(567, 21, 5, 5),
(568, 21, 5, 5),
(569, 21, 5, 5),
(570, 21, 5, 5),
(571, 21, 5, 5),
(572, 21, 5, 5),
(573, 21, 5, 5),
(574, 21, 5, 5),
(575, 21, 5, 5),
(581, 21, 5, 3),
(582, 21, 5, 3),
(584, 21, 5, 3),
(585, 21, 5, 9),
(586, 21, 5, 9),
(587, 21, 5, 9),
(590, 21, 2, 9),
(591, 21, 2, 9),
(595, 21, 5, 9),
(596, 21, 5, 9),
(597, 21, 5, 9);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `kategori`) VALUES
(5, 'Bahasa'),
(9, 'Biologi'),
(8, 'Ekonomi'),
(4, 'Fisika'),
(6, 'Ilmu Sosial'),
(3, 'Matematika'),
(7, 'Teknologi dan Komputer');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`level_id`, `level_name`) VALUES
(1, 'Level 1'),
(2, 'Level 2'),
(3, 'level 3'),
(4, 'level 4'),
(5, 'Level 5');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `pilihan_1` varchar(255) NOT NULL,
  `pilihan_2` varchar(255) NOT NULL,
  `pilihan_3` varchar(255) NOT NULL,
  `pilihan_4` varchar(255) NOT NULL,
  `correct_choice` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `kategori_id`, `level_id`, `question`, `pilihan_1`, `pilihan_2`, `pilihan_3`, `pilihan_4`, `correct_choice`) VALUES
(1, 5, 1, 'Which of the following sentences best uses the passive voice?', '\"The chef prepares the meal with great care.\"\r\n\r\n', '\"The chef was preparing the meal with great care.\"\r\n', '\"The meal is prepared by the chef with great care.\"\r\n', '\"The meal has been prepared by the chef.\"\r\n', '\"The meal is prepared by the chef with great care.\"'),
(2, 5, 2, 'Define \"sustainable development\" in your own words', 'Pembangunan yang memenuhi kebutuhan sekarang tanpa mengorbankan generasi mendatang\r\n', '', '', '', 'Pembangunan yang memenuhi kebutuhan sekarang tanpa mengorbankan generasi mendatang\r\n'),
(3, 5, 3, 'What is the primary function of mitochondria in a cell?', 'Produksi energi (ATP)', '', '', '', 'Produksi energi (ATP)'),
(4, 5, 4, 'In the context of persuasive writing, which of the following best defines the term \"ethos\"?', 'The emotional appeal used to persuade an audience\'s feelings', 'The ethical appeal used to establish the credibility of the speaker\r\n', '', '', 'The ethical appeal used to establish the credibility of the speaker\r\n'),
(5, 5, 5, 'What is the primary theme of the following passage?\r\n\r\n   \"In the quiet village of Ashbury, a mysterious fog rolled in every evening, concealing the streets and houses in a thick, eerie mist. The townspeople whispered about the fog, believing it to be the work of spirits seeking revenge.\"\r\n', ' The impact of weather on daily life', 'The relationship between the natural and supernatural \r\n', 'The resilience of the human spirit', 'The fear of the unknown among townspeople', '4'),
(6, 5, 5, 'Which of the following best interprets the metaphor in this sentence?\r\n\r\n   \"The classroom was a battlefield, with students engaging in intellectual duels.\"\r\n', 'The students were actively debating and challenging each other\'s ideas', 'The students were physically fighting in the classroom', 'The classroom environment was chaotic and disorganized', 'The students were competing in a physical sports event', '1'),
(7, 9, 1, 'Apa fungsi utama klorofil dalam fotosintesis?', 'Menyerap cahaya matahari', 'Menghasilkan oksigen', 'Mengangkut air', 'Menyimpan energi', 'Menyerap cahaya matahari'),
(8, 9, 2, 'Sebutkan jenis asam nukleat yang berperan sebagai materi genetik utama dalam sel.', 'DNA', '', '', '', 'DNA'),
(9, 9, 3, 'Apa nama proses pembelahan sel yang menghasilkan dua sel anak identik?', 'Mitosis', '', '', '', 'Mitosis'),
(10, 9, 4, 'Manakah dari dua enzim berikut yang berperan dalam replikasi DNA?', ' Ligase', 'DNA polimerase', '', '', 'DNA polimerase'),
(11, 9, 5, 'Manakah dari berikut yang merupakan organel sel yang mengandung enzim hidrolitik untuk pencernaan intraseluler?', 'Mitokondria', ' Lisosom', 'Retikulum endoplasma kasar', 'Aparatus Golgi', '2'),
(12, 9, 5, 'Apa peran utama dari hormon insulin dalam tubuh?', 'Meningkatkan kadar gula darah', 'Mengatur kadar kalsium dalam darah', 'Mengurangi kadar gula darah', 'Mempercepat metabolisme lemak', '3'),
(13, 8, 1, 'Apa yang dimaksud dengan inflasi?', 'Penurunan harga barang dan jasa secara umum', 'Kenaikan harga barang dan jasa secara umum', 'Stabilitas harga barang dan jasa', 'Ketidakstabilan nilai mata uang asing', 'Kenaikan harga barang dan jasa secara umum'),
(14, 8, 2, 'Sebutkan salah satu faktor yang dapat menyebabkan inflasi!', 'Permintaan', '', '', '', 'Permintaan'),
(15, 8, 3, 'Apa singkatan dari Produk Domestik Bruto?', 'PDB', '', '', '', 'PDB'),
(16, 8, 4, 'Dalam teori ekonomi, hukum permintaan menyatakan bahwa, dengan asumsi ceteris paribus, ketika harga suatu barang meningkat, maka:', 'Permintaan akan barang tersebut meningkat', 'Permintaan akan barang tersebut menurun', '', '', 'Permintaan akan barang tersebut menurun'),
(17, 8, 5, 'Manakah dari berikut ini yang bukan merupakan jenis pengangguran?', 'Pengangguran struktural', 'Pengangguran siklis', 'Pengangguran friksional', 'Pengangguran spekulatif', '4'),
(18, 8, 5, 'Kebijakan fiskal ekspansif meliputi:', 'Peningkatan pajak dan penurunan pengeluaran pemerintah', 'Penurunan pajak dan peningkatan pengeluaran pemerintah', 'Penurunan pajak dan pengeluaran pemerintah', 'Peningkatan pajak dan pengeluaran pemerintah', '2'),
(19, 4, 1, 'Seorang anak menjatuhkan bola dari ketinggian 20 meter. Jika percepatan gravitasi adalah 9,8 m/s², berapa waktu yang dibutuhkan bola untuk mencapai tanah?', '2 detik', '4 detik', '2,02 detik', '3,02 detik', '2,02 detik'),
(20, 4, 2, 'Apa yang dimaksud dengan refraksi dalam fisika?', 'Pembiasan', '', '', '', 'Pembiasan'),
(21, 4, 3, 'Apa yang dimaksud dengan medan magnet?', 'Gaya', '', '', '', 'Gaya'),
(22, 4, 4, 'Sebuah benda bergerak dengan kecepatan konstan di atas permukaan yang licin tanpa gesekan. Manakah pernyataan berikut yang benar?', 'Benda memerlukan gaya untuk terus bergerak.', 'Benda tidak memerlukan gaya untuk terus bergerak.', '', '', 'Benda tidak memerlukan gaya untuk terus bergerak.'),
(23, 4, 5, 'Jika dua bola yang memiliki massa yang sama bertabrakan secara elastis, dan salah satu bola awalnya diam, apa yang terjadi setelah tumbukan?', 'Bola yang bergerak awalnya berhenti, dan bola yang awalnya diam bergerak dengan kecepatan bola pertama', 'Kedua bola bergerak dengan kecepatan yang sama', 'Bola yang awalnya diam tetap diam', ' Kedua bola berhenti', '1'),
(24, 4, 5, 'Sebuah satelit bergerak mengelilingi bumi pada orbit yang berbentuk lingkaran dengan kecepatan konstan. Apa yang menyebabkan satelit tetap berada di orbitnya?', 'Tidak ada gaya yang bekerja pada satelit', 'Gaya sentrifugal dari rotasi satelit', 'Gaya elektromagnetik antara satelit dan bumi', 'Gaya gravitasi antara satelit dan bumi', '4'),
(25, 6, 1, 'Konsep sosial yang penting dalam ilmu sosial adalah', 'Perubahan Sosial', 'Struktur Sosial', 'Sosialisasi', 'Identitas Sosial', 'Sosialisasi'),
(26, 6, 2, 'Fungsi institusi sosial adalah', ' Stabilitas', '', '', '', ' Stabilitas'),
(27, 6, 3, 'Perbedaan gerakan sosial dan revolusi sosial adalah', 'Kekerasan', '', '', '', 'Kekerasan'),
(28, 6, 4, 'Ciri khas masyarakat industri adalah', 'Tingkat industri yang tinggi', 'Tingkat sektor jasa yang tinggi', '', '', 'Tingkat sektor jasa yang tinggi'),
(29, 6, 5, 'Fitur utama sistem ekonomi kapitalis adalah', ' Pemilikan negara atas industri utama', 'Pemilikan swasta atas industri utama', 'Pemilikan campuran atas industri utama', 'Tidak ada pemilikan swasta atas industri utama', '2'),
(30, 6, 5, 'Konsep utama dalam teori hubungan internasional adalah', 'Realisme', 'Liberalisme', 'Konstruktivisme', 'Marxisme', '1'),
(31, 3, 1, 'Diketahui sebuah persegi dengan panjang sisi 𝑠.Berapakah keliling persegi tersebut?', 's×s', '2×s', '4×s', 's+s', '4×s'),
(32, 3, 2, 'Sebuah segitiga memiliki panjang alas a=6 cm dan tinggi t=4 cm. Berapakah luas segitiga tersebut?', '12', '', '', '', '12'),
(33, 3, 3, 'Hitunglah luas jajaran genjang yang memiliki panjang alas a=8 dan tinggi t=5!', '40', '', '', '', '40'),
(34, 3, 4, 'Sebuah trapesium memiliki panjang sisi sejajar a=8 dan b=6, serta tinggi t=4. Hitunglah luas trapesium tersebut!', '32', '24', '', '', '24'),
(35, 3, 5, 'Sebuah bola diletakkan di dalam sebuah kubus dengan panjang rusuk 10. Berapakah volume kubus tersebut?', '1000', '5000', '10000', '2000', '3'),
(36, 3, 5, 'Sebuah roda sepeda berputar dengan kecepatan 120 putaran per menit. Berapakah kecepatan linear ujung dari roda tersebut jika jari-jarinya 30 cm?', '12π cm/s', '6π cm/s', '24π cm/s', '18π cm/s', '4'),
(37, 7, 1, 'Manakah di antara ini yang bukan merupakan jenis sistem operasi komputer?', 'Windows', 'iOS', ' Android', 'Microsoft Office', 'Microsoft Office\r\n\r\n'),
(38, 7, 2, 'Apa yang dimaksud dengan perangkat lunak (software)?', 'Program', '', '', '', 'Program'),
(39, 7, 3, 'Apa yang dimaksud dengan cloud computing ?', 'Internet', '', '', '', 'Internet'),
(40, 7, 4, 'Dua perangkat keras berikut, manakah yang biasanya tidak termasuk dalam sebuah komputer?', 'Router', 'Modem', '', '', 'Router'),
(41, 7, 5, 'Apa yang dimaksud dengan \"artificial intelligence\" (kecerdasan buatan)?', 'Komputer yang berfungsi secara otomatis tanpa pengawasan manusia', 'Proses mengotomatisasi tugas-tugas rumit dalam bisnis', 'Teknologi yang memungkinkan komputer untuk belajar dari pengalaman', ' Algoritma untuk mengamankan data pribadi', '3'),
(42, 7, 5, 'Manakah yang bukan merupakan jenis-jenis jaringan komputer?', 'LAN', 'WAN', 'PAN', 'USB', '4');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `role` varchar(11) NOT NULL,
  `score` int(50) NOT NULL,
  `last_selected_kategori_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `foto`, `role`, `score`, `last_selected_kategori_id`) VALUES
(17, 'Ali Husein', 'alihusein', 'muhammadalihusein@gmail.com', 'uploads/ali husein.jpg', '0', 2100, 5),
(19, 'Mahmud', 'mahmud', 'mahmudtajinan@gmail.com', 'uploads/channels4_profile.jpg', '0', 500, NULL),
(20, 'Ratsel Group', 'Ratsel', 'RatselGroup@gmail.com', 'uploads/20240516_183458.png', '0', 400, NULL),
(21, 'Dhanang', 'dhanang', 'dhanangfitrah@gmail.com', 'uploads/11203082_10204380652257354_2781648511060668916_n.jpg', '0', 9535, 9),
(23, 'Okta', 'okta', 'oktavia@gmail.com', 'uploads/Mejakita Docker 2.PNG', '', 1200, 5),
(24, 'tiara', '12345678', 'tiara@gmail.com', 'uploads/admin1.jpg', '', 7600, 3),
(26, 'user', 'user', 'user@gmail.com', 'uploads/admin1.jpg', '', 3400, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autosave`
--
ALTER TABLE `autosave`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `level_id` (`level_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`),
  ADD KEY `kategori` (`kategori`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `score` (`score`),
  ADD KEY `last_selected_kategori_id` (`last_selected_kategori_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autosave`
--
ALTER TABLE `autosave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=599;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `autosave`
--
ALTER TABLE `autosave`
  ADD CONSTRAINT `autosave_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `autosave_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `levels` (`level_id`),
  ADD CONSTRAINT `autosave_ibfk_3` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`),
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `levels` (`level_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`last_selected_kategori_id`) REFERENCES `kategori` (`kategori_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
