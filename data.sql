-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 29-Nov-2018 às 04:55
-- Versão do servidor: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lpii:agencia_bancaria`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agencias`
--

CREATE TABLE `agencias` (
  `id_agencia` int(10) UNSIGNED NOT NULL,
  `numero_agencia` varchar(15) NOT NULL,
  `nome_agencia` varchar(50) NOT NULL,
  `endereco` varchar(75) NOT NULL,
  `capacidade` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `agencias`
--

INSERT INTO `agencias` (`id_agencia`, `numero_agencia`, `nome_agencia`, `endereco`, `capacidade`) VALUES
(1, '7549-L', 'Agência Norte Bradesco', 'Rua dos Alfeneiros, Centro - 211', 1000000),
(2, '0937-x', 'Agência Sudeste Bradesco', 'King\'s Landing, Porto Real, 110', 10000),
(23, '3992-y', 'Agência Norte Banco do Brasil', 'BR 316 KM - 302, Zona Sul', 100000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas`
--

CREATE TABLE `contas` (
  `id` int(10) UNSIGNED NOT NULL,
  `numero` varchar(15) NOT NULL,
  `saldo` int(11) NOT NULL,
  `limite` int(11) DEFAULT NULL,
  `rendimento` int(11) DEFAULT NULL,
  `tipo` enum('CONTA_CORRENTE','CONTA_POUPANCA','CONTA_ESPECIAL') NOT NULL,
  `fk_id_agencia` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas`
--

INSERT INTO `contas` (`id`, `numero`, `saldo`, `limite`, `rendimento`, `tipo`, `fk_id_agencia`) VALUES
(8, '1235', 660, NULL, 10, 'CONTA_POUPANCA', 1),
(9, '1233x', 6750, 5000, NULL, 'CONTA_ESPECIAL', 2),
(10, '1235-ax', 201, 5000, NULL, 'CONTA_ESPECIAL', 23),
(11, '77382-z', 100, NULL, 5, 'CONTA_POUPANCA', 2),
(12, '12378-yy', 1111, NULL, NULL, 'CONTA_CORRENTE', 1),
(13, '123090001-J', 150, NULL, 3, 'CONTA_POUPANCA', 23);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agencias`
--
ALTER TABLE `agencias`
  ADD PRIMARY KEY (`id_agencia`);

--
-- Indexes for table `contas`
--
ALTER TABLE `contas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero` (`numero`),
  ADD KEY `fk_id_agencia` (`fk_id_agencia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agencias`
--
ALTER TABLE `agencias`
  MODIFY `id_agencia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `contas`
--
ALTER TABLE `contas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `contas`
--
ALTER TABLE `contas`
  ADD CONSTRAINT `contas_ibfk_1` FOREIGN KEY (`fk_id_agencia`) REFERENCES `agencias` (`id_agencia`),
  ADD CONSTRAINT `fk_id_agencia` FOREIGN KEY (`fk_id_agencia`) REFERENCES `agencias` (`id_agencia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
