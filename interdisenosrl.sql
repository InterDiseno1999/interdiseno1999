/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `interdisenosrl` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `interdisenosrl`;

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `compositions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `compositions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `compositions` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Algodón', '2026-03-02 23:56:27', '2026-03-02 23:56:27'),
	(2, 'Lino', '2026-03-02 23:56:34', '2026-03-02 23:56:34'),
	(3, 'Poliester', '2026-03-02 23:56:41', '2026-03-02 23:56:41'),
	(4, 'Cuero Sintetico', '2026-03-02 23:56:52', '2026-03-02 23:56:52'),
	(5, 'Pana', '2026-03-03 04:53:07', '2026-03-03 04:53:07');

CREATE TABLE IF NOT EXISTS `composition_product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `composition_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `composition_product_product_id_foreign` (`product_id`),
  KEY `composition_product_composition_id_foreign` (`composition_id`),
  CONSTRAINT `composition_product_composition_id_foreign` FOREIGN KEY (`composition_id`) REFERENCES `compositions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `composition_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `composition_product` (`id`, `product_id`, `composition_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2026-03-02 23:57:24', '2026-03-02 23:57:24'),
	(3, 2, 1, '2026-03-03 02:34:54', '2026-03-03 02:34:54'),
	(4, 3, 1, '2026-03-03 03:59:49', '2026-03-03 03:59:49'),
	(5, 4, 1, '2026-03-03 04:01:52', '2026-03-03 04:01:52'),
	(6, 5, 1, '2026-03-03 04:05:57', '2026-03-03 04:05:57'),
	(7, 6, 1, '2026-03-03 04:36:09', '2026-03-03 04:36:09'),
	(8, 7, 2, '2026-03-03 04:37:24', '2026-03-03 04:37:24'),
	(9, 8, 2, '2026-03-03 04:38:06', '2026-03-03 04:38:06'),
	(10, 9, 1, '2026-03-03 04:40:32', '2026-03-03 04:40:32'),
	(11, 10, 1, '2026-03-03 04:41:42', '2026-03-03 04:41:42'),
	(12, 11, 1, '2026-03-03 04:46:41', '2026-03-03 04:46:41'),
	(13, 12, 1, '2026-03-03 04:49:48', '2026-03-03 04:49:48'),
	(14, 13, 5, '2026-03-03 04:53:40', '2026-03-03 04:53:40'),
	(15, 14, 5, '2026-03-03 04:54:15', '2026-03-03 04:54:15'),
	(16, 15, 3, '2026-03-03 04:56:22', '2026-03-03 04:56:22'),
	(17, 16, 1, '2026-03-03 05:00:58', '2026-03-03 05:00:58'),
	(18, 17, 1, '2026-03-03 05:01:57', '2026-03-03 05:01:57'),
	(19, 18, 1, '2026-03-03 20:23:33', '2026-03-03 20:23:33');

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_03_02_162649_create_compositions_table', 1),
	(5, '2026_03_02_164414_create_variants_table', 1),
	(6, '2026_03_02_222711_create_products_table', 1),
	(7, '2026_03_03_164748_create_product_variant_table', 1),
	(8, '2026_03_03_203647_create_composition_product_table', 1);

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1.40',
  `stock` tinyint(1) NOT NULL DEFAULT '1',
  `has_design` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `image`, `width`, `stock`, `has_design`, `created_at`, `updated_at`) VALUES
	(1, 'Boucle Caterina', 'boucle-caterina', 'Nuestro boucle Caterina invita a recorrer su textura, apreciar sus colores y disfrutar de una tela pensada para aportar carácter, calidez y sofisticación a cada ambiente.\r\n \r\nIdeal para tapicería y proyectos de alto impacto visual.', 'products/main/FA9fc19fg9uQ8GNDvWy8S0IHfWUEbmPCImQFJuqI.jpeg', '1.40', 1, 0, '2026-03-02 23:57:24', '2026-03-03 16:52:41'),
	(2, 'Bantu', 'bantu', 'Un género Jacquard de fibra natural, 100% algodón. Versátil, suave y resistente que se adapta a cada espacio con etilo y confort. \r\n\r\nPerfecta para tapicería, mantas o detalles decorativos, su textura aporta calidez y un toque artesanal transformando los ambientes.', 'products/main/F3KnBN8EsEsGxsgtiqSHq4G2TmaYkUMIyjJV7CDG.jpeg', '1.40', 1, 0, '2026-03-03 02:34:54', '2026-03-03 16:53:13'),
	(3, 'Boucle Verona', 'boucle-verona', 'Versión más refinada de boucle, con textura agradable al tacto y acabado suave.   \r\n\r\nIdeal para muebles modernos y diseños contemporáneos.', 'products/main/taD5vKXPhuMOflnPOhwC9JFKrf6qocgnULHqUNBh.jpeg', '1.40', 1, 0, '2026-03-03 03:59:49', '2026-03-03 16:53:39'),
	(4, 'Capri', 'capri', 'Una tela de look artesanal, resistente que combina perfectamente un chenyl con el boucle. Da profundidad visual a los muebles y es perfecta para diseños nórdicos o modernos.  \r\n\r\nCon su textura de carácter y su acabado elegante, transforma cualquier espacio en una obra de arte decorativo.', 'products/main/1YlAzC76BmwURZU8Hvdz9QVOOeN8ICsltYJSHAOL.jpeg', '1.40', 1, 0, '2026-03-03 04:01:52', '2026-03-03 16:53:52'),
	(5, 'Dakar', 'dakar', 'Una tela que se destaca por su elegante diseño geométrico, producido mediante la técnica de tejido Jacquard, aporta relieve, textura y profundidad visual. \r\n\r\nSu patrón encadenado genera un efecto dinámico y moderno, convirtiéndola en una opción ideal para tapicería y proyectos decorativos que buscan incorporar diseño y personalidad. Su estructura firme, brinda resistencia y durabilidad, permitiendo su uso en piezas de uso frecuente sin perder su estética distintiva.', 'products/main/7pD7Zb5CdysmY5nxuLeJhxpSzEEzTvhF8OPmRaUz.jpeg', '1.40', 1, 0, '2026-03-03 04:05:57', '2026-03-03 16:54:12'),
	(6, 'Kenia', 'kenia', 'Tela que combina la elegancia del tejido jacquard con un diseño de pequeños cuadrados, que aporta textura, rusticidad y un estilo atemporal. \r\n\r\nSu entramado estructurado brinda resistencia y durabilidad, convirtiéndola en una excelente \r\nopción para tapicería y proyectos de decoración. El patrón geométrico sutil genera un equilibrio perfecto entre lo clásico y lo moderno, permitiendo integrar distintos estilos de interiorismo.', 'products/main/FAdgR70SjzqNTV4F27HmROptNCBqEM8p4b9f7dnZ.jpeg', '1.40', 1, 0, '2026-03-03 04:36:09', '2026-03-03 16:54:28'),
	(7, 'Lino Cali', 'lino-cali', 'Una genero con textura de lino reconocido por su elegancia y delicada apariencia rustica. Su \r\nentramado fino y uniforma imita a la perfección el lino autentico, brindando frescura visual y un tacto suave al uso diario. \r\n\r\nSi buscas una tela que se adapte fácilmente a diferentes estilos con luminosidad y sofisticación, el lino Cali es tu mejor opción.', 'products/main/0DK88mhkfrF1814jwdU1eI7nCRFbGgiQsNa8LvVx.jpeg', '1.40', 1, 0, '2026-03-03 04:37:24', '2026-03-03 16:54:52'),
	(8, 'Lino Folk', 'lino-folk', 'Tela de textura de lino lavado, que aporta un aire relajado, natural. Su fino tramado visible le \r\notorga carácter artesanal, ideal para ambientes que buscan equilibrio entre los rustico y lo contemporáneo.  \r\n\r\nEsta tela ofrece una combinación de versatilidad y resistencia, ideal para proyectos \r\nresidenciales como comerciales.', 'products/main/LSYGFz9iX2Q3dFn8rynoxEP4WGeu3zacQ1ES0mSt.jpeg', '1.40', 1, 0, '2026-03-03 04:38:06', '2026-03-03 16:55:06'),
	(9, 'Mali', 'mali', 'Genero que combina la sofisticación del tejido jacquard con un delicado diseño espigado, su \r\ntextura sutil y elegante destaca en lo visual sin sobrecargar el ambiente. \r\n\r\nSu entramado compacto es y durable, es una excelente opción para tapicería y proyectos \r\ndecorativos que buscan un estilo equilibrado y clásico. Su patrón versátil permite integrarla \r\nfácilmente en propuestas modernas, clásicas o minimalistas.', 'products/main/AipUqDdqmI07DghDYWqrWDwrwpzAlPjm87ePoxIG.jpeg', '1.40', 1, 0, '2026-03-03 04:40:32', '2026-03-03 16:55:28'),
	(10, 'Mohana', 'mohana', '¡Una tela de tendencia, que brillo en el último salón del mueble en Milán! Descubrí este \r\ngénero de actualidad de diseño innovador, funcional y elegante. Su textura suave al tacto y  acabado distintivo la convierten en una opción única e innovadora, ideal para quienes buscan modernismo y sofisticación en sus espacios. \r\n\r\nIdeal para sillones, sillas, almohadones y accesorios deco, esta tela es la elección perfecta para quienes priorizan calidad, tendencia y distinción en cada detalle.', 'products/main/a1UMX1gpJyEsmFOe8kySfr9jkU74plY1Urwl8ihu.jpeg', '1.40', 1, 0, '2026-03-03 04:41:42', '2026-03-03 16:55:49'),
	(11, 'Mombasa', 'mombasa', 'Una tela que transforma el diseño en experiencia sensorial. Su patrón geométrico y \r\nconstrucción especial la transforman en una tela ideal para mantas decorativas, pie de cama o almohadones, aportando un diferencial textil decorativo. \r\n\r\nGracias a su suavidad envolvente, resulta ideal para proyectos textiles decorativos. Su diseño \r\ngeométrico de raíces étnicas destaca en mantas, pie de cama y almohadones.', 'products/main/GlXVhSolYeXXr8pw7I9PzNgZiQa34drHDJx6esk9.jpeg', '1.40', 1, 0, '2026-03-03 04:46:41', '2026-03-03 16:56:18'),
	(12, 'Nairobi', 'nairobi', 'Tela que transforma la superficie en un juego sutil de movimiento y textura. Su diseño de \r\ncuadros ondulados y sinuosos destaca por su carácter e identidad, impregnando alegría y \r\nmovimiento a tus espacios. \r\n\r\nTejido Jacquard con cuerpo, resistente y durable, es una excelente alternativa para tapizados que busquen destacar. De origen rustico su estilo adaptable lo hace ideal para todo tipo de propuestas, contemporáneos, clásicos, modernos y naturales.', 'products/main/xAcdtMpBcWXdKRPeHNEc7KiSmwCjVUIpxlV9BYXj.jpeg', '1.40', 1, 0, '2026-03-03 04:49:48', '2026-03-03 16:56:30'),
	(13, 'Pana Chandelier', 'pana-chandelier', 'Una pana elegante y contemporánea, su textura aterciopelada de pelo corto brinda suavidad y refinamiento, de delicado brillo aporta suntuosidad y sofisticación en los ambientes. \r\n\r\nGracias a su excelente caída y tacto sedoso, es ideal para piezas protagonistas y cortinados imponentes.', 'products/main/afd7oosDhkjPRreDL0ElzRpaTttitexMTRSFKNOe.jpeg', '1.40', 1, 0, '2026-03-03 04:53:40', '2026-03-03 16:56:45'),
	(14, 'Pana Milano', 'pana-milano', 'Una pana que representa la tendencia actual hacia lo simple y lo auténtico. Esta pana de sutil opacidad ofrece una textura suave y envolvente, con un acabado sobrio que transmite calidez y armonía visual. \r\n\r\nSu resistencia y versatilidad la hacen perfecta para tapicería y decoración, adaptándose \r\nfácilmente a estilos minimalistas, modernos y clásicos.', 'products/main/V2aLieV7gsGs5xX8VtFYif2LU0MICSNS1VQpzLpI.jpeg', '1.40', 1, 0, '2026-03-03 04:54:15', '2026-03-03 16:57:01'),
	(15, 'Rafia', 'rafia', 'Tela inspirada en la naturaleza, donde la textura rústica y el entramado grueso crean \r\nsuperficies elegante rusticidad, adaptándose también para proyectos modernos, costeros y \r\nminimalistas.  \r\n\r\nSu equilibrio entre resistencia y estética orgánica la convierte en una opción ideal para \r\ntapizados y decoración con estilo cálido, relajado y sofisticado.', 'products/main/y6c4kV8Hv3ZY9U7dDZQ7tjTZPmDWTsdlcmQyR5et.jpeg', '1.40', 1, 0, '2026-03-03 04:56:22', '2026-03-03 16:57:15'),
	(16, 'Sabana', 'sabana', 'Una tela que se distingue por su diseño liso con un delicado efecto rustico, que aporta volumen, resistencia y naturalidad a los tapizados. \r\n\r\nSu estructura brinda resistencia y durabilidad, convirtiéndola en una excelente opción para tapicería y proyectos decorativos. Su textura suave y envolvente genera superficies cálidas y confortables, ideales para acompañar tendencias de interiorismo contemporáneo y orgánico. \r\n\r\nPerfecta para sillones, sillas, almohadones y piezas decorativas, es una tela versátil que combina elegancia, confort y personalidad en cada aplicación.', 'products/main/uARzNGN0dlIwkDhk37yC0GB2ktX72n0BINyHpbKu.jpeg', '1.40', 1, 0, '2026-03-03 05:00:58', '2026-03-03 16:57:31'),
	(17, 'Wilson', 'wilson', 'Un género ideal  para todo uso. De apariencia lino este liso combina color, resistencia y buen \r\ngusto. \r\n\r\nEspecialmente pensado para todo uso en tapicería. Ideal para sillas, sillones, fundas, paneles entelados y sillas de oficina.', 'products/main/YHSmtnnwwgRbtQjs2dXJmHSq5iOpo4zcoLp5s1XW.jpeg', '1.40', 1, 0, '2026-03-03 05:01:57', '2026-03-03 16:57:45'),
	(18, 'Tanziano', 'tanziano', 'Una tela Jacquard de clara personalidad. Se destaca por su diseño espigado de apariencia \r\nartesanal, de composición 100% algodón. Su presencia y refinamiento la distinguen como un producto resistente, suave al tacto y elegante a la vista. \r\n\r\nSu estructura firme y resistente la convierte en una excelente alternativa para tapicería de uso frecuente y proyectos decorativos que buscan protagonismo y personalidad. El dibujo más marcado genera dinamismo visual y aporta un estilo elegante y contemporáneo.', 'products/main/UadHSH6PvKKc6HNRKmcAofFYYTvf0tnuin2SboUy.jpeg', '1.40', 1, 0, '2026-03-03 20:23:33', '2026-03-03 20:23:33');

CREATE TABLE IF NOT EXISTS `product_variant` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `variant_id` bigint unsigned NOT NULL,
  `variant_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variant_product_id_foreign` (`product_id`),
  KEY `product_variant_variant_id_foreign` (`variant_id`),
  CONSTRAINT `product_variant_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_variant_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `product_variant` (`id`, `product_id`, `variant_id`, `variant_image`, `created_at`, `updated_at`) VALUES
	(4, 2, 3, 'products/variants/jBXeAlhypTnndTbjGSvOCaEtGtN5IdAWz7JQBpDc.jpeg', '2026-03-03 03:56:56', '2026-03-03 16:53:13'),
	(5, 2, 8, 'products/variants/yy5fBWbePOSRhVngUNZxDEjwExFPgpSzlGmn2gRP.jpeg', '2026-03-03 03:56:56', '2026-03-03 16:53:13'),
	(6, 4, 9, 'products/variants/AS631BDZqJxPbnD9FTix3qWTrkG3rWbD1HjYBKSB.jpeg', '2026-03-03 04:01:52', '2026-03-03 16:53:52'),
	(7, 4, 4, 'products/variants/wgkNB06KWscqYuvhRauDA7qjzCCPheFCNU4nPHDL.jpeg', '2026-03-03 04:01:52', '2026-03-03 16:53:52'),
	(8, 5, 5, 'products/variants/DU6megeGrc90ekKxjd400hWPuUJS4su5jfvWLCCk.jpeg', '2026-03-03 04:05:57', '2026-03-03 16:54:12'),
	(9, 5, 10, 'products/variants/d731jXDZlS0oU6OEpbeZXrPx2i9zZMNPBx3Fcjpj.jpeg', '2026-03-03 04:05:57', '2026-03-03 16:54:12'),
	(10, 5, 4, 'products/variants/h4YxqrhK46RxcZH6OgbucU8OwpHueNl8y45GuvDh.jpeg', '2026-03-03 04:05:57', '2026-03-03 16:54:12'),
	(11, 6, 5, 'products/variants/44JVY9VLEehW3Y4Fy9iSyOLovcg4CDGzxqOHBhLG.jpeg', '2026-03-03 04:36:09', '2026-03-03 16:54:28'),
	(12, 9, 10, 'products/variants/MjsxECDUUjsaIYhzQ1868KTDlnObZrL2UBWECmeN.jpeg', '2026-03-03 04:40:32', '2026-03-03 16:55:28'),
	(13, 9, 11, 'products/variants/mdVgXHdV8WLKbojGJRHiCqwSkIESYq8l9youHfIh.jpeg', '2026-03-03 04:40:32', '2026-03-03 16:55:28'),
	(14, 11, 6, 'products/variants/16Yc5si5bB7Z0KcZX7TjyLDbABUBy4IV5AP7qGLP.jpeg', '2026-03-03 04:46:41', '2026-03-03 16:56:18'),
	(15, 11, 5, 'products/variants/zTutAifafdN73lLEGnbpWOOkZEAg1RtDGgt1wxtF.jpeg', '2026-03-03 04:46:41', '2026-03-03 16:56:18'),
	(16, 11, 7, 'products/variants/1NpTshKsO90vLzg8IUP3ti5gjiUsRsRDFKxeYnLT.jpeg', '2026-03-03 04:46:41', '2026-03-03 16:56:18'),
	(17, 12, 5, 'products/variants/TEtRmAx9zDWTkhFCz4QTJx8r8bn1EOIBikEboFuo.jpeg', '2026-03-03 04:49:48', '2026-03-03 16:56:30'),
	(18, 12, 10, 'products/variants/Df7ZTrI01WtASliUPTlbyXLmlqKTKxex7s0WgaK7.jpeg', '2026-03-03 04:49:48', '2026-03-03 16:56:30'),
	(19, 12, 4, 'products/variants/rykTrMrMX8THPpnnokTiuQGwOWVvsPSZzy53dV8j.jpeg', '2026-03-03 04:49:48', '2026-03-03 16:56:30'),
	(20, 16, 12, 'products/variants/xqpP5sju2Rq36BByufQjFuC76EcQ2czhhSOgji4H.jpeg', '2026-03-03 05:00:58', '2026-03-03 16:57:31'),
	(21, 16, 10, 'products/variants/830iSyOdbyQmg7iUB8bRsF9DtW2yf7R35wMizU9r.jpeg', '2026-03-03 05:00:58', '2026-03-03 16:57:31'),
	(22, 16, 4, 'products/variants/kjZqQnLaCq6Jbl7mp7D4Ch30784Gc6RREi5LbXUL.jpeg', '2026-03-03 05:00:58', '2026-03-03 16:57:31'),
	(23, 18, 4, 'products/variants/EDFt1rArAj1uj9wVWY8CkCEeC2Whg7jfZ0AqAxEf.jpeg', '2026-03-03 20:23:33', '2026-03-03 20:23:33');

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('Io3YzedA8qqft6u8tcPDTbiyC7CedOiGCT5TUzH8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOU9KbGJuNW1EZ3E3NWk1TG5nN3hTODhyZTRmenNmc1FBU3ZseWNUZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jb250YWN0byI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772578130),
	('tdpndXiLSa2B2xJjVzWDiLEwJgd4E2qE5P1K6Zhl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieWxITVZYTkxpTkF6aXBPQmRjRFp2enQxYkl0OVhjOGRmbWs3WjlSZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772917509);

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('Base','Estampado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Base',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `variants_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `variants` (`id`, `name`, `category`, `created_at`, `updated_at`) VALUES
	(1, 'Blanco', 'Base', '2026-03-02 23:56:09', '2026-03-02 23:56:09'),
	(2, 'Rayado', 'Estampado', '2026-03-02 23:56:18', '2026-03-02 23:56:18'),
	(3, 'Natural', 'Base', '2026-03-03 03:45:53', '2026-03-03 03:45:53'),
	(4, 'Sand', 'Base', '2026-03-03 03:46:49', '2026-03-03 03:46:49'),
	(5, 'Negro', 'Base', '2026-03-03 03:53:30', '2026-03-03 03:53:30'),
	(6, 'Bronce', 'Base', '2026-03-03 03:53:46', '2026-03-03 03:53:46'),
	(7, 'Vison', 'Base', '2026-03-03 03:54:01', '2026-03-03 03:54:01'),
	(8, 'Niebla', 'Base', '2026-03-03 03:54:17', '2026-03-03 03:54:17'),
	(9, 'Perla', 'Base', '2026-03-03 03:54:33', '2026-03-03 03:54:33'),
	(10, 'Gris', 'Base', '2026-03-03 03:54:48', '2026-03-03 03:54:48'),
	(11, 'Ivory', 'Base', '2026-03-03 03:55:02', '2026-03-03 03:55:02'),
	(12, 'Crudo', 'Base', '2026-03-03 03:55:18', '2026-03-03 03:55:18');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
