-- phpMyAdmin SQL Dump
-- version 3.1.5
-- http://www.phpmyadmin.net
--
-- Généré le : Ven 18 Décembre 2015 à 01:49
-- Version du serveur: 5.0.83
-- Version de PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Structure de la table `bad_player`
--

CREATE TABLE IF NOT EXISTS `bad_player` (
  `id` int(11) NOT NULL auto_increment,
  `first_name` varchar(60) collate latin1_general_ci NOT NULL,
  `last_name` varchar(60) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `bad_player_score`
--

CREATE TABLE IF NOT EXISTS `bad_player_score` (
  `id` int(11) NOT NULL auto_increment,
  `id_player` int(11) NOT NULL,
  `id_set_type` int(11) NOT NULL,
  `nb_sets_played` int(11) NOT NULL,
  `score` decimal(10,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `bad_set`
--

CREATE TABLE IF NOT EXISTS `bad_set` (
  `id` int(11) NOT NULL auto_increment,
  `creation_datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `id_set_type` int(11) NOT NULL,
  `id_player_1_win` int(11) NOT NULL,
  `id_player_2_win` int(11) default NULL,
  `id_player_1_lose` int(11) NOT NULL,
  `id_player_2_lose` int(11) default NULL,
  `init_score_player_1_win` decimal(10,2) NOT NULL default '0.00',
  `init_score_player_2_win` decimal(10,2) default NULL,
  `init_score_player_1_lose` decimal(10,2) NOT NULL default '0.00',
  `init_score_player_2_lose` decimal(10,2) default NULL,
  `init_nb_sets_player_1_win` int(11) NOT NULL default '0',
  `init_nb_sets_player_2_win` int(11) default NULL,
  `init_nb_sets_player_1_lose` int(11) NOT NULL default '0',
  `init_nb_sets_player_2_lose` int(11) default NULL,
  `new_score_player_1_win` decimal(10,2) NOT NULL,
  `new_score_player_2_win` decimal(10,2) default NULL,
  `new_score_player_1_lose` decimal(10,2) NOT NULL,
  `new_score_player_2_lose` decimal(10,2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `bad_set_type`
--

CREATE TABLE IF NOT EXISTS `bad_set_type` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(60) collate latin1_general_ci NOT NULL,
  `abbreviation` varchar(5) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `bad_set_type`
--

INSERT INTO `bad_set_type` (`id`, `name`, `abbreviation`) VALUES
(1, 'Simple Dames', 'SD'),
(2, 'Simple Hommes', 'SH'),
(3, 'Double Mixte', 'DX'),
(4, 'Double Dames', 'DD'),
(5, 'Double Hommes', 'DH');
