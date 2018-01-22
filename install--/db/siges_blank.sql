-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 15, 2016 at 06:03 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `siges_blank_`
--

-- --------------------------------------------------------

--
-- Table structure for table `academicperiods`
--

CREATE TABLE `academicperiods` (
`id` int(11) NOT NULL,
  `name_period` varchar(45) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `is_year` tinyint(1) DEFAULT NULL,
  `previous_academic_year` int(11) NOT NULL COMMENT 'Annee academique precedente',
  `year` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `accounting`
--

CREATE TABLE `accounting` (
`id` int(11) NOT NULL,
  `old_balance` double NOT NULL,
  `expenses` double NOT NULL,
  `incomes` double NOT NULL,
  `new_balance` double NOT NULL,
  `month` int(3) NOT NULL,
  `academic_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
`id` int(11) NOT NULL,
  `action_id` varchar(64) NOT NULL,
  `action_name` varchar(64) NOT NULL,
  `controller` varchar(64) NOT NULL,
  `module_id` int(11) NOT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=335 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `action_id`, `action_name`, `controller`, `module_id`, `create_date`, `update_date`, `create_by`, `update_by`) VALUES
(1, 'index', 'Lister les utilisateurs', 'User', 5, NULL, NULL, NULL, NULL),
(2, 'create', 'Creation d''utilisateur', 'User', 5, NULL, NULL, NULL, NULL),
(3, 'update', 'Mise a jour d''un utilisateur', 'User', 5, NULL, NULL, NULL, NULL),
(4, 'delete', 'Suppression d''un utilisateur', 'User', 5, NULL, NULL, NULL, NULL),
(5, 'view', 'Affichage d''un utilisateur', 'User', 5, NULL, NULL, NULL, NULL),
(6, 'changePassword', 'Modification du mot de passe', 'User', 5, NULL, NULL, NULL, NULL),
(7, 'updateUser', 'Mise a jour d''un utilisateur en mode vue', 'User', 5, NULL, NULL, NULL, NULL),
(8, 'disableusers', 'Lister les utilisateurs inactifs', 'User', 5, NULL, NULL, NULL, NULL),
(9, 'listForReport', 'Liste personne pour rapport', 'Persons', 9, NULL, NULL, NULL, NULL),
(10, 'viewForReport', 'Vue personne pour rapport', 'Persons', 9, NULL, NULL, NULL, NULL),
(11, 'list', 'Liste eleve ', 'Persons', 9, NULL, NULL, NULL, NULL),
(12, 'update', 'mise a jour d''une personne', 'Persons', 9, NULL, NULL, NULL, NULL),
(13, 'roomAffectation', 'Affecter des eleves a une salle', 'Persons', 9, NULL, NULL, NULL, NULL),
(14, 'create', 'Ajouter une nouvelle personne', 'Persons', 9, NULL, NULL, NULL, NULL),
(15, 'listArchive', 'Liste des personnes inactifs ', 'Persons', 9, NULL, NULL, NULL, NULL),
(16, 'exTeachers', 'Liste des anciens professeurs', 'Persons', 9, NULL, NULL, NULL, NULL),
(17, 'exEmployees', 'Liste des anciens employes', 'Persons', 9, NULL, NULL, NULL, NULL),
(18, 'exStudents', 'Liste des anciens eleves', 'Persons', 9, NULL, NULL, NULL, NULL),
(19, 'delete', 'Suppression d''une personne', 'Persons', 9, NULL, NULL, NULL, NULL),
(20, 'index', 'Liste des eleves ayant des infos additinnelles', 'StudentOtherInfo', 9, NULL, NULL, NULL, NULL),
(21, 'create', 'Creation des infos additinnelles pour un eleve', 'StudentOtherInfo', 9, NULL, NULL, NULL, NULL),
(22, 'update', 'Mise a jour des infos additinnelles pour eleve', 'StudentOtherInfo', 9, NULL, NULL, NULL, NULL),
(23, 'view', 'Affichage des infos additinnelles pour eleve', 'StudentOtherInfo', 9, NULL, NULL, NULL, NULL),
(24, 'delete', 'Suppression d''info additionnelle', 'StudentOtherInfo', 9, NULL, NULL, NULL, NULL),
(25, 'index', 'Liste des employes ayant des infos additinnelles', 'Employeeinfo', 9, NULL, NULL, NULL, NULL),
(26, 'create', 'Creation des infos additionnelles pour employe', 'Employeeinfo', 9, NULL, NULL, NULL, NULL),
(27, 'update', 'Mis a jour des infos additinnelles pour employe', 'Employeeinfo', 9, NULL, NULL, NULL, NULL),
(28, 'view', 'Affichage des infos additinnelles pour employe', 'Employeeinfo', 9, NULL, NULL, NULL, NULL),
(29, 'delete', 'Suppression d''info additionnelle pour employe', 'Employeeinfo', 9, NULL, NULL, NULL, NULL),
(30, 'index', 'Liste de contact', 'ContactInfo', 9, NULL, NULL, NULL, NULL),
(31, 'create', 'Creation de contact pour chaque personne', 'ContactInfo', 9, NULL, NULL, NULL, NULL),
(32, 'update', 'mise a jour de contact pour une personne', 'ContactInfo', 9, NULL, NULL, NULL, NULL),
(33, 'view', 'Affichage de contact pour une personne', 'ContactInfo', 9, NULL, NULL, NULL, NULL),
(34, 'delete', 'Suppression de contact pour une personne', 'ContactInfo', 9, NULL, NULL, NULL, NULL),
(35, 'index', 'Liste des departements ayant des employes', 'DepartmentHasPerson', 9, NULL, NULL, NULL, NULL),
(36, 'create', 'Ajouter un employe dans un departement', 'DepartmentHasPerson', 9, NULL, NULL, NULL, NULL),
(37, 'update', 'Mise a jour d''un employe dans un departement', 'DepartmentHasPerson', 9, NULL, NULL, NULL, NULL),
(38, 'view', 'Affichage d''un employe dans un departement ', 'DepartmentHasPerson', 9, NULL, NULL, NULL, NULL),
(39, 'delete', 'Suppression d''un employe dans un departement', 'DepartmentHasPerson', 9, NULL, NULL, NULL, NULL),
(40, 'index', 'Liste de notes de tous les eleves', 'Grades', 9, NULL, NULL, NULL, NULL),
(41, 'create', 'Ajouter une nouvelle note pour un eleve', 'Grades', 9, NULL, NULL, NULL, NULL),
(42, 'update', 'Mise a jour d''une note pour un eleve', 'Grades', 9, NULL, NULL, NULL, NULL),
(43, 'view', 'Affichage d''une note pour un eleve', 'Grades', 9, NULL, NULL, NULL, NULL),
(44, 'delete', 'Suppression d''une note', 'Grades', 9, NULL, NULL, NULL, NULL),
(45, 'listByRoom', 'Affichage des notes par salle', 'Grades', 9, NULL, NULL, NULL, NULL),
(46, 'balance', 'Liste des eleves ayant une balance sup. a zero', 'Balance', 8, NULL, NULL, NULL, NULL),
(47, 'view', 'Affichage de balance pour un eleve', 'Balance', 8, NULL, NULL, NULL, NULL),
(48, 'create', 'Creation de balance pour un eleve', 'Balance', 8, NULL, NULL, NULL, NULL),
(49, 'update', 'Mise a jour d''une balance pour un eleve', 'Balance', 8, NULL, NULL, NULL, NULL),
(50, 'index', 'Liste des transactions des eleves avec l''economat', 'Billings', 8, NULL, NULL, NULL, NULL),
(51, 'create', 'Ajouter d''une nouvelle transaction pour un eleve', 'Billings', 8, NULL, NULL, NULL, NULL),
(52, 'update', 'Mise a jour d''une transaction pour un eleve', 'Billings', 8, NULL, NULL, NULL, NULL),
(53, 'view', 'Affichage d''une transaction pour un eleve', 'Billings', 8, NULL, NULL, NULL, NULL),
(54, 'delete', 'Suppression d''une transaction', 'Billings', 8, NULL, NULL, NULL, NULL),
(55, 'generalReport', 'Affichage d''un rapport general', 'Reportcard', 6, NULL, NULL, NULL, NULL),
(56, 'create', 'Creation de bulletin pour une salle', 'Reportcard', 6, NULL, NULL, NULL, NULL),
(57, 'report', 'Affichage d''un bulletin d''un eleve', 'Reportcard', 6, NULL, NULL, NULL, NULL),
(58, 'admitted', 'Liste des admis par salle', 'Reportcard', 6, NULL, NULL, NULL, NULL),
(59, 'endYearDecision', 'Prise de decision de fin d''annee', 'Reportcard', 6, NULL, NULL, NULL, NULL),
(60, 'index', 'Liste des cours de l''ecole', 'Courses', 7, NULL, NULL, NULL, NULL),
(61, 'create', 'Creation d''un nouveau cours', 'Courses', 7, NULL, NULL, NULL, NULL),
(62, 'update', 'Mise a jour d''un cours', 'Courses', 7, NULL, NULL, NULL, NULL),
(63, 'view', 'Affichage d''un cours', 'Courses', 7, NULL, NULL, NULL, NULL),
(64, 'viewForTeacher', 'Liste des cours de l''ecole pour professeur', 'Courses', 7, NULL, NULL, NULL, NULL),
(65, 'delete', 'Suppression d''un cours', 'Courses', 7, NULL, NULL, NULL, NULL),
(66, 'index', 'Liste des matieres enseignees ', 'Subjects', 7, NULL, NULL, NULL, NULL),
(67, 'create', 'Ajouter une nouvelle matiere', 'Subjects', 7, NULL, NULL, NULL, NULL),
(68, 'update', 'Mise a jour d''une matiere', 'Subjects', 7, NULL, NULL, NULL, NULL),
(69, 'view', 'Affichage d''une matiere', 'Subjects', 7, NULL, NULL, NULL, NULL),
(70, 'delete', 'Suppression d''une matiere', 'Subjects', 7, NULL, NULL, NULL, NULL),
(71, 'index', 'Liste des evaluations pour chaque periode', 'Evaluationbyyear', 7, NULL, NULL, NULL, NULL),
(72, 'create', 'Creation d''une nouvelle evaluation pour une periode', 'Evaluationbyyear', 7, NULL, NULL, NULL, NULL),
(73, 'update', 'Mise a jour d''une evaluation pour une periode', 'Evaluationbyyear', 7, NULL, NULL, NULL, NULL),
(74, 'view', 'Affichage d''une evaluation pour une periode', 'Evaluationbyyear', 7, NULL, NULL, NULL, NULL),
(75, 'delete', 'Suppression d''une evaluation pour une periode', 'Evaluationbyyear', 7, NULL, NULL, NULL, NULL),
(76, 'index', 'Liste des heures de cours par une salle', 'Schedules', 7, NULL, NULL, NULL, NULL),
(77, 'create', 'Ajouter d''une heure de cours pour une salle', 'Schedules', 7, NULL, NULL, NULL, NULL),
(78, 'update', 'Mise a jour d''une heure de cours', 'Schedules', 7, NULL, NULL, NULL, NULL),
(79, 'view', 'Affichage d''une heure de cours pour une salle', 'Schedules', 7, NULL, NULL, NULL, NULL),
(80, 'viewForTeacher', 'Liste des heures de cours pour professeur', 'Schedules', 7, NULL, NULL, NULL, NULL),
(81, 'viewForUpdate', 'Liste des heures de cours pret a etre modifier', 'Schedules', 7, NULL, NULL, NULL, NULL),
(82, 'delete', 'Suppression d''une heure de cours', 'Schedules', 7, NULL, NULL, NULL, NULL),
(83, 'index', 'Liste des periodes academiques', 'Academicperiods', 1, NULL, NULL, NULL, NULL),
(84, 'create', 'Creation d''une nouvelle periode academique', 'Academicperiods', 1, NULL, NULL, NULL, NULL),
(85, 'update', 'Mise a jour d''une periode academique', 'Academicperiods', 1, NULL, NULL, NULL, NULL),
(86, 'view', 'Affichage d''une periode academique', 'Academicperiods', 1, NULL, NULL, NULL, NULL),
(87, 'delete', 'Suppression d''une periode academique', 'Academicperiods', 1, NULL, NULL, NULL, NULL),
(88, 'index', 'Liste des departements de l''ecole', 'DepartmentInSchool', 1, NULL, NULL, NULL, NULL),
(89, 'create', 'Creation d''un nouveau departement de l''ecole', 'DepartmentInSchool', 1, NULL, NULL, NULL, NULL),
(90, 'update', 'Mise a jour d''un departement de l''ecole', 'DepartmentInSchool', 1, NULL, NULL, NULL, NULL),
(91, 'view', 'Affichage d''un departement de l''ecole', 'DepartmentInSchool', 1, NULL, NULL, NULL, NULL),
(92, 'delete', 'Suppression d''un departement de l''ecole', 'DepartmentInSchool', 1, NULL, NULL, NULL, NULL),
(93, 'index', 'Liste des devises acceptees a l''ecole', 'Devises', 1, NULL, NULL, NULL, NULL),
(94, 'create', 'Ajouter une nouvelle devise', 'Devises', 1, NULL, NULL, NULL, NULL),
(95, 'update', 'Mise a jour d''une devise', 'Devises', 1, NULL, NULL, NULL, NULL),
(96, 'view', 'Affichage d''une devise', 'Devises', 1, NULL, NULL, NULL, NULL),
(97, 'delete', 'Suppression d''une devise', 'Devises', 1, NULL, NULL, NULL, NULL),
(98, 'index', 'Liste des evaluations de l''ecole', 'Evaluations', 1, NULL, NULL, NULL, NULL),
(99, 'create', 'Ajouter une nouvelle evaluation', 'Evaluations', 1, NULL, NULL, NULL, NULL),
(100, 'update', 'Mise a jour d''une evaluation', 'Evaluations', 1, NULL, NULL, NULL, NULL),
(101, 'view', 'Affichage d''une evaluation', 'Evaluations', 1, NULL, NULL, NULL, NULL),
(102, 'delete', 'Suppression d''une evaluation', 'Evaluations', 1, NULL, NULL, NULL, NULL),
(103, 'index', 'Liste des frais exigees par l''ecole', 'Fees', 1, NULL, NULL, NULL, NULL),
(104, 'create', 'Ajouter un nouveau frais', 'Fees', 1, NULL, NULL, NULL, NULL),
(105, 'update', 'Mise a jour d''un frais', 'Fees', 1, NULL, NULL, NULL, NULL),
(106, 'view', 'Affichage d''un frais', 'Fees', 1, NULL, NULL, NULL, NULL),
(107, 'delete', 'Suppression d''un frais', 'Fees', 1, NULL, NULL, NULL, NULL),
(108, 'index', 'Liste des domaines d''etude des employes', 'Fieldstudy', 1, NULL, NULL, NULL, NULL),
(109, 'create', 'Ajouter un nouveau domaine d''etude', 'Fieldstudy', 1, NULL, NULL, NULL, NULL),
(110, 'update', 'Mise a jour d''un domaine d''etude', 'Fieldstudy', 1, NULL, NULL, NULL, NULL),
(111, 'view', 'Affichage d''un domaine d''etude', 'Fieldstudy', 1, NULL, NULL, NULL, NULL),
(112, 'delete', 'Suppression d''un domaine d''etude', 'Fieldstudy', 1, NULL, NULL, NULL, NULL),
(113, 'index', 'Liste des champs de configuration generale', 'Generalconfig', 1, NULL, NULL, NULL, NULL),
(114, 'admin', 'Liste des champs de configuration generale Pret a modifier', 'Generalconfig', 1, NULL, NULL, NULL, NULL),
(115, 'create', 'Creation d''un nouveau champ de configuration generale', 'Generalconfig', 1, NULL, NULL, NULL, NULL),
(116, 'update', 'Mise a jour d''un champ de configuration generale', 'Generalconfig', 1, NULL, NULL, NULL, NULL),
(117, 'view', 'Affichage d''un champ de configuration generale', 'Generalconfig', 1, NULL, NULL, NULL, NULL),
(118, 'delete', 'Suppression d''un champ de configuration generale', 'Generalconfig', 1, NULL, NULL, NULL, NULL),
(119, 'index', 'Liste des statuts d''emploi', 'Jobstatus', 1, NULL, NULL, NULL, NULL),
(120, 'create', 'Creation d''un nouveau statut d''emploi', 'Jobstatus', 1, NULL, NULL, NULL, NULL),
(121, 'update', 'Mise a jour d''un statut d''emploi', 'Jobstatus', 1, NULL, NULL, NULL, NULL),
(122, 'view', 'Affichage d''un statut d''emploi', 'Jobstatus', 1, NULL, NULL, NULL, NULL),
(123, 'delete', 'Suppression d''un statut d''emploi', 'Jobstatus', 1, NULL, NULL, NULL, NULL),
(124, 'index', 'Liste des differents niveaux d''etude', 'Levels', 1, NULL, NULL, NULL, NULL),
(125, 'create', 'Creation d''un nouveau niveau d''etude', 'Levels', 1, NULL, NULL, NULL, NULL),
(126, 'update', 'Mise a jour d''un niveau d''etude', 'Levels', 1, NULL, NULL, NULL, NULL),
(127, 'view', 'Affichage d''un niveau d''etude', 'Levels', 1, NULL, NULL, NULL, NULL),
(128, 'delete', 'Suppression d''un niveau d''etude', 'Levels', 1, NULL, NULL, NULL, NULL),
(129, 'index', 'Liste des notes de passage de l''ecole', 'Passinggrades', 1, NULL, NULL, NULL, NULL),
(130, 'create', 'Creation d''une nouvelle note de passage', 'Passinggrades', 1, NULL, NULL, NULL, NULL),
(131, 'update', 'Mise a jour d''une note de passage', 'Passinggrades', 1, NULL, NULL, NULL, NULL),
(132, 'view', 'Affichage d''une note de passage', 'Passinggrades', 1, NULL, NULL, NULL, NULL),
(133, 'delete', 'Suppression d''une note de passage', 'Passinggrades', 1, NULL, NULL, NULL, NULL),
(134, 'index', 'Liste des methodes de paiement exigees par l''ecole', 'Paymentmethod', 1, NULL, NULL, NULL, NULL),
(135, 'create', 'Creation d''une nouvelle methode de paiement', 'Paymentmethod', 1, NULL, NULL, NULL, NULL),
(136, 'update', 'Mise a jour d''une methode de paiement', 'Paymentmethod', 1, NULL, NULL, NULL, NULL),
(137, 'view', 'Affichage d''une methode de paiement', 'Paymentmethod', 1, NULL, NULL, NULL, NULL),
(138, 'delete', 'Suppression d''une methode de paiement', 'Paymentmethod', 1, NULL, NULL, NULL, NULL),
(139, 'index', 'Liste des differents titres de qualification', 'Qualifications', 1, NULL, NULL, NULL, NULL),
(140, 'create', 'Creation d''un nouveau titre de qualification', 'Qualifications', 1, NULL, NULL, NULL, NULL),
(141, 'update', 'Mise a jour d''un titre de qualification', 'Qualifications', 1, NULL, NULL, NULL, NULL),
(142, 'view', 'Affichage d''un titre de qualification', 'Qualifications', 1, NULL, NULL, NULL, NULL),
(143, 'delete', 'Suppression d''un titre de qualification', 'Qualifications', 1, NULL, NULL, NULL, NULL),
(144, 'index', 'Liste de relations eleve et responsable', 'Relations', 1, NULL, NULL, NULL, NULL),
(145, 'create', 'Creation d''un nouveau titre de relation', 'Relations', 1, NULL, NULL, NULL, NULL),
(146, 'update', 'Mise a jour d''un titre de relation', 'Relations', 1, NULL, NULL, NULL, NULL),
(147, 'view', 'Affichage d''un titre de relation', 'Relations', 1, NULL, NULL, NULL, NULL),
(148, 'delete', 'Suppression d''un titre de relation', 'Relations', 1, NULL, NULL, NULL, NULL),
(149, 'index', 'Liste de toutes les salles de classe', 'Rooms', 1, NULL, NULL, NULL, NULL),
(150, 'create', 'Creation d''une nouvelle salle de classe', 'Rooms', 1, NULL, NULL, NULL, NULL),
(151, 'update', 'Mise a jour d''une salle de classe', 'Rooms', 1, NULL, NULL, NULL, NULL),
(152, 'view', 'Affichage d''une salle de classe', 'Rooms', 1, NULL, NULL, NULL, NULL),
(153, 'delete', 'Suppression d''une salle de classe', 'Rooms', 1, NULL, NULL, NULL, NULL),
(154, 'index', 'Liste de toutes les sections de l''ecole', 'Sections', 1, NULL, NULL, NULL, NULL),
(155, 'create', 'Creation d''une nouvelle section', 'Sections', 1, NULL, NULL, NULL, NULL),
(156, 'update', 'Mise a jour d''une section', 'Sections', 1, NULL, NULL, NULL, NULL),
(157, 'view', 'Affichage d''une section', 'Sections', 1, NULL, NULL, NULL, NULL),
(158, 'delete', 'Suppression d''une section', 'Sections', 1, NULL, NULL, NULL, NULL),
(159, 'index', 'Liste de toutes les vacations de l''ecole', 'Shifts', 1, NULL, NULL, NULL, NULL),
(160, 'create', 'Creation d''une nouvelle vacation', 'Shifts', 1, NULL, NULL, NULL, NULL),
(161, 'update', 'Mise a jour d''une vacation', 'Shifts', 1, NULL, NULL, NULL, NULL),
(162, 'view', 'Affichage d''une vacation', 'Shifts', 1, NULL, NULL, NULL, NULL),
(163, 'delete', 'Suppression d''une vacation', 'Shifts', 1, NULL, NULL, NULL, NULL),
(164, 'index', 'Liste des positions administratives', 'Titles', 1, NULL, NULL, NULL, NULL),
(165, 'create', 'Creation d''une nouvelle position', 'Titles', 1, NULL, NULL, NULL, NULL),
(166, 'update', 'Mise a jour d''une position', 'Titles', 1, NULL, NULL, NULL, NULL),
(167, 'view', 'Affichage d''une position', 'Titles', 1, NULL, NULL, NULL, NULL),
(168, 'delete', 'Suppression d''une position', 'Titles', 1, NULL, NULL, NULL, NULL),
(169, 'index', 'Liste de toutes les modules du systeme', 'Modules', 5, NULL, NULL, NULL, NULL),
(170, 'create', 'Creation d''une nouvelle module du systeme', 'Modules', 5, NULL, NULL, NULL, NULL),
(171, 'update', 'Mise a jour d''une module', 'Modules', 5, NULL, NULL, NULL, NULL),
(172, 'view', 'Affichage d''une module', 'Modules', 5, NULL, NULL, NULL, NULL),
(173, 'delete', 'Suppression d''une module', 'Modules', 5, NULL, NULL, NULL, NULL),
(174, 'index', 'Liste de tous les groupes utilisateur du systeme', 'Groups', 5, NULL, NULL, NULL, NULL),
(175, 'create', 'Creation d''un nouveau groupe utilisateur', 'Groups', 5, NULL, NULL, NULL, NULL),
(176, 'update', 'Mise a jour d''un groupe utilisateur', 'Groups', 5, NULL, NULL, NULL, NULL),
(177, 'view', 'Affichage d''un groupe utilisateur', 'Groups', 5, NULL, NULL, NULL, NULL),
(178, 'delete', 'Suppression d''un groupe utilisateur', 'Groups', 5, NULL, NULL, NULL, NULL),
(179, 'index', 'Liste de toutes les actions autorisees du systeme', 'Actions', 5, NULL, NULL, NULL, NULL),
(180, 'create', 'Creation d''une nouvelle action', 'Actions', 5, NULL, NULL, NULL, NULL),
(181, 'update', 'Mise a jour d''une action', 'Actions', 5, NULL, NULL, NULL, NULL),
(182, 'view', 'Affichage d''une action', 'Actions', 5, NULL, NULL, NULL, NULL),
(183, 'delete', 'Suppression d''une action', 'Actions', 5, NULL, NULL, NULL, NULL),
(184, 'validatePublish', 'Validation et Publication des notes', 'Grades', 9, NULL, NULL, NULL, NULL),
(185, 'index', 'Liste des periodes academiques pour INVITE', 'Academicperiods', 10, NULL, NULL, NULL, NULL),
(186, 'balance', 'Liste des eleves ayant une balance sup. a zero  pour INVITE', 'Balance', 10, NULL, NULL, NULL, NULL),
(187, 'index', 'Liste des transactions des eleves avec l''economat  pour INVITE', 'Billings', 10, NULL, NULL, NULL, NULL),
(188, 'view', 'Affichage des info personnelles parent', 'ContactInfo', 10, NULL, NULL, NULL, NULL),
(189, 'update', 'Mise a jour des infos personnelles parent', 'ContactInfo', 10, NULL, NULL, NULL, NULL),
(190, 'index', 'Liste des cours que suit l''eleve', 'Courses', 10, NULL, NULL, NULL, NULL),
(191, 'index', 'Liste des evaluations pour chaque periode  pour INVITE', 'Evaluationbyyear', 10, NULL, NULL, NULL, NULL),
(192, 'index', 'Liste des frais exigees par l''ecole  pour INVITE', 'Fees', 10, NULL, NULL, NULL, NULL),
(193, 'index', 'Liste des notes (publiees) de l''eleve', 'Grades', 10, NULL, NULL, NULL, NULL),
(194, 'index', 'Liste des notes de passage de l''ecole  pour INVITE', 'Passinggrades', 10, NULL, NULL, NULL, NULL),
(195, 'index', 'Liste des methodes de paiement exigees par l''ecole  pour INVITE', 'Paymentmethod', 10, NULL, NULL, NULL, NULL),
(196, 'report', 'Affichage du bulletin de l''eleve  pour INVITE', 'Reportcard', 10, NULL, NULL, NULL, NULL),
(197, 'index', 'Liste des heures de cours de l''eleve  pour INVITE', 'Schedules', 10, NULL, NULL, NULL, NULL),
(198, 'view', 'Affichage des info personnelles eleve', 'StudentOtherInfo', 10, NULL, NULL, NULL, NULL),
(200, 'index', 'Liste des matieres enseignees,  pour INVITE', 'Subjects', 10, NULL, NULL, NULL, NULL),
(201, 'viewcontact', 'Vue des contacts de l''utilisateur', 'ContactInfo', 9, NULL, NULL, NULL, NULL),
(202, 'updateMyContacts', 'Mise a jour de contacts par l''utilisateur', 'ContactInfo', 9, NULL, NULL, NULL, NULL),
(203, 'viewForUpdate', 'Modifier info personnelle utilisateur', 'Persons', 9, NULL, NULL, NULL, NULL),
(204, 'updateMyInfo', 'Mise a jour des infos personnelles utilisateur systeme', 'Persons', 9, NULL, NULL, NULL, NULL),
(205, 'updateParent', 'Mise a jour des infos personnelles d''un parent', 'ContactInfo', 10, NULL, NULL, NULL, NULL),
(206, 'viewForUpdate', 'Mise a jour des infos personnelles d''un eleve ....', 'Persons', 10, NULL, NULL, NULL, NULL),
(207, 'updateMyInfo', 'Mise a jour des infos personnelles utilisateur eleve', 'Persons', 10, NULL, NULL, NULL, NULL),
(208, 'index', 'Lister emails', 'Mails', 9, NULL, NULL, NULL, NULL),
(209, 'sendEmail', 'Envoyer Email', 'Persons', 9, NULL, NULL, NULL, NULL),
(210, 'index', 'Affiche le calendrier', 'Calendar', 7, NULL, NULL, NULL, NULL),
(211, 'create', 'Ajouter évenements', 'Calendar', 7, NULL, NULL, NULL, NULL),
(212, 'update', 'Modifier un évenement', 'Calendar', 7, NULL, NULL, NULL, NULL),
(213, 'delete', 'Supprimer un évenement', 'Calendar', 7, NULL, NULL, NULL, NULL),
(214, 'view', 'Voir un évenement en mode admin', 'Calendar', 7, NULL, NULL, NULL, NULL),
(215, 'viewForIndex', 'Voir un évenement en mode utilisateur', 'Calendar', 7, NULL, NULL, NULL, NULL),
(216, 'calendarEvents', 'Evenement du calendrier', 'Calendar', 7, NULL, NULL, NULL, NULL),
(217, 'calendarEvents', 'Evenement du calendrier pour invites', 'Calendar', 10, NULL, NULL, NULL, NULL),
(218, 'viewForIndex', 'afficher les evenements en mod utili', 'Calendar', 10, NULL, NULL, NULL, NULL),
(219, 'viewOnlineUsers', 'Voir les utilisateurs connectés', 'User', 5, NULL, NULL, NULL, NULL),
(220, 'viewDecision', 'Voir la liste de decision finale', 'Reportcard', 6, NULL, NULL, NULL, NULL),
(221, 'classSetup', 'Formation des classes', 'Persons', 9, NULL, NULL, NULL, NULL),
(222, 'create', 'Ajouter une nouvelle configuration payroll', 'PayrollSettings', 8, NULL, NULL, NULL, NULL),
(223, 'update', 'Modifier  configuration payroll', 'PayrollSettings', 8, NULL, NULL, NULL, NULL),
(224, 'index', 'Affichage des configurations payroll', 'PayrollSettings', 8, NULL, NULL, NULL, NULL),
(225, 'view', 'Voir configuration payroll', 'PayrollSettings', 8, NULL, NULL, NULL, NULL),
(226, 'paverage', 'Palmares des moyennes', 'Reportcard', 6, NULL, NULL, NULL, NULL),
(227, 'admission', 'Admission des postulants', 'Persons', 9, NULL, NULL, NULL, NULL),
(228, 'viewListAdmission', 'Voir la liste d''admission', 'Persons', 9, NULL, NULL, NULL, NULL),
(229, 'levelRoomAffectation', 'Affectation a un niveau et/ou a une salle', 'Persons', 9, NULL, NULL, NULL, NULL),
(230, 'viewDetailAdmission', 'Afficher toutes les info d''une admission', 'Persons', 9, NULL, NULL, NULL, NULL),
(231, 'index', 'Liste des devoirs soumis par les professeurs', 'Homework', 9, NULL, NULL, NULL, NULL),
(232, 'create', 'Ajouter un devoir', 'Homework', 9, NULL, NULL, NULL, NULL),
(233, 'update', 'Modifier un devoir soumis par les professeurs', 'Homework', 9, NULL, NULL, NULL, NULL),
(234, 'view', '	Afficher les info d''un devoir soumis par un professeur', 'Homework', 9, NULL, NULL, NULL, NULL),
(235, 'index', 'Lister les devoirs soumis par des professeurs', 'Homework', 10, NULL, NULL, NULL, NULL),
(236, 'view', 'Afficher les devoirs soumis par des professeurs', 'Homework', 10, NULL, NULL, NULL, NULL),
(237, 'index', 'Lister les devoirs soumis par des professeurs', 'homeworkSubmission', 10, NULL, NULL, NULL, NULL),
(238, 'create', 'Soumettre un devoir', 'homeworkSubmission', 10, NULL, NULL, NULL, NULL),
(239, 'generalReport', 'Affichage d''un rapport general pour INVITE', 'Reportcard', 10, NULL, NULL, NULL, NULL),
(240, 'index', 'Liste type d''infraction', 'InfractionType', 11, NULL, NULL, NULL, NULL),
(241, 'create', 'Créer type d''infraction', 'InfractionType', 11, NULL, NULL, NULL, NULL),
(242, 'view', 'Voir type d''infraction', 'InfractionType', 11, NULL, NULL, NULL, NULL),
(243, 'update', 'Modifier type d''infraction', 'InfractionType', 11, NULL, NULL, NULL, NULL),
(244, 'delete', 'Supprimer type d''infraction', 'InfractionType', 11, NULL, NULL, NULL, NULL),
(245, 'index', 'Liste des enregistrements d''infraction', 'RecordInfraction', 11, NULL, NULL, NULL, NULL),
(246, 'create', 'Créer enregistrement d''infraction', 'RecordInfraction', 11, NULL, NULL, NULL, NULL),
(247, 'update', 'Modifier enregistrement d''infraction', 'RecordInfraction', 11, NULL, NULL, NULL, NULL),
(248, 'delete', 'Supprimer enregistrement d''infraction', 'RecordInfraction', 11, NULL, NULL, NULL, NULL),
(249, 'view', 'Voir enregistrement d''infraction', 'RecordInfraction', 11, NULL, NULL, NULL, NULL),
(250, 'index', 'Lister enregistrement présence', 'RecordPresence', 11, NULL, NULL, NULL, NULL),
(251, 'view', 'Voir une présence', 'RecordPresence', 11, NULL, NULL, NULL, NULL),
(252, 'update', 'Modifier une présence', 'RecordPresence', 11, NULL, NULL, NULL, NULL),
(253, 'recordPresence', 'Enregistrer présence élèves par salle', 'RecordPresence', 11, NULL, NULL, NULL, NULL),
(254, 'admin', 'Rapport présence', 'RecordPresence', 11, NULL, NULL, NULL, NULL),
(255, 'create', 'Prendre présence pour un élève', 'RecordPresence', 11, NULL, NULL, NULL, NULL),
(256, 'delete', 'Supprimer Présence', 'RecordPresence', 11, NULL, NULL, NULL, NULL),
(257, 'index', 'Liste des avances sur salaire effectues', 'LoanOfMoney', 8, NULL, NULL, NULL, NULL),
(258, 'disableStudents', 'Rendre des élèves inactifs', 'Persons', 9, NULL, NULL, NULL, NULL),
(259, 'create', 'Ajouter des avances sur salaire', 'LoanOfMoney', 8, NULL, NULL, NULL, NULL),
(260, 'update', 'Modifier avance sur salaire', 'LoanOfMoney', 8, NULL, NULL, NULL, NULL),
(261, 'index', 'Liste des devoirs soumis par les élèves', 'homeworkSubmission', 9, NULL, NULL, NULL, NULL),
(262, 'index', 'Liste des payroll effectues', 'Payroll', 8, NULL, NULL, NULL, NULL),
(263, 'create', 'Ajouter un payroll', 'Payroll', 8, NULL, NULL, NULL, NULL),
(264, 'update', 'Modifier un payroll', 'Payroll', 8, NULL, NULL, NULL, NULL),
(265, 'delete', 'Supprimer un payroll', 'Payroll', 8, NULL, NULL, NULL, NULL),
(266, 'view', 'Afficher payroll en mode vue', 'Payroll', 8, NULL, NULL, NULL, NULL),
(267, 'index', 'Liste des obligations a payer', 'Taxes', 8, NULL, NULL, NULL, NULL),
(268, 'create', 'Ajouter une obligation', 'Taxes', 8, NULL, NULL, NULL, NULL),
(269, 'update', 'Modifier une obligation', 'Taxes', 8, NULL, NULL, NULL, NULL),
(270, 'delete', 'Supprimer une obligation', 'Taxes', 8, NULL, NULL, NULL, NULL),
(271, 'view', 'Afficher une obligation en mode vue', 'Taxes', 8, NULL, NULL, NULL, NULL),
(272, 'index', 'Liste de description des autres rentrées', 'OtherIncomesDescription', 8, NULL, NULL, NULL, NULL),
(273, 'create', 'Ajouter description autres rentrées', 'OtherIncomesDescription', 8, NULL, NULL, NULL, NULL),
(274, 'update', 'Modifier description autres rentrées', 'OtherIncomesDescription', 8, NULL, NULL, NULL, NULL),
(275, 'delete', 'Supprimer description autres rentrées', 'OtherIncomesDescription', 8, NULL, NULL, NULL, NULL),
(276, 'index', 'Liste des autres rentrées', 'OtherIncomes', 8, NULL, NULL, NULL, NULL),
(277, 'create', 'Ajouter autres rentrées', 'OtherIncomes', 8, NULL, NULL, NULL, NULL),
(278, 'update', 'Modifier autres rentrées', 'OtherIncomes', 8, NULL, NULL, NULL, NULL),
(279, 'delete', 'Supprimer autres rentrées', 'OtherIncomes', 8, NULL, NULL, NULL, NULL),
(280, 'view', 'Afficher autres rentrées en mode vue', 'OtherIncomes', 8, NULL, NULL, NULL, NULL),
(281, 'view', 'Afficher un pret en mode vue', 'LoanOfMoney', 8, NULL, NULL, NULL, NULL),
(282, 'admissionSearch', 'Recherche d''un postulant dans la liste des anciens eleves ', 'Persons', 9, NULL, NULL, NULL, NULL),
(283, 'view', 'Afficher un devoir soumis (INVITE)', 'homeworkSubmission', 10, NULL, NULL, NULL, NULL),
(284, 'index', 'Lister les articles du portail', 'CmsArticle', 12, NULL, NULL, NULL, NULL),
(285, 'create', 'Ajouter un article au portail', 'CmsArticle', 12, NULL, NULL, NULL, NULL),
(286, 'update', 'Modifier un article du portail', 'CmsArticle', 12, NULL, NULL, NULL, NULL),
(287, 'delete', 'Supprimer un article du portail', 'CmsArticle', 12, NULL, NULL, NULL, NULL),
(288, 'view', 'Voir discipline pour un élève', 'RecordInfraction', 10, NULL, NULL, NULL, NULL),
(289, 'viewParent', 'Vue parent de la discipline', 'RecordInfraction', 10, NULL, NULL, NULL, NULL),
(290, 'config', 'Configuration ', 'Billings', 8, NULL, NULL, NULL, NULL),
(291, 'disciplineReport', 'Rapport sur la conduite de l''eleve', 'Reportcard', 6, NULL, NULL, NULL, NULL),
(292, 'index', 'Liste des partenaires', 'Partners', 1, NULL, NULL, NULL, NULL),
(293, 'create', 'Ajouter un nouveau partenaire', 'Partners', 1, NULL, NULL, NULL, NULL),
(294, 'update', 'Modifier un partenaire', 'Partners', 1, NULL, NULL, NULL, NULL),
(295, 'delete', 'Supprimer un partenaire', 'Partners', 1, NULL, NULL, NULL, NULL),
(296, 'view', 'Voir plus de details sur un partenaire', 'Partners', 1, NULL, NULL, NULL, NULL),
(297, 'index', 'Liste des boursiers', 'Scholarshipholder', 8, NULL, NULL, NULL, NULL),
(298, 'create', 'Ajouter un boursier', 'Scholarshipholder', 8, NULL, NULL, NULL, NULL),
(299, 'update', 'Modifier un boursier', 'Scholarshipholder', 8, NULL, NULL, NULL, NULL),
(300, 'delete', 'Supprimer un boursier', 'Scholarshipholder', 8, NULL, NULL, NULL, NULL),
(301, 'view', 'Voir plus de details sur un boursier', 'Scholarshipholder', 8, NULL, NULL, NULL, NULL),
(302, 'index', 'Liste des libelles depenses', 'ChargeDescription', 8, NULL, NULL, NULL, NULL),
(303, 'create', 'Ajouter libelle depense', 'ChargeDescription', 8, NULL, NULL, NULL, NULL),
(304, 'update', 'Modifier libelle depense', 'ChargeDescription', 8, NULL, NULL, NULL, NULL),
(305, 'delete', 'Supprimer libelle depense', 'ChargeDescription', 8, NULL, NULL, NULL, NULL),
(306, 'index', 'Liste des depenses', 'ChargePaid', 8, NULL, NULL, NULL, NULL),
(307, 'create', 'Ajouter une depense', 'ChargePaid', 8, NULL, NULL, NULL, NULL),
(308, 'update', 'Modifier une depense', 'ChargePaid', 8, NULL, NULL, NULL, NULL),
(309, 'delete', 'Supprimer une depense', 'ChargePaid', 8, NULL, NULL, NULL, NULL),
(310, 'view', 'Voir plus de details d''une depense', 'ChargePaid', 8, NULL, NULL, NULL, NULL),
(311, 'view', 'Voir plus de details d''un libelle depense', 'ChargeDescription', 8, NULL, NULL, NULL, NULL),
(312, 'delete', 'Supprimer un parametre payroll', 'PayrollSettings', 8, NULL, NULL, NULL, NULL),
(313, 'receipt', 'Produire fiche de paie', 'Payroll', 8, NULL, NULL, NULL, NULL),
(314, 'paymentReceipt', 'Recu de paiement', 'Billings', 8, NULL, NULL, NULL, NULL),
(315, 'create', 'Ajouter libelle frais', 'FeesLabel', 8, NULL, NULL, NULL, NULL),
(316, 'update', 'Modifier libelle frais', 'FeesLabel', 8, NULL, NULL, NULL, NULL),
(317, 'delete', 'Supprimer libelle frais', 'FeesLabel', 8, NULL, NULL, NULL, NULL),
(318, 'index', 'Liste des libelles frais', 'FeesLabel', 8, NULL, NULL, NULL, NULL),
(319, 'uploadLogo', 'Upload logo', 'Generalconfig', 1, NULL, NULL, NULL, NULL),
(320, 'etatF', 'Voir les etats financiers', 'Reports', 8, NULL, NULL, NULL, NULL),
(321, 'taxreport', 'Rapport taxe', 'Reports', 8, NULL, NULL, NULL, NULL),
(322, 'create', 'Ajouter une nouvelle vente', 'Sellings', 8, NULL, NULL, NULL, NULL),
(323, 'return', 'Liste des produits retournés', 'Sellings', 8, NULL, NULL, NULL, NULL),
(324, 'returnitem', 'Retourner un produit', 'Sellings', 8, NULL, NULL, NULL, NULL),
(325, 'admin', 'Afficher le rapport de vente', 'Sellings', 8, NULL, NULL, NULL, NULL),
(326, 'emptyCart', 'Vider le panier de vente', 'Sellings', 8, NULL, NULL, NULL, NULL),
(327, 'index', 'Liste des produits en dépot', 'Products', 8, NULL, NULL, NULL, NULL),
(328, 'create', 'Ajouter un produit', 'Stocks', 8, NULL, NULL, NULL, NULL),
(329, 'update', 'Modifier produit en dépôt', 'Products', 8, NULL, NULL, NULL, NULL),
(330, 'delete', 'Supprimer un produit en dépôt', 'Products', 8, NULL, NULL, NULL, NULL),
(331, 'create', 'Ajouter un nouveau produit en dépôt', 'Products', 8, NULL, NULL, NULL, NULL),
(332, 'update', 'Modifier le dépôt', 'Stocks', 8, NULL, NULL, NULL, NULL),
(333, 'uploadLogo', 'Gérer carrousel portal', 'CmsArticle', 12, NULL, NULL, NULL, NULL),
(334, 'view', 'Voir plus de details sur une note', 'Grades', 10, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
`id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `create_by` varchar(128) NOT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `arrondissements`
--

CREATE TABLE `arrondissements` (
`id` int(11) NOT NULL,
  `arrondissement_name` varchar(45) NOT NULL,
  `departement` int(11) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `arrondissements`
--

INSERT INTO `arrondissements` (`id`, `arrondissement_name`, `departement`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Port-au-Prince', 2, NULL, NULL, '', ''),
(2, 'Borgne', 1, NULL, NULL, NULL, NULL),
(3, 'Cap-Haitien', 1, NULL, NULL, NULL, NULL),
(4, 'Grande-Rivière Du Nord', 1, NULL, NULL, NULL, NULL),
(5, 'L''Acul Du Nord', 1, NULL, NULL, NULL, NULL),
(6, 'Limbé', 1, NULL, NULL, NULL, NULL),
(7, 'Plaisance', 1, NULL, NULL, NULL, NULL),
(8, 'Saint-Raphael', 1, NULL, NULL, NULL, NULL),
(9, 'Arcahaie', 2, NULL, NULL, NULL, NULL),
(10, 'Croix-Des-Bouquets', 2, NULL, NULL, NULL, NULL),
(11, 'La Gonâve', 2, NULL, NULL, NULL, NULL),
(12, 'Léogâne', 2, NULL, NULL, NULL, NULL),
(13, 'Dessalines', 3, NULL, NULL, NULL, NULL),
(14, 'Gonaïves', 3, NULL, NULL, NULL, NULL),
(15, 'Gros-Morne', 3, NULL, NULL, NULL, NULL),
(16, 'Marmelade', 3, NULL, NULL, NULL, NULL),
(17, 'Saint-Marc', 3, NULL, NULL, NULL, NULL),
(18, 'Cerca-La-Source', 4, NULL, NULL, NULL, NULL),
(19, 'Hinche', 4, NULL, NULL, NULL, NULL),
(20, 'Lascahobas', 4, NULL, NULL, NULL, NULL),
(21, 'Mirebalais', 4, NULL, NULL, NULL, NULL),
(22, 'Anse-D''Hainault', 5, NULL, NULL, NULL, NULL),
(23, 'Corail', 5, NULL, NULL, NULL, NULL),
(24, 'Jérémie', 5, NULL, NULL, NULL, NULL),
(25, 'Anse-A-Veau', 6, NULL, NULL, NULL, NULL),
(26, 'Baradères', 6, NULL, NULL, NULL, NULL),
(27, 'Miragoâne', 6, NULL, NULL, NULL, NULL),
(28, 'Fort-Liberté', 7, NULL, NULL, NULL, NULL),
(29, 'Ouanaminthe', 7, NULL, NULL, NULL, NULL),
(30, 'Trou-Du-Nord', 7, NULL, NULL, NULL, NULL),
(31, 'Vallières', 7, NULL, NULL, NULL, NULL),
(32, 'Môle Saint-Nicolas', 8, NULL, NULL, NULL, NULL),
(33, 'Port-De-Paix', 8, NULL, NULL, NULL, NULL),
(34, 'Saint-Louis Du Nord', 8, NULL, NULL, NULL, NULL),
(35, 'Aquin', 9, NULL, NULL, NULL, NULL),
(36, 'Chardonnières', 9, NULL, NULL, NULL, NULL),
(37, 'Côteaux', 9, NULL, NULL, NULL, NULL),
(38, 'Les Cayes', 9, NULL, NULL, NULL, NULL),
(39, 'Port-Salut', 9, NULL, NULL, NULL, NULL),
(40, 'Bainet', 10, NULL, NULL, NULL, NULL),
(41, 'Belle-Anse', 10, NULL, NULL, NULL, NULL),
(42, 'Jacmel', 10, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `average_by_period`
--

CREATE TABLE `average_by_period` (
  `academic_year` int(11) NOT NULL,
  `evaluation_by_year` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `sum` double NOT NULL,
  `average` double NOT NULL,
  `place` int(11) NOT NULL,
  `reportcard_ref` varchar(255) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
`id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `balance` double NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `billings`
--

CREATE TABLE `billings` (
`id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `fee_period` int(11) NOT NULL,
  `amount_to_pay` float NOT NULL,
  `amount_pay` float NOT NULL,
  `balance` float DEFAULT NULL,
  `academic_year` int(11) NOT NULL,
  `date_pay` date NOT NULL,
  `payment_method` int(11) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `fee_totally_paid` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0: paiement partiel; 1: paiement total ',
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `created_by` varchar(64) DEFAULT NULL,
  `updated_by` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `charge_description`
--

CREATE TABLE `charge_description` (
`id` int(11) NOT NULL,
  `description` varchar(65) NOT NULL,
  `category` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `charge_description`
--

INSERT INTO `charge_description` (`id`, `description`, `category`, `comment`) VALUES
(1, 'Entretien et réparation', 3, ''),
(2, 'Voyages', 7, ''),
(3, 'Transport', 7, ''),
(4, 'Internet et téléphone', 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `charge_paid`
--

CREATE TABLE `charge_paid` (
`id` int(11) NOT NULL,
  `id_charge_description` int(11) NOT NULL,
  `amount` double NOT NULL,
  `payment_date` date NOT NULL,
  `comment` varchar(255) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `created_by` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
`id` int(11) NOT NULL,
  `city_name` varchar(45) NOT NULL,
  `arrondissement` int(11) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`, `arrondissement`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Carrefour', 1, NULL, NULL, NULL, NULL),
(2, 'Cite-Soleil', 1, NULL, NULL, NULL, NULL),
(3, 'Delmas', 1, NULL, NULL, NULL, NULL),
(4, 'Tabarre', 1, NULL, NULL, NULL, NULL),
(5, 'Gressier', 1, NULL, NULL, NULL, NULL),
(6, 'Kenscoff', 1, NULL, NULL, NULL, NULL),
(7, 'Petion-Ville', 1, NULL, NULL, NULL, NULL),
(8, 'Port-Au-Prince', 1, NULL, NULL, NULL, NULL),
(9, 'Borgne', 2, NULL, NULL, NULL, NULL),
(10, 'Port-Margot', 2, NULL, NULL, NULL, NULL),
(11, 'Cap-Haitien', 3, NULL, NULL, NULL, NULL),
(12, 'Limonade', 3, NULL, NULL, NULL, NULL),
(13, 'Quartier-Morin', 3, NULL, NULL, NULL, NULL),
(14, 'Bahon', 4, NULL, NULL, NULL, NULL),
(15, 'Grande-Riviere Du Nord', 4, NULL, NULL, NULL, NULL),
(16, 'Acul-Du-Nord', 5, NULL, NULL, NULL, NULL),
(17, 'Milot', 5, NULL, NULL, NULL, NULL),
(18, 'Plaine-Du-Nord', 5, NULL, NULL, NULL, NULL),
(19, 'Bas-Limbe', 6, NULL, NULL, NULL, NULL),
(20, 'Limbe', 6, NULL, NULL, NULL, NULL),
(21, 'Pilate', 7, NULL, NULL, NULL, NULL),
(22, 'Plaisance', 7, NULL, NULL, NULL, NULL),
(23, 'La Victoire', 8, NULL, NULL, NULL, NULL),
(24, 'Pignon', 8, NULL, NULL, NULL, NULL),
(25, 'Ranquitte', 8, NULL, NULL, NULL, NULL),
(26, 'Dondon', 8, NULL, NULL, NULL, NULL),
(27, 'Saint-Raphael', 8, NULL, NULL, NULL, NULL),
(28, 'Arcahaie', 9, NULL, NULL, NULL, NULL),
(29, 'Cabaret', 9, NULL, NULL, NULL, NULL),
(30, 'Cornillon', 10, NULL, NULL, NULL, NULL),
(31, 'Croix Des Bouquets', 10, NULL, NULL, NULL, NULL),
(32, 'Thomazeau', 10, NULL, NULL, NULL, NULL),
(33, 'Fonds-Verrettes', 10, NULL, NULL, NULL, NULL),
(34, 'Ganthier', 10, NULL, NULL, NULL, NULL),
(35, 'Anse-A-Galets', 11, NULL, NULL, NULL, NULL),
(36, 'Pointe-A-Raquette', 11, NULL, NULL, NULL, NULL),
(37, 'Grand-Goave', 12, NULL, NULL, NULL, NULL),
(38, 'Leogane', 12, NULL, NULL, NULL, NULL),
(39, 'Petit-Goave', 12, NULL, NULL, NULL, NULL),
(40, 'Desdunes', 13, NULL, NULL, NULL, NULL),
(41, 'Dessalines', 13, NULL, NULL, NULL, NULL),
(42, 'Grande-Saline', 13, NULL, NULL, NULL, NULL),
(43, 'Petite-Riviere De L''Artibonite', 13, NULL, NULL, NULL, NULL),
(44, 'Ennery', 14, NULL, NULL, NULL, NULL),
(45, 'Gonaives', 14, NULL, NULL, NULL, NULL),
(46, 'L''Estere', 14, NULL, NULL, NULL, NULL),
(47, 'Gros-Morne', 15, NULL, NULL, NULL, NULL),
(48, 'Anse-Rouge', 15, NULL, NULL, NULL, NULL),
(49, 'Terre-Neuve', 15, NULL, NULL, NULL, NULL),
(50, 'Marmelade', 16, NULL, NULL, NULL, NULL),
(51, 'Saint-Michel De L''Attalaye', 16, NULL, NULL, NULL, NULL),
(52, 'La Chapelle', 17, NULL, NULL, NULL, NULL),
(53, 'Saint-Marc', 17, NULL, NULL, NULL, NULL),
(54, 'Verrettes', 17, NULL, NULL, NULL, NULL),
(55, 'Cerca-La-Source', 18, NULL, NULL, NULL, NULL),
(56, 'Thomassique', 18, NULL, NULL, NULL, NULL),
(57, 'Cerca-Carvajal', 19, NULL, NULL, NULL, NULL),
(58, 'Hinche', 19, NULL, NULL, NULL, NULL),
(59, 'Maissade', 19, NULL, NULL, NULL, NULL),
(60, 'Thomonde', 19, NULL, NULL, NULL, NULL),
(61, 'Belladere', 20, NULL, NULL, NULL, NULL),
(62, 'Lascahobas', 20, NULL, NULL, NULL, NULL),
(63, 'Savanette', 20, NULL, NULL, NULL, NULL),
(64, 'Boucan-Carre', 21, NULL, NULL, NULL, NULL),
(65, 'Mirebalais', 21, NULL, NULL, NULL, NULL),
(66, 'Saut-D''Eau', 21, NULL, NULL, NULL, NULL),
(67, 'Anse D''Hainault', 22, NULL, NULL, NULL, NULL),
(68, 'Les Irois', 22, NULL, NULL, NULL, NULL),
(69, 'Dame-Marie', 22, NULL, NULL, NULL, NULL),
(70, 'Corail', 23, NULL, NULL, NULL, NULL),
(71, 'Roseaux', 23, NULL, NULL, NULL, NULL),
(72, 'Beaumont', 23, NULL, NULL, NULL, NULL),
(73, 'Pestel', 23, NULL, NULL, NULL, NULL),
(74, 'Abricots', 24, NULL, NULL, NULL, NULL),
(75, 'Bonbon', 24, NULL, NULL, NULL, NULL),
(76, 'Jeremie', 24, NULL, NULL, NULL, NULL),
(77, 'Chambellan', 24, NULL, NULL, NULL, NULL),
(78, 'Moron', 24, NULL, NULL, NULL, NULL),
(79, 'Anse-A-Veau', 25, NULL, NULL, NULL, NULL),
(80, 'Arnaud', 25, NULL, NULL, NULL, NULL),
(81, 'L''Asile', 25, NULL, NULL, NULL, NULL),
(82, 'Petit-Trou De Nippes', 25, NULL, NULL, NULL, NULL),
(83, 'Plaisance Du Sud', 25, NULL, NULL, NULL, NULL),
(84, 'Baraderes', 26, NULL, NULL, NULL, NULL),
(85, 'Grand-Boucan', 26, NULL, NULL, NULL, NULL),
(86, 'Fonds-Des-Negres', 27, NULL, NULL, NULL, NULL),
(87, 'Miragoane', 27, NULL, NULL, NULL, NULL),
(88, 'Paillant', 27, NULL, NULL, NULL, NULL),
(89, 'Petite Riviere De Nippes', 27, NULL, NULL, NULL, NULL),
(90, 'Ferrier', 28, NULL, NULL, NULL, NULL),
(91, 'Fort-Liberte', 28, NULL, NULL, NULL, NULL),
(92, 'Perches', 28, NULL, NULL, NULL, NULL),
(93, 'Capotille', 29, NULL, NULL, NULL, NULL),
(94, 'Mont-Organise', 29, NULL, NULL, NULL, NULL),
(95, 'Ouanaminthe', 29, NULL, NULL, NULL, NULL),
(96, 'Sainte-Suzanne', 30, NULL, NULL, NULL, NULL),
(97, 'Terrier-Rouge', 30, NULL, NULL, NULL, NULL),
(98, 'Caracol', 30, NULL, NULL, NULL, NULL),
(99, 'Trou-Du-Nord', 30, NULL, NULL, NULL, NULL),
(100, 'Carice', 31, NULL, NULL, NULL, NULL),
(101, 'Mombin Crochu', 31, NULL, NULL, NULL, NULL),
(102, 'Vallieres', 31, NULL, NULL, NULL, NULL),
(103, 'Baie-De-Henne', 32, NULL, NULL, NULL, NULL),
(104, 'Bombardopolis', 32, NULL, NULL, NULL, NULL),
(105, 'Jean Rabel', 32, NULL, NULL, NULL, NULL),
(106, 'Mole Saint-Nicolas', 32, NULL, NULL, NULL, NULL),
(107, 'Bassin Bleu', 33, NULL, NULL, NULL, NULL),
(108, 'Chansolme', 33, NULL, NULL, NULL, NULL),
(109, 'La Tortue', 33, NULL, NULL, NULL, NULL),
(110, 'Port-De-Paix', 33, NULL, NULL, NULL, NULL),
(111, 'Anse-A-Foleur', 34, NULL, NULL, NULL, NULL),
(112, 'Saint-Louis Du Nord', 34, NULL, NULL, NULL, NULL),
(113, 'Aquin', 35, NULL, NULL, NULL, NULL),
(114, 'Cavaillon', 35, NULL, NULL, NULL, NULL),
(115, 'Saint-Louis Du Sud', 35, NULL, NULL, NULL, NULL),
(116, 'Chardonnieres', 36, NULL, NULL, NULL, NULL),
(117, 'Les Anglais', 36, NULL, NULL, NULL, NULL),
(118, 'Tiburon', 36, NULL, NULL, NULL, NULL),
(119, 'Coteaux', 37, NULL, NULL, NULL, NULL),
(120, 'Port-A-Piment', 37, NULL, NULL, NULL, NULL),
(121, 'Roche-A-Bateau', 37, NULL, NULL, NULL, NULL),
(122, 'Camp-Perrin', 38, NULL, NULL, NULL, NULL),
(123, 'Maniche', 38, NULL, NULL, NULL, NULL),
(124, 'Cayes', 38, NULL, NULL, NULL, NULL),
(125, 'Ile-A-Vache', 38, NULL, NULL, NULL, NULL),
(126, 'Chantal', 38, NULL, NULL, NULL, NULL),
(127, 'Torbeck', 38, NULL, NULL, NULL, NULL),
(128, 'Port-Salut', 39, NULL, NULL, NULL, NULL),
(129, 'Arniquet', 39, NULL, NULL, NULL, NULL),
(130, 'Saint-Jean Du Sud', 39, NULL, NULL, NULL, NULL),
(131, 'Bainet', 40, NULL, NULL, NULL, NULL),
(132, 'Cotes De Fer', 40, NULL, NULL, NULL, NULL),
(133, 'Anse-A-Pitre', 41, NULL, NULL, NULL, NULL),
(134, 'Belle-Anse', 41, NULL, NULL, NULL, NULL),
(135, 'Grand-Gosier', 41, NULL, NULL, NULL, NULL),
(136, 'Thiotte', 41, NULL, NULL, NULL, NULL),
(137, 'Jacmel', 42, NULL, NULL, NULL, NULL),
(138, 'La Vallee De Jacmel', 42, NULL, NULL, NULL, NULL),
(139, 'Cayes-Jacmel', 42, NULL, NULL, NULL, NULL),
(140, 'Marigot', 42, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_article`
--

CREATE TABLE `cms_article` (
`id` int(11) NOT NULL,
  `article_title` varchar(255) NOT NULL,
  `article_description` longtext NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL,
  `create_by` varchar(128) DEFAULT NULL,
  `is_publish` tinyint(1) DEFAULT NULL,
  `section` int(11) DEFAULT NULL,
  `last_update` date DEFAULT NULL,
  `set_position` varchar(64) DEFAULT NULL COMMENT 'box or main'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cms_article`
--

INSERT INTO `cms_article` (`id`, `article_title`, `article_description`, `date_create`, `create_by`, `is_publish`, `section`, `last_update`, `set_position`) VALUES
(1, 'Bienvenue chez Logipam', '<p style="text-align: justify;"><img alt="" height="240" src="/siges_bug/cms_files/images/Toussaint%20fondamentale.jpg" style="float:right" width="450" />The chapter <em>&ldquo;The Good and the Bad&rdquo;</em> of Tolstoy&rsquo;s text is particularly relevant to designer because it is a treatise concerning the nature and purpose of art. It describes how art can express both aesthetic and ethic values. Accordingly, as applied art, design will not be defined in terms of its ability to express form and beauty, but instead in terms of its ability to communicate concepts of morality. Therefore, bad design is &ldquo;unintelligible and incomprehensible&rdquo;. Good design has a form and content, which are in unity with the ideas and feelings it evokes; and, it expresses its meaning in a way which can be understood by everyone. Beyond all consciousness and all legislation, it often happens that the pencil of the designer starts to drift and invent forms that are beyond reason. Indeed, designers still draw weapons of mass destruction and atomic bombs. Scientists in the armies draw war plans, all in order to enslave and diminish men. In this sense, if one departs from the theological references, the aesthetics in Tolstoy&rsquo;s thought could be a salvation, because it is based on Ethics. The latter, for Tolstoy, is a philosophy that would be interested in moral judgments of what designers create for societies, it would propose a rational justification about what is &quot;good and bad design.&quot; &nbsp;Since the designers are creators and can go beyond intent and laws, human will touch the line of the &ldquo;absolute beauty&rdquo; praised by Plato, only if Ethics is their compass.</p>\r\n\r\n<p style="text-align: justify;">It has been demonstrated as being art, <em>Design</em> goes to <em>Beauty</em>. The enjoyment of this beauty gives access to the &ldquo;intelligible world&rdquo; of Plato, but is materialized in the &ldquo;sensible world&rdquo;throughall king of designs. This sensible world must be governed by laws and regulations. Nevertheless, these non-contingent laws can be very harmful to design; therefore, to human progress. Ethics would be the salvation for the failure of policies.&nbsp;All in all, design goal should be to create a living environment that provides pleasure and enjoyment; produce objects, implement systems and arrange spaces that fulfill their functions harmoniously.&nbsp;It should provide a quality of life for consumers not only physically but also, more subtly, aesthetically, psychologically and socially.&nbsp;</p>\r\n\r\n<div>\r\n<div id="edn1">\r\n<p style="text-align: justify;">Tolstoy tried to subordinate art to religion. He thought that art has lost its religious substance and was made to please a certain class of people, becoming, ipso facto, insincere. Since at his time, Tolstoy believed that most people had stopped living according to the principle of religion.</p>\r\n\r\n<p>&nbsp;</p>\r\n</div>\r\n</div>\r\n', '2016-04-14 00:00:00', 'master_user', 1, NULL, '2016-04-14', 'main'),
(2, 'Ce court film en dit long...', '<p>In regard to applied art, <em>Design</em> can be defined as a creative activity associated to formal qualities of objects produced industrially for an aesthetic result agreeing with technical, ethical,<iframe allowfullscreen="" frameborder="0" height="250" src="//www.youtube.com/embed/kUxTUUk69OI" width="450"></iframe> and socio-economic attributes, all conceived in a cohesive unit. Albeit design has emerged in its infancy as exclusively allied to objects, nowadays it invades all places of &ldquo;<em>production of meaning</em>&rdquo;: individuals, objects, spaces, images, services, and society in its entirety. In fact, design offers introspective and prospective perspectives on societies to the extent that it participated in the reflection of collective and individual lifestyles. Therefore, since it is highly correlated to technology and ingrained in social cog, policies and regulations become inherent to design because - it is self-evident, there can be no society or technique without boundaries. Nevertheless, aesthetic, technological and political realities show that creation, which is the backbone of design, usually takes root in the dream and desire of individuals. As a result, despite the now widespread commitment to streamline applied arts, creation still cannot be intended, regulated, and industrialized as it is entrenched in designers&rsquo; psychic singularity. Clearly, design is before all from the domain of art; thus, it refers to freedom of expression, which is a fundamental right of creators, and to the tastes or perceptions of consumers. To create, designers must dream as dilettantes and be bored of freedom. Nietzsche subscribes to this idea when he contends in the <em>Gay Science</em>: &ldquo;For thinkers and all sensitive spirits, boredom is that disagreeable &ldquo;windless calm&rdquo; of the soul that precedes a happy voyage and cheerful winds&rdquo; (Nietzsche 78). This occurs, even when the basic requirements for creation or design are captured with all elements of their environment in a consistent basis.</p>\r\n', '2016-04-14 00:00:00', 'master_user', 1, NULL, '2016-04-14', 'main'),
(3, 'Bonne annee scolaire a toutes et a tous', 'Design can be defined as a creative activity associated to formal qualities of objects produced industrially for an aesthetic result agreeing with technical, ethical, and socio-economic attributes, all conceived in a cohesive unit. Albeit design has emerged in its infancy as exclusively allied to objects, nowadays it invades all places of “production of meaning”: individuals, objects, spaces, imag', '2016-04-14 00:00:00', 'master_user', 1, NULL, NULL, 'box1'),
(4, 'Design', 'Clearly, design is before all from the domain of art; thus, it refers to freedom of expression, which is a fundamental right of creators, and to the tastes or perceptions of consumers. To create, designers must dream as dilettantes and be bored of freedom. Nietzsche subscribes to this idea when he contends in the Gay Science: ', '2016-04-14 00:00:00', 'master_user', 1, NULL, NULL, 'box2'),
(5, 'Historique', '<p><span style="font-family:times new roman,serif; font-size:12.0pt">In regard to applied art, <em>Design</em> can be defined as a creative activity associated to formal qualities of objects produced industrially for an aesthetic result agreeing<img alt="" height="278" src="/siges_bug/cms_files/images/lycee-toussaint.jpg" style="float:right" width="500" /> with technical, ethical, and socio-economic attributes, all conceived in a cohesive unit. Albeit design has emerged in its infancy as exclusively allied to objects, nowadays it invades all places of &ldquo;<em>production of meaning</em>&rdquo;: individuals, objects, spaces, images, services, and society in its entirety. In fact, design offers introspective and prospective perspectives on societies to the extent that it participated in the reflection of collective and individual lifestyles. Therefore, since it is highly correlated to technology and ingrained in social cog, policies and regulations become inherent to design because - it is self-evident, there can be no society or technique without boundaries. Nevertheless, aesthetic, technological and political realities show that creation, which is the backbone of design, usually takes root in the dream and desire of individuals. As a result, despite the now widespread commitment to streamline applied arts, creation still cannot be intended, regulated, and industrialized as it is entrenched in designers&rsquo; psychic singularity. Clearly, design is before all from the domain of art; thus, it refers to freedom of expression, which is a fundamental right of creators, and to the tastes or perceptions of consumers</span></p>\r\n', '2016-04-14 00:00:00', 'master_user', 1, NULL, NULL, 'about'),
(6, 'Nos eleves', '<p>However, in the noteworthy book &ldquo;<em>The Substance of Style</em>&rdquo;, Virginia Postrel examines aesthetic values and explores the boundaries of design. She asserts: &ldquo;depending on its boundaries, then, design can be satisfying or tyrannical. It ranges from individualistic, expressing one identity among many possibilities, to the totalitarian, subordinating all particulars to a unitary vision&rdquo; (Postrel 123). In other words, she insinuates that by monitoring society&rsquo;s lifestyle, and given the profusion of styles and expressions of design, if/when <img alt="" height="319" src="/siges_bug/cms_files/images/pourunerentrescolairerussie%281%29.jpg" style="float:left" width="400" />misjudged or abused, laws and regulations though intrinsic to design, may become delicate, divisive, tyrannical, and structurally contingent. Undoubtedly, the issue of regulation of artistic creation is the substrate of Postrel&rsquo;s thoughts, both politically and technically. The real dilemma lies in the approach to articulate the freedom of designers-creators and /or the intimate tastes of consumers to design criteria. Since the ultimate role of design is to create beautiful, useful, and modern objects for the progress of humanity. Also it allows designers to imagine the future, stimulate desire, and build dreams among human being within legal, technical, and ethical considerations. Perhaps, one potential outcome of this quandary is to design according to the criteria of style/substances (considering freedom of expression and regulations), functions (given the objects&rsquo; usefulness), and perceptions (in terms of meanings, aesthetics and ethics).</p>\r\n\r\n<div>\r\n<div id="edn1">\r\n<p>Policy in this context addresses <em>actions</em> and balances the internal or external development of societies, and their relationship to other sets. It is primarily related to the respect of the collective as a sum of uniqueness and/or multiplicities.</p>\r\n</div>\r\n</div>\r\n', '2016-04-14 00:00:00', 'master_user', 1, NULL, NULL, 'about'),
(7, 'Conditions d''admission', '<h1 style="margin-right:5%"><strong><span style="font-size:16px">Admission au premier cycle &agrave; Logipam</span></strong></h1>\r\n\r\n<p style="margin-right:5%">Conditions g&eacute;n&eacute;rales</p>\r\n\r\n<ol style="margin-left:40px">\r\n	<li>L&#39;admission &agrave; l&rsquo;Universit&eacute; d&rsquo;Etat d&rsquo;Ha&iuml;ti est ouverte &agrave; toutes et &agrave; tous sans discrimination de sexe, de religion ou de classe sociale. Pour toutes les entit&eacute;s, l&#39;admission est annuelle, elle se fait &agrave; la fin de l&rsquo;ann&eacute;e acad&eacute;mique mais biannuelle &agrave; la facult&eacute; des Sciences Humaines (FASCH) qui en r&eacute;alise une autre.</li>\r\n	<li>La pr&eacute;-inscription est une &eacute;tape initiale et obligatoire du processus d&rsquo;inscription pour toute personne qui d&eacute;sire int&eacute;grer l&rsquo;Logipam. Il pr&eacute;c&egrave;de le processus de validation qui se fait dans chaque entit&eacute; choisie.</li>\r\n	<li>Le concours sera bas&eacute; sur la culture g&eacute;n&eacute;rale, la dissertation philosophique, les connaissances linguistiques; les sciences naturelles et les math&eacute;matiques d&eacute;pendant de l&rsquo;entit&eacute; choisie par le postulant. La s&eacute;lection se fait sur une base de m&eacute;rite.</li>\r\n	<li>L&#39;admission &agrave; l&rsquo;Universit&eacute; d&rsquo;Etat d&rsquo;Ha&iuml;ti est ouverte &agrave; toutes et &agrave; tous sans discrimination de sexe, de religion ou de classe sociale. Pour toutes les entit&eacute;s, l&#39;admission est annuelle, elle se fait &agrave; la fin de l&rsquo;ann&eacute;e acad&eacute;mique mais biannuelle &agrave; la facult&eacute; des Sciences Humaines (FASCH) qui en r&eacute;alise une autre.</li>\r\n	<li>La pr&eacute;-inscription est une &eacute;tape initiale et obligatoire du processus d&rsquo;inscription pour toute personne qui d&eacute;sire int&eacute;grer l&rsquo;Logipam. Il pr&eacute;c&egrave;de le processus de validation qui se fait dans chaque entit&eacute; choisie.</li>\r\n	<li>Le concours sera bas&eacute; sur la culture g&eacute;n&eacute;rale, la dissertation philosophique, les connaissances linguistiques; les sciences naturelles et les math&eacute;matiques d&eacute;pendant de l&rsquo;entit&eacute; choisie par le postulant. La s&eacute;lection se fait sur une base de m&eacute;rite.</li>\r\n</ol>\r\n', '2016-04-14 00:00:00', 'master_user', 1, NULL, '2016-04-14', 'admission');

-- --------------------------------------------------------

--
-- Table structure for table `cms_image`
--

CREATE TABLE `cms_image` (
`id` int(11) NOT NULL,
  `label_image` varchar(255) NOT NULL,
  `type_image` varchar(64) NOT NULL COMMENT 'Carrousel or Logo',
  `nom_image` varchar(255) NOT NULL,
  `is_publish` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cms_section`
--

CREATE TABLE `cms_section` (
`id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `create_by` varchar(128) DEFAULT NULL,
  `is_publish` tinyint(1) DEFAULT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
`id` int(11) NOT NULL,
  `person` int(11) NOT NULL,
  `contact_name` varchar(45) DEFAULT NULL,
  `contact_relationship` int(11) DEFAULT NULL,
  `profession` varchar(100) NOT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL,
  `one_more` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
`id` int(11) NOT NULL,
  `subject` int(11) NOT NULL,
  `teacher` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `academic_period` int(11) NOT NULL,
  `weight` float DEFAULT NULL COMMENT 'Weight : Le coefficient du cours',
  `debase` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `custom_field`
--

CREATE TABLE `custom_field` (
`id` int(11) NOT NULL,
  `field_name` varchar(64) NOT NULL,
  `field_label` varchar(45) DEFAULT NULL,
  `field_type` varchar(45) DEFAULT 'text',
  `value_type` varchar(16) DEFAULT NULL,
  `field_option` text,
  `field_related_to` varchar(45) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `custom_field_data`
--

CREATE TABLE `custom_field_data` (
`id` bigint(20) NOT NULL,
  `field_link` int(11) NOT NULL,
  `field_data` text,
  `object_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Cycles`
--

CREATE TABLE `Cycles` (
`id` int(11) NOT NULL,
  `cycle_description` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Cycles`
--

INSERT INTO `Cycles` (`id`, `cycle_description`) VALUES
(1, '1er Cycle'),
(3, '2ème Cycle'),
(4, '3ème Cycle');

-- --------------------------------------------------------

--
-- Table structure for table `decision_finale`
--

CREATE TABLE `decision_finale` (
`id` bigint(20) NOT NULL,
  `student` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `general_average` float DEFAULT NULL,
  `mention` varchar(45) DEFAULT NULL,
  `comments` varchar(128) DEFAULT NULL,
  `is_move_to_next_year` tinyint(1) DEFAULT NULL,
  `current_level` int(11) DEFAULT NULL,
  `next_level` int(11) DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
`id` int(11) NOT NULL,
  `department_name` varchar(45) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Nord', NULL, NULL, '', ''),
(2, 'Ouest', NULL, NULL, '', ''),
(3, 'Artibonite', NULL, NULL, NULL, NULL),
(4, 'Centre', NULL, NULL, NULL, NULL),
(5, 'Grand''Anse', NULL, NULL, NULL, NULL),
(6, 'Nippes', NULL, NULL, NULL, NULL),
(7, 'Nord-Est', NULL, NULL, NULL, NULL),
(8, 'Nord-Ouest', NULL, NULL, NULL, NULL),
(9, 'Sud', NULL, NULL, NULL, NULL),
(10, 'Sud-Est', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department_has_person`
--

CREATE TABLE `department_has_person` (
`id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `created_by` varchar(45) NOT NULL,
  `updated_by` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `department_in_school`
--

CREATE TABLE `department_in_school` (
`id` int(11) NOT NULL,
  `department_name` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `created_by` varchar(45) NOT NULL,
  `updated_by` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `devises`
--

CREATE TABLE `devises` (
`id` int(11) NOT NULL,
  `devise_name` varchar(45) NOT NULL,
  `devise_symbol` varchar(45) NOT NULL,
  `description` text,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `devises`
--

INSERT INTO `devises` (`id`, `devise_name`, `devise_symbol`, `description`, `date_create`, `date_update`, `create_by`, `update_by`) VALUES
(1, 'Gourde', 'HTG', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_info`
--

CREATE TABLE `employee_info` (
`id` int(11) NOT NULL,
  `employee` int(11) NOT NULL,
  `hire_date` date DEFAULT NULL,
  `country_of_birth` varchar(45) NOT NULL,
  `university_or_school` varchar(45) DEFAULT NULL,
  `number_of_year_of_study` int(11) DEFAULT NULL,
  `field_study` int(11) DEFAULT NULL,
  `qualification` int(11) DEFAULT NULL,
  `job_status` int(11) DEFAULT NULL,
  `permis_enseignant` varchar(45) NOT NULL,
  `leaving_date` date DEFAULT NULL,
  `comments` text,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
`id` int(11) NOT NULL,
  `evaluation_name` varchar(64) NOT NULL,
  `weight` float DEFAULT NULL,
  `academic_year` int(11) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_by_year`
--

CREATE TABLE `evaluation_by_year` (
`id` int(11) NOT NULL,
  `evaluation` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `evaluation_date` date NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
`id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `academic_period` int(11) NOT NULL,
  `fee` int(11) NOT NULL,
  `amount` float NOT NULL,
  `devise` int(11) DEFAULT NULL,
  `date_limit_payment` date DEFAULT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT '0',
  `description` text,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fees_label`
--

CREATE TABLE `fees_label` (
`id` int(11) NOT NULL,
  `fee_label` varchar(100) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0: other fees, no pending; 1: tuition fees, pending'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fees_label`
--

INSERT INTO `fees_label` (`id`, `fee_label`, `status`) VALUES
(1, 'Versement 1', 1),
(2, 'Versement 2', 1),
(3, 'Droits d''entrée', 0),
(4, 'Frais d''examen', 0),
(5, 'Frais informatique', 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_study`
--

CREATE TABLE `field_study` (
`id` int(11) NOT NULL,
  `field_name` varchar(45) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `field_study`
--

INSERT INTO `field_study` (`id`, `field_name`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Sciences sociales', '2016-04-14 00:00:00', '2016-04-14 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `general_average_by_period`
--

CREATE TABLE `general_average_by_period` (
  `academic_year` int(11) NOT NULL,
  `academic_period` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `general_average` double NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_config`
--

CREATE TABLE `general_config` (
`id` int(11) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `item_value` text,
  `description` text,
  `english_comment` text,
  `category` varchar(12) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_config`
--

INSERT INTO `general_config` (`id`, `item_name`, `name`, `item_value`, `description`, `english_comment`, `category`, `date_create`, `date_update`, `create_by`, `update_by`) VALUES
(1, 'school_name', 'Nom établissement', 'College Mixte Logipam', 'Saisir le nom de l''établissement', 'Enter the name of the school', 'sys', '0000-00-00 00:00:00', '2016-04-14 00:00:00', '', ''),
(2, 'school_address', 'Adresse établissement', '104 Rue Louverture, Petion-Ville, Haiti', 'Adresse de l''école', 'School address', 'sys', '0000-00-00 00:00:00', '2016-04-14 00:00:00', '', ''),
(3, 'school_phone_number', 'Tél établissement', '4567898', 'Saisir les numéros de téléphone, s''il y a plusieurs numéros, utiliser un "/" pour les séparer.', 'Enter the phone number, if there are multiple phone numbers, use a "/" to separated them.', 'sys', NULL, '2016-04-14 00:00:00', NULL, NULL),
(4, 'school_director_name', 'Nom Directeur', 'Abraham Janvier', 'Saisir le nom du Directeur de l''école.', 'Enter the name of the director of the school.', 'sys', NULL, '2016-04-14 00:00:00', NULL, NULL),
(5, 'school_email_address', 'Email établissement', 'metminwi@gmail.com', 'Saisir l''adresse email de l''école.', 'Enter school email address.', 'sys', NULL, '2016-04-14 00:00:00', NULL, NULL),
(6, 'school_site_web', 'Site web établissement', 'www.logipam.com', 'Saisir URL du site web de l''école. (Exemple: http:://logipam.com)', 'Enter the URL of the school site web (Example: http:://logipam.com)', 'sys', NULL, '2016-04-14 00:00:00', NULL, NULL),
(7, 'academic_success', 'Message pour réussite', 'Success', 'Message pour un élève qui a réussi.', 'Message for a successful student. ', 'acad', NULL, '2016-04-14 00:00:00', NULL, NULL),
(8, 'a_link', '', 'link', NULL, NULL, NULL, NULL, '2015-08-24 00:00:00', NULL, NULL),
(9, 'ppe_number', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'cie_number', 'Numéro Carte Identification École', '', 'Numéro de la carte d''identité d''etablissement (CIE)', 'ID Number of the school ID Card.', 'sys', NULL, '2016-04-14 00:00:00', NULL, NULL),
(11, 'school_licence_number', 'Numéro de la licence', '', 'Numéro de licence de l''établissement.', 'Authorisation license of the school. ', 'sys', NULL, '2016-04-14 00:00:00', NULL, NULL),
(12, 'default_vacation', 'Vacation par défaut', 'Matin', 'Vacation  par defaut.', 'Default Shift.', 'acad', '2015-05-20 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(13, 'default_section', 'Section par défaut', 'Fondamental', 'Section par défaut', 'Default Section', 'acad', '2015-05-20 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(14, 'success_mention', 'Mention pour réussite', 'Succès', 'Message pour la mention de réussite', 'Message for success notification. ', 'acad', '2015-07-01 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(15, 'failure_mention', 'Mention pour échec', 'Echec', 'Message en cas d''échec d''un élève.', 'Message for failed student.', 'acad', '2015-07-01 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(16, 'decision_finale_success', 'Message de réussite pour décision de fin d''année', 'Admis(e) au niveau supérieur/Admis(e) ailleurs/Doit prendre des leçons', 'Option de message en cas de réussite. Sépare chaque option par un "/". ', 'Message option in case of success. Separate each option with a "/". ', 'acad', '2015-07-01 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(17, 'decision_finale_failure', 'Message d''échec pour décision de fin d''année', 'L''élève doit refaire la classe/L''élève doit refaire la classe ailleurs', 'Option de message en cas d''échec d''un élève. Sépare chaque option par un /.', 'Message option in case of student failed. Separate each option with a /.', 'acad', '2015-07-01 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(18, 'code1', 'Code liste de formation classe (MENFP)', '', 'Code fourni par le ministère de l''éducation nationale d''Haïti pour l''école.', 'Education department official code for the school. ', 'sys', '2015-08-01 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(19, 'code2', 'Code à 11 chiffres du MENFP', '', 'Code a 11 chiffres fourni par le ministere de l''éducation nationale d''Haïti.', 'Education department code with 11 digit for the school.', 'sys', '2015-08-01 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(20, 'methode_deduction_note_discipline', 'Méthode déduction note discipline', '1', '0: Valeur ------- 1 : Pourcentage -------\nValeur : les deductions affectent la valeur de la note de discipline -------- Pourcentage : les deductions affectent un pourcentage de la note de discipline', '0: Value ------ 1: Percentage ------\nValue: the deduction will affect the value of discipline grade ------ \nPercentage : the deduction will affect a percentage of discipline grade. ', 'disc', '2015-08-19 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(21, 'note_discipline_initiale', 'Note discipline initiale', '10', 'Valeur initiale de la note de discipline.  Par exemple : 100 ou 20 ou 50. ', 'Initial value for discipline grade. Example : 100 or 20 or 50', 'disc', '2015-08-19 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(22, 'max_amount_loan', 'Montant maximun d''un prêt', '50000', 'Acronyme du nom de l''école. Placer entre parenthèse. ', 'Acronym for school name. Place within parenthesis. ', 'sys', '2015-09-18 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(23, 'School_acronym', 'Acronyme établissement', '- CML', 'Le montant maximum que l''on peut donner comme prêter a un employé.', 'Maximun loan can be granted to an employee. ', 'econ', '2015-09-19 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(24, 'include_discipline_grade', 'Inclure note discipline', '1', ' 2: ne pas afficher discipline dans le carnet. ------ 1: oui, on doit inclure la note de discipline dans le calcul de la moyenne ------ 0: non, le calcul de la moyenne ne tient pas compte de la note de discipline.', '2:  do not display discipline in reportcard. ----- 1: include discipline grade in calculation of average. ------ 0: no, the calculation of average don''t include discipline grade. ', 'disc', NULL, '2016-04-14 00:00:00', NULL, NULL),
(25, 'average_base', 'Moyenne de base', '100', 'La base de la moyenne: 10 ou 100.', 'Base average: 10 or 100.', 'acad', NULL, '2016-04-14 00:00:00', NULL, NULL),
(26, 'reportcard_structure', 'Format bulletin', '1', '1: Simple (une évaluation par période, moyenne générale sur demande);  2: Avancé (Plusieurs évaluations sur UNE période, moyenne générale automatique)', '1: Basic (One evaluation by Period, general average on request); 2: Advanced (Many evaluations in ONE Period, general average automatic)', 'acad', NULL, '2016-04-14 00:00:00', NULL, NULL),
(27, 'include_place', 'Inclure rang élève dans bulletin', '1', '0: le rang de l''eleve ne figure pas dans le bulletin. 1: le rang de l''eleve figure dans le bulletin.', '0: student rank not include in the reportcard. 1: student rang include in the reportcard. ', 'acad', NULL, '2016-04-14 00:00:00', NULL, NULL),
(28, 'tardy_absence_display', 'Inclure "retard" et "absence" dans le bulletin', '1', '1:Figure OU 0:Ne figure pas', '1:Display OR 0:Do not display ', 'disc', '2015-12-18 00:00:00', '2016-04-14 00:00:00', 'SIGES', NULL),
(29, 'total_payroll', 'Nombre de payroll par année', '12', 'Nombre de payroll pour l''annee', 'Number of payroll per year', 'econ', '2015-12-08 00:00:00', '2016-04-14 00:00:00', 'SIGES', NULL),
(30, 'limit_payroll_update', 'Délai modifcation payroll', '', 'Nombre de jours (à partir de la date de paiement) durant lesquels le payroll peut etre modifié.', 'Number of days (from the payment date) the payrolls can be updated. ', 'econ', '2015-12-14 00:00:00', '2016-04-14 00:00:00', 'SIGES', NULL),
(31, 'pied_fiche_ad', 'Message fiche inscription', 'L’élève est accepté à suivre la classe pour laquelle il a fait une demande d’admission quand le sceau de l’école est apposé au bas de cette fiche dûment signee par un membre de la Direction et de la Personne Responsable à Port-au-Prince. La Personne Responsable doit aussi rapporter personnellement la feuille accompagnant les règlements du Collège. Si l’écolage n’est pas acquité à la date du 27 Septembre, l’inscription est annulée.', '', NULL, NULL, NULL, '2016-04-14 00:00:00', 'SIGES', NULL),
(32, 'currency_name_symbol', 'Nom et symbole monétaire', 'Gourde/HTG', 'Le nom et le symbol de la devise utilisée par l''école', 'Currency name and symbol used', 'econ', NULL, '2016-04-14 00:00:00', 'SIGES', NULL),
(33, 'facebook_page', 'Page facebook', 'LOGIPAM', 'Adresse de la page facebook de l''établissement (Exemple : facebook.com/logipam -> Ecrivez : logipam) ', 'Facebook address of the institution. Example : facebook.com/logipam -> type logipam) ', 'sys', '2016-03-25 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(34, 'twitter_page', 'Compte twitter', 'LOGIPAM', 'Nom d''utilisateur twitter de l''établissement.', 'Twitter username of the institution.', 'sys', '2016-03-25 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(35, 'youtube_page', 'Page youtube', 'https://youtube.com', 'Adresse de la Chaine YouTube de l''institution.', 'Address of the YouTube Channel of the instutition.', 'sys', '2016-03-25 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(36, 'devise_school', 'Devise établissement', 'SIGES, Parce que l''éducation n''est pas une question d''argent !', 'La phrase devise de l''établissement.', 'The motto phrase of the institution.', 'sys', '2016-03-25 00:00:00', '2016-04-14 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
`id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `evaluation` int(11) NOT NULL,
  `grade_value` float DEFAULT NULL,
  `validate` tinyint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  `comment` varchar(255) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
`id` int(11) NOT NULL,
  `group_name` varchar(32) NOT NULL,
  `belongs_to_profil` int(11) NOT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `create_by` varchar(32) DEFAULT NULL,
  `update_by` varchar(32) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `belongs_to_profil`, `create_date`, `update_date`, `create_by`, `update_by`) VALUES
(1, 'Developer', 1, '2015-05-04 00:00:00', '2016-04-14 00:00:00', '_developer_', 'master_user'),
(2, 'Default Group', 5, NULL, '2015-05-07 00:00:00', NULL, '_developer_'),
(3, 'Student', 5, NULL, '2016-04-15 00:00:00', NULL, 'master_user'),
(4, 'Parent', 5, NULL, '2016-04-15 00:00:00', NULL, 'master_user'),
(5, 'Direction', 1, NULL, '2016-04-14 00:00:00', NULL, 'master_user'),
(6, 'Administration', 2, NULL, '2016-04-14 00:00:00', NULL, 'admin'),
(7, 'Economat', 3, NULL, '2015-09-06 00:00:00', NULL, '_developer_'),
(8, 'Teacher', 4, NULL, '2015-09-03 00:00:00', NULL, '_developer_'),
(9, 'Reporter', 6, NULL, '2015-05-07 00:00:00', NULL, '_developer_'),
(10, 'Discipline', 2, '2015-09-05 00:00:00', '2015-09-06 00:00:00', '_developer_', '_developer_'),
(11, 'Pedagogie', 2, '2015-09-06 00:00:00', '2015-09-06 00:00:00', '_developer_', '_developer_'),
(12, 'Portail', 2, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'master_user', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `groups_has_actions`
--

CREATE TABLE `groups_has_actions` (
  `groups_id` int(11) NOT NULL,
  `actions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups_has_actions`
--

INSERT INTO `groups_has_actions` (`groups_id`, `actions_id`) VALUES
(1, 1),
(5, 1),
(1, 2),
(1, 3),
(5, 3),
(7, 3),
(10, 3),
(1, 4),
(5, 4),
(1, 5),
(5, 5),
(8, 5),
(1, 6),
(3, 6),
(4, 6),
(5, 6),
(7, 6),
(8, 6),
(10, 6),
(11, 6),
(1, 7),
(5, 7),
(7, 7),
(10, 7),
(11, 7),
(1, 8),
(5, 8),
(1, 9),
(5, 9),
(6, 9),
(7, 9),
(8, 9),
(10, 9),
(11, 9),
(1, 10),
(5, 10),
(6, 10),
(7, 10),
(8, 10),
(10, 10),
(11, 10),
(1, 11),
(5, 11),
(6, 11),
(7, 11),
(8, 11),
(10, 11),
(11, 11),
(1, 12),
(5, 12),
(6, 12),
(7, 12),
(10, 12),
(11, 12),
(1, 13),
(5, 13),
(6, 13),
(10, 13),
(1, 14),
(5, 14),
(6, 14),
(7, 14),
(10, 14),
(11, 14),
(1, 15),
(5, 15),
(6, 15),
(7, 15),
(10, 15),
(11, 15),
(1, 16),
(5, 16),
(6, 16),
(7, 16),
(10, 16),
(11, 16),
(1, 17),
(5, 17),
(6, 17),
(7, 17),
(10, 17),
(11, 17),
(1, 18),
(5, 18),
(6, 18),
(7, 18),
(10, 18),
(11, 18),
(1, 19),
(5, 19),
(6, 19),
(7, 19),
(10, 19),
(11, 19),
(1, 20),
(5, 20),
(6, 20),
(7, 20),
(10, 20),
(11, 20),
(1, 21),
(5, 21),
(6, 21),
(7, 21),
(10, 21),
(11, 21),
(1, 22),
(5, 22),
(6, 22),
(7, 22),
(10, 22),
(11, 22),
(1, 23),
(5, 23),
(6, 23),
(7, 23),
(10, 23),
(11, 23),
(1, 24),
(5, 24),
(6, 24),
(7, 24),
(11, 24),
(1, 25),
(5, 25),
(6, 25),
(7, 25),
(10, 25),
(11, 25),
(1, 26),
(5, 26),
(6, 26),
(7, 26),
(10, 26),
(11, 26),
(1, 27),
(5, 27),
(6, 27),
(7, 27),
(8, 27),
(10, 27),
(11, 27),
(1, 28),
(5, 28),
(6, 28),
(7, 28),
(8, 28),
(10, 28),
(11, 28),
(1, 29),
(5, 29),
(6, 29),
(7, 29),
(11, 29),
(1, 30),
(5, 30),
(6, 30),
(7, 30),
(10, 30),
(11, 30),
(1, 31),
(5, 31),
(6, 31),
(7, 31),
(10, 31),
(11, 31),
(1, 32),
(5, 32),
(6, 32),
(7, 32),
(10, 32),
(11, 32),
(1, 33),
(5, 33),
(6, 33),
(7, 33),
(10, 33),
(11, 33),
(1, 34),
(5, 34),
(6, 34),
(7, 34),
(11, 34),
(1, 35),
(5, 35),
(6, 35),
(7, 35),
(10, 35),
(11, 35),
(1, 36),
(5, 36),
(6, 36),
(7, 36),
(11, 36),
(1, 37),
(5, 37),
(6, 37),
(7, 37),
(10, 37),
(11, 37),
(1, 38),
(5, 38),
(6, 38),
(7, 38),
(10, 38),
(11, 38),
(1, 39),
(5, 39),
(6, 39),
(7, 39),
(11, 39),
(1, 40),
(5, 40),
(6, 40),
(7, 40),
(8, 40),
(10, 40),
(11, 40),
(1, 41),
(5, 41),
(6, 41),
(8, 41),
(11, 41),
(1, 42),
(5, 42),
(6, 42),
(8, 42),
(11, 42),
(1, 43),
(5, 43),
(6, 43),
(7, 43),
(8, 43),
(10, 43),
(11, 43),
(1, 44),
(5, 44),
(6, 44),
(8, 44),
(11, 44),
(1, 45),
(5, 45),
(6, 45),
(7, 45),
(8, 45),
(10, 45),
(11, 45),
(1, 46),
(5, 46),
(6, 46),
(7, 46),
(1, 47),
(5, 47),
(6, 47),
(7, 47),
(1, 48),
(5, 48),
(6, 48),
(7, 48),
(1, 49),
(5, 49),
(6, 49),
(7, 49),
(1, 50),
(5, 50),
(6, 50),
(7, 50),
(1, 51),
(5, 51),
(6, 51),
(7, 51),
(1, 52),
(5, 52),
(6, 52),
(7, 52),
(1, 53),
(5, 53),
(6, 53),
(7, 53),
(1, 54),
(5, 54),
(7, 54),
(1, 55),
(5, 55),
(6, 55),
(7, 55),
(8, 55),
(10, 55),
(11, 55),
(1, 56),
(5, 56),
(6, 56),
(7, 56),
(10, 56),
(11, 56),
(1, 57),
(5, 57),
(6, 57),
(7, 57),
(10, 57),
(11, 57),
(1, 58),
(5, 58),
(6, 58),
(7, 58),
(10, 58),
(11, 58),
(1, 59),
(5, 59),
(6, 59),
(7, 59),
(10, 59),
(11, 59),
(1, 60),
(5, 60),
(6, 60),
(7, 60),
(10, 60),
(11, 60),
(1, 61),
(5, 61),
(6, 61),
(11, 61),
(1, 62),
(5, 62),
(6, 62),
(11, 62),
(1, 63),
(5, 63),
(6, 63),
(7, 63),
(10, 63),
(11, 63),
(1, 64),
(5, 64),
(6, 64),
(7, 64),
(8, 64),
(10, 64),
(11, 64),
(1, 65),
(5, 65),
(6, 65),
(11, 65),
(1, 66),
(5, 66),
(6, 66),
(7, 66),
(10, 66),
(11, 66),
(1, 67),
(5, 67),
(6, 67),
(11, 67),
(1, 68),
(5, 68),
(6, 68),
(11, 68),
(1, 69),
(5, 69),
(6, 69),
(7, 69),
(10, 69),
(11, 69),
(1, 70),
(5, 70),
(6, 70),
(11, 70),
(1, 71),
(5, 71),
(6, 71),
(7, 71),
(8, 71),
(10, 71),
(11, 71),
(1, 72),
(5, 72),
(6, 72),
(11, 72),
(1, 73),
(5, 73),
(6, 73),
(11, 73),
(1, 74),
(5, 74),
(6, 74),
(7, 74),
(10, 74),
(11, 74),
(1, 75),
(5, 75),
(6, 75),
(11, 75),
(1, 76),
(5, 76),
(6, 76),
(7, 76),
(10, 76),
(11, 76),
(1, 77),
(5, 77),
(6, 77),
(10, 77),
(11, 77),
(1, 78),
(5, 78),
(6, 78),
(10, 78),
(11, 78),
(1, 79),
(5, 79),
(6, 79),
(7, 79),
(10, 79),
(11, 79),
(1, 80),
(5, 80),
(6, 80),
(7, 80),
(8, 80),
(10, 80),
(11, 80),
(1, 81),
(5, 81),
(6, 81),
(10, 81),
(11, 81),
(1, 82),
(5, 82),
(6, 82),
(10, 82),
(11, 82),
(1, 83),
(5, 83),
(6, 83),
(11, 83),
(12, 83),
(1, 84),
(5, 84),
(6, 84),
(11, 84),
(1, 85),
(5, 85),
(6, 85),
(11, 85),
(1, 86),
(5, 86),
(6, 86),
(11, 86),
(1, 87),
(5, 87),
(6, 87),
(11, 87),
(1, 88),
(5, 88),
(6, 88),
(11, 88),
(1, 89),
(5, 89),
(6, 89),
(11, 89),
(1, 90),
(5, 90),
(6, 90),
(11, 90),
(1, 91),
(5, 91),
(6, 91),
(11, 91),
(1, 92),
(5, 92),
(6, 92),
(11, 92),
(1, 93),
(5, 93),
(6, 93),
(1, 94),
(5, 94),
(6, 94),
(1, 95),
(5, 95),
(6, 95),
(1, 96),
(5, 96),
(6, 96),
(1, 97),
(5, 97),
(6, 97),
(1, 98),
(5, 98),
(6, 98),
(11, 98),
(1, 99),
(5, 99),
(6, 99),
(11, 99),
(1, 100),
(5, 100),
(6, 100),
(11, 100),
(1, 101),
(5, 101),
(6, 101),
(11, 101),
(1, 102),
(5, 102),
(6, 102),
(11, 102),
(1, 103),
(5, 103),
(6, 103),
(1, 104),
(5, 104),
(6, 104),
(1, 105),
(5, 105),
(6, 105),
(1, 106),
(5, 106),
(6, 106),
(1, 107),
(5, 107),
(6, 107),
(1, 108),
(5, 108),
(6, 108),
(11, 108),
(1, 109),
(5, 109),
(6, 109),
(11, 109),
(1, 110),
(5, 110),
(6, 110),
(11, 110),
(1, 111),
(5, 111),
(6, 111),
(11, 111),
(1, 112),
(5, 112),
(6, 112),
(11, 112),
(1, 113),
(5, 113),
(6, 113),
(1, 114),
(5, 114),
(6, 114),
(1, 115),
(5, 115),
(6, 115),
(1, 116),
(5, 116),
(6, 116),
(1, 117),
(5, 117),
(6, 117),
(1, 118),
(5, 118),
(6, 118),
(1, 119),
(5, 119),
(6, 119),
(1, 120),
(5, 120),
(6, 120),
(1, 121),
(5, 121),
(6, 121),
(1, 122),
(5, 122),
(6, 122),
(1, 123),
(5, 123),
(6, 123),
(1, 124),
(5, 124),
(6, 124),
(11, 124),
(1, 125),
(5, 125),
(6, 125),
(11, 125),
(1, 126),
(5, 126),
(6, 126),
(11, 126),
(1, 127),
(5, 127),
(6, 127),
(11, 127),
(1, 128),
(5, 128),
(6, 128),
(11, 128),
(1, 129),
(5, 129),
(6, 129),
(11, 129),
(1, 130),
(5, 130),
(6, 130),
(11, 130),
(1, 131),
(5, 131),
(6, 131),
(11, 131),
(1, 132),
(5, 132),
(6, 132),
(11, 132),
(1, 133),
(5, 133),
(6, 133),
(11, 133),
(1, 134),
(5, 134),
(6, 134),
(1, 135),
(5, 135),
(6, 135),
(1, 136),
(5, 136),
(6, 136),
(1, 137),
(5, 137),
(6, 137),
(1, 138),
(5, 138),
(6, 138),
(1, 139),
(5, 139),
(6, 139),
(11, 139),
(1, 140),
(5, 140),
(6, 140),
(11, 140),
(1, 141),
(5, 141),
(6, 141),
(11, 141),
(1, 142),
(5, 142),
(6, 142),
(11, 142),
(1, 143),
(5, 143),
(6, 143),
(11, 143),
(1, 144),
(5, 144),
(6, 144),
(11, 144),
(1, 145),
(5, 145),
(6, 145),
(11, 145),
(1, 146),
(5, 146),
(6, 146),
(11, 146),
(1, 147),
(5, 147),
(6, 147),
(11, 147),
(1, 148),
(5, 148),
(6, 148),
(11, 148),
(1, 149),
(5, 149),
(6, 149),
(11, 149),
(1, 150),
(5, 150),
(6, 150),
(11, 150),
(1, 151),
(5, 151),
(6, 151),
(11, 151),
(1, 152),
(5, 152),
(6, 152),
(11, 152),
(1, 153),
(5, 153),
(6, 153),
(11, 153),
(1, 154),
(5, 154),
(6, 154),
(11, 154),
(1, 155),
(5, 155),
(6, 155),
(11, 155),
(1, 156),
(5, 156),
(6, 156),
(11, 156),
(1, 157),
(5, 157),
(6, 157),
(11, 157),
(1, 158),
(5, 158),
(6, 158),
(11, 158),
(1, 159),
(5, 159),
(6, 159),
(11, 159),
(1, 160),
(5, 160),
(6, 160),
(11, 160),
(1, 161),
(5, 161),
(6, 161),
(11, 161),
(1, 162),
(5, 162),
(6, 162),
(11, 162),
(1, 163),
(5, 163),
(6, 163),
(11, 163),
(1, 164),
(5, 164),
(6, 164),
(11, 164),
(1, 165),
(5, 165),
(6, 165),
(11, 165),
(1, 166),
(5, 166),
(6, 166),
(11, 166),
(1, 167),
(5, 167),
(6, 167),
(11, 167),
(1, 168),
(5, 168),
(6, 168),
(11, 168),
(1, 169),
(1, 170),
(1, 171),
(1, 172),
(1, 173),
(1, 174),
(5, 174),
(1, 175),
(5, 175),
(1, 176),
(5, 176),
(1, 177),
(5, 177),
(1, 178),
(5, 178),
(1, 179),
(5, 179),
(1, 180),
(1, 181),
(1, 182),
(5, 182),
(1, 183),
(1, 184),
(5, 184),
(6, 184),
(11, 184),
(1, 185),
(3, 185),
(4, 185),
(5, 185),
(6, 185),
(1, 186),
(3, 186),
(4, 186),
(5, 186),
(6, 186),
(1, 187),
(3, 187),
(4, 187),
(5, 187),
(6, 187),
(1, 188),
(4, 188),
(5, 188),
(6, 188),
(1, 189),
(4, 189),
(5, 189),
(6, 189),
(1, 190),
(3, 190),
(4, 190),
(5, 190),
(6, 190),
(1, 191),
(3, 191),
(4, 191),
(5, 191),
(6, 191),
(1, 192),
(3, 192),
(4, 192),
(5, 192),
(6, 192),
(1, 193),
(3, 193),
(4, 193),
(5, 193),
(6, 193),
(1, 194),
(3, 194),
(4, 194),
(5, 194),
(6, 194),
(1, 195),
(3, 195),
(4, 195),
(5, 195),
(6, 195),
(1, 196),
(3, 196),
(4, 196),
(5, 196),
(6, 196),
(1, 197),
(3, 197),
(4, 197),
(5, 197),
(6, 197),
(1, 198),
(3, 198),
(4, 198),
(5, 198),
(6, 198),
(1, 200),
(3, 200),
(4, 200),
(5, 200),
(6, 200),
(1, 201),
(5, 201),
(6, 201),
(7, 201),
(8, 201),
(10, 201),
(11, 201),
(1, 202),
(5, 202),
(6, 202),
(7, 202),
(8, 202),
(10, 202),
(11, 202),
(1, 203),
(5, 203),
(6, 203),
(7, 203),
(8, 203),
(10, 203),
(11, 203),
(1, 204),
(5, 204),
(6, 204),
(7, 204),
(8, 204),
(10, 204),
(11, 204),
(1, 205),
(4, 205),
(5, 205),
(6, 205),
(1, 206),
(3, 206),
(5, 206),
(6, 206),
(1, 207),
(3, 207),
(5, 207),
(6, 207),
(1, 208),
(5, 208),
(6, 208),
(7, 208),
(10, 208),
(11, 208),
(1, 209),
(5, 209),
(6, 209),
(7, 209),
(10, 209),
(11, 209),
(1, 210),
(5, 210),
(6, 210),
(7, 210),
(8, 210),
(10, 210),
(11, 210),
(1, 211),
(5, 211),
(6, 211),
(7, 211),
(10, 211),
(11, 211),
(1, 212),
(5, 212),
(6, 212),
(7, 212),
(10, 212),
(11, 212),
(1, 213),
(5, 213),
(6, 213),
(7, 213),
(10, 213),
(11, 213),
(1, 214),
(5, 214),
(6, 214),
(7, 214),
(8, 214),
(10, 214),
(11, 214),
(1, 215),
(5, 215),
(6, 215),
(7, 215),
(8, 215),
(10, 215),
(11, 215),
(1, 216),
(5, 216),
(6, 216),
(7, 216),
(8, 216),
(10, 216),
(11, 216),
(1, 217),
(2, 217),
(3, 217),
(4, 217),
(5, 217),
(6, 217),
(1, 218),
(2, 218),
(3, 218),
(4, 218),
(5, 218),
(6, 218),
(1, 219),
(5, 219),
(1, 220),
(5, 220),
(6, 220),
(7, 220),
(10, 220),
(11, 220),
(1, 221),
(5, 221),
(6, 221),
(7, 221),
(10, 221),
(11, 221),
(1, 222),
(5, 222),
(7, 222),
(1, 223),
(5, 223),
(7, 223),
(1, 224),
(5, 224),
(7, 224),
(1, 225),
(5, 225),
(6, 225),
(7, 225),
(1, 226),
(5, 226),
(6, 226),
(7, 226),
(10, 226),
(11, 226),
(1, 227),
(5, 227),
(6, 227),
(7, 227),
(10, 227),
(11, 227),
(1, 228),
(5, 228),
(6, 228),
(7, 228),
(10, 228),
(11, 228),
(1, 229),
(5, 229),
(6, 229),
(10, 229),
(1, 230),
(5, 230),
(6, 230),
(7, 230),
(10, 230),
(11, 230),
(1, 231),
(5, 231),
(6, 231),
(7, 231),
(8, 231),
(10, 231),
(11, 231),
(1, 232),
(5, 232),
(6, 232),
(8, 232),
(11, 232),
(1, 233),
(5, 233),
(6, 233),
(8, 233),
(1, 234),
(5, 234),
(6, 234),
(8, 234),
(11, 234),
(1, 235),
(3, 235),
(4, 235),
(5, 235),
(6, 235),
(1, 236),
(3, 236),
(4, 236),
(5, 236),
(6, 236),
(1, 237),
(3, 237),
(4, 237),
(5, 237),
(6, 237),
(1, 238),
(3, 238),
(5, 238),
(6, 238),
(1, 239),
(3, 239),
(4, 239),
(5, 239),
(6, 239),
(1, 240),
(5, 240),
(6, 240),
(10, 240),
(11, 240),
(1, 241),
(5, 241),
(6, 241),
(10, 241),
(11, 241),
(1, 242),
(5, 242),
(6, 242),
(10, 242),
(11, 242),
(1, 243),
(5, 243),
(6, 243),
(10, 243),
(11, 243),
(1, 244),
(5, 244),
(6, 244),
(10, 244),
(11, 244),
(1, 245),
(5, 245),
(6, 245),
(10, 245),
(11, 245),
(1, 246),
(5, 246),
(6, 246),
(10, 246),
(11, 246),
(1, 247),
(5, 247),
(6, 247),
(10, 247),
(11, 247),
(1, 248),
(5, 248),
(6, 248),
(10, 248),
(11, 248),
(1, 249),
(5, 249),
(6, 249),
(10, 249),
(11, 249),
(1, 250),
(5, 250),
(6, 250),
(10, 250),
(11, 250),
(1, 251),
(5, 251),
(6, 251),
(10, 251),
(11, 251),
(1, 252),
(5, 252),
(6, 252),
(10, 252),
(11, 252),
(1, 253),
(5, 253),
(6, 253),
(10, 253),
(11, 253),
(1, 254),
(5, 254),
(6, 254),
(10, 254),
(11, 254),
(1, 255),
(5, 255),
(6, 255),
(10, 255),
(11, 255),
(1, 256),
(5, 256),
(6, 256),
(10, 256),
(11, 256),
(1, 257),
(5, 257),
(7, 257),
(1, 258),
(5, 258),
(6, 258),
(1, 259),
(5, 259),
(7, 259),
(1, 260),
(5, 260),
(7, 260),
(1, 261),
(5, 261),
(6, 261),
(8, 261),
(10, 261),
(11, 261),
(1, 262),
(5, 262),
(7, 262),
(1, 263),
(5, 263),
(7, 263),
(1, 264),
(5, 264),
(7, 264),
(1, 265),
(5, 265),
(7, 265),
(1, 266),
(5, 266),
(6, 266),
(7, 266),
(8, 266),
(10, 266),
(11, 266),
(1, 267),
(5, 267),
(7, 267),
(1, 268),
(5, 268),
(7, 268),
(1, 269),
(5, 269),
(7, 269),
(1, 270),
(5, 270),
(7, 270),
(1, 271),
(5, 271),
(7, 271),
(1, 272),
(5, 272),
(7, 272),
(1, 273),
(5, 273),
(7, 273),
(1, 274),
(5, 274),
(7, 274),
(1, 275),
(5, 275),
(7, 275),
(1, 276),
(5, 276),
(6, 276),
(7, 276),
(1, 277),
(5, 277),
(6, 277),
(7, 277),
(1, 278),
(5, 278),
(6, 278),
(7, 278),
(1, 279),
(5, 279),
(7, 279),
(1, 280),
(5, 280),
(6, 280),
(7, 280),
(1, 281),
(5, 281),
(6, 281),
(7, 281),
(8, 281),
(10, 281),
(11, 281),
(1, 282),
(5, 282),
(6, 282),
(1, 283),
(3, 283),
(4, 283),
(1, 284),
(5, 284),
(12, 284),
(1, 285),
(5, 285),
(12, 285),
(1, 286),
(5, 286),
(12, 286),
(1, 287),
(5, 287),
(12, 287),
(1, 288),
(3, 288),
(4, 288),
(5, 288),
(1, 289),
(4, 289),
(5, 289),
(1, 290),
(5, 290),
(7, 290),
(1, 291),
(5, 291),
(6, 291),
(7, 291),
(10, 291),
(1, 292),
(5, 292),
(6, 292),
(1, 293),
(5, 293),
(6, 293),
(1, 294),
(5, 294),
(6, 294),
(1, 295),
(5, 295),
(6, 295),
(1, 296),
(5, 296),
(6, 296),
(1, 297),
(5, 297),
(7, 297),
(1, 298),
(5, 298),
(6, 298),
(7, 298),
(1, 299),
(5, 299),
(6, 299),
(7, 299),
(1, 300),
(5, 300),
(7, 300),
(1, 301),
(5, 301),
(6, 301),
(7, 301),
(1, 302),
(5, 302),
(7, 302),
(1, 303),
(5, 303),
(7, 303),
(1, 304),
(5, 304),
(7, 304),
(1, 305),
(5, 305),
(7, 305),
(1, 306),
(5, 306),
(7, 306),
(1, 307),
(5, 307),
(7, 307),
(1, 308),
(5, 308),
(6, 308),
(7, 308),
(1, 309),
(5, 309),
(7, 309),
(1, 310),
(5, 310),
(7, 310),
(1, 311),
(5, 311),
(7, 311),
(1, 312),
(5, 312),
(7, 312),
(1, 313),
(5, 313),
(7, 313),
(1, 314),
(5, 314),
(6, 314),
(7, 314),
(1, 315),
(5, 315),
(7, 315),
(1, 316),
(5, 316),
(7, 316),
(1, 317),
(5, 317),
(7, 317),
(1, 318),
(5, 318),
(7, 318),
(1, 319),
(5, 319),
(6, 319),
(1, 320),
(5, 320),
(7, 320),
(1, 321),
(5, 321),
(7, 321),
(1, 322),
(5, 322),
(6, 322),
(7, 322),
(1, 323),
(5, 323),
(6, 323),
(7, 323),
(1, 324),
(5, 324),
(6, 324),
(7, 324),
(1, 325),
(5, 325),
(6, 325),
(7, 325),
(1, 326),
(5, 326),
(6, 326),
(7, 326),
(1, 327),
(5, 327),
(6, 327),
(7, 327),
(1, 328),
(5, 328),
(6, 328),
(7, 328),
(1, 329),
(5, 329),
(6, 329),
(7, 329),
(1, 330),
(5, 330),
(6, 330),
(7, 330),
(1, 331),
(5, 331),
(6, 331),
(7, 331),
(1, 332),
(5, 332),
(6, 332),
(7, 332),
(1, 333),
(5, 333),
(12, 333),
(3, 334),
(4, 334);

-- --------------------------------------------------------

--
-- Table structure for table `groups_has_modules`
--

CREATE TABLE `groups_has_modules` (
  `groups_id` int(11) NOT NULL,
  `modules_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups_has_modules`
--

INSERT INTO `groups_has_modules` (`groups_id`, `modules_id`) VALUES
(1, 1),
(5, 1),
(6, 1),
(10, 1),
(11, 1),
(12, 1),
(1, 5),
(2, 5),
(3, 5),
(4, 5),
(5, 5),
(6, 5),
(7, 5),
(8, 5),
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(1, 6),
(5, 6),
(6, 6),
(7, 6),
(8, 6),
(9, 6),
(10, 6),
(11, 6),
(12, 6),
(1, 7),
(5, 7),
(6, 7),
(7, 7),
(8, 7),
(10, 7),
(11, 7),
(12, 7),
(1, 8),
(5, 8),
(6, 8),
(7, 8),
(8, 8),
(10, 8),
(11, 8),
(12, 8),
(1, 9),
(5, 9),
(6, 9),
(7, 9),
(8, 9),
(10, 9),
(11, 9),
(12, 9),
(1, 10),
(2, 10),
(3, 10),
(4, 10),
(5, 10),
(6, 10),
(10, 10),
(11, 10),
(12, 10),
(1, 11),
(5, 11),
(6, 11),
(10, 11),
(11, 11),
(12, 11),
(1, 12),
(5, 12),
(6, 12),
(10, 12),
(11, 12),
(12, 12);

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
`id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `limit_date_submission` date NOT NULL,
  `given_date` date NOT NULL,
  `attachment_ref` varchar(255) NOT NULL,
  `academic_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `homework_submission`
--

CREATE TABLE `homework_submission` (
`id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `homework_id` int(11) NOT NULL,
  `date_submission` date NOT NULL,
  `comment` varchar(255) NOT NULL,
  `attachment_ref` varchar(100) NOT NULL,
  `grade_value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `infraction_type`
--

CREATE TABLE `infraction_type` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `deductible_value` float DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `infraction_type`
--

INSERT INTO `infraction_type` (`id`, `name`, `description`, `deductible_value`) VALUES
(1, 'Tapage en classe', '', 2),
(2, 'Bagarre', 'Quand deux ou plusieurs eleves se battent dans la salle de classe ou sur la cours de l''ecole', 5);

-- --------------------------------------------------------

--
-- Table structure for table `job_status`
--

CREATE TABLE `job_status` (
`id` int(11) NOT NULL,
  `status_name` varchar(45) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `job_status`
--

INSERT INTO `job_status` (`id`, `status_name`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Contractuel', '2015-08-20 00:00:00', NULL, NULL, NULL),
(2, 'Amployé à plein temps ', '2016-04-14 00:00:00', '2016-04-14 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `label_category_for_billing`
--

CREATE TABLE `label_category_for_billing` (
`id` int(11) NOT NULL,
  `category` varchar(220) NOT NULL,
  `income_expense` varchar(3) NOT NULL COMMENT 'ri: income; di: expense'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `label_category_for_billing`
--

INSERT INTO `label_category_for_billing` (`id`, `category`, `income_expense`) VALUES
(1, 'Donations and grants', 'ri'),
(2, 'Other incomes', 'ri'),
(3, 'Rent expenses', 'di'),
(4, 'Amenities and services', 'di'),
(5, 'Staff', 'di'),
(6, 'Tax', 'di'),
(7, 'Other expenses', 'di');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
`id` int(11) NOT NULL COMMENT 'School level (calling classes dans le system scolaire Haitien)',
  `level_name` varchar(45) NOT NULL,
  `short_level_name` varchar(45) NOT NULL,
  `previous_level` int(11) DEFAULT NULL,
  `section` int(11) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `level_name`, `short_level_name`, `previous_level`, `section`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Première Année', '1ère AF', 14, 1, '2014-09-23 00:00:00', '2015-08-29 00:00:00', 'admin', 'admin'),
(2, 'Deuxième Année', '2ème AF', 1, 1, '2014-09-23 00:00:00', '2015-08-29 00:00:00', 'admin', 'admin'),
(3, 'Troisième Année', '3ème AF', 2, 1, '2014-09-23 00:00:00', '2015-08-29 00:00:00', 'admin', 'admin'),
(4, 'Quatrième Année', '4ème AF', 3, 1, '2014-09-23 00:00:00', '2015-08-29 00:00:00', 'admin', 'admin'),
(5, 'Cinquième Année', '5ème AF', 4, 1, '2014-09-23 00:00:00', '2015-08-29 00:00:00', 'admin', 'admin'),
(6, 'Sixième Année', '6ème AF', 5, 1, '2014-09-23 00:00:00', '2015-08-29 00:00:00', 'admin', 'admin'),
(7, 'Septième Année', '7ème AF', 6, 1, '2014-09-23 00:00:00', '2015-08-29 00:00:00', 'admin', 'admin'),
(8, 'Huitième Année', '8ème AF', 7, 1, '2014-09-23 00:00:00', '2015-08-29 00:00:00', 'admin', 'admin'),
(9, 'Neuvième Année', '9ème AF', 8, 1, '2014-09-23 00:00:00', '2015-08-29 00:00:00', 'admin', 'admin'),
(10, 'Troisième', 'Troisième', 9, 2, '2014-09-23 00:00:00', '2015-08-27 00:00:00', 'admin', 'admin'),
(11, 'Seconde', 'Seconde', 10, 2, '2014-09-23 00:00:00', '2015-08-27 00:00:00', 'admin', 'admin'),
(12, 'Rhéto', 'Rhéto', 11, 2, '2014-09-23 00:00:00', '2015-08-27 00:00:00', 'admin', 'admin'),
(13, 'Terminale ', 'Terminale', 12, 2, '2015-08-20 00:00:00', '2015-08-27 00:00:00', 'admin', 'admin'),
(14, 'Section des Grands', 'Grands', NULL, 3, '2015-08-29 00:00:00', '2015-08-29 00:00:00', 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `level_has_person`
--

CREATE TABLE `level_has_person` (
`id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `students` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `loan_of_money`
--

CREATE TABLE `loan_of_money` (
`id` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `person_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `payroll_month` int(3) NOT NULL,
  `deduction_percentage` int(3) NOT NULL,
  `solde` double NOT NULL,
  `paid` int(1) NOT NULL DEFAULT '0',
  `number_of_month_repayment` int(5) NOT NULL,
  `remaining_month_number` int(5) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL,
  `created_by` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
`id` int(11) NOT NULL,
  `sender` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `receivers` text CHARACTER SET utf8,
  `subject` varchar(255) CHARACTER SET utf8 NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `is_read` int(1) DEFAULT NULL,
  `id_sender` int(11) DEFAULT NULL,
  `date_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_delete` int(11) DEFAULT NULL,
  `is_my_send` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
`id` int(11) NOT NULL,
  `module_short_name` varchar(64) NOT NULL,
  `module_name` varchar(64) NOT NULL,
  `mod_lateral_menu` varchar(255) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_short_name`, `module_name`, `mod_lateral_menu`, `create_date`, `update_date`, `create_by`, `update_by`) VALUES
(1, 'configuration', 'Paramètre Ecole', '//layouts/menuSchoolSetting', NULL, NULL, NULL, NULL),
(5, 'users', 'Utilisateur', '//layouts/menuUser', NULL, NULL, NULL, NULL),
(6, 'reports', 'Reports', '//layouts/menuReportManager', NULL, NULL, NULL, NULL),
(7, 'schoolconfig', 'Gestion académique', '//layouts/menuAcademicSetting', NULL, NULL, NULL, NULL),
(8, 'billings', 'Facturation', '//layouts/menuBilling', NULL, NULL, NULL, NULL),
(9, 'academic', 'Académique', '//layouts/menuStudentManager', NULL, NULL, NULL, NULL),
(10, 'guest', 'Invite', NULL, NULL, NULL, NULL, NULL),
(11, 'discipline', 'Discipline', '', NULL, NULL, NULL, NULL),
(12, 'portal', 'Portal', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `other_incomes`
--

CREATE TABLE `other_incomes` (
`id` int(11) NOT NULL,
  `id_income_description` int(11) NOT NULL,
  `amount` double NOT NULL,
  `income_date` date NOT NULL,
  `academic_year` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `created_by` varchar(65) NOT NULL,
  `updated_by` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `other_incomes_description`
--

CREATE TABLE `other_incomes_description` (
`id` int(11) NOT NULL,
  `income_description` varchar(65) NOT NULL,
  `category` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `other_incomes_description`
--

INSERT INTO `other_incomes_description` (`id`, `income_description`, `category`, `comment`) VALUES
(1, 'Admission', 2, ''),
(2, 'Sorties educatives', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
`id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `activity_field` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `passing_grades`
--

CREATE TABLE `passing_grades` (
`id` int(11) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `course` int(11) DEFAULT NULL,
  `academic_period` int(11) NOT NULL,
  `minimum_passing` float NOT NULL,
  `level_or_course` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: level, 1: course',
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(20) DEFAULT NULL,
  `update_by` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
`id` int(11) NOT NULL,
  `method_name` varchar(45) NOT NULL,
  `description` text,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`id`, `method_name`, `description`, `date_create`, `date_update`, `create_by`, `update_by`) VALUES
(1, 'Virement bancaire', 'Le parent apporte la fiche bancaire. La secrétaire enregistre le paiement dans le registre de paiement. Le parent de l''élève doit payer intégralement pour que sa fiche soit acceptée. ', NULL, NULL, NULL, NULL),
(2, 'Chèque', 'Cheque tire sur banque haitienne uniquement', '2016-04-14 00:00:00', NULL, NULL, NULL),
(3, 'Liquide', '', '2016-04-14 00:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
`id` int(11) NOT NULL,
  `id_payroll_set` int(11) NOT NULL,
  `payroll_month` int(3) NOT NULL,
  `payroll_date` date NOT NULL,
  `missing_hour` int(11) NOT NULL,
  `taxe` double NOT NULL,
  `net_salary` double NOT NULL,
  `payment_date` date NOT NULL,
  `cash_check` varchar(45) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL,
  `created_by` varchar(65) NOT NULL,
  `updated_by` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_settings`
--

CREATE TABLE `payroll_settings` (
`id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `an_hour` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0:no, 1:yes',
  `number_of_hour` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `as` int(2) DEFAULT '0' COMMENT '0: employee; 1: teacher',
  `old_new` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0: old setting; 1: new setting',
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL,
  `created_by` varchar(65) NOT NULL,
  `updated_by` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_setting_taxes`
--

CREATE TABLE `payroll_setting_taxes` (
`id` int(11) NOT NULL,
  `id_payroll_set` int(11) NOT NULL,
  `id_taxe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
`id` int(11) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `first_name` varchar(120) NOT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `blood_group` varchar(10) NOT NULL,
  `birthday` date DEFAULT NULL,
  `id_number` varchar(50) DEFAULT NULL,
  `is_student` tinyint(1) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `nif_cin` varchar(100) NOT NULL,
  `cities` int(11) DEFAULT NULL,
  `citizenship` varchar(45) NOT NULL,
  `mother_first_name` varchar(55) DEFAULT NULL COMMENT 'student for ( Ministere Edu. Nat)',
  `identifiant` varchar(100) DEFAULT NULL COMMENT 'student for ( Ministere Edu. Nat)',
  `matricule` varchar(100) DEFAULT NULL COMMENT 'student for ( Ministere Edu. Nat)',
  `paid` tinyint(2) DEFAULT NULL COMMENT 'for admission list. 0: not yet paid; 1: already paid; NULL: left admission list ',
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT 'rhe',
  `update_by` varchar(45) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`id`, `last_name`, `first_name`, `gender`, `blood_group`, `birthday`, `id_number`, `is_student`, `adresse`, `phone`, `email`, `nif_cin`, `cities`, `citizenship`, `mother_first_name`, `identifiant`, `matricule`, `paid`, `date_created`, `date_updated`, `create_by`, `update_by`, `active`, `image`, `comment`) VALUES
(1, 'Super', 'Admin', NULL, '', NULL, NULL, NULL, NULL, NULL, 'jehilaire@logipam.com', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, ''),
(2, 'Roimage', 'Baltazar', '0', '1', '0000-00-00', '', 0, '', '', 'jcpoulard@gmail.com', '', 8, '', NULL, NULL, NULL, NULL, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, '', ''),
(3, 'Pierre', 'Meredith', '1', '', '0000-00-00', '', 0, '', '', 'mpierre@gmail.com', '', NULL, '', NULL, NULL, NULL, NULL, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, 'Chauvet.jpg', ''),
(4, 'Andre', 'Mackenson', '0', '2', '1993-04-22', '', 1, '', '', 'metminwi@gmail.com', '', 98, '', '', '', '', NULL, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, 'AVT_Jacques-Roumain_8038.jpeg', ''),
(5, 'Pouli', 'Pametecours', '1', '', '1990-04-10', '', 0, '', '', '', '', NULL, '', NULL, NULL, NULL, NULL, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, '', ''),
(6, 'Fouad', 'Andre', '0', '4', '0000-00-00', '', 0, '', '', '', '', NULL, '', NULL, NULL, NULL, NULL, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, '', ''),
(7, 'Charrier', 'Michelle', '1', '5', '0000-00-00', '', 0, '', '', 'jmarc2@fau.edu', '', NULL, '', NULL, NULL, NULL, NULL, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, '', ''),
(8, 'Pierre', 'Marise', '1', '5', '0000-00-00', '', 0, '', '', 'jnbmarc@hotmail.com', '', NULL, '', NULL, NULL, NULL, NULL, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, '', ''),
(9, 'Celestin', 'Mia', '1', '6', '0000-00-00', '', 0, '', '', 'jcpoulard@logipam.com', '', NULL, '', NULL, NULL, NULL, NULL, '2016-04-14 00:00:00', '2016-04-15 00:00:00', 'rhe', NULL, 2, '', ''),
(10, 'Yucca', 'Lina', '1', '3', '0000-00-00', '', 1, '', '', 'jnbmarc@yahoo.com', '', 11, '', '', '', '', NULL, '2016-04-14 00:00:00', '2016-04-15 00:00:00', 'rhe', 'admin', 1, '', ''),
(11, 'Prosper', 'Eder', '0', '', '0000-00-00', '', 1, '', '', '', '', NULL, '', '', '', '', NULL, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, '', ''),
(12, 'Fortuné', 'Herve', '0', '6', '0000-00-00', '', 0, '', '', '', '', NULL, '', NULL, NULL, NULL, NULL, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, '', ''),
(13, 'Charles', 'Samantha', '1', '4', '0000-00-00', '', 0, '', '', '', '', NULL, '', NULL, NULL, NULL, NULL, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, '', ''),
(14, 'Acril', 'Eric', '0', '', '0000-00-00', '', 0, '', '', '', '', NULL, '', NULL, NULL, NULL, NULL, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, '', ''),
(15, 'Kira', 'Machin', '1', '', '0000-00-00', '', 1, '', '', '', '', NULL, '', '', '', '', 1, '2016-04-14 00:00:00', '2016-04-14 00:00:00', 'rhe', NULL, 2, '', ''),
(16, 'Porky', 'Violant', '0', '1', '1994-04-21', '', 1, '', '', '', '', 38, '', '', '', '', NULL, '2016-04-15 00:00:00', '2016-04-15 00:00:00', 'rhe', NULL, 2, '', ''),
(17, 'Prosper', 'Metus', '0', '', '0000-00-00', '', 1, '', '', '', '', NULL, '', '', '', '', NULL, '2016-04-15 00:00:00', '2016-04-15 00:00:00', 'rhe', NULL, 2, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `persons_has_titles`
--

CREATE TABLE `persons_has_titles` (
  `persons_id` int(11) NOT NULL,
  `titles_id` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `person_history`
--

CREATE TABLE `person_history` (
`id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `entry_hire_date` datetime DEFAULT NULL,
  `leaving_date` datetime NOT NULL,
  `disable_date` datetime NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `profil` varchar(32) NOT NULL,
  `job_status_name` varchar(100) NOT NULL,
  `last_level_name` varchar(70) DEFAULT NULL,
  `academic_year` varchar(70) NOT NULL,
  `created_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
`id` int(11) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `stock_alert` int(11) NOT NULL DEFAULT '0',
  `is_forsale` tinyint(1) DEFAULT NULL,
  `create_by` varchar(64) DEFAULT NULL,
  `update_by` varchar(64) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
`id` int(11) NOT NULL,
  `profil_name` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id`, `profil_name`) VALUES
(1, 'Admin'),
(2, 'Manager'),
(3, 'Billing'),
(4, 'Teacher'),
(5, 'Guest'),
(6, 'Reporter');

-- --------------------------------------------------------

--
-- Table structure for table `profil_has_modules`
--

CREATE TABLE `profil_has_modules` (
`id` int(11) NOT NULL,
  `profil_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profil_has_modules`
--

INSERT INTO `profil_has_modules` (`id`, `profil_id`, `module_id`) VALUES
(1, 1, 1),
(2, 1, 5),
(3, 1, 6),
(4, 1, 7),
(5, 1, 8),
(6, 1, 9),
(7, 1, 10),
(8, 2, 1),
(9, 2, 5),
(10, 2, 6),
(11, 2, 7),
(12, 2, 9),
(13, 2, 10),
(14, 3, 5),
(15, 3, 6),
(16, 3, 8),
(17, 4, 5),
(18, 4, 6),
(19, 4, 7),
(20, 4, 9),
(21, 5, 5),
(22, 5, 10),
(23, 6, 5),
(24, 6, 6),
(25, 1, 11),
(26, 2, 11),
(27, 2, 8),
(28, 3, 7),
(29, 3, 9),
(30, 1, 12),
(31, 2, 12),
(32, 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
`id` int(11) NOT NULL,
  `qualification_name` varchar(45) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `qualification_name`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Licence', '2016-04-14 00:00:00', NULL, NULL, NULL),
(2, 'Maitrise', '2016-04-14 00:00:00', NULL, NULL, NULL),
(3, 'Certificat', '2016-04-14 00:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `raise_salary`
--

CREATE TABLE `raise_salary` (
`id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `raising_date` date NOT NULL,
  `academic_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `record_infraction`
--

CREATE TABLE `record_infraction` (
`id` bigint(20) NOT NULL,
  `student` int(20) NOT NULL,
  `infraction_type` int(11) NOT NULL,
  `record_by` varchar(64) NOT NULL,
  `incident_date` date NOT NULL,
  `academic_period` int(11) DEFAULT NULL,
  `exam_period` int(11) DEFAULT NULL,
  `incident_description` text NOT NULL,
  `decision_description` text,
  `value_deduction` float DEFAULT NULL,
  `general_comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `record_presence`
--

CREATE TABLE `record_presence` (
`id` int(11) NOT NULL,
  `student` int(20) NOT NULL,
  `room` int(11) DEFAULT NULL,
  `academic_period` int(11) DEFAULT NULL,
  `exam_period` int(11) DEFAULT NULL,
  `date_record` date NOT NULL,
  `presence_type` int(11) NOT NULL,
  `comments` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `relations`
--

CREATE TABLE `relations` (
`id` int(11) NOT NULL,
  `relation_name` varchar(45) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `relations`
--

INSERT INTO `relations` (`id`, `relation_name`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Père ', NULL, '2016-04-14 00:00:00', NULL, NULL),
(3, 'Mère', NULL, NULL, NULL, NULL),
(5, 'Autres', NULL, NULL, NULL, NULL),
(6, 'Frère', '2016-04-14 00:00:00', NULL, NULL, NULL),
(7, 'Cousin', '2016-04-14 00:00:00', NULL, NULL, NULL),
(8, 'Grand-Mère', '2016-04-14 00:00:00', '2016-04-14 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `return_history`
--

CREATE TABLE `return_history` (
`id` int(11) NOT NULL,
  `id_transaction` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `return_amount` float NOT NULL,
  `return_quantity` int(11) NOT NULL,
  `date_return` datetime NOT NULL,
  `return_by` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
`id` int(11) NOT NULL,
  `room_name` varchar(45) NOT NULL,
  `short_room_name` varchar(45) NOT NULL,
  `level` int(11) NOT NULL,
  `shift` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_name`, `short_room_name`, `level`, `shift`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Première Année', '', 1, 1, '2014-09-23 00:00:00', '2014-09-23 00:00:00', 'admin', NULL),
(2, 'Deuxième Année', '', 2, 1, '2014-09-23 00:00:00', '2014-09-23 00:00:00', 'admin', NULL),
(3, 'Troisième Année', '', 3, 1, '2014-09-23 00:00:00', '2014-09-23 00:00:00', 'admin', NULL),
(4, 'Quatrième Année', '', 4, 1, '2014-09-23 00:00:00', '2014-09-23 00:00:00', 'admin', NULL),
(5, 'Cinquième Année', '', 5, 1, '2014-09-23 00:00:00', '2014-09-23 00:00:00', 'admin', NULL),
(6, 'Sixième Année', '', 6, 1, '2014-09-23 00:00:00', '2014-09-23 00:00:00', 'admin', NULL),
(7, 'Septième Année', '', 7, 1, '2014-09-23 00:00:00', '2014-09-23 00:00:00', 'admin', NULL),
(8, 'Huitième Année', '', 8, 1, '2014-09-23 00:00:00', '2014-09-23 00:00:00', 'admin', NULL),
(9, 'Neuvième Année', '', 9, 1, '2014-09-23 00:00:00', '2014-09-23 00:00:00', 'admin', NULL),
(10, 'Troisième', '3e', 10, 1, '2014-09-23 00:00:00', '2016-04-14 00:00:00', 'admin', 'admin'),
(11, 'Seconde', '', 11, 1, '2014-09-23 00:00:00', '2014-09-23 00:00:00', 'admin', NULL),
(12, 'Rheto', '', 12, 1, '2014-09-23 00:00:00', '2014-09-23 00:00:00', 'admin', NULL),
(13, 'Terminale ', '', 13, 1, '2015-08-20 00:00:00', '2015-08-20 00:00:00', 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `room_has_person`
--

CREATE TABLE `room_has_person` (
`id` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `students` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sale_transaction`
--

CREATE TABLE `sale_transaction` (
`id` int(11) NOT NULL,
  `id_transaction` int(11) NOT NULL,
  `amount_sale` float NOT NULL,
  `discount` float DEFAULT NULL,
  `amount_receive` float NOT NULL,
  `amount_balance` float NOT NULL,
  `create_by` varchar(64) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by` varchar(64) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `scalendar`
--

CREATE TABLE `scalendar` (
`id` int(11) NOT NULL,
  `c_title` varchar(255) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_all_day_event` smallint(6) NOT NULL,
  `color` varchar(200) DEFAULT NULL,
  `academic_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
`id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `day_course` varchar(32) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_holder`
--

CREATE TABLE `scholarship_holder` (
`id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `partner` int(11) DEFAULT NULL,
  `percentage_pay` double NOT NULL,
  `is_internal` tinyint(1) NOT NULL DEFAULT '0',
  `academic_year` int(11) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
`id` int(11) NOT NULL,
  `section_name` varchar(45) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section_name`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Fondamental', '2014-09-23 00:00:00', '2014-09-23 00:00:00', NULL, NULL),
(2, 'Secondaire', '2014-09-23 00:00:00', '2015-08-20 02:08:20', NULL, NULL),
(3, 'Préscolaire', '2015-08-29 00:00:00', '2015-08-29 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `section_has_cycle`
--

CREATE TABLE `section_has_cycle` (
`id` int(11) NOT NULL,
  `cycle` int(11) NOT NULL,
  `section` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sellings`
--

CREATE TABLE `sellings` (
`id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `id_products` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `selling_date` datetime NOT NULL,
  `client_name` varchar(128) DEFAULT NULL,
  `sell_by` varchar(64) DEFAULT NULL,
  `amount_receive` float DEFAULT NULL,
  `amount_selling` float DEFAULT NULL,
  `amount_balance` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `update_by` varchar(64) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `unit_selling_price` float DEFAULT NULL,
  `is_return` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  `user_id` int(11) NOT NULL,
  `last_activity` datetime NOT NULL,
  `last_ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `expire`, `data`, `user_id`, `last_activity`, `last_ip`) VALUES
('7c6td9etponhokik3cp9udvfi6', 1460692537, 0x6d61696e5f70726f66696c7c733a353a2241646d696e223b31666232633036373138333165343861643635646337363963306232313664365f5f69647c733a353a2261646d696e223b31666232633036373138333165343861643635646337363963306232313664365f5f6e616d657c733a353a2261646d696e223b316662326330363731383331653438616436356463373639633062323136643670726f66696c7c733a353a2241646d696e223b31666232633036373138333165343861643635646337363963306232313664367573657269647c733a313a2231223b316662326330363731383331653438616436356463373639633062323136643667726f757069647c733a313a2235223b316662326330363731383331653438616436356463373639633062323136643666756c6c6e616d657c733a353a2241646d696e223b3166623263303637313833316534386164363564633736396330623231366436656d61696c7c733a32313a226a6568696c61697265406c6f676970616d2e636f6d223b3166623263303637313833316534386164363564633736396330623231366436706572736f6e69647c733a313a2231223b3166623263303637313833316534386164363564633736396330623231366436706172746e616d657c733a353a2241646d696e223b31666232633036373138333165343861643635646337363963306232313664365f5f7374617465737c613a373a7b733a363a2270726f66696c223b623a313b733a363a22757365726964223b623a313b733a373a2267726f75706964223b623a313b733a383a2266756c6c6e616d65223b623a313b733a353a22656d61696c223b623a313b733a383a22706572736f6e6964223b623a313b733a383a22706172746e616d65223b623a313b7d656d706c6f7965655f746561636865727c693a303b63757272656e7449645f61636164656d69635f796561727c733a313a2231223b63757272656e744e616d655f61636164656d69635f796561727c733a393a22323031352d32303136223b63757272656e63794e616d657c733a363a22476f75726465223b63757272656e637953796d626f6c7c733a333a22485447223b6c6173745f7472616e73616374696f6e7c733a313a2235223b31666232633036373138333165343861643635646337363963306232313664365969692e43576562557365722e666c617368636f756e746572737c613a303a7b7d, 1, '2016-04-15 03:31:37', '200.113.234.73');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
`id` int(11) NOT NULL,
  `shift_name` varchar(45) NOT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `shift_name`, `time_start`, `time_end`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Matin', '07:00:00', '15:00:00', '2014-09-23 00:00:00', '2016-04-14 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
`id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `acquisition_date` date NOT NULL,
  `buiying_price` float DEFAULT NULL,
  `selling_price` float DEFAULT NULL,
  `is_donation` tinyint(1) DEFAULT NULL,
  `create_by` varchar(64) DEFAULT NULL,
  `update_by` varchar(64) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock_history`
--

CREATE TABLE `stock_history` (
`id` int(11) NOT NULL,
  `id_stock` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `buying_date` date NOT NULL,
  `buying_price` float NOT NULL,
  `selling_price` float NOT NULL,
  `create_by` varchar(64) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_other_info`
--

CREATE TABLE `student_other_info` (
`id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `school_date_entry` date DEFAULT NULL,
  `leaving_date` datetime NOT NULL,
  `previous_school` varchar(255) DEFAULT NULL,
  `previous_level` varchar(45) DEFAULT NULL,
  `apply_for_level` varchar(45) DEFAULT NULL,
  `health_state` varchar(255) NOT NULL,
  `father_full_name` varchar(45) NOT NULL,
  `mother_full_name` varchar(100) NOT NULL,
  `person_liable` varchar(100) NOT NULL,
  `person_liable_phone` varchar(65) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime NOT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
`id` int(11) NOT NULL,
  `subject_name` varchar(45) NOT NULL,
  `is_subject_parent` tinyint(1) DEFAULT NULL,
  `subject_parent` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL COMMENT '	',
  `create_by` varchar(45) DEFAULT NULL COMMENT '	',
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `is_subject_parent`, `subject_parent`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Espagnol', 0, NULL, '2014-10-04 01:10:44', '2014-10-04 01:10:44', NULL, NULL),
(2, 'Anglais', 0, NULL, '2014-10-04 01:10:47', '2014-10-04 01:10:47', NULL, NULL),
(3, 'Mathématiques', 1, NULL, '2014-10-04 01:10:10', '2014-10-11 12:10:44', NULL, NULL),
(4, 'Algèbre', 0, 3, '2014-10-04 01:10:49', '2014-10-11 12:10:41', NULL, NULL),
(5, 'Géométrie', 0, 3, '2014-10-04 01:10:14', '2014-10-11 12:10:11', NULL, NULL),
(6, 'Créole', 0, NULL, '2014-10-11 11:10:20', '2014-10-11 12:10:20', NULL, NULL),
(7, 'Communication française', 0, NULL, '2014-10-11 11:10:22', '2014-10-11 12:10:36', NULL, NULL),
(8, 'Biologie', 0, NULL, '2014-10-11 11:10:56', '2014-10-11 11:10:56', NULL, NULL),
(9, 'Sciences physiques ', 0, NULL, '2014-10-11 11:10:11', '2014-10-11 12:10:36', NULL, NULL),
(10, 'Sciences sociales', 1, NULL, '2014-10-11 11:10:06', '2014-10-11 11:10:06', NULL, NULL),
(11, 'Histoire', 0, 10, '2014-10-11 11:10:59', '2014-10-11 11:10:10', NULL, NULL),
(12, 'Géographie', 0, 10, '2014-10-11 11:10:50', '2014-10-11 12:10:58', NULL, NULL),
(13, 'Savoir vivre', 0, NULL, '2014-10-11 11:10:41', '2014-10-11 12:10:25', NULL, NULL),
(14, 'Sport', 0, NULL, '2014-10-11 11:10:55', '2014-10-11 12:10:40', NULL, NULL),
(15, 'Chimie', 0, NULL, '2014-10-11 11:10:59', '2014-10-11 11:10:59', NULL, NULL),
(16, 'Discipline', 0, NULL, '2014-10-11 11:10:15', '2014-10-11 11:10:15', NULL, NULL),
(17, 'Littérature', 1, NULL, '2014-10-11 11:10:01', '2014-10-11 12:10:58', NULL, NULL),
(19, 'Littérature française', 0, 17, '2014-10-11 11:10:01', '2014-10-11 12:10:50', NULL, NULL),
(20, 'Littérature haitienne', 0, 17, '2014-10-11 11:10:49', '2014-10-11 12:10:42', NULL, NULL),
(21, 'Analyse linéaire', 0, 3, '2014-10-11 12:10:02', '2014-10-11 12:10:57', NULL, NULL),
(22, 'Analyse combinatoire', 0, 3, '2014-10-11 12:10:41', '2014-10-11 12:10:41', NULL, NULL),
(23, 'Physique', 1, NULL, '2014-10-16 05:10:30', '2014-10-16 05:10:30', NULL, NULL),
(39, 'Ecriture & Copie', 0, NULL, '2014-11-03 07:11:57', '2014-11-04 08:11:29', NULL, NULL),
(40, 'Catéchisme', 0, NULL, '2014-11-03 07:11:55', '2014-11-03 07:11:55', NULL, NULL),
(41, 'Communication créole', 1, NULL, '2014-11-03 07:11:24', '2014-11-06 05:11:22', NULL, NULL),
(42, 'Poésie/ Art manuel', 0, NULL, '2014-11-03 07:11:52', '2014-11-03 07:11:52', NULL, NULL),
(43, 'Lecture orale créole', 0, 41, '2014-11-03 07:11:40', '2014-11-06 05:11:46', NULL, NULL),
(44, 'Orthographe & Vocabulaire créole', 0, 41, '2014-11-03 07:11:11', '2014-11-06 05:11:46', NULL, NULL),
(45, 'Production orale & écrite créole', 0, 41, '2014-11-03 07:11:04', '2014-11-06 05:11:55', NULL, NULL),
(46, 'Problème', 0, NULL, '2014-11-03 07:11:32', '2014-11-03 07:11:32', NULL, NULL),
(47, 'Numération & Opération  ', 0, NULL, '2014-11-03 07:11:44', '2014-11-03 07:11:44', NULL, NULL),
(48, 'Francais', 1, NULL, NULL, NULL, NULL, NULL),
(49, 'Lecture orale française', 0, 48, '2014-11-03 07:11:39', '2014-11-06 05:11:09', NULL, NULL),
(50, 'Orthographe et Vocabulaire français', 0, 48, '2014-11-03 07:11:01', '2014-11-06 05:11:30', NULL, NULL),
(51, 'Grammaire et Conjugaison française', 0, 48, '2014-11-03 07:11:21', '2014-11-06 05:11:59', NULL, NULL),
(52, 'Analyse', 0, 48, '2014-11-03 07:11:09', '2014-11-03 07:11:09', NULL, NULL),
(53, 'Géométrie & Mesures', 0, NULL, '2014-11-03 07:11:13', '2014-11-06 05:11:36', NULL, NULL),
(54, 'Production orale & écrite française', 0, 48, '2014-11-03 07:11:12', '2014-11-06 05:11:07', NULL, NULL),
(55, 'Production écrite', 0, NULL, '2014-11-03 07:11:23', '2014-11-06 05:11:43', NULL, NULL),
(58, 'Grammaire et Conjugaison créole', 0, NULL, '2014-11-03 08:11:05', '2014-11-06 05:11:40', NULL, NULL),
(59, 'Sciences Expérimentales  ', 0, NULL, '2014-11-03 08:11:11', '2014-11-03 08:11:11', NULL, NULL),
(60, 'Poésie & Chant', 0, NULL, '2014-11-04 03:11:49', '2014-11-04 03:11:49', NULL, NULL),
(61, 'Art manuel', 0, NULL, '2014-11-04 03:11:21', '2014-11-04 03:11:21', NULL, NULL),
(62, 'Theorie des jeux', 0, 3, '2016-04-14 00:00:00', '2016-04-14 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject_average`
--

CREATE TABLE `subject_average` (
  `academic_year` int(11) NOT NULL,
  `evaluation_by_year` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `average` double NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL,
  `create_by` varchar(100) NOT NULL,
  `update_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
`id` int(11) NOT NULL,
  `taxe_description` varchar(120) NOT NULL,
  `employeur_employe` int(2) DEFAULT NULL COMMENT '0: employe; 1: employeur',
  `taxe_value` double NOT NULL,
  `academic_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
`id` int(11) NOT NULL,
  `title_name` varchar(45) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `create_by` varchar(45) DEFAULT NULL,
  `update_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`id`, `title_name`, `date_created`, `date_updated`, `create_by`, `update_by`) VALUES
(1, 'Secretaire', '2014-10-04 00:00:00', '2014-10-04 00:00:00', NULL, NULL),
(2, 'Responsable de discipline', '2014-10-04 00:00:00', '2014-10-04 00:00:00', NULL, NULL),
(3, 'Directrice administrative', '2014-10-04 00:00:00', '2014-10-04 00:00:00', NULL, NULL),
(4, 'Censeur', '2014-10-04 00:00:00', '2014-10-04 00:00:00', NULL, NULL),
(5, 'Responsable de cycle', '2014-10-04 00:00:00', '2014-10-04 00:00:00', NULL, NULL),
(6, 'Econome', '2014-10-04 00:00:00', '2014-10-04 00:00:00', NULL, NULL),
(9, 'Aide titulaire ', '2015-08-20 00:00:00', '2015-08-20 00:00:00', NULL, NULL),
(10, 'Petit personnel', '2015-08-20 00:00:00', '2015-08-20 00:00:00', NULL, NULL),
(11, 'Directeur', '2016-04-14 00:00:00', '2016-04-14 00:00:00', NULL, NULL),
(12, 'Webmaster', '2016-04-14 00:00:00', '2016-04-14 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `person_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `create_by` varchar(64) DEFAULT NULL,
  `update_by` varchar(64) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `profil` int(11) DEFAULT NULL,
  `group_id` int(10) DEFAULT NULL,
  `is_parent` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `last_ip` varchar(100) NOT NULL,
  `last_activity` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `active`, `person_id`, `full_name`, `create_by`, `update_by`, `date_created`, `date_updated`, `profil`, `group_id`, `is_parent`, `user_id`, `last_ip`, `last_activity`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1, 'Admin', 'admin', NULL, '2014-01-10 00:00:00', '2014-01-10 00:00:00', 1, 5, NULL, 0, '200.113.234.73', '2016-04-15 03:01:31'),
(2, 'master_user', '21232f297a57a5a743894a0e4a801fc3', 1, 0, '', 'admin', NULL, '2015-03-07 00:00:00', '2015-03-07 00:00:00', 1, 1, NULL, 0, '::1', '2016-04-15 01:28:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academicperiods`
--
ALTER TABLE `academicperiods`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_academic_periods_academic_periods1_idx` (`year`);

--
-- Indexes for table `accounting`
--
ALTER TABLE `accounting`
 ADD PRIMARY KEY (`id`), ADD KEY `academic_year` (`academic_year`);

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_action_module` (`module_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
 ADD PRIMARY KEY (`id`), ADD KEY `title` (`title`,`create_by`);

--
-- Indexes for table `arrondissements`
--
ALTER TABLE `arrondissements`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `arrondissement_name` (`arrondissement_name`), ADD KEY `departement` (`departement`);

--
-- Indexes for table `average_by_period`
--
ALTER TABLE `average_by_period`
 ADD PRIMARY KEY (`academic_year`,`evaluation_by_year`,`student`), ADD KEY `fk_average_by_period_eval_by_y` (`evaluation_by_year`), ADD KEY `fk_average_by_period_person` (`student`);

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
 ADD PRIMARY KEY (`id`), ADD KEY `student` (`student`);

--
-- Indexes for table `billings`
--
ALTER TABLE `billings`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_biiling_student_idx` (`student`), ADD KEY `fk_payment_method_idx` (`payment_method`), ADD KEY `fk_billings_fee_period` (`fee_period`), ADD KEY `academic_year` (`academic_year`);

--
-- Indexes for table `charge_description`
--
ALTER TABLE `charge_description`
 ADD PRIMARY KEY (`id`), ADD KEY `category` (`category`);

--
-- Indexes for table `charge_paid`
--
ALTER TABLE `charge_paid`
 ADD PRIMARY KEY (`id`), ADD KEY `academic_year` (`academic_year`), ADD KEY `id_charge_description` (`id_charge_description`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `city_name_UNIQUE` (`city_name`), ADD KEY `fk_cities_arrondissement_idx` (`arrondissement`);

--
-- Indexes for table `cms_article`
--
ALTER TABLE `cms_article`
 ADD PRIMARY KEY (`id`), ADD KEY `section` (`section`);

--
-- Indexes for table `cms_image`
--
ALTER TABLE `cms_image`
 ADD PRIMARY KEY (`id`), ADD KEY `label_image` (`label_image`);

--
-- Indexes for table `cms_section`
--
ALTER TABLE `cms_section`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `section_name` (`section_name`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_student_contact_info_idx` (`person`), ADD KEY `fk_relationship_idx` (`contact_relationship`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_couse_subject_idx` (`subject`), ADD KEY `fk_course_teacher_idx` (`teacher`), ADD KEY `room_idx` (`room`), ADD KEY `fk_course_period_academic_idx` (`academic_period`);

--
-- Indexes for table `custom_field`
--
ALTER TABLE `custom_field`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_field_data`
--
ALTER TABLE `custom_field_data`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_custom_field_idx` (`field_link`), ADD KEY `fk_object_id_idx` (`object_id`);

--
-- Indexes for table `Cycles`
--
ALTER TABLE `Cycles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `decision_finale`
--
ALTER TABLE `decision_finale`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_students_decision_idx` (`student`), ADD KEY `fk_academic_year_decision_idx` (`academic_year`), ADD KEY `fk_current_level_idx` (`current_level`), ADD KEY `fk_next_level_idx` (`next_level`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `department_name_UNIQUE` (`department_name`);

--
-- Indexes for table `department_has_person`
--
ALTER TABLE `department_has_person`
 ADD PRIMARY KEY (`id`), ADD KEY `department_id` (`department_id`), ADD KEY `academic_year` (`academic_year`), ADD KEY `employee` (`employee`);

--
-- Indexes for table `department_in_school`
--
ALTER TABLE `department_in_school`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devises`
--
ALTER TABLE `devises`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `devise_name_UNIQUE` (`devise_name`), ADD UNIQUE KEY `devise_symbol_UNIQUE` (`devise_symbol`);

--
-- Indexes for table `employee_info`
--
ALTER TABLE `employee_info`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_employee_qualification_idx` (`qualification`), ADD KEY `fk_employee_job_status_idx` (`job_status`), ADD KEY `fk_employee_field_of_study_idx` (`field_study`), ADD KEY `fk_employee_person` (`employee`);

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
 ADD PRIMARY KEY (`id`), ADD KEY `academic_year` (`academic_year`);

--
-- Indexes for table `evaluation_by_year`
--
ALTER TABLE `evaluation_by_year`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_evaluation_year_evaluation_idx` (`evaluation`), ADD KEY `fk_evaluation_year_academic_year_idx` (`academic_year`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
 ADD PRIMARY KEY (`id`), ADD KEY `level` (`level`), ADD KEY `academic_period` (`academic_period`), ADD KEY `devise` (`devise`), ADD KEY `fee` (`fee`);

--
-- Indexes for table `fees_label`
--
ALTER TABLE `fees_label`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `field_study`
--
ALTER TABLE `field_study`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `field_name_UNIQUE` (`field_name`);

--
-- Indexes for table `general_average_by_period`
--
ALTER TABLE `general_average_by_period`
 ADD PRIMARY KEY (`academic_year`,`academic_period`,`student`), ADD KEY `academic_year` (`academic_year`), ADD KEY `academic_period` (`academic_period`), ADD KEY `student` (`student`);

--
-- Indexes for table `general_config`
--
ALTER TABLE `general_config`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `item_name_UNIQUE` (`item_name`), ADD KEY `name` (`name`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_grades_student_idx` (`student`), ADD KEY `fk_grades_course_idx` (`course`), ADD KEY `fk_grades_evaluation_idx` (`evaluation`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`), ADD KEY `belongs_to_profil` (`belongs_to_profil`);

--
-- Indexes for table `groups_has_actions`
--
ALTER TABLE `groups_has_actions`
 ADD PRIMARY KEY (`groups_id`,`actions_id`), ADD KEY `fk_groups_has_actions_actions1_idx` (`actions_id`), ADD KEY `fk_groups_has_actions_groups1_idx` (`groups_id`);

--
-- Indexes for table `groups_has_modules`
--
ALTER TABLE `groups_has_modules`
 ADD PRIMARY KEY (`groups_id`,`modules_id`), ADD KEY `fk_groups_has_modules_modules` (`modules_id`);

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
 ADD PRIMARY KEY (`id`), ADD KEY `course` (`course`), ADD KEY `person_id` (`person_id`), ADD KEY `academic_year` (`academic_year`);

--
-- Indexes for table `homework_submission`
--
ALTER TABLE `homework_submission`
 ADD PRIMARY KEY (`id`), ADD KEY `student` (`student`), ADD KEY `homework_id` (`homework_id`);

--
-- Indexes for table `infraction_type`
--
ALTER TABLE `infraction_type`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `job_status`
--
ALTER TABLE `job_status`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `status_name_UNIQUE` (`status_name`);

--
-- Indexes for table `label_category_for_billing`
--
ALTER TABLE `label_category_for_billing`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `level_name_UNIQUE` (`level_name`), ADD KEY `fk_levels_levels1_idx` (`previous_level`), ADD KEY `section` (`section`);

--
-- Indexes for table `level_has_person`
--
ALTER TABLE `level_has_person`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_students_level_idx` (`students`), ADD KEY `fk_student_level_year_idx` (`academic_year`), ADD KEY `fk_level_students_idx` (`level`);

--
-- Indexes for table `loan_of_money`
--
ALTER TABLE `loan_of_money`
 ADD PRIMARY KEY (`id`), ADD KEY `id_payroll_set` (`person_id`), ADD KEY `academic_year` (`academic_year`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
 ADD PRIMARY KEY (`id`), ADD KEY `from` (`sender`(191),`subject`(191),`is_read`), ADD KEY `id_sender` (`id_sender`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `module_short_UNIQUE` (`module_short_name`), ADD UNIQUE KEY `module_name_UNIQUE` (`module_name`);

--
-- Indexes for table `other_incomes`
--
ALTER TABLE `other_incomes`
 ADD PRIMARY KEY (`id`), ADD KEY `academic_year` (`academic_year`), ADD KEY `id_income_description` (`id_income_description`);

--
-- Indexes for table `other_incomes_description`
--
ALTER TABLE `other_incomes_description`
 ADD PRIMARY KEY (`id`), ADD KEY `category` (`category`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passing_grades`
--
ALTER TABLE `passing_grades`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_level_passing_grade_idx` (`level`), ADD KEY `fk_academic_period_passing_idx` (`academic_period`), ADD KEY `course` (`course`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `method_name_UNIQUE` (`method_name`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
 ADD PRIMARY KEY (`id`), ADD KEY `id_paroll_set` (`id_payroll_set`);

--
-- Indexes for table `payroll_settings`
--
ALTER TABLE `payroll_settings`
 ADD PRIMARY KEY (`id`), ADD KEY `person_id` (`person_id`,`academic_year`), ADD KEY `fk_payroll_setting_academicperiods` (`academic_year`);

--
-- Indexes for table `payroll_setting_taxes`
--
ALTER TABLE `payroll_setting_taxes`
 ADD PRIMARY KEY (`id`), ADD KEY `id_payroll_set` (`id_payroll_set`), ADD KEY `id_taxe` (`id_taxe`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_persons_cities1_idx` (`cities`);

--
-- Indexes for table `persons_has_titles`
--
ALTER TABLE `persons_has_titles`
 ADD PRIMARY KEY (`persons_id`,`titles_id`,`academic_year`), ADD KEY `fk_persons_has_titles_titles1_idx` (`titles_id`), ADD KEY `fk_persons_has_titles_persons1_idx` (`persons_id`), ADD KEY `academic_year` (`academic_year`);

--
-- Indexes for table `person_history`
--
ALTER TABLE `person_history`
 ADD PRIMARY KEY (`id`), ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `product_name` (`product_name`), ADD KEY `type` (`type`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profil_has_modules`
--
ALTER TABLE `profil_has_modules`
 ADD PRIMARY KEY (`id`), ADD KEY `module_id` (`module_id`), ADD KEY `profil_id` (`profil_id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `qualification_name_UNIQUE` (`qualification_name`);

--
-- Indexes for table `raise_salary`
--
ALTER TABLE `raise_salary`
 ADD PRIMARY KEY (`id`), ADD KEY `person_id` (`person_id`,`academic_year`);

--
-- Indexes for table `record_infraction`
--
ALTER TABLE `record_infraction`
 ADD PRIMARY KEY (`id`), ADD KEY `indx_stud_infrac` (`student`), ADD KEY `infraction_type` (`infraction_type`), ADD KEY `academic_period` (`academic_period`), ADD KEY `exam_period` (`exam_period`);

--
-- Indexes for table `record_presence`
--
ALTER TABLE `record_presence`
 ADD PRIMARY KEY (`id`), ADD KEY `student` (`student`), ADD KEY `room` (`room`), ADD KEY `academic_period` (`academic_period`), ADD KEY `exam_period` (`exam_period`);

--
-- Indexes for table `relations`
--
ALTER TABLE `relations`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `relation_name_UNIQUE` (`relation_name`);

--
-- Indexes for table `return_history`
--
ALTER TABLE `return_history`
 ADD PRIMARY KEY (`id`), ADD KEY `id_transaction` (`id_transaction`), ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_room_levels1_idx` (`level`), ADD KEY `fk_room_shift_idx` (`shift`);

--
-- Indexes for table `room_has_person`
--
ALTER TABLE `room_has_person`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_students_level_idx` (`students`), ADD KEY `fk_student_level_year_idx` (`academic_year`), ADD KEY `fk_level_students_idx` (`room`);

--
-- Indexes for table `sale_transaction`
--
ALTER TABLE `sale_transaction`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_transaction` (`id_transaction`);

--
-- Indexes for table `scalendar`
--
ALTER TABLE `scalendar`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_scalendar_academic_year` (`academic_year`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_schedule_course_idx` (`course`);

--
-- Indexes for table `scholarship_holder`
--
ALTER TABLE `scholarship_holder`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_scholarship_holder_student` (`student`), ADD KEY `fk_scholarship_holder_academicperiods` (`academic_year`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_has_cycle`
--
ALTER TABLE `section_has_cycle`
 ADD PRIMARY KEY (`id`), ADD KEY `cycle` (`cycle`,`section`), ADD KEY `section` (`section`), ADD KEY `level` (`level`), ADD KEY `academic_year` (`academic_year`);

--
-- Indexes for table `sellings`
--
ALTER TABLE `sellings`
 ADD PRIMARY KEY (`id`), ADD KEY `id_products` (`id_products`), ADD KEY `transac` (`transaction_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
 ADD PRIMARY KEY (`id`), ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `stock_history`
--
ALTER TABLE `stock_history`
 ADD PRIMARY KEY (`id`), ADD KEY `id_product` (`id_product`), ADD KEY `id_stock` (`id_stock`);

--
-- Indexes for table `student_other_info`
--
ALTER TABLE `student_other_info`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_student_other_info` (`student`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_subjects_subjects1_idx` (`subject_parent`);

--
-- Indexes for table `subject_average`
--
ALTER TABLE `subject_average`
 ADD PRIMARY KEY (`academic_year`,`evaluation_by_year`,`course`), ADD KEY `fk_subject_average_evaluation_byyear` (`evaluation_by_year`), ADD KEY `fk_subject_average_course` (`course`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
 ADD PRIMARY KEY (`id`), ADD KEY `academic_year` (`academic_year`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `title_name_UNIQUE` (`title_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD KEY `group_id` (`group_id`), ADD KEY `person_idx` (`person_id`), ADD KEY `profil` (`profil`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academicperiods`
--
ALTER TABLE `academicperiods`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `accounting`
--
ALTER TABLE `accounting`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=335;
--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `arrondissements`
--
ALTER TABLE `arrondissements`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `balance`
--
ALTER TABLE `balance`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `billings`
--
ALTER TABLE `billings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `charge_description`
--
ALTER TABLE `charge_description`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `charge_paid`
--
ALTER TABLE `charge_paid`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=141;
--
-- AUTO_INCREMENT for table `cms_article`
--
ALTER TABLE `cms_article`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `cms_image`
--
ALTER TABLE `cms_image`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cms_section`
--
ALTER TABLE `cms_section`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `custom_field`
--
ALTER TABLE `custom_field`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `custom_field_data`
--
ALTER TABLE `custom_field_data`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Cycles`
--
ALTER TABLE `Cycles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `decision_finale`
--
ALTER TABLE `decision_finale`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `department_has_person`
--
ALTER TABLE `department_has_person`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department_in_school`
--
ALTER TABLE `department_in_school`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `devises`
--
ALTER TABLE `devises`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `employee_info`
--
ALTER TABLE `employee_info`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `evaluation_by_year`
--
ALTER TABLE `evaluation_by_year`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fees_label`
--
ALTER TABLE `fees_label`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `field_study`
--
ALTER TABLE `field_study`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_config`
--
ALTER TABLE `general_config`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=172;
--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `homework_submission`
--
ALTER TABLE `homework_submission`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `infraction_type`
--
ALTER TABLE `infraction_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `job_status`
--
ALTER TABLE `job_status`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `label_category_for_billing`
--
ALTER TABLE `label_category_for_billing`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'School level (calling classes dans le system scolaire Haitien)',AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `level_has_person`
--
ALTER TABLE `level_has_person`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `loan_of_money`
--
ALTER TABLE `loan_of_money`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `other_incomes`
--
ALTER TABLE `other_incomes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `other_incomes_description`
--
ALTER TABLE `other_incomes_description`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `passing_grades`
--
ALTER TABLE `passing_grades`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payroll_settings`
--
ALTER TABLE `payroll_settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payroll_setting_taxes`
--
ALTER TABLE `payroll_setting_taxes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `person_history`
--
ALTER TABLE `person_history`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `profil_has_modules`
--
ALTER TABLE `profil_has_modules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `raise_salary`
--
ALTER TABLE `raise_salary`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `record_infraction`
--
ALTER TABLE `record_infraction`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `record_presence`
--
ALTER TABLE `record_presence`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `relations`
--
ALTER TABLE `relations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `return_history`
--
ALTER TABLE `return_history`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `room_has_person`
--
ALTER TABLE `room_has_person`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sale_transaction`
--
ALTER TABLE `sale_transaction`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `scalendar`
--
ALTER TABLE `scalendar`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `scholarship_holder`
--
ALTER TABLE `scholarship_holder`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `section_has_cycle`
--
ALTER TABLE `section_has_cycle`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `sellings`
--
ALTER TABLE `sellings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_history`
--
ALTER TABLE `stock_history`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_other_info`
--
ALTER TABLE `student_other_info`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `actions`
--
ALTER TABLE `actions`
ADD CONSTRAINT `actions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `arrondissements`
--
ALTER TABLE `arrondissements`
ADD CONSTRAINT `arrondissements_ibfk_1` FOREIGN KEY (`departement`) REFERENCES `departments` (`id`);

--
-- Constraints for table `average_by_period`
--
ALTER TABLE `average_by_period`
ADD CONSTRAINT `fk_average_by_period_acad` FOREIGN KEY (`academic_year`) REFERENCES `academicperiods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_average_by_period_eval_by_y` FOREIGN KEY (`evaluation_by_year`) REFERENCES `evaluation_by_year` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_average_by_period_person` FOREIGN KEY (`student`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `balance`
--
ALTER TABLE `balance`
ADD CONSTRAINT `fk_balance_person` FOREIGN KEY (`student`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `billings`
--
ALTER TABLE `billings`
ADD CONSTRAINT `fk_biiling_student` FOREIGN KEY (`student`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_billings_fees` FOREIGN KEY (`fee_period`) REFERENCES `fees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_billing_academic_year` FOREIGN KEY (`academic_year`) REFERENCES `academicperiods` (`id`),
ADD CONSTRAINT `fk_billing_payment_method` FOREIGN KEY (`payment_method`) REFERENCES `payment_method` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `charge_paid`
--
ALTER TABLE `charge_paid`
ADD CONSTRAINT `fk_charge_paid_academicperiods` FOREIGN KEY (`academic_year`) REFERENCES `academicperiods` (`id`),
ADD CONSTRAINT `fk_charge_paid_charge_description` FOREIGN KEY (`id_charge_description`) REFERENCES `charge_description` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
ADD CONSTRAINT `fk_cities_arrondissement` FOREIGN KEY (`arrondissement`) REFERENCES `arrondissements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cms_article`
--
ALTER TABLE `cms_article`
ADD CONSTRAINT `cms_article_ibfk_1` FOREIGN KEY (`section`) REFERENCES `cms_section` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `contact_info`
--
ALTER TABLE `contact_info`
ADD CONSTRAINT `fk_contact_info` FOREIGN KEY (`person`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_relationship` FOREIGN KEY (`contact_relationship`) REFERENCES `relations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
ADD CONSTRAINT `fk_course_period_academic` FOREIGN KEY (`academic_period`) REFERENCES `academicperiods` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
ADD CONSTRAINT `fk_course_room` FOREIGN KEY (`room`) REFERENCES `rooms` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
ADD CONSTRAINT `fk_course_teacher` FOREIGN KEY (`teacher`) REFERENCES `persons` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
ADD CONSTRAINT `fk_couse_subject` FOREIGN KEY (`subject`) REFERENCES `subjects` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `custom_field_data`
--
ALTER TABLE `custom_field_data`
ADD CONSTRAINT `fk_custom_field` FOREIGN KEY (`field_link`) REFERENCES `custom_field` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_object_id` FOREIGN KEY (`object_id`) REFERENCES `persons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `decision_finale`
--
ALTER TABLE `decision_finale`
ADD CONSTRAINT `fk_academic_year_decision` FOREIGN KEY (`academic_year`) REFERENCES `academicperiods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_current_level` FOREIGN KEY (`current_level`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_next_level` FOREIGN KEY (`next_level`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_students_decision` FOREIGN KEY (`student`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `department_has_person`
--
ALTER TABLE `department_has_person`
ADD CONSTRAINT `fk_depatment_in_school_acad` FOREIGN KEY (`academic_year`) REFERENCES `academicperiods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_depatment_in_school_depatment_in_school` FOREIGN KEY (`department_id`) REFERENCES `department_in_school` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_depatment_in_school_perso` FOREIGN KEY (`employee`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_info`
--
ALTER TABLE `employee_info`
ADD CONSTRAINT `fk_employee_field_of_study` FOREIGN KEY (`field_study`) REFERENCES `field_study` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_employee_job_status` FOREIGN KEY (`job_status`) REFERENCES `job_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_employee_person` FOREIGN KEY (`employee`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_employee_qualification` FOREIGN KEY (`qualification`) REFERENCES `qualifications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `evaluations`
--
ALTER TABLE `evaluations`
ADD CONSTRAINT `fk_evaluation_academicperiod` FOREIGN KEY (`academic_year`) REFERENCES `academicperiods` (`id`);

--
-- Constraints for table `evaluation_by_year`
--
ALTER TABLE `evaluation_by_year`
ADD CONSTRAINT `fk_evaluation_year_academic_year` FOREIGN KEY (`academic_year`) REFERENCES `academicperiods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_evaluation_year_evaluation` FOREIGN KEY (`evaluation`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
ADD CONSTRAINT `fk_fees_academic_period` FOREIGN KEY (`academic_period`) REFERENCES `academicperiods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_fees_devise` FOREIGN KEY (`devise`) REFERENCES `devises` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_fees_fees_label` FOREIGN KEY (`fee`) REFERENCES `fees_label` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_fees_level` FOREIGN KEY (`level`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `general_average_by_period`
--
ALTER TABLE `general_average_by_period`
ADD CONSTRAINT `fk_general_average_period_academicperiod_academicYear` FOREIGN KEY (`academic_year`) REFERENCES `academicperiods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_general_average_period_academicperiod_period` FOREIGN KEY (`academic_period`) REFERENCES `academicperiods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_general_average_period_persons` FOREIGN KEY (`student`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
ADD CONSTRAINT `fk_grades_course` FOREIGN KEY (`course`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_grades_evaluation` FOREIGN KEY (`evaluation`) REFERENCES `evaluation_by_year` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_grades_student` FOREIGN KEY (`student`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
ADD CONSTRAINT `fk_group_profil_id` FOREIGN KEY (`belongs_to_profil`) REFERENCES `profil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups_has_actions`
--
ALTER TABLE `groups_has_actions`
ADD CONSTRAINT `fk_groups_has_actions_actions` FOREIGN KEY (`actions_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_groups_has_actions_groups` FOREIGN KEY (`groups_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups_has_modules`
--
ALTER TABLE `groups_has_modules`
ADD CONSTRAINT `fk_groups_has_modules_groups` FOREIGN KEY (`groups_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_groups_has_modules_modules` FOREIGN KEY (`modules_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `homework_submission`
--
ALTER TABLE `homework_submission`
ADD CONSTRAINT `fk_homework_submission_homework` FOREIGN KEY (`homework_id`) REFERENCES `homework` (`id`),
ADD CONSTRAINT `fk_homework_submission_person` FOREIGN KEY (`student`) REFERENCES `persons` (`id`);

--
-- Constraints for table `levels`
--
ALTER TABLE `levels`
ADD CONSTRAINT `fk_levels_levels1` FOREIGN KEY (`previous_level`) REFERENCES `levels` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
ADD CONSTRAINT `fk_levels_section` FOREIGN KEY (`section`) REFERENCES `sections` (`id`);

--
-- Constraints for table `level_has_person`
--
ALTER TABLE `level_has_person`
ADD CONSTRAINT `fk_students_level` FOREIGN KEY (`students`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_student_level_year` FOREIGN KEY (`academic_year`) REFERENCES `academicperiods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `level_has_person_ibfk_2` FOREIGN KEY (`level`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loan_of_money`
--
ALTER TABLE `loan_of_money`
ADD CONSTRAINT `fk_loan_person` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`);

--
-- Constraints for table `other_incomes`
--
ALTER TABLE `other_incomes`
ADD CONSTRAINT `fk_other_income_academicperiod` FOREIGN KEY (`academic_year`) REFERENCES `academicperiods` (`id`),
ADD CONSTRAINT `fk_other_income_incomes_description` FOREIGN KEY (`id_income_description`) REFERENCES `other_incomes_description` (`id`);

--
-- Constraints for table `passing_grades`
--
ALTER TABLE `passing_grades`
ADD CONSTRAINT `fk_academic_period_passing` FOREIGN KEY (`academic_period`) REFERENCES `academicperiods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_level_passing_grade` FOREIGN KEY (`level`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_passing_grade_course` FOREIGN KEY (`course`) REFERENCES `courses` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
