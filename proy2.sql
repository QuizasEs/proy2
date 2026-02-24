-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2026 a las 18:53:34
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proy2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `em_id` bigint(20) UNSIGNED NOT NULL,
  `em_nombre` varchar(150) NOT NULL,
  `em_celular` varchar(20) DEFAULT NULL,
  `em_nit` varchar(50) NOT NULL,
  `em_comision` decimal(10,2) NOT NULL DEFAULT 0.00,
  `em_creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `em_actualizado_en` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `em_estado` tinyint(1) NOT NULL DEFAULT 1,
  `us_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`em_id`, `em_nombre`, `em_celular`, `em_nit`, `em_comision`, `em_creado_en`, `em_actualizado_en`, `em_estado`, `us_id`) VALUES
(2, 'Comercial Importadora Ltda.', '242342342', '2009876543', 3.25, '2026-02-22 20:50:53', '2026-02-23 02:02:53', 1, 1),
(3, 'Servicios Profesionales del Norte', '+591-70098765', '3004567890', 7.00, '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(4, 'Industrias Metálicas Bolivianas', '+591-70024680', '4001357924', 4.75, '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(5, 'Distribuidora Nacional S.R.L.', '+591-70013579', '5008642097', 6.00, '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(6, 'fsdfd', '234242423', '24234234', 10.00, '2026-02-23 01:59:39', '2026-02-23 01:59:39', 1, NULL),
(7, 'paralelepipedo', '+-3242423', '43223423', 1.00, '2026-02-23 02:03:07', '2026-02-23 02:04:20', 1, 1),
(8, 'industrias hercules srl', '70112345', '10234567891', 5.50, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(9, 'comercial los andes', '70123456', '10234567892', 3.00, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(10, 'transportes rapido del norte', '70134567', '10234567893', 7.25, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(11, 'construcciones y representaciones gomez', '70145678', '10234567894', 4.75, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(12, 'servicios integrales la paz', '70156789', '10234567895', 6.00, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(13, 'distribuidora central', '70167890', '10234567896', 2.50, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(14, 'fabrica de productos naturales', '70178901', '10234567897', 8.00, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(15, 'importadora comercial bolivia', '70189012', '10234567898', 5.00, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(16, 'constructora horizonte', '70190123', '10234567899', 9.50, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(17, 'empresa de limpieza profesional', '70201234', '10234567901', 3.75, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(18, 'tienda de tecnologia avanzada', '70212345', '10234567902', 4.25, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(19, 'laboratorio farmaceutico san jose', '70223456', '10234567903', 6.50, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(20, 'restaurante comida tipica', '70234567', '10234567904', 10.00, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(21, 'agencia de publicidad maxima', '70245678', '10234567905', 5.25, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(22, 'taller mecanico express', '70256789', '10234567906', 7.00, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(23, 'escuela de idiomas internacional', '70267890', '10234567907', 4.50, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(24, 'clinica de salud integral', '70278901', '10234567908', 8.75, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(25, 'empresa de seguridad privada', '70289012', '10234567909', 6.25, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(26, 'estacion de servicio premium', '70290123', '10234567911', 3.50, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1),
(27, 'hotel boutique centro', '70301234', '10234567912', 11.00, '2026-02-23 02:08:10', '2026-02-23 02:08:10', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilitaciones`
--

CREATE TABLE `habilitaciones` (
  `ha_id` bigint(20) UNSIGNED NOT NULL,
  `se_id` bigint(20) UNSIGNED NOT NULL,
  `em_id` bigint(20) UNSIGNED NOT NULL,
  `ha_link_sistema` varchar(255) DEFAULT NULL,
  `ha_tipo_suscripcion` tinyint(1) NOT NULL COMMENT '1: Mensual, 2: Anual',
  `ha_sucursal` varchar(255) DEFAULT NULL,
  `ha_creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `ha_actualizado_en` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ha_estado` tinyint(1) NOT NULL DEFAULT 1,
  `us_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habilitaciones`
--

INSERT INTO `habilitaciones` (`ha_id`, `se_id`, `em_id`, `ha_link_sistema`, `ha_tipo_suscripcion`, `ha_sucursal`, `ha_creado_en`, `ha_actualizado_en`, `ha_estado`, `us_id`) VALUES
(4, 1, 2, 'https://inventario.comercialimp.bo', 1, 'Almacén Central - Santa Cruz', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(5, 2, 2, 'https://factura.comercialimp.bo', 2, 'Sucursal Santa Cruz', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(6, 4, 2, 'https://pos.comercialimp.bo', 1, 'Tienda 1 - Santa Cruz', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(7, 4, 2, 'https://pos2.comercialimp.bo', 1, 'Tienda 2 - Cochabamba', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(8, 2, 3, 'https://factura.serviciosnorte.bo', 2, 'Oficina Central - El Alto', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(9, 3, 3, 'https://conta.serviciosnorte.bo', 2, 'Oficina Central - El Alto', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(10, 7, 3, 'https://dashboard.serviciosnorte.bo', 1, 'Oficina Central - El Alto', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(11, 1, 4, 'https://inventario.indmet.bo', 2, 'Planta Principal - Oruro', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(12, 5, 4, 'https://activos.indmet.bo', 2, 'Planta Principal - Oruro', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(13, 6, 4, 'https://compras.indmet.bo', 1, 'Planta Principal - Oruro', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(14, 1, 5, 'https://inventario.distnacional.bo', 2, 'Centro de Distribución - La Paz', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(15, 2, 5, 'https://factura.distnacional.bo', 2, 'Todas las sucursales', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(16, 4, 5, 'https://pos.distnacional.bo', 1, 'Sucursal La Paz', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(17, 4, 5, 'https://pos-sc.distnacional.bo', 1, 'Sucursal Santa Cruz', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(18, 8, 5, 'https://creditos.distnacional.bo', 1, 'Oficina Central - La Paz', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(19, 5, 6, 'https://www.youtube.com/watch?v=4kHl4FoK1Ys&list=RDGMEMQ1dJ7wXfLlqCjwV0xfSNbAVM0B0e1NRwaHQ&index=10', 1, '2', '2026-02-24 01:28:55', '2026-02-24 01:33:10', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ro_id` bigint(20) UNSIGNED NOT NULL,
  `ro_nombre` varchar(50) NOT NULL,
  `ro_descripcion` text DEFAULT NULL,
  `ro_creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `ro_actualizado_en` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ro_estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ro_id`, `ro_nombre`, `ro_descripcion`, `ro_creado_en`, `ro_actualizado_en`, `ro_estado`) VALUES
(1, 'admin', 'Administrador del sistema con todos los permisos', '2025-10-12 23:00:54', '2025-10-12 23:00:54', 1),
(2, 'ventas', 'usuario de ventas sin privilegios resaltantes\r\n', '2025-10-12 23:00:54', '2026-02-23 01:39:47', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `se_id` bigint(20) UNSIGNED NOT NULL,
  `se_nombre` varchar(100) NOT NULL,
  `se_descripcion` text DEFAULT NULL,
  `se_tipo_sistema` enum('inventario','facturacion','contabilidad','otros') NOT NULL DEFAULT 'otros',
  `se_creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `se_actualizado_en` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `se_estado` tinyint(1) NOT NULL DEFAULT 1,
  `us_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`se_id`, `se_nombre`, `se_descripcion`, `se_tipo_sistema`, `se_creado_en`, `se_actualizado_en`, `se_estado`, `us_id`) VALUES
(1, 'Sistema de Inventario Pro', 'Gestión completa de inventario con control de stock y alertas', 'inventario', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(2, 'Facturación Electrónica', 'Sistema de facturación con integración a impuestos nacionales', 'facturacion', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(3, 'Contabilidad General', 'Módulo contable con balance, libro diario y reportes financieros', 'contabilidad', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(4, 'Gestión de Punto de Venta', 'Sistema POS para ventas rápidas y control de caja', 'otros', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(5, 'Control de Activos Fijos', 'Gestión y depreciación de activos fijos de la empresa', 'otros', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(6, 'Sistema de Compras', 'Control de proveedores y gestión de órdenes de compra', 'inventario', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(7, 'Reportes Gerenciales', 'Dashboard con KPIs y reportes personalizados', 'otros', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(8, 'Gestión de Créditos', 'Control de cuentas por cobrar y gestión de créditos', 'facturacion', '2026-02-22 20:50:53', '2026-02-22 20:50:53', 1, 1),
(9, 'asd', 'asd', 'inventario', '2026-02-24 02:27:24', '2026-02-24 02:27:33', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `us_id` bigint(20) UNSIGNED NOT NULL,
  `us_nombres` varchar(120) NOT NULL,
  `us_apellido_paterno` varchar(80) DEFAULT NULL,
  `us_apellido_materno` varchar(80) DEFAULT NULL,
  `us_numero_carnet` varchar(60) DEFAULT NULL,
  `us_telefono` varchar(30) DEFAULT NULL,
  `us_correo` varchar(120) DEFAULT NULL,
  `us_direccion` text DEFAULT NULL,
  `us_username` varchar(80) NOT NULL,
  `us_password_hash` varchar(255) NOT NULL,
  `us_token_recuperacion` varchar(255) DEFAULT NULL,
  `us_token_expiracion` datetime DEFAULT NULL,
  `us_creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `us_actualizado_en` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `us_estado` tinyint(1) NOT NULL DEFAULT 1,
  `ro_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`us_id`, `us_nombres`, `us_apellido_paterno`, `us_apellido_materno`, `us_numero_carnet`, `us_telefono`, `us_correo`, `us_direccion`, `us_username`, `us_password_hash`, `us_token_recuperacion`, `us_token_expiracion`, `us_creado_en`, `us_actualizado_en`, `us_estado`, `ro_id`) VALUES
(1, 'admin', 'admin', 'adminadmin', '64564564', '123123123', 'zetaconde@gmail.com', 'adminadminadminadminadminadminadmin', 'admin', 'dlo5ZmZvbmRjME41dGlDY01tTGcrUT09', NULL, NULL, '2026-02-19 02:01:28', '2026-02-24 13:43:51', 1, 1),
(2, 'Juan Carlos', 'Perez', 'Gomez', '12345678', '70123456', 'juan.perez@correo.com', 'Av. Principal #123', 'jperez', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-15 08:00:00', '2026-01-15 08:00:00', 1, 2),
(3, 'Maria Elena', 'Rodriguez', 'Lopez', '23456789', '70123457', 'maria.rodriguez@correo.com', 'Calle Central #456', 'mrodriguez', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-16 09:00:00', '2026-01-16 09:00:00', 1, 2),
(4, 'Roberto Carlos', 'Fernandez', 'Diaz', '34567890', '70123458', 'roberto.fernandez@correo.com', 'Av. Secondary #789', 'rfernandez', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-17 10:00:00', '2026-01-17 10:00:00', 1, 2),
(6, 'Carlos Miguel', 'Gonzales', 'Ramirez', '56789012', '70123460', 'carlos.gonzales@correo.com', 'Av. Libertad #202', 'cgonzales', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-19 08:30:00', '2026-01-19 08:30:00', 1, 2),
(7, 'Laura Beatriz', 'Jimenez', 'Cruz', '67890123', '70123461', 'laura.jimenez@correo.com', 'Calle Nueva #303', 'ljimenez', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-20 09:30:00', '2026-01-20 09:30:00', 1, 2),
(8, 'Pedro Antonio', 'Hernandez', 'Vega', '78901234', '70123462', 'pedro.hernandez@correo.com', 'Av. Norte #404', 'phernandez', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-21 10:30:00', '2026-01-21 10:30:00', 1, 2),
(9, 'Sofia Isabel', 'Morales', 'Castillo', '89012345', '70123463', 'sofia.morales@correo.com', 'Calle Sur #505', 'smorales', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-22 11:30:00', '2026-01-22 11:30:00', 1, 2),
(10, 'Diego Andres', 'Reyes', 'Gutierrez', '90123456', '70123464', 'diego.reyes@correo.com', 'Av. Este #606', 'dreyes', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-23 08:00:00', '2026-01-23 08:00:00', 1, 2),
(11, 'Carmen Rosa', 'Flores', 'Sosa', '01234567', '70123465', 'carmen.flores@correo.com', 'Calle Oeste #707', 'cflores', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-24 09:00:00', '2026-01-24 09:00:00', 1, 2),
(12, 'Jorge Luis', 'Nunez', 'Aguirre', '11223344', '70123466', 'jorge.nunez@correo.com', 'Av. Central #808', 'jnunez', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-25 10:00:00', '2026-01-25 10:00:00', 1, 2),
(13, 'Patricia Elena', 'Castro', 'Ortega', '22334455', '70123467', 'patricia.castro@correo.com', 'Calle Primera #909', 'pcastro', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-26 11:00:00', '2026-01-26 11:00:00', 1, 2),
(14, 'Luis Fernando', 'Vargas', 'Luna', '33445566', '70123468', 'luis.vargas@correo.com', 'Av. Segunda #1010', 'lvargas', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-27 08:15:00', '2026-01-27 08:15:00', 1, 2),
(15, 'Gloria Maria', 'Mendoza', 'Rios', '44556677', '70123469', 'gloria.mendoza@correo.com', 'Calle Tercera #1111', 'gmendoza', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-28 09:15:00', '2026-01-28 09:15:00', 1, 2),
(16, 'Oscar David', 'Silva', 'Paredes', '55667788', '70123470', 'oscar.silva@correo.com', 'Av. Cuarta #1212', 'osilva', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-29 10:15:00', '2026-01-29 10:15:00', 1, 2),
(17, 'Teresa Carmen', 'Aguilar', 'Caceres', '66778899', '70123471', 'teresa.aguilar@correo.com', 'Calle Quinta #1313', 'taguilar', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-30 11:15:00', '2026-01-30 11:15:00', 1, 2),
(18, 'Ricardo Jose', 'Medina', 'Benitez', '77889900', '70123472', 'ricardo.medina@correo.com', 'Av. Sexta #1414', 'rmedina', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-01-31 08:45:00', '2026-01-31 08:45:00', 1, 2),
(19, 'Veronica Luz', 'Rojas', 'Campos', '88990011', '70123473', 'veronica.rojas@correo.com', 'Calle Septima #1515', 'vrojas', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-02-01 09:45:00', '2026-02-01 09:45:00', 1, 2),
(20, 'Fernando Raul', 'Salazar', 'Espinoza', '99001122', '70123474', 'fernando.salazar@correo.com', 'Av. Octava #1616', 'fsalazar', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-02-02 10:45:00', '2026-02-02 10:45:00', 1, 2),
(21, 'Sandra Patricia', 'Navarro', 'Valdez', '10111213', '70123475', 'sandra.navarro@correo.com', 'Calle Novena #1717 para los lomos', 'snavarro', 'cDRwcGE1UDNNdHZrblRmejR5VDFrQT09', NULL, NULL, '2026-02-03 11:45:00', '2026-02-23 01:05:17', 1, 2),
(22, 'asd', 'asd', 'asd', '2342323423', '223423', '', '', 'homer', 'MWIzYzFERXlzai9zUlR4VlJwaWNmdz09', NULL, NULL, '2026-02-23 01:18:21', '2026-02-24 01:32:45', 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`em_id`),
  ADD UNIQUE KEY `uk_em_nit` (`em_nit`),
  ADD KEY `fk_empresas_usuarios` (`us_id`);

--
-- Indices de la tabla `habilitaciones`
--
ALTER TABLE `habilitaciones`
  ADD PRIMARY KEY (`ha_id`),
  ADD KEY `fk_habilitaciones_servicios` (`se_id`),
  ADD KEY `fk_habilitaciones_empresas` (`em_id`),
  ADD KEY `fk_habilitaciones_usuarios` (`us_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ro_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`se_id`),
  ADD KEY `fk_servicios_usuarios` (`us_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`us_id`),
  ADD KEY `fk_usuarios_roles` (`ro_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `em_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `habilitaciones`
--
ALTER TABLE `habilitaciones`
  MODIFY `ha_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ro_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `se_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `us_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD CONSTRAINT `fk_empresas_usuarios` FOREIGN KEY (`us_id`) REFERENCES `usuarios` (`us_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `habilitaciones`
--
ALTER TABLE `habilitaciones`
  ADD CONSTRAINT `fk_habilitaciones_empresas` FOREIGN KEY (`em_id`) REFERENCES `empresas` (`em_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_habilitaciones_servicios` FOREIGN KEY (`se_id`) REFERENCES `servicios` (`se_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_habilitaciones_usuarios` FOREIGN KEY (`us_id`) REFERENCES `usuarios` (`us_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `fk_servicios_usuarios` FOREIGN KEY (`us_id`) REFERENCES `usuarios` (`us_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`ro_id`) REFERENCES `roles` (`ro_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
