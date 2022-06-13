-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Maio-2022 às 02:26
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gestaodeprojetos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `permission` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  `code` text NOT NULL,
  `re` text NOT NULL,
  `phone` text NOT NULL,
  `department` text NOT NULL,
  `role` text NOT NULL,
  `projects` text NOT NULL,
  `company` text NOT NULL,
  `address` text NOT NULL,
  `integration` text NOT NULL,
  `zipcode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `employees`
--

INSERT INTO `employees` (`id`, `permission`, `email`, `password`, `name`, `code`, `re`, `phone`, `department`, `role`, `projects`, `company`, `address`, `integration`, `zipcode`) VALUES
(21, 'externalemployee', 'kennedy_leon@unilever.com.br', '234', 'Leon S. Kennedy', '922991', '', '(48) 3248-6502', '', 'TI', '5,3', '4', 'Servidão Santino, Capoeiras - Florianópolis, SC', 'no', '88070-170'),
(22, 'externalemployee', 'claire.redfield@unilever.com.br', '234', 'Claire Redfield', '17121012', '', '(48) 99682-0755', '', 'Vendedora', '6', '11', 'Servidão Santino, Capoeiras - Florianópolis, SC', 'yes', '88070-170'),
(23, 'admin', 'tommy_vercetti@unilever.com.br', '234', 'Tommy Vercetti', '', '23654789A', '(48) 99682-0755', 'Gerência', 'CEO', '2,4,5,3,6', '', '', '', ''),
(24, 'employee', 'johnson.carl@unilever.com.br', '234', 'Carl Johnson', '', '2365AB21', '(48) 3248-6502', 'Comunicação', 'Motoboy', '5', '', '', '', ''),
(25, 'disabled', 'laracroft@unilever.com.br', '234', 'Lara Croft', '', '365DES232', '(48) 99682-0755', 'Limpeza', 'Zeladora', '4,5', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `seguimento` varchar(255) NOT NULL,
  `numerodeprofissionais` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `zipcode` text NOT NULL,
  `localizacao` text NOT NULL,
  `cnpj` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `empresas`
--

INSERT INTO `empresas` (`id`, `nome`, `seguimento`, `numerodeprofissionais`, `telefone`, `zipcode`, `localizacao`, `cnpj`) VALUES
(2, 'Evelyn e Regina Financeira ME', 'Serviços', '6', '(11) 2701-1289', '', 'Jundiaí, SP', '19.868.620/0001-75'),
(3, 'Sara Limpeza ME', 'Serviços', '10', '(11) 99597-3720', '', 'Guarulhos, SP', '99.977.462/0001-20'),
(4, 'Yago e Diego Eletrônica Ltda', 'TI', '6', '(15) 3949-6810', '', 'Itapetininga, SP', '19.924.902/0001-42'),
(5, 'Severino e Mateus TI Ltda', 'TI', '3', '(17) 98390-0510', '', 'São José do Rio Preto, SP', '72.576.192/0001-90'),
(6, 'Rosângela e Victor Telas Ltda', 'Construção', '8', '(11) 2785-8848', '', 'São Paulo, SP', '61.633.167/0001-84'),
(7, 'Valentine Arquitetura Ltda', 'Construção', '12', '(19) 3680-3483', '', 'Mogi Guaçu, SP', '95.077.122/0001-92'),
(8, 'Juan Empreiteira Ltda', 'Construção', '6', '(17) 99666-5950', '', 'Balneario Camboriu, SC', '28.092.851/0001-20'),
(9, 'Regina e Hadassa Entulhos Ltda', 'Construção', '16', '(18) 3688-9926', '', 'Presidente Prudente, SP', '86.252.839/0001-32'),
(10, 'Lívia Design Ltda', 'Design', '2', '(11) 98666-4557', '', 'Rio de Janeiro, RJ', '73.488.835/0001-06'),
(11, 'Isabelly Arts Ltda', 'Design', '8', '(12) 2567-4785', '', 'Jacareí, SP', '58.631.248/0001-30'),
(12, 'Alana Mudanças ME', 'Serviços', '5', '(11) 2936-7676', '', 'São José, SC', '49.095.246/0001-83'),
(13, 'Filipe Pães e Doces Ltda', 'Serviços', '6', '(19) 99337-8763', '', 'Criciúma, SC', '57.954.947/0001-59'),
(14, 'Emanuel e Raimundo Publicidade e Propaganda ME', 'Design', '4', '(48) 2626-9758', '', 'Florianópolis, SC', '56.975.844/0001-02'),
(15, 'Carla e Luzia Advocacia ME', 'Serviços', '15', '(43) 3513-0950', '', 'Londrina, PR', '39.463.841/0001-70'),
(16, 'Local Locações de Automóveis ME', 'Serviços', '6', '(42) 3865-3397', '', 'Porto Vitória, PR', '67.859.137/0001-77'),
(17, 'Gameloop', 'TI', '2', '(48) 99682-0755', '', 'Florianópolis, SC', '81.181.490/0001-71'),
(19, 'Isa Telecomunicações ME', 'Telecomunicações', '15', '(48) 3248-6502', '88111-520', 'Rua Bom Pastor, Ipiranga - São José, SC', '25.500.257/0001-33');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos`
--

CREATE TABLE `projetos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `seguimento` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Em andamento',
  `descricao` text NOT NULL,
  `inicio` varchar(255) NOT NULL,
  `duracao` int(11) NOT NULL,
  `lider` varchar(255) NOT NULL,
  `empresa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `projetos`
--

INSERT INTO `projetos` (`id`, `nome`, `seguimento`, `status`, `descricao`, `inicio`, `duracao`, `lider`, `empresa`) VALUES
(2, 'Campanha de Marketing', 'Marketing', 'Em andamento', 'Campanha de Marketing 2021 Unilever', '25/09/2021', 31, 'Alex', 'Gameloop'),
(3, 'Novo layout de baias', 'Construção', 'Finalizado', 'Novo layout de baias para empresa', '11/11/2019', 120, 'Junior', 'Juan Empreiteira Ltda'),
(4, 'Reforma salas de reunião', 'Construção', 'Em atraso', 'Reforma salas de reunião da empresa', '03/10/2018', 365, 'André', 'Valentine Arquitetura Ltda'),
(5, 'Troca de equipamentos e cabeamentos', 'TI', 'Em andamento', 'Troca de equipamentos e cabeamentos da empresa', '10/09/2020', 110, 'Alex', 'Severino e Mateus TI Ltda'),
(6, 'Nova logomarca', 'Design', 'Em andamento', 'Desenvolvimento da nova logomarca da empresa', '22/06/2021', 60, 'Junior', 'Lívia Design Ltda');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `embed` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `reports`
--

INSERT INTO `reports` (`id`, `title`, `description`, `embed`) VALUES
(1, 'Exemplo 1', 'Um relatório de exemplo para mostrar o funcionamento do embed no sistema.', '<iframe title=\"Projeto F1\" width=\"1140\" height=\"541.25\" src=\"https://app.powerbi.com/reportEmbed?reportId=d24b31e2-04a0-40cc-b40a-a35abbaa20e9&autoAuth=true&ctid=f66fae02-5d36-495b-bfe0-78a6ff9f8e6e&config=eyJjbHVzdGVyVXJsIjoiaHR0cHM6Ly93YWJpLW5vcnRoLWV1cm9wZS1yZWRpcmVjdC5hbmFseXNpcy53aW5kb3dzLm5ldC8ifQ%3D%3D\" frameborder=\"0\" allowFullScreen=\"true\"></iframe>'),
(2, 'Relatório de Empresas', 'Informações referentes a empresas cadastradas na plataforma.', '<iframe title=\"Projeto F1\" width=\"1140\" height=\"541.25\" src=\"https://app.powerbi.com/reportEmbed?reportId=d24b31e2-04a0-40cc-b40a-a35abbaa20e9&autoAuth=true&ctid=f66fae02-5d36-495b-bfe0-78a6ff9f8e6e&config=eyJjbHVzdGVyVXJsIjoiaHR0cHM6Ly93YWJpLW5vcnRoLWV1cm9wZS1yZWRpcmVjdC5hbmFseXNpcy53aW5kb3dzLm5ldC8ifQ%3D%3D\" frameborder=\"0\" allowFullScreen=\"true\"></iframe>');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
