-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-08-2024 a las 18:39:05
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `neumático rd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'willy', '123456', '2024-07-25 15:41:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `carrito_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad_` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

CREATE TABLE `carritos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_usuarios`
--

CREATE TABLE `carrito_usuarios` (
  `id_sesion` varchar(255) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` int(100) NOT NULL,
  `imagen` int(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `imagen`) VALUES
(1, 0, 0),
(2, 0, 0),
(3, 0, 0),
(4, 0, 0),
(5, 0, 0),
(6, 0, 0),
(7, 0, 0),
(8, 0, 0),
(9, 0, 0),
(10, 0, 0),
(11, 0, 0),
(12, 0, 0),
(13, 0, 0),
(14, 0, 0),
(15, 0, 0),
(16, 0, 0),
(17, 0, 0),
(18, 0, 0),
(19, 0, 0),
(20, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `correo` varchar(80) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `perfil` varchar(100) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_person_id` int(11) DEFAULT NULL,
  `delivery_person_name` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Accepted','In Progress','Delivered') NOT NULL DEFAULT 'Pending',
  `delivery_date` datetime DEFAULT NULL,
  `accepted_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `delivery`
--

INSERT INTO `delivery` (`id`, `order_id`, `delivery_person_id`, `delivery_person_name`, `status`, `delivery_date`, `accepted_date`) VALUES
(75, 1723353912, 8, NULL, 'Delivered', NULL, NULL),
(76, 1723360758, 10, NULL, 'Delivered', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `is_admin` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `email`, `password`, `fecha_registro`, `firstname`, `lastname`, `is_admin`) VALUES
(6, 'willyperez7112@gmail.com', '$2y$10$xSxvFmEU4SbkKgLbEw8mgeGq21OmdPQzrcLQHDYXY0dEb5GuimxHK', '2024-07-25 15:56:20', 'willy', 'admin', 1),
(8, 'willyperez16@gmail.com', '$2y$10$Vp2bCx2mPoKNO5vEwt4.I.98BYcTSi0qbP0WJLc0KCRbSpYJm70l.', '2024-08-07 23:39:54', 'delivery', '1', 2),
(10, 'willyperez14@hotmail.com', '$2y$10$YHwRpeXBkeMGPQc9Tqzg5OIYU50LZYkq7mT.64/cpJPcuxuC.1muy', '2024-08-09 18:59:49', 'delivery', '1', 2),
(11, 'webhosting2111@gmail.com', '$2y$10$ocZinGPkEP/s4oKYTj66aeuQjc3ykmr1hhD0ZMAjC8ZtBHsTlDjOm', '2024-08-11 15:40:05', 'willy', 'perez', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pendiente','leído') NOT NULL DEFAULT 'pendiente',
  `subject` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`order_id`, `name`, `email`, `address`, `city`, `state`, `zip`, `phone`, `total_amount`, `created_at`) VALUES
(1723353912, 'willy', 'willyperez7112@gmail.com', 'agua loca', 'santo domingo', 'santo domingo este', '11011', '8298927857', 20000.00, '2024-08-11 05:25:26'),
(1723360758, 'willy', 'willyperez7112@gmail.com', 'agua loca', 'santo domingo', 'santo domingo este', '11011', '8298927857', 24002.00, '2024-08-11 07:20:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(105, 1723353912, 4124, 1, 20000.00),
(106, 1723360758, 4124, 1, 20000.00),
(107, 1723360758, 4116, 1, 5.00),
(108, 1723360758, 4115, 1, 856.00),
(109, 1723360758, 4098, 1, 2262.00),
(110, 1723360758, 4097, 1, 879.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `monto` decimal(10,0) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `payment_type` enum('credit-card','apple-pay','paypal','google-pay') NOT NULL,
  `account` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `method`, `created_at`, `user_id`, `payment_type`, `account`) VALUES
(1, 'paypal', '2024-07-21 21:39:30', 1, 'credit-card', 'wfsf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id+transsccion` varchar(80) NOT NULL,
  `monto` decimal(10,0) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `fecha` datetime NOT NULL,
  `email` varchar(80) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `email_user` varchar(80) NOT NULL,
  `proceso` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` longtext NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `imagen` varchar(150) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `tamaño` varchar(10) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `categorias` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `marca` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `cantidad`, `imagen`, `id_categoria`, `tamaño`, `tipo`, `categorias`, `fecha_creacion`, `marca`) VALUES
(4010, 'Double Coin', '[object Object]', 3497, 80, 'https://robohash.org/dictaquiaaliquam.png?size=1920x1080&set=set1', 0, '15', 'Diagonal', 'Neumáticos de Invierno', '2024-07-19 13:31:23', 'Michelin'),
(4011, 'Avon', '[object Object]', 2711, 0, 'https://robohash.org/aperiamliberoasperiores.png?size=1920x1080&set=set1', 0, '13', 'Radial', 'Neumáticos para Camionetas', '2024-07-19 13:31:23', 'Michelin'),
(4013, 'Pirelli', '[object Object]', 3358, 0, 'https://robohash.org/etdoloremqueet.png?size=1920x1080&set=set1', 0, '13', 'Radial', 'Neumáticos para Carreras', '2024-07-19 13:31:23', 'Michelin'),
(4014, 'Linglong', '[object Object]', 847, 0, 'https://robohash.org/perspiciatisofficiisquis.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4015, 'Toyo', '[object Object]', 2224, 0, 'https://robohash.org/sitconsecteturet.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4016, 'Duraturn', '[object Object]', 2399, 0, 'https://robohash.org/optiosapientequos.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4017, 'Nexen', '[object Object]', 1022, 0, 'https://robohash.org/maioresnatusminima.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4018, 'Nexen', '[object Object]', 154, 0, 'https://robohash.org/quidemautdolorem.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4019, 'Double Coin', '[object Object]', 1039, 0, 'https://robohash.org/omnisdoloremenim.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4020, 'Heidenau', '[object Object]', 2617, 0, 'https://robohash.org/architectonisiet.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4021, 'Cooper', '[object Object]', 2419, 0, 'https://robohash.org/seddolorumet.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4022, 'Continental', '[object Object]', 1367, 0, 'https://robohash.org/autemautin.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4023, 'Federal', '[object Object]', 4552, 0, 'https://robohash.org/eligendidoloresperferendis.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4024, 'JK Tyre', '[object Object]', 2119, 0, 'https://robohash.org/molestiaeexplicaboexercitationem.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4025, 'IRC', '[object Object]', 1050, 0, 'https://robohash.org/culpaquamhic.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4026, 'Birla Tyres', '[object Object]', 2187, 0, 'https://robohash.org/solutasitin.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4027, 'Bridgestone', '[object Object]', 1468, 0, 'https://robohash.org/doloresquomolestias.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4028, 'Metzeler', '[object Object]', 4443, 0, 'https://robohash.org/consecteturcupiditatelaboriosam.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4029, 'Falken', '[object Object]', 467, 0, 'https://robohash.org/omnisvelitipsum.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4030, 'Michelin', '[object Object]', 2489, 0, 'https://robohash.org/sintdelenitiin.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4031, 'Federal', '[object Object]', 1854, 0, 'https://robohash.org/etconsequaturculpa.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4032, 'Shinko', '[object Object]', 283, 0, 'https://robohash.org/estaliquamest.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4033, 'Vee Rubber', '[object Object]', 2459, 0, 'https://robohash.org/similiqueidprovident.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4034, 'IRC', '[object Object]', 4990, 0, 'https://robohash.org/doloribusinnumquam.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4035, 'Heidenau', '[object Object]', 2211, 0, 'https://robohash.org/sedmagnamrem.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4036, 'Bridgestone', '[object Object]', 1458, 0, 'https://robohash.org/remquamadipisci.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4037, 'Metzeler', '[object Object]', 2746, 0, 'https://robohash.org/estvoluptatemeligendi.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4038, 'Nexen', '[object Object]', 506, 0, 'https://robohash.org/ullaminventorevoluptates.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4039, 'Avon', '[object Object]', 3473, 0, 'https://robohash.org/dolorumaccusantiumquaerat.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4040, 'Thunderer', '[object Object]', 3240, 0, 'https://robohash.org/totamestoccaecati.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4041, 'Shinko', '[object Object]', 733, 0, 'https://robohash.org/hiciustoaliquid.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4042, 'Kenda', '[object Object]', 4396, 0, 'https://robohash.org/rerumdoloremqui.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4043, 'GoldenTyre', '[object Object]', 419, 0, 'https://robohash.org/eosetporro.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4044, 'Double Coin', '[object Object]', 88, 0, 'https://robohash.org/ipsapossimusut.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4045, 'Heidenau', '[object Object]', 4255, 0, 'https://robohash.org/impeditatnecessitatibus.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4046, 'GoldenTyre', '[object Object]', 2758, 0, 'https://robohash.org/illumdignissimoset.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4047, 'Continental', '[object Object]', 2762, 0, 'https://robohash.org/inquonostrum.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4048, 'Kelly', '[object Object]', 2093, 0, 'https://robohash.org/aperiamillumquia.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4049, 'Lionhart', '[object Object]', 413, 0, 'https://robohash.org/fugiatasperioresbeatae.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4050, 'Kumho', '[object Object]', 902, 0, 'https://robohash.org/ullamasperioresrerum.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4051, 'GoldenTyre', '[object Object]', 3365, 0, 'https://robohash.org/quaehicin.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4052, 'Barum', '[object Object]', 1144, 0, 'https://robohash.org/autmaioreset.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4053, 'Achilles', '[object Object]', 2419, 0, 'https://robohash.org/explicaboautsequi.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4054, 'Cheng Shin', '[object Object]', 1519, 0, 'https://robohash.org/aliquideavoluptatem.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4055, 'Mastercraft', '[object Object]', 111, 0, 'https://robohash.org/eaeabeatae.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4056, 'Dunlop', '[object Object]', 2338, 0, 'https://robohash.org/debitisquasaliquid.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4057, 'Continental', '[object Object]', 1928, 0, 'https://robohash.org/reprehenderitomnisvel.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4058, 'Metzeler', '[object Object]', 2533, 0, 'https://robohash.org/veroestimpedit.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4059, 'Triangle', '[object Object]', 2081, 0, 'https://robohash.org/recusandaedelenitieos.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4060, 'Lassa', '[object Object]', 3250, 0, 'https://robohash.org/iustoeiusut.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4061, 'Vee Rubber', '[object Object]', 4357, 0, 'https://robohash.org/quisimiliqueimpedit.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4062, 'Vee Rubber', '[object Object]', 3986, 0, 'https://robohash.org/enimcumqueodit.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4063, 'Shinko', '[object Object]', 4047, 0, 'https://robohash.org/deseruntlaborevoluptatem.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4064, 'Apollo', '[object Object]', 2571, 0, 'https://robohash.org/sedutpossimus.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4065, 'IRC', '[object Object]', 1006, 0, 'https://robohash.org/delectusdoloremqueharum.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4066, 'Heidenau', '[object Object]', 71, 0, 'https://robohash.org/numquamquicommodi.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4067, 'Hercules', '[object Object]', 4324, 0, 'https://robohash.org/molestiasfugitporro.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4068, 'Hercules', '[object Object]', 4784, 0, 'https://robohash.org/quisequiquibusdam.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4069, 'Metzeler', '[object Object]', 2635, 0, 'https://robohash.org/adveritatisassumenda.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4070, 'Dunlop', '[object Object]', 3500, 0, 'https://robohash.org/aperiamquosid.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4071, 'Vredestein', '[object Object]', 993, 0, 'https://robohash.org/aliquiddignissimosquis.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4072, 'Michelin', '[object Object]', 4170, 0, 'https://robohash.org/eosfugiatmollitia.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4073, 'Lionhart', '[object Object]', 934, 0, 'https://robohash.org/voluptatemsolutalaudantium.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4074, 'Atturo', '[object Object]', 2601, 0, 'https://robohash.org/quiimpeditest.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4075, 'GoldenTyre', '[object Object]', 1628, 0, 'https://robohash.org/blanditiisaccusamusvoluptatem.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4076, 'Toyo', '[object Object]', 4271, 0, 'https://robohash.org/laboriosamsedcum.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4077, 'Lassa', '[object Object]', 3335, 0, 'https://robohash.org/reprehenderitquamvoluptas.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4078, 'Shinko', '[object Object]', 246, 0, 'https://robohash.org/nonautplaceat.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4079, 'Vredestein', '[object Object]', 966, 0, 'https://robohash.org/autinalias.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4080, 'Pirelli', '[object Object]', 2736, 0, 'https://robohash.org/nonexplicaboa.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4081, 'Metzeler', '[object Object]', 328, 0, 'https://robohash.org/noneiusquas.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4082, 'Maxxis', '[object Object]', 2548, 0, 'https://robohash.org/ametutvoluptas.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4083, 'Dunlop', '[object Object]', 693, 0, 'https://robohash.org/autvitaevoluptatem.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4084, 'Cheng Shin', '[object Object]', 2328, 0, 'https://robohash.org/totamutipsa.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4085, 'Michelin', '[object Object]', 760, 0, 'https://robohash.org/autemaliquamaut.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4086, 'Hercules', '[object Object]', 1774, 0, 'https://robohash.org/natuscumquia.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4087, 'Yokohama', '[object Object]', 859, 0, 'https://robohash.org/nametconsequatur.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4088, 'Mitas', '[object Object]', 3220, 0, 'https://robohash.org/sequifugaprovident.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4089, 'Triangle', '[object Object]', 1204, 0, 'https://robohash.org/doloribuscumeos.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4090, 'Nitto', '[object Object]', 1192, 0, 'https://robohash.org/quinoneius.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4091, 'Shinko', '[object Object]', 3735, 0, 'https://robohash.org/perferendisquisunt.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4092, 'Apollo', '[object Object]', 4868, 0, 'https://robohash.org/consequatursitquas.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4093, 'Yokohama', '[object Object]', 2037, 0, 'https://robohash.org/eumseddebitis.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4094, 'Dunlop', '[object Object]', 1782, 0, 'https://robohash.org/possimusteneturqui.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4095, 'Matador', '[object Object]', 4319, 0, 'https://robohash.org/eaauttemporibus.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4096, 'Shinko', '[object Object]', 503, 0, 'https://robohash.org/consequunturquamid.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4097, 'Riken', '[object Object]', 879, 0, 'https://robohash.org/liberovoluptasomnis.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4098, 'Kelly', '[object Object]', 2262, 0, 'https://robohash.org/iurecumqueculpa.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4099, 'Cooper', '[object Object]', 789, 0, 'https://robohash.org/molestiaeeumest.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4100, 'Vee Rubber', '[object Object]', 1621, 0, 'https://robohash.org/animisuntipsam.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4101, 'Goodyear', '[object Object]', 3527, 0, 'https://robohash.org/magnidoloruminventore.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4102, 'Heidenau', '[object Object]', 187, 0, 'https://robohash.org/delenitidoloreos.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4103, 'Lassa', '[object Object]', 4458, 0, 'https://robohash.org/utsintnon.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4104, 'CST', '[object Object]', 3304, 0, 'https://robohash.org/amolestiasvoluptates.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4105, 'Nankang', '[object Object]', 1876, 0, 'https://robohash.org/sitprovidentofficia.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4106, 'Mitas', '[object Object]', 792, 0, 'https://robohash.org/necessitatibusetquibusdam.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4107, 'Michelin', '[object Object]', 1774, 0, 'https://robohash.org/animiadomnis.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4108, 'Roadstone', '[object Object]', 4607, 0, 'https://robohash.org/sedsintquo.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4109, 'Maxxis', '[object Object]', 3992, 0, 'https://robohash.org/corrupticumquepariatur.png?size=1920x1080&set=set1', 0, '', '', '', '2024-07-19 13:31:23', ''),
(4110, '1', 'gh', 250, 3, 'uploads/wp7667749-tyre-wallpapers_resized (5).jpg', 1, '6', '52', '', '2024-07-19 13:31:23', ''),
(4111, '1', 'gh', 250, 3, 'uploads/wp7667749-tyre-wallpapers_resized (5).jpg', 1, '6', '52', '', '2024-07-19 13:31:23', ''),
(4112, '2', '45456', 450, 3, 'uploads/wp7667742-tyre-wallpapers.jpg', 3, '8', '69', '', '2024-07-19 13:31:23', ''),
(4113, 's', 'fgd', 45, 45, 'uploads/wp7667738-tyre-wallpapers.jpg', 2, '13', 'm,', '', '2024-07-19 13:31:23', ''),
(4115, '9', 'dg', 856, 4, 'uploads/pngwing.com (3).png', 3, '5', 'v', '', '2024-07-19 13:43:34', ''),
(4116, '5', 'fgd', 5, 6, 'uploads/wp7667742-tyre-wallpapers.jpg', 0, '13', 'Radial', '', '2024-07-19 13:56:25', 'Michelin'),
(4122, 'producto', 'producto', 10000000, 85, 'uploads/cart-removebg-preview.png', 0, '15', 'Radial', '', '2024-08-07 19:16:21', 'Michelin'),
(4123, 'producto', 'mlk', 445581000, 5, 'uploads/pngwing.com (3).png', 1, '15', 'Neumático de Verano', '', '2024-08-07 20:46:43', 'Michelin'),
(4124, 'prueba', 'prueba', 20000, 69, 'uploads/pngwing.com (2).png', 0, '13', 'Radial', 'Neumáticos para Todo el Año', '2024-08-07 22:42:09', 'Michelin'),
(4125, 'prueba', 'fgfg', 20000, 59, '', 0, '13', 'Radial', 'Neumáticos de Alto Rendimiento', '2024-08-07 22:45:10', 'Michelin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagenes`
--

CREATE TABLE `producto_imagenes` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_imagenes`
--

INSERT INTO `producto_imagenes` (`id`, `producto_id`, `imagen`) VALUES
(10, 4122, 'uploads/WhatsApp Image 2024-07-08 at 6.44.46 PM_resized.jpeg'),
(11, 4122, 'uploads/1_resized.png'),
(12, 4122, 'uploads/WhatsApp_Image_2024-07-08_at_6.44.46_PM-removebg-preview.png'),
(13, 4123, 'uploads/pngwing.com (3).png'),
(14, 4123, 'uploads/pngwing.com (2).png'),
(15, 4123, 'uploads/pngwing.com (1).png'),
(16, 4123, 'uploads/pngwing.com.png'),
(17, 4123, 'uploads/wp7667749-tyre-wallpapers_resized (7).jpg'),
(18, 4010, 'uploads/wp7667749-tyre-wallpapers.jpg'),
(19, 4010, 'uploads/wp7667742-tyre-wallpapers.jpg'),
(20, 4010, 'uploads/wp7667738-tyre-wallpapers.jpg'),
(21, 4010, 'uploads/cart-removebg-preview.png'),
(22, 4010, 'uploads/pngwing.com (2).png'),
(23, 4122, 'uploads/pngwing.com.png'),
(24, 4122, 'uploads/wp7667749-tyre-wallpapers_resized (6).jpg'),
(25, 4124, 'uploads/pngwing.com (2).png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrito_id` (`carrito_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `carrito_usuarios`
--
ALTER TABLE `carrito_usuarios`
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `delivery_person_id` (`delivery_person_id`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_ibfk_2` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carritos`
--
ALTER TABLE `carritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1723360759;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4126;

--
-- AUTO_INCREMENT de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`carrito_id`) REFERENCES `carritos` (`id`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD CONSTRAINT `carritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `carritos` (`id`);

--
-- Filtros para la tabla `carrito_usuarios`
--
ALTER TABLE `carrito_usuarios`
  ADD CONSTRAINT `carrito_usuarios_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`delivery_person_id`) REFERENCES `login` (`id`);

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD CONSTRAINT `producto_imagenes_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
