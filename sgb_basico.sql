-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Nov-2022 às 18:57
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sgb_basico`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `emprestimos`
--

CREATE TABLE `emprestimos` (
  `id_emprestimo` int(11) NOT NULL,
  `data_emprestimo` date NOT NULL,
  `dias_emprestimos` int(4) NOT NULL,
  `id_usuario` int(5) NOT NULL,
  `id_livro` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `emprestimos`
--

INSERT INTO `emprestimos` (`id_emprestimo`, `data_emprestimo`, `dias_emprestimos`, `id_usuario`, `id_livro`) VALUES
(58, '2022-11-01', 7, 4, 2),
(59, '2022-11-18', 7, 4, 1),
(60, '2022-11-18', 7, 4, 3),
(61, '2022-11-18', 14, 4, 4),
(62, '2022-11-18', 21, 3, 5),
(63, '2022-11-19', 7, 3, 1),
(64, '2022-11-19', 7, 3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `livro`
--

CREATE TABLE `livro` (
  `id_livro` int(11) NOT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `ano` varchar(5) DEFAULT NULL,
  `paginas` int(4) DEFAULT NULL,
  `emprestado` tinyint(1) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `livro`
--

INSERT INTO `livro` (`id_livro`, `nome`, `ano`, `paginas`, `emprestado`, `id_usuario`) VALUES
(1, 'A odisséia', '1999', 325, 1, 3),
(2, 'kali', '2000', 123, 1, 4),
(3, 'O epiceto', '1850', 400, 1, 4),
(4, 'Ponto de Equilibrio', '2014', 220, 1, 4),
(5, 'Miliada', '1560', 550, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `telefone`, `email`, `senha`) VALUES
(3, 'Anderson Miguel Lenz', '456456', 'anderson@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(4, 'Heitor da Silva', '789456', 'heitor@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(6, 'gerente', '1223789456', 'gerente@gerente.com', '6572bdaff799084b973320f43f09b363');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD PRIMARY KEY (`id_emprestimo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_livro` (`id_livro`);

--
-- Índices para tabela `livro`
--
ALTER TABLE `livro`
  ADD PRIMARY KEY (`id_livro`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `emprestimos`
--
ALTER TABLE `emprestimos`
  MODIFY `id_emprestimo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `livro`
--
ALTER TABLE `livro`
  MODIFY `id_livro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD CONSTRAINT `emprestimos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `emprestimos_ibfk_2` FOREIGN KEY (`id_livro`) REFERENCES `livro` (`id_livro`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
