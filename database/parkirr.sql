-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: parkirr
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (4,'2026_11_15_132539_create_tb_tarif_table',1),(5,'2026_11_15_132545_create_tb_area_parkir_table',1),(6,'2026_11_15_132548_create_tb_kendaraan_table',1),(7,'2026_11_15_132552_create_tb_transaksi_table',1),(8,'2026_11_15_132554_create_tb_log_aktivitas_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('88m7db4D4FLPRkcIjf6zSU9aDTuC8U05oeADUTtc',1,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoic3ZtVFBpZU9aUXg2cmNhR0t3MncyVndhYjN1N2JYdXNZRnh1V25CbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9hZG1pbi9sb2ciO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmxvZy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImJjMjE2MzI4YWFlZmE2YjUzMjIzOTc3NzVmYmIzMGZhMWI3OWZjNTQxZWFjZjNiNmRlMjg2MmZhZjNkMWM0YjUiO30=',1794757081),('d7gfjo2SYzC8JCdFGiyzjECiqeVDIVabv92h5xV0',2,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTmhVVmxlSUNJa3gxTnlaYWs0Wk1uNkJXZWw0Tndmb1RxcURZYnFGTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjFkYjA1MTYxYjg0ZjAxZDc4YzhjZWM3OGFlMDZhOTNmZWNmM2VhZjlkY2RmOGE2OTA0YTJlYWNkNDk0YzI0MjUiO30=',1794757245),('EOvO6Vldfd9EOiHySPkx1iknHFmtp5XzDIbMLz61',2,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoid0VwRHV0MDhVb3VQRFRGeEdYTmNpWnZZRDVwOW1kenFwbGhKUTZWMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9wZXR1Z2FzL3N0cnVrLzEiO3M6NToicm91dGUiO3M6MTM6InBldHVnYXMuc3RydWsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiIxZGIwNTE2MWI4NGYwMWQ3OGM4Y2VjNzhhZTA2YTkzZmVjZjNlYWY5ZGNkZjhhNjkwNGEyZWFjZDQ5NGMyNDI1Ijt9',1794757331),('eTMxFo8A1ipapvCiGFsl5HrYe5knokJtRpXLzRYC',3,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYW9CQjlZUEx6bVFmRndyY2IxRDdFTTBWNFJXaGdOMlU2OVNyMFNnZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9vd25lci9yZWthcCI7czo1OiJyb3V0ZSI7czoxMToib3duZXIucmVrYXAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiI4YzdkYzMwMmY1NGY4ODE0NGQzNzA5NTI3YmI3NzRkZWJmNDc2NmZiOWM5ZDJkZjljOGNkYzMxNDAwYTQwMDE4Ijt9',1794757088),('gsrYKCNTQiQqQkQBAM66yLYVbJgtLFHcoobTrfct',1,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTkZ3dmZ5NU12dDBMMGJuVDNsVXFpRnJpQjA2a1hMY2JFYnZwYmcwTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9wZXR1Z2FzL3N0cnVrLzEiO3M6NToicm91dGUiO3M6MTM6InBldHVnYXMuc3RydWsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiJiYzIxNjMyOGFhZWZhNmI1MzIyMzk3Nzc1ZmJiMzBmYTFiNzlmYzU0MWVhY2YzYjZkZTI4NjJmYWYzZDFjNGI1Ijt9',1794757163),('i3QoxnQ0efrYdY3ac2cCFEJTx5cxeaUfheQvmkaY',2,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiek10dmpCaTJkRHA4Z3JYTUlnendHWnJ2NjhYelRNR3VybnRIdWx3RCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjFkYjA1MTYxYjg0ZjAxZDc4YzhjZWM3OGFlMDZhOTNmZWNmM2VhZjlkY2RmOGE2OTA0YTJlYWNkNDk0YzI0MjUiO30=',1794757277),('JIeUKGbUZKtijNFiNS21yZqmMMq7gWSQjClaZQhu',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:160.0) Gecko/20100101 Firefox/160.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMjhHQ1d4VW5wSG1WckZGNUNURVVRVjl1eHh0VGliVHYzTFZydVhKdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=',1794755036),('Pcjse6lBwvQE2Q7ieEOCJ6AYWsX1woWnb9yq2Cww',2,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoic1dQVmg4VktPR1hITnoxVW94M1R2eGFEZWUwRlFqRkxpcVp3VGw5cSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9wZXR1Z2FzL3RyYW5zYWtzaSI7czo1OiJyb3V0ZSI7czoyMzoicGV0dWdhcy50cmFuc2Frc2kuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiIxZGIwNTE2MWI4NGYwMWQ3OGM4Y2VjNzhhZTA2YTkzZmVjZjNlYWY5ZGNkZjhhNjkwNGEyZWFjZDQ5NGMyNDI1Ijt9',1794757140),('Q6giXIANb1O9WEMIHtR3JridOWj7GuXr6Ccmx368',3,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiczBsZTdqRjNiOFN2MlZZWGZyeWhWSE11MmVIYW5Fc2NTZVdrblhpMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9vd25lci9yZWthcCI7czo1OiJyb3V0ZSI7czoxMToib3duZXIucmVrYXAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiI4YzdkYzMwMmY1NGY4ODE0NGQzNzA5NTI3YmI3NzRkZWJmNDc2NmZiOWM5ZDJkZjljOGNkYzMxNDAwYTQwMDE4Ijt9',1794757142),('RDes7ktYaz6J8M31l5Q1VarV4igxLMMFcJZwfnty',1,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNXZCS0kybVI3TkhpcTNIUHl0NGFuZWlxZTVxVjBwOUdjNmJmZVNheSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9hZG1pbi9sb2ciO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmxvZy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImJjMjE2MzI4YWFlZmE2YjUzMjIzOTc3NzVmYmIzMGZhMWI3OWZjNTQxZWFjZjNiNmRlMjg2MmZhZjNkMWM0YjUiO30=',1794757138),('SUxEz4m2XbwoVTt3nwqY8CHxQl0rffsXKwGOo4mR',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.146.0 Chrome/150.0.7871.250 Electron/43.8.6 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQnV5WVhSV1hPWDlBVVk2RmZpTGJLU0FhOE1lQTI1dkYzdDVwc2t1OSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImJjMjE2MzI4YWFlZmE2YjUzMjIzOTc3NzVmYmIzMGZhMWI3OWZjNTQxZWFjZjNiNmRlMjg2MmZhZjNkMWM0YjUiO30=',1794755163),('w8KnGnAbhgKkWeXXwXQDBA4J9FZuNVpnSoeGCpbZ',2,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWUVramFQMEEwdjRzSjhCUGRBRjNxRmhvQU1heWhrMVh6SVZ3YzY1byI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9wZXR1Z2FzL3RyYW5zYWtzaSI7czo1OiJyb3V0ZSI7czoyMzoicGV0dWdhcy50cmFuc2Frc2kuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiIxZGIwNTE2MWI4NGYwMWQ3OGM4Y2VjNzhhZTA2YTkzZmVjZjNlYWY5ZGNkZjhhNjkwNGEyZWFjZDQ5NGMyNDI1Ijt9',1794757085),('XfjIKH7lT8fYc2WUIzOgM2OiJYKbUmOkCY2C24ER',2,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNGs3eVhGNEg4TDVEcEFWODBRTlB1dVM2V0VKVXJjbGFjWkJ5YnZFeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9wZXR1Z2FzL3N0cnVrLzIiO3M6NToicm91dGUiO3M6MTM6InBldHVnYXMuc3RydWsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiIxZGIwNTE2MWI4NGYwMWQ3OGM4Y2VjNzhhZTA2YTkzZmVjZjNlYWY5ZGNkZjhhNjkwNGEyZWFjZDQ5NGMyNDI1Ijt9',1794757347),('YcExrhdESUWjdBIF27kCqP4Z2Q2NilewcOIhWrSX',2,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiR3hpVnJWdGgzN2JRR08xQnBqTGZNRXo2Y1pmcU0wcTBoMUw3WTI0dyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9wZXR1Z2FzL3N0cnVrLzEiO3M6NToicm91dGUiO3M6MTM6InBldHVnYXMuc3RydWsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiIxZGIwNTE2MWI4NGYwMWQ3OGM4Y2VjNzhhZTA2YTkzZmVjZjNlYWY5ZGNkZjhhNjkwNGEyZWFjZDQ5NGMyNDI1Ijt9',1794757177),('YQFCEVkTIp97Tnazl29E9yYU0K7yU2bKvakEDxgj',2,'127.0.0.1','','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQmdibUdMY29NVWRwaW1pUXE5bmlkMWtmbUczbUF0TUV5aVZ1ZEtDVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwOS9wZXR1Z2FzL3N0cnVrLzAiO3M6NToicm91dGUiO3M6MTM6InBldHVnYXMuc3RydWsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiIxZGIwNTE2MWI4NGYwMWQ3OGM4Y2VjNzhhZTA2YTkzZmVjZjNlYWY5ZGNkZjhhNjkwNGEyZWFjZDQ5NGMyNDI1Ijt9',1794757216);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_area_parkir`
--

DROP TABLE IF EXISTS `tb_area_parkir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_area_parkir` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_area` varchar(255) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `terisi` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_area_parkir`
--

LOCK TABLES `tb_area_parkir` WRITE;
/*!40000 ALTER TABLE `tb_area_parkir` DISABLE KEYS */;
INSERT INTO `tb_area_parkir` VALUES (1,'Area Motor',50,0,'2026-11-15 07:26:05','2026-11-15 08:42:27'),(2,'Area Mobil',30,0,'2026-11-15 07:26:05','2026-11-15 07:26:05'),(3,'Area Umum',20,0,'2026-11-15 07:26:05','2026-11-15 07:26:05');
/*!40000 ALTER TABLE `tb_area_parkir` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_kendaraan`
--

DROP TABLE IF EXISTS `tb_kendaraan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_kendaraan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `plat_nomor` varchar(15) NOT NULL,
  `jenis_kendaraan` enum('motor','mobil','lainnya') NOT NULL,
  `warna` varchar(30) DEFAULT NULL,
  `pemilik` varchar(255) DEFAULT NULL,
  `id_user` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tb_kendaraan_plat_nomor_unique` (`plat_nomor`),
  KEY `tb_kendaraan_id_user_foreign` (`id_user`),
  CONSTRAINT `tb_kendaraan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_kendaraan`
--

LOCK TABLES `tb_kendaraan` WRITE;
/*!40000 ALTER TABLE `tb_kendaraan` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_kendaraan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_log_aktivitas`
--

DROP TABLE IF EXISTS `tb_log_aktivitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_log_aktivitas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `waktu_aktivitas` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_log_aktivitas_id_user_foreign` (`id_user`),
  CONSTRAINT `tb_log_aktivitas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_log_aktivitas`
--

LOCK TABLES `tb_log_aktivitas` WRITE;
/*!40000 ALTER TABLE `tb_log_aktivitas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_log_aktivitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tarif`
--

DROP TABLE IF EXISTS `tb_tarif`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_tarif` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jenis_kendaraan` enum('motor','mobil','lainnya') NOT NULL,
  `tarif_per_jam` decimal(10,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tarif`
--

LOCK TABLES `tb_tarif` WRITE;
/*!40000 ALTER TABLE `tb_tarif` DISABLE KEYS */;
INSERT INTO `tb_tarif` VALUES (1,'motor',2000,'2026-11-15 07:26:05','2026-11-15 07:26:05'),(2,'mobil',5000,'2026-11-15 07:26:05','2026-11-15 07:26:05'),(3,'lainnya',7000,'2026-11-15 07:26:05','2026-11-15 07:26:05');
/*!40000 ALTER TABLE `tb_tarif` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_transaksi`
--

DROP TABLE IF EXISTS `tb_transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_transaksi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_kendaraan` bigint(20) unsigned NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `waktu_keluar` datetime DEFAULT NULL,
  `id_tarif` bigint(20) unsigned NOT NULL,
  `durasi_jam` int(11) DEFAULT NULL,
  `biaya_total` decimal(10,0) DEFAULT NULL,
  `status` enum('masuk','keluar') NOT NULL DEFAULT 'masuk',
  `id_user` bigint(20) unsigned NOT NULL,
  `id_area` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_transaksi_id_kendaraan_foreign` (`id_kendaraan`),
  KEY `tb_transaksi_id_tarif_foreign` (`id_tarif`),
  KEY `tb_transaksi_id_user_foreign` (`id_user`),
  KEY `tb_transaksi_id_area_foreign` (`id_area`),
  CONSTRAINT `tb_transaksi_id_area_foreign` FOREIGN KEY (`id_area`) REFERENCES `tb_area_parkir` (`id`),
  CONSTRAINT `tb_transaksi_id_kendaraan_foreign` FOREIGN KEY (`id_kendaraan`) REFERENCES `tb_kendaraan` (`id`),
  CONSTRAINT `tb_transaksi_id_tarif_foreign` FOREIGN KEY (`id_tarif`) REFERENCES `tb_tarif` (`id`),
  CONSTRAINT `tb_transaksi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_transaksi`
--

LOCK TABLES `tb_transaksi` WRITE;
/*!40000 ALTER TABLE `tb_transaksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_transaksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','owner') NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin','$2y$12$O0maDxPi8dm3Xb9GK7OXF.9l/4051E6YxJzNUOzI0jRGqnLXSu9p6','admin',1,'2026-11-15 07:26:04','2026-11-15 07:26:04'),(2,'Petugas Parkir','petugas','$2y$12$MbsOVYP/en3/IIArMC64W.gCMXQIq3O4//vIpcGE1ay2i61YyIY16','petugas',1,'2026-11-15 07:26:05','2026-11-15 07:26:05'),(3,'Pemilik Parkir','owner','$2y$12$/7BGVvmw4Xxx7ukdZCj3WOX8LJj7H2Csx2AsoSZrk6M8hxz1FAWGm','owner',1,'2026-11-15 07:26:05','2026-11-15 07:26:05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-15 22:42:51
