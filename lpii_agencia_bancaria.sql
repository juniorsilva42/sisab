-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 03-Dez-2018 às 14:00
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
  `id` int(10) UNSIGNED NOT NULL,
  `numero` varchar(10) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `endereco` varchar(75) DEFAULT NULL,
  `capacidade` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `agencias`
--

INSERT INTO `agencias` (`id`, `numero`, `nome`, `endereco`, `capacidade`) VALUES
(2, '0937-y', 'Agência Sudeste Bradesco', 'King\'s Landing, Porto Real, 220', 10),
(23, '3992-y', 'Agência Norte Banco do Brasil', 'BR 316 KM - 302, Zona Sul', 100000),
(25, 'LCM0001-x', 'La Casa da Moeda', 'Rua dos Alfeneiros, Hogwarts', 1000000),
(26, 'Agência Br', 'Agência Bradesco Sem nome', 'Endereço Padrão', 500);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas`
--

CREATE TABLE `contas` (
  `id` int(10) UNSIGNED NOT NULL,
  `numero` varchar(15) CHARACTER SET latin1 NOT NULL,
  `saldo` float DEFAULT NULL,
  `limite` int(11) DEFAULT NULL,
  `rendimento` float DEFAULT NULL,
  `tipo` enum('CONTA_CORRENTE','CONTA_POUPANCA','CONTA_ESPECIAL') CHARACTER SET latin1 NOT NULL,
  `fk_id_agencia` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `contas`
--

INSERT INTO `contas` (`id`, `numero`, `saldo`, `limite`, `rendimento`, `tipo`, `fk_id_agencia`) VALUES
(36, '12AD0CP', 655, 0, 3, 'CONTA_POUPANCA', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agencias`
--
ALTER TABLE `agencias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_agencia` (`numero`);

--
-- Indexes for table `contas`
--
ALTER TABLE `contas`
  ADD PRIMARY KEY (`id`,`fk_id_agencia`,`tipo`),
  ADD UNIQUE KEY `numero` (`numero`),
  ADD KEY `fk_id_agencia` (`fk_id_agencia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agencias`
--
ALTER TABLE `agencias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `contas`
--
ALTER TABLE `contas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `contas`
--
ALTER TABLE `contas`
  ADD CONSTRAINT `contas_ibfk_1` FOREIGN KEY (`fk_id_agencia`) REFERENCES `agencias` (`id`),
  ADD CONSTRAINT `fk_id_agencia` FOREIGN KEY (`fk_id_agencia`) REFERENCES `agencias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
