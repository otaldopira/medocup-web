-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: medocup
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agendamentos`
--

DROP TABLE IF EXISTS `agendamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agendamentos` (
  `agendamento_id` int unsigned NOT NULL AUTO_INCREMENT,
  `colaborador_id` int unsigned DEFAULT NULL,
  `profissional_id` int unsigned DEFAULT NULL,
  `empresa_id` int unsigned DEFAULT NULL,
  `procedimento_id` int unsigned DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `tempo` int DEFAULT NULL,
  `status_id` int DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `observacoes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`agendamento_id`),
  KEY `colaborador_fk_idx` (`colaborador_id`),
  KEY `profissional_fk_idx` (`profissional_id`),
  KEY `empresa_fk` (`empresa_id`),
  KEY `procedimento_fk` (`procedimento_id`),
  CONSTRAINT `colaborador_fk` FOREIGN KEY (`colaborador_id`) REFERENCES `colaboradores` (`colaborador_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `empresa_fk` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`empresa_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `procedimento_fk` FOREIGN KEY (`procedimento_id`) REFERENCES `procedimentos` (`procedimento_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `profissional_fk` FOREIGN KEY (`profissional_id`) REFERENCES `profissionais` (`profissional_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `atendimentos`
--

DROP TABLE IF EXISTS `atendimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `atendimentos` (
  `atendimento_id` int unsigned NOT NULL AUTO_INCREMENT,
  `colaborador_id` int unsigned DEFAULT NULL,
  `profissional_id` int unsigned DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `caminho` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`atendimento_id`),
  KEY `colaborador_fk_idx` (`colaborador_id`),
  KEY `profissional_fkk_idx` (`profissional_id`),
  CONSTRAINT `colaborador_fkk` FOREIGN KEY (`colaborador_id`) REFERENCES `colaboradores` (`colaborador_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `profissional_fkk` FOREIGN KEY (`profissional_id`) REFERENCES `profissionais` (`profissional_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `colaboradores`
--

DROP TABLE IF EXISTS `colaboradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colaboradores` (
  `colaborador_id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(255) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `data_admissao` date DEFAULT NULL,
  `genero` varchar(255) DEFAULT NULL,
  `celular` varchar(255) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`colaborador_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `empresas`
--

DROP TABLE IF EXISTS `empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresas` (
  `empresa_id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome_fantasia` varchar(255) DEFAULT NULL,
  `cnpj` varchar(255) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`empresa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `procedimentos`
--

DROP TABLE IF EXISTS `procedimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `procedimentos` (
  `procedimento_id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `tempo` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`procedimento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `profissionais`
--

DROP TABLE IF EXISTS `profissionais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profissionais` (
  `profissional_id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `crm` int DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`profissional_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-23 17:27:35
