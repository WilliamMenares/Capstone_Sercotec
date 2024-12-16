-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-12-2024 a las 20:10:51
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `meniazco_sercotec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambitos`
--

CREATE TABLE `ambitos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ambitos`
--

INSERT INTO `ambitos` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Comercial (DL)', NULL, NULL),
(2, 'Financiero & Contable (RT)', NULL, NULL),
(3, 'Operaciones & Logistcia (FP)', NULL, NULL),
(4, 'Planificación & Análisis (ME)', NULL, NULL),
(5, 'RRHH (IB)', NULL, NULL),
(6, 'OL)()(@@@@@█████████████████████████', '2024-12-15 01:55:23', '2024-12-15 01:55:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `codigo`, `rut`, `nombre`, `email`, `contacto`, `created_at`, `updated_at`) VALUES
(1, 'Sin Asignar', '20880577-0', 'Meniaz', 'williammenares0@gmail.com', 'William Alexander Menares Diaz', NULL, NULL),
(2, 'Sernac', '12345678-5', 'HJUANMA', 'jua.olivares@duocuc.cl', 'OSCAR y WILLY', '2024-12-15 01:50:24', '2024-12-15 02:02:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `formulario_id` bigint(20) UNSIGNED NOT NULL,
  `empresa_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `user_id`, `formulario_id`, `empresa_id`, `created_at`, `updated_at`) VALUES
(4, 1, 2, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pregunta_id` bigint(20) UNSIGNED NOT NULL,
  `respuestas_tipo_id` bigint(20) UNSIGNED NOT NULL,
  `situacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accion1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accion2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accion3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accion4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formularios`
--

CREATE TABLE `formularios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `formularios`
--

INSERT INTO `formularios` (`id`, `nombre`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'formulario de prueba', 1, '2024-12-14 23:50:16', '2024-12-14 23:50:16'),
(2, 'ꜴꜴꜴꜴꜴꜴꜴꜴꜴꜴꜴꜴꜴꜴꜴꜴꜴꜴ', 1, '2024-12-15 01:56:31', '2024-12-15 01:56:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario_ambito`
--

CREATE TABLE `formulario_ambito` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `formulario_id` bigint(20) UNSIGNED NOT NULL,
  `ambito_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `formulario_ambito`
--

INSERT INTO `formulario_ambito` (`id`, `formulario_id`, `ambito_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, NULL, NULL),
(2, 1, 4, NULL, NULL),
(3, 2, 6, NULL, NULL),
(4, 2, 5, NULL, NULL),
(5, 2, 4, NULL, NULL),
(6, 2, 3, NULL, NULL),
(7, 2, 2, NULL, NULL),
(8, 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_24_000003_create_empresa_table', 1),
(5, '2024_11_24_163731_create_formulario_table', 1),
(6, '2024_11_24_163835_create_ambito_table', 1),
(7, '2024_11_24_164832_create_formulario_ambito_table', 1),
(8, '2024_11_24_164932_create_preguntas_table', 1),
(9, '2024_11_24_165116_create_encuestas_table', 1),
(10, '2024_11_24_170433_create_respuestas_tipo_table', 1),
(11, '2024_11_24_170536_create_respuestas_table', 1),
(12, '2024_11_24_172117_create_feedback_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ambito_id` bigint(20) UNSIGNED NOT NULL,
  `prioridad` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `title`, `ambito_id`, `prioridad`, `created_at`, `updated_at`) VALUES
(1, '¿La empresa tiene una estrategia comercial definida con objetivos claros a corto, mediano y largo plazo? (Esta pregunta busca saber si el negocio tiene un plan para vender sus productos o servicios. ¿Sabe la empresa qué quiere lograr en el futuro cercano (por ejemplo, en los próximos 6 meses), a mediano plazo (un año) y a largo plazo (más de un año)? Tener objetivos claros ayuda a dirigir las acciones del negocio para crecer y mejorar las ventas.)', 1, 1, NULL, NULL),
(2, '¿La empresa mide regularmente la satisfacción de sus clientes y utiliza los resultados para mejorar productos o servicios? (Aquí queremos saber si el negocio le pregunta a sus clientes si están contentos con lo que compraron o el servicio que recibieron. Saber qué piensan los clientes es importante para hacer mejoras y asegurarse de que regresen. ¿El negocio hace encuestas o preguntas a los clientes para saber si están satisfechos y usa esa información para mejorar?)', 1, 2, NULL, NULL),
(3, '¿La empresa tiene estrategias claras para retener a los clientes, como programas de lealtad o atención postventa? (Esta pregunta se enfoca en si el negocio tiene formas de mantener a los clientes actuales y hacer que vuelvan. ¿El negocio ofrece beneficios por ser cliente habitual, como descuentos o promociones especiales? Además, ¿hacen seguimiento después de la compra para asegurarse de que el cliente esté contento y regrese?)', 1, 3, NULL, NULL),
(4, '¿La empresa utiliza activamente medios tradicionales (publicidad impresa, eventos, etc.) para atraer y mantener a los clientes? (Esta pregunta trata de saber si el negocio usa medios como volantes, carteles, anuncios en la radio o participa en eventos locales para promocionarse. ¿El negocio hace este tipo de actividades para atraer nuevos clientes o recordar a los clientes actuales que vuelvan?)', 1, 4, NULL, NULL),
(5, '¿La empresa tiene una estrategia de marketing digital clara, utilizando redes sociales, campañas pagadas y SEO/SEM? (Queremos saber si el negocio está usando internet y redes sociales como Facebook, Instagram o Google para promocionarse. ¿Publican contenido, pagan por anuncios o usan estrategias para que el negocio aparezca en las búsquedas de Google? El marketing digital ayuda a atraer más clientes en línea.)', 1, 5, NULL, NULL),
(6, '¿La empresa realiza un análisis periódico del comportamiento de sus clientes y la competencia para ajustar sus estrategias comerciales? (Esta pregunta busca saber si el negocio observa y estudia tanto a sus propios clientes como a la competencia (otros negocios similares). ¿Saben qué prefieren los clientes, y qué están haciendo los competidores para mejorar sus propias estrategias de venta? Este análisis es útil para ajustar las ofertas y mantenerse competitivo en el mercado.)', 1, 6, NULL, NULL),
(7, '¿Se realiza un control adecuado del flujo de caja para garantizar liquidez en el corto plazo?', 2, 2, NULL, NULL),
(8, '¿Se gestionan eficientemente los costos, se han calculado correctamente los precios y el punto de equilibrio para asegurar la rentabilidad?', 2, 1, NULL, NULL),
(9, '¿Se realiza un análisis de los estados financieros (EERR y balance) y se evalúa la rentabilidad de las operaciones?', 2, 4, NULL, NULL),
(10, '¿Se lleva un control adecuado de los antecedentes tributarios y se cumplen las obligaciones fiscales a tiempo?', 2, 3, NULL, NULL),
(11, '¿Se evalúan adecuadamente las opciones de financiamiento y se gestionan de manera estratégica las inversiones?', 2, 5, NULL, NULL),
(12, '¿Se tiene un presupuesto anual definido y se compara regularmente con los resultados reales?', 2, 6, NULL, NULL),
(13, '¿Los tiempos de producción y logística están optimizados?', 3, 5, NULL, NULL),
(14, '¿Se gestionan adecuadamente los inventarios y stocks?', 3, 1, NULL, NULL),
(15, '¿Existen cuellos de botella en la cadena de suministro?', 3, 4, NULL, NULL),
(16, '¿La calidad del producto o servicio está estandarizada y es consistente?', 3, 3, NULL, NULL),
(17, '¿Se revisan periódicamente las relaciones con proveedores para mejorar costos y tiempos de entrega?', 3, 2, NULL, NULL),
(18, '¿Los procesos operativos están diseñados para maximizar la eficiencia y reducir desperdicios?', 3, 6, NULL, NULL),
(19, '¿Se establecen objetivos claros a corto, mediano y largo plazo e indicadores para medir su avance o cumplimiento?', 4, 1, NULL, NULL),
(20, '¿Se realiza un análisis de fortalezas, oportunidades, debilidades y amenazas (FODA) regularmente para ajustar la estrategia de la empresa?', 4, 2, NULL, NULL),
(21, '¿La empresa analiza regularmente las tendencias del mercado para anticiparse a futuros desafíos y oportunidades?', 4, 6, NULL, NULL),
(22, '¿La empresa utiliza sistemas tecnológicos para la gestión de la información?', 4, 3, NULL, NULL),
(23, '¿Se analizan los datos obtenidos para tomar decisiones informadas?', 4, 4, NULL, NULL),
(24, '¿Se implementan mejoras continuas basadas en el análisis de datos?', 4, 5, NULL, NULL),
(25, '¿Existe un proceso estructurado para la contratación y selección de personal?', 5, 1, NULL, NULL),
(26, '¿Se gestiona adecuadamente la documentación esencial de Recursos Humanos, como perfiles de cargo, organigrama, contratos y registros laborales?', 5, 2, NULL, NULL),
(27, '¿Se gestionan adecuadamente los beneficios y la compensación de los empleados?', 5, 4, NULL, NULL),
(28, '¿Se implementan políticas de retención de talento y planes de carrera para los empleados?', 5, 5, NULL, NULL),
(29, '¿Existe un sistema de evaluación de desempeño regular y bien definido?', 5, 3, NULL, NULL),
(30, '¿Se promueve un ambiente laboral positivo y se gestionan los conflictos de manera efectiva?', 5, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `encuesta_id` bigint(20) UNSIGNED NOT NULL,
  `pregunta_id` bigint(20) UNSIGNED NOT NULL,
  `respuestatipo_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `encuesta_id`, `pregunta_id`, `respuestatipo_id`, `created_at`, `updated_at`) VALUES
(55, 4, 6, 3, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(56, 4, 5, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(57, 4, 4, 1, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(58, 4, 3, 3, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(59, 4, 2, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(60, 4, 1, 1, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(61, 4, 12, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(62, 4, 11, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(63, 4, 10, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(64, 4, 9, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(65, 4, 8, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(66, 4, 7, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(67, 4, 18, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(68, 4, 17, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(69, 4, 16, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(70, 4, 15, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(71, 4, 14, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(72, 4, 13, 3, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(73, 4, 24, 3, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(74, 4, 23, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(75, 4, 22, 1, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(76, 4, 21, 1, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(77, 4, 20, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(78, 4, 19, 3, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(79, 4, 30, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(80, 4, 29, 3, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(81, 4, 28, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(82, 4, 27, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(83, 4, 26, 2, '2024-12-15 02:03:30', '2024-12-15 02:03:30'),
(84, 4, 25, 3, '2024-12-15 02:03:30', '2024-12-15 02:03:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_tipo`
--

CREATE TABLE `respuestas_tipo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puntaje` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `respuestas_tipo`
--

INSERT INTO `respuestas_tipo` (`id`, `titulo`, `puntaje`, `created_at`, `updated_at`) VALUES
(1, 'Cumple', 5, NULL, NULL),
(2, 'Cumple Parcialmente', 3, NULL, NULL),
(3, 'No Cumple', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1oPdJN5cpCsnmM2juIHl2s7uKa8rVBmnzsIwLuvC', 1, '179.60.76.168', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoickVVUkEyY1FWSDRUY3R0VExWSEk3b0YwRXFObnNSTVhMV2ZXaXhyVCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwczovL21lbmlhei5jb20vYXNlc29yaWFzL3BkZi8xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1734212901),
('6DztD7DeSh9xqmcw35lw5bM3RUzQeA47FZfaYmXE', NULL, '62.146.226.39', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTDZXN09GNDN1SmhtUUVDeXBITENuYUNzVmpTdHc0OTBWcFFnN01kNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vbWVuaWF6LmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1734210631),
('buuAVMoquHVLvKOWBv9E2rtfbM8fx7hHW7uBZYaP', NULL, '31.220.97.151', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGZzWVdlMHpmTFo3dk9valdaOG1XaWJ5b0RoWXBmazhpUmlIeVdqOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vbWVuaWF6LmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1734217826),
('cJE7TJXugIDYLGKgQQxxSKjbNO8OxXzeeCEWQCJc', NULL, '31.220.97.151', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWFFua3Z0QXM3UDU0Wlp6c1hxVlNiN3NxbDFXN2g0cmNBS3I5TVQ2YiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vbWVuaWF6LmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1734214097),
('gGeCeVVk2VqzS1qTG7pmvbhU1XFpPqpGwKed1mYH', 1, '45.230.39.104', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibkpIeDBGOVE0VlVLMmRub2pZcVQyZ1Q0WllraUhJVFhIdVdLNTlaSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vbWVuaWF6LmNvbS9hc2Vzb3JpYXMvcGRmLzQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1734217623),
('hzSMe5D11eZZxD2ntJV55jyzsvpooERayBDOjacJ', NULL, '113.62.169.130', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibU0zeWxOVVpxV05qbWZJM0xPTDFRVXBMVFI1N1BrZ3BIY3pVSTdTQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly93d3cubWVuaWF6LmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1734217674),
('MhOulcQJXtr296K7qj7d9DFqQXguFPcaugyus7tg', 1, '201.246.36.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTDdUTlRjaDFjMmtpc3RzOGJicWxsTm5ZOEhYV2plcHRpU3kxblROOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNDoiaHR0cHM6Ly9tZW5pYXouY29tL2FzZXNvcmlhcy9wZGYvNCI7fX0=', 1734217615),
('VvwOhYXIs7R1NTb9s2d8FnGkzryY3T4ZoCGB5q55', NULL, '190.208.14.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNzg5cElLMlhLd0taMUpWSWd3d1Zhano3aDVKVG45WXR3VldWOVYzWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vbWVuaWF6LmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1734216475),
('z6enTRauPeSjPyGifbpMHkbFK7y1b4xDZItpnCXf', NULL, '31.13.115.9', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOHc2a3IwcDJ1NU5HdURoTHFoSG5rcE9KQ1IyVGdadzh2RnljR3NNMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTc6Imh0dHA6Ly9tZW5pYXouY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1734215559);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `telefono`, `rut`, `rol`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '+56000000000', '88888888-8', 0, 'williammenares0@gmail.com', NULL, '$2y$12$mZqKF/3jOCreBEntRUrM/u5lgixpThf6p/swR9m11VpVRDNKi12RG', 'DNkINa1tkRPUlHPLMRwB12WlsCREg9nxVMID5Jhb3ni0yRc87twy3NABHXp7', '2024-12-14 23:49:33', '2024-12-14 23:49:33'),
(2, 'Juan Manuel Olivares Jiménez', '+56964409666', '12345678-5', 0, 'jua.olivares@duocuc.cl', NULL, '$2y$12$u.mTOD3/M.vrNc/0LdZs9urIty.OAw0m66LaMlL4W4s8kObtv1/Ei', NULL, '2024-12-15 01:51:49', '2024-12-15 01:51:49');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ambitos`
--
ALTER TABLE `ambitos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empresas_codigo_unique` (`codigo`),
  ADD UNIQUE KEY `empresas_rut_unique` (`rut`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `encuestas_user_id_foreign` (`user_id`),
  ADD KEY `encuestas_formulario_id_foreign` (`formulario_id`),
  ADD KEY `encuestas_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedbacks_pregunta_id_foreign` (`pregunta_id`),
  ADD KEY `feedbacks_respuestas_tipo_id_foreign` (`respuestas_tipo_id`);

--
-- Indices de la tabla `formularios`
--
ALTER TABLE `formularios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formularios_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `formulario_ambito`
--
ALTER TABLE `formulario_ambito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formulario_ambito_formulario_id_foreign` (`formulario_id`),
  ADD KEY `formulario_ambito_ambito_id_foreign` (`ambito_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `preguntas_ambito_id_foreign` (`ambito_id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `respuestas_encuesta_id_foreign` (`encuesta_id`),
  ADD KEY `respuestas_pregunta_id_foreign` (`pregunta_id`),
  ADD KEY `respuestas_respuestatipo_id_foreign` (`respuestatipo_id`);

--
-- Indices de la tabla `respuestas_tipo`
--
ALTER TABLE `respuestas_tipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ambitos`
--
ALTER TABLE `ambitos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formularios`
--
ALTER TABLE `formularios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `formulario_ambito`
--
ALTER TABLE `formulario_ambito`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `respuestas_tipo`
--
ALTER TABLE `respuestas_tipo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD CONSTRAINT `encuestas_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  ADD CONSTRAINT `encuestas_formulario_id_foreign` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`),
  ADD CONSTRAINT `encuestas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_pregunta_id_foreign` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`),
  ADD CONSTRAINT `feedbacks_respuestas_tipo_id_foreign` FOREIGN KEY (`respuestas_tipo_id`) REFERENCES `respuestas_tipo` (`id`);

--
-- Filtros para la tabla `formularios`
--
ALTER TABLE `formularios`
  ADD CONSTRAINT `formularios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `formulario_ambito`
--
ALTER TABLE `formulario_ambito`
  ADD CONSTRAINT `formulario_ambito_ambito_id_foreign` FOREIGN KEY (`ambito_id`) REFERENCES `ambitos` (`id`),
  ADD CONSTRAINT `formulario_ambito_formulario_id_foreign` FOREIGN KEY (`formulario_id`) REFERENCES `formularios` (`id`);

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_ambito_id_foreign` FOREIGN KEY (`ambito_id`) REFERENCES `ambitos` (`id`);

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_encuesta_id_foreign` FOREIGN KEY (`encuesta_id`) REFERENCES `encuestas` (`id`),
  ADD CONSTRAINT `respuestas_pregunta_id_foreign` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`),
  ADD CONSTRAINT `respuestas_respuestatipo_id_foreign` FOREIGN KEY (`respuestatipo_id`) REFERENCES `respuestas_tipo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
