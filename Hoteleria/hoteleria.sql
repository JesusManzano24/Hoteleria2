-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: hoteleria
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `alojamiento_servicio`
--

DROP TABLE IF EXISTS `alojamiento_servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alojamiento_servicio` (
  `id_alojamiento` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  PRIMARY KEY (`id_alojamiento`,`id_servicio`),
  KEY `id_servicio` (`id_servicio`),
  CONSTRAINT `alojamiento_servicio_ibfk_1` FOREIGN KEY (`id_alojamiento`) REFERENCES `alojamientos` (`id_alojamiento`),
  CONSTRAINT `alojamiento_servicio_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alojamiento_servicio`
--

LOCK TABLES `alojamiento_servicio` WRITE;
/*!40000 ALTER TABLE `alojamiento_servicio` DISABLE KEYS */;
INSERT INTO `alojamiento_servicio` VALUES (1,1),(1,2),(1,4),(2,1),(2,2),(2,3),(2,4),(2,5),(3,1),(3,3),(3,4),(4,1),(4,2),(4,5),(5,1),(5,4),(6,1),(6,2),(6,3),(7,1),(7,2),(7,3),(7,4),(7,5),(8,1),(8,4),(8,5),(9,1),(9,3),(10,1),(10,3),(10,5),(11,1),(11,2),(11,4),(12,1),(12,3),(12,5),(13,1),(13,3),(14,1),(14,2),(14,5),(15,1),(15,2),(15,3),(15,4);
/*!40000 ALTER TABLE `alojamiento_servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alojamientos`
--

DROP TABLE IF EXISTS `alojamientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alojamientos` (
  `id_alojamiento` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `id_tipo_alojamiento` int(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_alojamiento`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_tipo_alojamiento` (`id_tipo_alojamiento`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `alojamientos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `alojamientos_ibfk_2` FOREIGN KEY (`id_tipo_alojamiento`) REFERENCES `tipos_alojamiento` (`id_tipo_alojamiento`),
  CONSTRAINT `alojamientos_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estados_alojamiento` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alojamientos`
--

LOCK TABLES `alojamientos` WRITE;
/*!40000 ALTER TABLE `alojamientos` DISABLE KEYS */;
INSERT INTO `alojamientos` VALUES (1,2,'Casa Playa Progreso',1,'Progreso, Yucatán','Casa frente al mar con alberca',1850.00,5,21.28360000,-89.66470000,1),(2,3,'Hotel Vista Telchac',2,'Telchac Puerto, Yucatán','Hotel con vista al mar y alberca',2200.00,10,21.34210000,-89.26230000,1),(3,4,'Hostal Celestún Eco',3,'Celestún, Yucatán','Hostal ecológico rodeado de naturaleza',950.00,4,20.86680000,-90.40160000,1),(4,5,'Depto Chicxulub Beach',4,'Chicxulub, Yucatán','Departamento con balcón frente al mar',1900.00,6,21.29610000,-89.59350000,1),(5,6,'Casa Chelem Relax',1,'Chelem, Yucatán','Casa tranquila cerca del muelle',1600.00,4,21.23200000,-89.74100000,1),(6,2,'Departamento Chuburná',4,'Chuburná, Yucatán','Departamento ideal para vacaciones familiares',1750.00,5,21.23000000,-89.76000000,2),(7,3,'Hotel Boutique Sisal',2,'Sisal, Yucatán','Pequeño hotel boutique frente a la playa',2500.00,8,21.16330000,-90.03850000,1),(8,4,'Casa San Crisanto Sunset',1,'San Crisanto, Yucatán','Casa con terraza y vista al mar',2000.00,6,21.37670000,-89.20830000,1),(9,5,'Hostal Dzilam Chill',3,'Dzilam de Bravo, Yucatán','Hostal económico y cómodo',950.00,3,21.38750000,-88.92190000,1),(10,6,'Cabaña El Cuyo',1,'El Cuyo, Yucatán','Cabaña rústica con hamacas',1450.00,4,21.50320000,-87.66730000,1),(11,2,'Casa del Mar Progreso II',1,'Progreso, Yucatán','Casa moderna cerca del malecón',1750.00,5,21.28500000,-89.66550000,1),(12,3,'Hotel Yucateco Telchac',2,'Telchac Puerto, Yucatán','Hotel tradicional con desayuno incluido',2100.00,9,21.34550000,-89.26000000,1),(13,4,'Hostal Flamingo Celestún',3,'Celestún, Yucatán','Hostal con tours a la reserva natural',980.00,4,20.86800000,-90.40220000,1),(14,5,'Departamento Playa Chicxulub',4,'Chicxulub, Yucatán','Moderno y con cocina equipada',1850.00,5,21.29700000,-89.59250000,1),(15,6,'Casa Familiar Chelem II',1,'Chelem, Yucatán','Casa familiar con estacionamiento',1650.00,6,21.23100000,-89.74220000,1);
/*!40000 ALTER TABLE `alojamientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compartidos`
--

DROP TABLE IF EXISTS `compartidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compartidos` (
  `id_compartido` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_compartido` datetime DEFAULT NULL,
  `plataforma` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_compartido`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `compartidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compartidos`
--

LOCK TABLES `compartidos` WRITE;
/*!40000 ALTER TABLE `compartidos` DISABLE KEYS */;
INSERT INTO `compartidos` VALUES (1,6,'2024-06-22 11:20:00','Facebook'),(2,7,'2024-07-10 15:45:00','WhatsApp'),(3,8,'2024-08-02 09:30:00','Instagram'),(4,9,'2024-08-18 13:15:00','WhatsApp'),(5,10,'2024-09-05 10:05:00','Facebook'),(6,11,'2024-09-30 17:50:00','WhatsApp'),(7,12,'2024-10-12 14:25:00','Instagram'),(8,13,'2024-10-28 12:00:00','Instagram'),(9,14,'2024-11-05 19:10:00','WhatsApp'),(10,15,'2024-11-19 11:35:00','Facebook'),(11,16,'2024-12-03 08:00:00','Instagram'),(12,17,'2024-12-17 13:40:00','Instagram'),(13,18,'2024-12-28 16:30:00','WhatsApp'),(14,19,'2025-01-10 10:20:00','Facebook'),(15,20,'2025-01-22 09:15:00','Facebook'),(16,6,'2025-02-01 18:45:00','Instagram'),(17,7,'2025-02-13 12:10:00','WhatsApp'),(18,8,'2025-02-27 08:30:00','Instagram'),(19,9,'2025-03-05 14:00:00','WhatsApp'),(20,10,'2025-03-18 17:25:00','Instagram'),(21,11,'2025-03-29 11:05:00','Facebook'),(22,12,'2025-04-04 13:20:00','Instagram'),(23,13,'2025-04-15 16:10:00','WhatsApp'),(24,14,'2025-04-25 08:50:00','WhatsApp'),(25,15,'2025-05-03 10:00:00','Instagram'),(26,16,'2025-05-12 15:30:00','Instagram'),(27,17,'2025-05-22 09:45:00','Facebook'),(28,18,'2025-06-01 11:15:00','Instagram'),(29,19,'2025-06-10 13:40:00','WhatsApp'),(30,20,'2025-06-20 17:55:00','Instagram'),(31,6,'2024-07-01 14:35:00','WhatsApp'),(32,7,'2024-08-15 12:10:00','Facebook'),(33,8,'2024-09-22 16:05:00','WhatsApp'),(34,10,'2024-11-08 13:45:00','Instagram'),(35,12,'2025-01-15 08:15:00','Facebook'),(36,13,'2025-02-20 18:10:00','WhatsApp'),(37,14,'2025-03-28 15:40:00','Instagram'),(38,15,'2025-04-07 09:00:00','WhatsApp'),(39,17,'2025-06-05 13:30:00','Facebook'),(40,18,'2024-07-14 10:45:00','Instagram'),(41,19,'2024-09-01 15:20:00','Facebook'),(42,20,'2024-10-20 17:10:00','Instagram');
/*!40000 ALTER TABLE `compartidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacto`
--

DROP TABLE IF EXISTS `contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacto` (
  `id_contacto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `asunto` varchar(255) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contacto` WRITE;
/*!40000 ALTER TABLE `contacto` DISABLE KEYS */;
INSERT INTO `contacto` VALUES (1,'María López','maria.lopez@example.com','Consulta sobre disponibilidad','Hola, quisiera saber si hay alojamientos disponibles para la primera semana de julio.','2024-06-10 09:15:00'),(2,'Juan Pérez','juan.perez@example.com','Problema con mi reserva','No puedo acceder a mi reserva desde la página, ¿podrían ayudarme?','2024-07-02 14:30:00'),(3,'Ana García','ana.garcia@example.com','Sugerencia de mejora','Sería genial tener un filtro por servicios en la búsqueda de alojamientos.','2024-08-15 10:45:00'),(4,'Carlos Ruiz','carlos.ruiz@example.com','Solicitud de factura','Solicito la factura de mi última reserva realizada el mes pasado.','2024-09-05 16:00:00'),(5,'Luisa Martínez','luisa.martinez@example.com','Información sobre cancelaciones','¿Cuál es la política de cancelación para los hoteles?','2024-09-20 11:20:00'),(6,'Pedro Gómez','pedro.gomez@example.com','Problema de pago','Mi pago fue rechazado pero el dinero ya salió de mi cuenta.','2024-10-10 13:50:00'),(7,'Sofía Díaz','sofia.diaz@example.com','Alojamiento pet friendly','¿Hay alojamientos que acepten mascotas en Yucatán?','2024-11-01 09:30:00'),(8,'Miguel Torres','miguel.torres@example.com','Promociones','¿Tienen alguna promoción para reservas en temporada baja?','2024-11-18 15:40:00'),(9,'Laura Fernández','laura.fernandez@example.com','Problemas técnicos','La página no carga correctamente en mi celular.','2024-12-05 10:10:00'),(10,'David Ramírez','david.ramirez@example.com','Cambio de fechas','Necesito cambiar las fechas de mi reserva, ¿cómo puedo hacerlo?','2024-12-22 12:00:00'),(11,'Elena Morales','elena.morales@example.com','Información general','¿Qué tipos de alojamientos ofrecen?','2025-01-15 11:25:00'),(12,'Andrés Castillo','andres.castillo@example.com','Soporte técnico','No puedo ingresar con mi usuario, ¿qué debo hacer?','2025-02-07 14:15:00'),(13,'Carla Rojas','carla.rojas@example.com','Solicitud de información','¿Qué métodos de pago aceptan?','2025-03-12 09:40:00'),(14,'Raúl Mendoza','raul.mendoza@example.com','Queja','Mi reserva fue cancelada sin previo aviso.','2025-04-01 17:30:00'),(15,'Isabel Herrera','isabel.herrera@example.com','Agradecimiento','Excelente servicio y atención al cliente, muchas gracias.','2025-05-05 10:50:00');
/*!40000 ALTER TABLE `contacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disponibilidad`
--

DROP TABLE IF EXISTS `disponibilidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disponibilidad` (
  `id_disponibilidad` int(11) NOT NULL AUTO_INCREMENT,
  `id_alojamiento` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id_disponibilidad`),
  KEY `id_alojamiento` (`id_alojamiento`),
  CONSTRAINT `disponibilidad_ibfk_1` FOREIGN KEY (`id_alojamiento`) REFERENCES `alojamientos` (`id_alojamiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disponibilidad`
--

LOCK TABLES `disponibilidad` WRITE;
/*!40000 ALTER TABLE `disponibilidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `disponibilidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_alojamiento`
--

DROP TABLE IF EXISTS `estados_alojamiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_alojamiento` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_alojamiento`
--

LOCK TABLES `estados_alojamiento` WRITE;
/*!40000 ALTER TABLE `estados_alojamiento` DISABLE KEYS */;
INSERT INTO `estados_alojamiento` VALUES (1,'Disponible'),(2,'Ocupado'),(3,'En mantenimiento');
/*!40000 ALTER TABLE `estados_alojamiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_pago`
--

DROP TABLE IF EXISTS `estados_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_pago` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_pago`
--

LOCK TABLES `estados_pago` WRITE;
/*!40000 ALTER TABLE `estados_pago` DISABLE KEYS */;
INSERT INTO `estados_pago` VALUES (1,'Pagado'),(2,'Pendiente'),(3,'Reembolsado'),(4,'Fallido');
/*!40000 ALTER TABLE `estados_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_reserva`
--

DROP TABLE IF EXISTS `estados_reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_reserva` (
  `id_estado_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_estado_reserva`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_reserva`
--

LOCK TABLES `estados_reserva` WRITE;
/*!40000 ALTER TABLE `estados_reserva` DISABLE KEYS */;
INSERT INTO `estados_reserva` VALUES (1,'Confirmada'),(2,'Cancelada'),(3,'Completada');
/*!40000 ALTER TABLE `estados_reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenes` (
  `id_imagen` int(11) NOT NULL AUTO_INCREMENT,
  `id_alojamiento` int(11) DEFAULT NULL,
  `url_imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_imagen`),
  KEY `id_alojamiento` (`id_alojamiento`),
  CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`id_alojamiento`) REFERENCES `alojamientos` (`id_alojamiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes`
--

LOCK TABLES `imagenes` WRITE;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `imagenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `id_remitente` int(11) DEFAULT NULL,
  `id_destinatario` int(11) DEFAULT NULL,
  `id_reserva` int(11) DEFAULT NULL,
  `contenido` text DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`),
  KEY `id_remitente` (`id_remitente`),
  KEY `id_destinatario` (`id_destinatario`),
  KEY `id_reserva` (`id_reserva`),
  CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_remitente`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `mensajes_ibfk_3` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`)
) ENGINE=InnoDB AUTO_INCREMENT=302 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensajes`
--

LOCK TABLES `mensajes` WRITE;
/*!40000 ALTER TABLE `mensajes` DISABLE KEYS */;
INSERT INTO `mensajes` VALUES (1,6,2,2,'Hola, ¿a qué hora puedo hacer el check-in?','2024-07-20 09:00:00'),(2,2,6,2,'Puedes llegar a partir de las 2 PM.','2024-07-20 09:30:00'),(3,7,3,3,'¿Hay estacionamiento disponible?','2025-05-01 10:00:00'),(4,3,7,3,'Sí, contamos con un espacio privado.','2025-05-01 10:15:00'),(5,8,4,5,'¿El alojamiento está cerca de la playa?','2024-08-20 11:00:00'),(6,4,8,5,'Está a 5 minutos caminando.','2024-08-20 11:15:00'),(7,9,5,6,'¿Puedo llegar más temprano?','2024-11-24 08:00:00'),(8,5,9,6,'Sí, no hay problema si es después de las 11.','2024-11-24 08:30:00'),(9,10,2,7,'¿Tienen cuna para bebé?','2024-07-10 13:00:00'),(10,2,10,7,'Sí, podemos prepararla sin costo.','2024-07-10 13:15:00'),(11,11,3,9,'¿Puedo cancelar sin penalización?','2024-06-19 18:00:00'),(12,3,11,9,'Si cancelas con 48h de anticipación, sí.','2024-06-19 18:10:00'),(13,12,4,11,'¿Tienen wifi disponible?','2024-10-07 16:00:00'),(14,4,12,11,'Sí, con buena velocidad.','2024-10-07 16:10:00'),(15,13,5,14,'¿Puedo llevar a mi perro?','2024-08-05 12:30:00'),(16,5,13,14,'Sí, aceptamos mascotas pequeñas.','2024-08-05 12:45:00'),(17,14,2,15,'¿El agua caliente funciona bien?','2025-02-24 14:30:00'),(18,2,14,15,'Sí, se revisó hace poco.','2025-02-24 14:45:00'),(19,15,3,18,'¿Puedo dejar mi equipaje antes?','2024-09-02 10:30:00'),(20,3,15,18,'Sí, desde las 10 AM está disponible.','2024-09-02 10:45:00'),(21,16,4,19,'¿Hay restaurantes cerca?','2025-02-08 09:00:00'),(22,4,16,19,'Sí, a solo dos cuadras.','2025-02-08 09:10:00'),(23,17,5,22,'¿Qué tan segura es la zona?','2024-10-17 15:20:00'),(24,5,17,22,'Muy segura, zona residencial.','2024-10-17 15:30:00'),(25,18,2,23,'¿Tienen aire acondicionado?','2025-02-23 08:30:00'),(26,2,18,23,'Sí, en todas las habitaciones.','2025-02-23 08:45:00'),(27,19,3,26,'¿Se incluye desayuno?','2025-04-06 11:00:00'),(28,3,19,26,'No, pero hay cocina disponible.','2025-04-06 11:15:00'),(29,20,5,27,'¿Es posible hacer late check-out?','2025-03-10 17:00:00'),(30,5,20,27,'Sí, hasta las 2 PM sin cargo.','2025-03-10 17:10:00'),(301,7,2,101,'Hola, tuve que cancelar por motivos personales. Disculpas.','2025-06-02 15:00:00');
/*!40000 ALTER TABLE `mensajes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodos_pago`
--

DROP TABLE IF EXISTS `metodos_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodos_pago` (
  `id_metodo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_metodo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_metodo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodos_pago`
--

LOCK TABLES `metodos_pago` WRITE;
/*!40000 ALTER TABLE `metodos_pago` DISABLE KEYS */;
INSERT INTO `metodos_pago` VALUES (1,'Tarjeta'),(2,'Transferencia'),(3,'Efectivo');
/*!40000 ALTER TABLE `metodos_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL AUTO_INCREMENT,
  `id_reserva` int(11) DEFAULT NULL,
  `id_metodo` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `comision` decimal(10,2) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pago`),
  KEY `id_reserva` (`id_reserva`),
  KEY `id_metodo` (`id_metodo`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`),
  CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`id_metodo`) REFERENCES `metodos_pago` (`id_metodo`),
  CONSTRAINT `pagos_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estados_pago` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
INSERT INTO `pagos` VALUES (1,1,1,1,2787.82,418.17,'2024-06-09 00:00:00'),(2,2,2,1,2678.27,401.74,'2024-07-23 00:00:00'),(3,3,1,3,7785.07,1167.76,'2025-05-05 00:00:00'),(4,4,3,1,9293.17,1393.98,'2024-10-13 00:00:00'),(5,5,2,1,3725.18,558.78,'2024-08-25 00:00:00'),(6,6,1,1,4026.96,604.04,'2024-11-27 00:00:00'),(7,7,2,1,2463.67,369.55,'2024-07-14 00:00:00'),(8,8,1,3,1671.78,250.77,'2024-08-02 00:00:00'),(9,9,1,1,4351.39,652.71,'2024-06-20 00:00:00'),(10,10,2,3,7095.83,1064.37,'2024-12-20 00:00:00'),(11,11,1,1,1876.99,281.55,'2024-10-10 00:00:00'),(12,12,3,2,2501.68,375.25,'2025-01-03 00:00:00'),(13,13,1,3,4953.88,743.08,'2024-12-10 00:00:00'),(14,14,2,1,1861.24,279.19,'2024-08-08 00:00:00'),(15,15,1,2,2489.17,373.38,'2025-02-26 00:00:00'),(16,16,2,3,4796.35,719.45,'2024-06-21 00:00:00'),(17,17,1,2,6367.71,955.16,'2025-04-01 00:00:00'),(18,18,1,1,1833.17,274.98,'2024-09-05 00:00:00'),(19,19,2,1,4784.23,717.63,'2025-02-10 00:00:00'),(20,20,3,3,6575.98,986.40,'2024-07-13 00:00:00'),(21,21,2,3,4471.67,670.75,'2025-01-10 00:00:00'),(22,22,1,1,9377.13,1406.57,'2024-10-20 00:00:00'),(23,23,2,1,9157.72,1373.66,'2025-02-26 00:00:00'),(24,24,1,3,7357.65,1103.65,'2024-12-01 00:00:00'),(25,25,3,3,7895.54,1184.33,'2024-06-27 00:00:00'),(26,26,1,1,2280.28,342.04,'2025-04-07 00:00:00'),(27,27,2,1,2107.83,316.17,'2025-03-10 00:00:00'),(28,28,1,2,5273.97,791.10,'2025-01-20 00:00:00'),(29,29,2,2,5101.72,765.26,'2024-08-18 00:00:00'),(30,30,1,3,6767.97,1015.20,'2025-01-06 00:00:00'),(31,31,3,3,3545.55,531.83,'2025-04-14 00:00:00'),(32,32,2,3,5584.78,837.72,'2024-06-15 00:00:00'),(33,33,1,3,6542.92,981.44,'2024-09-25 00:00:00'),(34,34,2,1,5917.83,887.67,'2025-05-09 00:00:00'),(35,35,1,3,1761.24,264.19,'2024-06-05 00:00:00'),(36,36,2,1,1694.24,254.14,'2024-10-30 00:00:00'),(37,37,3,3,2960.86,444.13,'2024-09-20 00:00:00'),(38,38,1,1,4125.15,618.77,'2024-11-28 00:00:00'),(39,39,2,1,3557.33,533.60,'2024-09-10 00:00:00'),(40,40,2,3,8600.49,1290.07,'2025-01-13 00:00:00'),(41,41,3,3,3361.27,504.19,'2024-06-10 00:00:00'),(42,42,2,2,3060.54,459.08,'2024-10-15 00:00:00'),(43,43,1,1,7585.34,1137.80,'2025-02-19 00:00:00'),(44,44,2,1,6126.15,918.92,'2024-07-20 00:00:00'),(45,45,1,3,2224.73,333.71,'2025-03-27 00:00:00'),(46,46,2,2,8321.19,1248.18,'2024-11-29 00:00:00'),(47,47,3,3,2731.90,409.79,'2024-08-28 00:00:00'),(48,48,2,1,4630.74,694.61,'2024-08-15 00:00:00'),(49,49,1,3,2016.84,302.53,'2024-07-10 00:00:00'),(50,50,3,3,5116.97,767.55,'2024-11-17 00:00:00'),(51,51,1,1,8954.20,1343.13,'2024-12-28 00:00:00'),(52,52,2,2,6018.75,902.81,'2024-08-08 00:00:00'),(53,53,1,3,4632.92,694.94,'2024-09-13 00:00:00'),(54,54,2,3,2415.26,362.29,'2024-12-20 00:00:00'),(55,55,3,1,5401.84,810.28,'2024-06-25 00:00:00'),(56,56,1,3,6925.33,1038.80,'2025-03-20 00:00:00'),(57,57,2,3,5673.24,850.99,'2025-04-01 00:00:00'),(58,58,3,2,3456.32,518.45,'2024-07-30 00:00:00'),(59,59,1,3,6111.86,916.78,'2024-08-30 00:00:00'),(60,60,2,1,4899.90,734.99,'2025-04-28 00:00:00'),(61,61,3,1,3891.73,583.76,'2024-10-08 00:00:00'),(62,62,1,2,4675.38,701.31,'2024-06-20 00:00:00'),(63,63,2,3,3126.70,469.01,'2025-01-18 00:00:00'),(64,64,1,3,7018.48,1052.77,'2025-02-10 00:00:00'),(65,65,3,1,2268.11,340.22,'2024-07-15 00:00:00'),(66,66,2,3,3301.64,495.25,'2024-10-28 00:00:00'),(67,67,1,2,4517.34,677.60,'2024-06-07 00:00:00'),(68,68,2,3,2836.80,425.52,'2024-12-22 00:00:00'),(69,69,3,1,7815.27,1172.29,'2024-08-10 00:00:00'),(70,70,1,3,5112.09,766.81,'2024-09-30 00:00:00'),(71,71,2,1,3738.20,560.73,'2025-03-05 00:00:00'),(72,72,1,3,8992.45,1348.87,'2025-03-27 00:00:00'),(73,73,3,1,7356.10,1103.42,'2024-09-03 00:00:00'),(74,74,2,3,4561.88,684.28,'2024-10-25 00:00:00'),(75,75,1,3,6110.41,916.56,'2024-06-20 00:00:00'),(76,76,3,2,3246.00,486.90,'2024-10-05 00:00:00'),(77,77,2,3,4412.78,661.92,'2025-02-10 00:00:00'),(78,78,1,3,3421.57,513.24,'2024-07-05 00:00:00'),(79,79,2,1,6118.99,917.85,'2024-07-24 00:00:00'),(80,80,3,3,5213.34,782.00,'2025-01-10 00:00:00'),(81,81,1,1,3442.67,516.40,'2024-09-01 00:00:00'),(82,82,2,3,4821.66,723.25,'2025-03-15 00:00:00'),(83,83,1,1,3190.82,478.62,'2024-12-10 00:00:00'),(84,84,3,3,5680.25,852.04,'2025-04-17 00:00:00'),(85,85,1,3,4451.56,667.73,'2024-11-05 00:00:00'),(86,86,2,1,5709.30,856.40,'2025-02-05 00:00:00'),(87,87,3,2,6301.78,945.27,'2024-07-12 00:00:00'),(88,88,2,1,2197.84,329.68,'2025-04-27 00:00:00'),(89,89,1,3,7114.02,1067.10,'2024-06-03 00:00:00'),(90,90,3,3,6528.88,979.33,'2025-03-01 00:00:00'),(91,91,1,1,5236.18,785.43,'2024-08-08 00:00:00'),(92,92,2,3,3625.00,543.75,'2024-10-20 00:00:00'),(93,93,3,3,7483.41,1122.51,'2025-01-10 00:00:00'),(94,94,1,1,2033.67,305.05,'2024-06-28 00:00:00'),(95,95,2,3,4882.90,732.44,'2024-08-20 00:00:00'),(96,96,1,1,3956.14,593.42,'2024-12-20 00:00:00'),(97,97,2,2,4195.32,629.30,'2025-04-01 00:00:00'),(98,98,3,3,6754.78,1013.22,'2024-10-29 00:00:00'),(99,99,2,1,5120.66,768.10,'2025-01-25 00:00:00'),(100,100,1,3,2685.01,402.75,'2024-10-10 00:00:00'),(102,102,3,1,4500.00,675.00,'2025-07-01 10:05:00'),(201,101,1,1,4500.00,675.00,'2025-06-01 10:05:00');
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos_anfitrion`
--

DROP TABLE IF EXISTS `pagos_anfitrion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagos_anfitrion` (
  `id_pago_anfitrion` int(11) NOT NULL AUTO_INCREMENT,
  `id_pago` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `monto_pagado` decimal(10,2) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `id_estado_pago` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pago_anfitrion`),
  KEY `id_pago` (`id_pago`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_estado_pago` (`id_estado_pago`),
  CONSTRAINT `pagos_anfitrion_ibfk_1` FOREIGN KEY (`id_pago`) REFERENCES `pagos` (`id_pago`),
  CONSTRAINT `pagos_anfitrion_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `pagos_anfitrion_ibfk_3` FOREIGN KEY (`id_estado_pago`) REFERENCES `estados_pago` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos_anfitrion`
--

LOCK TABLES `pagos_anfitrion` WRITE;
/*!40000 ALTER TABLE `pagos_anfitrion` DISABLE KEYS */;
INSERT INTO `pagos_anfitrion` VALUES (1,14,2,1582.05,'2024-08-08 00:00:00',1),(2,17,2,5412.55,'2025-04-01 00:00:00',2),(3,27,2,1791.66,'2025-03-10 00:00:00',1),(4,49,2,1714.31,'2024-07-10 00:00:00',3),(5,67,2,3839.74,'2024-06-07 00:00:00',2),(6,87,2,5356.51,'2024-07-12 00:00:00',2),(7,201,2,3825.00,'2025-06-01 10:05:00',1),(8,102,2,3825.00,'2025-07-01 10:05:00',1),(9,5,2,3166.40,'2024-08-25 00:00:00',1),(10,28,2,4482.87,'2025-01-20 00:00:00',2),(11,33,2,5561.48,'2024-09-25 00:00:00',3),(12,48,2,3936.13,'2024-08-15 00:00:00',1),(13,61,2,3307.97,'2024-10-08 00:00:00',1),(14,72,2,7643.58,'2025-03-27 00:00:00',3),(15,83,2,2712.20,'2024-12-10 00:00:00',1),(16,90,2,5549.55,'2025-03-01 00:00:00',3),(17,11,2,1595.44,'2024-10-10 00:00:00',1),(18,23,2,7784.06,'2025-02-26 00:00:00',1),(19,36,2,1440.10,'2024-10-30 00:00:00',1),(20,54,2,2052.97,'2024-12-20 00:00:00',3),(21,65,2,1927.89,'2024-07-15 00:00:00',1),(22,76,2,2759.10,'2024-10-05 00:00:00',2),(23,91,2,4450.75,'2024-08-08 00:00:00',1),(24,9,3,3698.68,'2024-06-20 00:00:00',1),(25,25,3,6711.21,'2024-06-27 00:00:00',3),(26,30,3,5752.77,'2025-01-06 00:00:00',3),(27,46,3,7073.01,'2024-11-29 00:00:00',2),(28,62,3,3974.07,'2024-06-20 00:00:00',2),(29,77,3,3750.86,'2025-02-10 00:00:00',3),(30,89,3,6046.92,'2024-06-03 00:00:00',3),(31,98,3,5741.56,'2024-10-29 00:00:00',3),(32,15,3,2115.79,'2025-02-26 00:00:00',2),(33,32,3,4747.06,'2024-06-15 00:00:00',3),(34,42,3,2601.46,'2024-10-15 00:00:00',2),(35,58,3,2937.87,'2024-07-30 00:00:00',2),(36,70,3,4345.28,'2024-09-30 00:00:00',3),(37,81,3,2926.27,'2024-09-01 00:00:00',1),(38,97,3,3566.02,'2025-04-01 00:00:00',2),(39,7,3,2094.12,'2024-07-14 00:00:00',1),(40,26,3,1938.24,'2025-04-07 00:00:00',1),(41,41,3,2857.08,'2024-06-10 00:00:00',3),(42,53,3,3937.98,'2024-09-13 00:00:00',3),(43,84,3,4828.21,'2025-04-17 00:00:00',3),(44,6,4,3422.92,'2024-11-27 00:00:00',1),(45,20,4,5589.58,'2024-07-13 00:00:00',3),(46,52,4,5115.94,'2024-08-08 00:00:00',2),(47,68,4,2411.28,'2024-12-22 00:00:00',3),(48,80,4,4431.34,'2025-01-10 00:00:00',3),(49,100,4,2282.26,'2024-10-10 00:00:00',3),(50,1,4,2369.65,'2024-06-09 00:00:00',1),(51,3,4,6617.31,'2025-05-05 00:00:00',3),(52,40,4,7310.42,'2025-01-13 00:00:00',3),(53,50,4,4349.42,'2024-11-17 00:00:00',3),(54,69,4,6642.98,'2024-08-10 00:00:00',1),(55,78,4,2908.33,'2024-07-05 00:00:00',3),(56,96,4,3362.72,'2024-12-20 00:00:00',1),(57,16,4,4076.90,'2024-06-21 00:00:00',3),(58,24,4,6254.00,'2024-12-01 00:00:00',3),(59,38,4,3506.38,'2024-11-28 00:00:00',1),(60,55,4,4591.56,'2024-06-25 00:00:00',1),(61,64,4,5965.71,'2025-02-10 00:00:00',3),(62,82,4,4098.41,'2025-03-15 00:00:00',3),(63,95,4,4150.47,'2024-08-20 00:00:00',3),(64,4,5,7899.19,'2024-10-13 00:00:00',1),(65,29,5,4336.46,'2024-08-18 00:00:00',2),(66,37,5,2516.73,'2024-09-20 00:00:00',3),(67,44,5,5207.23,'2024-07-20 00:00:00',1),(68,63,5,2657.70,'2025-01-18 00:00:00',3),(69,79,5,5201.14,'2024-07-24 00:00:00',1),(70,92,5,3081.25,'2024-10-20 00:00:00',3),(71,10,5,6031.46,'2024-12-20 00:00:00',3),(72,31,5,3013.72,'2025-04-14 00:00:00',3),(73,43,5,6447.54,'2025-02-19 00:00:00',1),(74,57,5,4822.25,'2025-04-01 00:00:00',3),(75,73,5,6252.69,'2024-09-03 00:00:00',1),(76,86,5,4852.91,'2025-02-05 00:00:00',1),(77,2,5,2276.53,'2024-07-23 00:00:00',1),(78,18,5,1558.19,'2024-09-05 00:00:00',1),(79,35,5,1497.05,'2024-06-05 00:00:00',3),(80,51,5,7611.07,'2024-12-28 00:00:00',1),(81,66,5,2806.39,'2024-10-28 00:00:00',3),(82,85,5,3783.83,'2024-11-05 00:00:00',3),(83,99,5,4352.56,'2025-01-25 00:00:00',1),(84,13,6,4210.80,'2024-12-10 00:00:00',3),(85,21,6,3800.92,'2025-01-10 00:00:00',3),(86,34,6,5030.16,'2025-05-09 00:00:00',1),(87,45,6,1891.02,'2025-03-27 00:00:00',3),(88,60,6,4164.92,'2025-04-28 00:00:00',1),(89,75,6,5193.85,'2024-06-20 00:00:00',3),(90,93,6,6360.90,'2025-01-10 00:00:00',3),(91,8,6,1421.01,'2024-08-02 00:00:00',3),(92,22,6,7970.56,'2024-10-20 00:00:00',1),(93,47,6,2322.12,'2024-08-28 00:00:00',3),(94,59,6,5195.08,'2024-08-30 00:00:00',3),(95,71,6,3177.47,'2025-03-05 00:00:00',1),(96,88,6,1868.16,'2025-04-27 00:00:00',1),(97,12,6,2126.43,'2025-01-03 00:00:00',2),(98,19,6,4066.60,'2025-02-10 00:00:00',1),(99,39,6,3023.73,'2024-09-10 00:00:00',1),(100,56,6,5886.53,'2025-03-20 00:00:00',3),(101,74,6,3877.60,'2024-10-25 00:00:00',3),(102,94,6,1728.62,'2024-06-28 00:00:00',1);
/*!40000 ALTER TABLE `pagos_anfitrion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resenas`
--

DROP TABLE IF EXISTS `resenas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resenas` (
  `id_resena` int(11) NOT NULL AUTO_INCREMENT,
  `id_reserva` int(11) DEFAULT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `fecha_resena` datetime DEFAULT NULL,
  PRIMARY KEY (`id_resena`),
  KEY `id_reserva` (`id_reserva`),
  CONSTRAINT `resenas_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resenas`
--

LOCK TABLES `resenas` WRITE;
/*!40000 ALTER TABLE `resenas` DISABLE KEYS */;
INSERT INTO `resenas` VALUES (1,2,5,'Una experiencia excelente, volvería sin dudar.','2024-07-24 00:00:00'),(2,3,4,'Muy buen lugar, aunque el wifi fallaba un poco.','2025-05-06 00:00:00'),(3,5,3,'Todo bien, pero esperaba más limpieza.','2024-08-26 00:00:00'),(4,6,5,'Perfecto para relajarse, muy tranquilo.','2024-11-28 00:00:00'),(5,7,4,'Buen precio y ubicación. Volvería.','2024-07-15 00:00:00'),(6,9,2,'El lugar no se parecía a las fotos.','2024-06-21 00:00:00'),(7,11,5,'El anfitrión fue muy amable. Lo recomiendo.','2024-10-11 00:00:00'),(8,14,4,'Muy cerca de la playa. Buena estancia.','2024-08-09 00:00:00'),(9,15,5,'Increíble lugar, súper cómodo y limpio.','2025-02-27 00:00:00'),(10,17,3,'La cama no era muy cómoda.','2025-04-02 00:00:00'),(11,18,4,'Buena atención y muy limpio.','2024-09-06 00:00:00'),(12,19,5,'Excelentes vistas y ubicación.','2025-02-11 00:00:00'),(13,22,3,'Ruidoso por las noches.','2024-10-21 00:00:00'),(14,23,5,'Muy recomendable para familias.','2025-02-27 00:00:00'),(15,26,4,'Buena relación calidad/precio.','2025-04-08 00:00:00'),(16,27,2,'Problemas con el agua caliente.','2025-03-11 00:00:00'),(17,28,5,'Encantador. Lo disfrutamos mucho.','2025-01-21 00:00:00'),(18,31,3,'Regular, podría mejorar.','2025-04-15 00:00:00'),(19,34,5,'Todo impecable, muy bonito.','2025-05-10 00:00:00'),(20,36,4,'Ideal para una escapada de fin de semana.','2024-10-31 00:00:00'),(21,38,5,'Lugar acogedor y limpio.','2024-11-29 00:00:00'),(22,39,3,'Mucho calor, aire acondicionado débil.','2024-09-11 00:00:00'),(23,41,5,'Muy buena experiencia. Todo excelente.','2024-06-11 00:00:00'),(24,43,4,'Muy tranquilo. Volveré.','2025-02-20 00:00:00'),(25,44,4,'Cómodo y cerca de todo.','2024-07-21 00:00:00'),(26,46,5,'Me encantó el ambiente del lugar.','2024-11-30 00:00:00'),(27,48,4,'Lugar muy limpio y buena atención.','2024-08-16 00:00:00'),(28,51,3,'Hubo problemas con la llave.','2024-12-29 00:00:00'),(29,52,2,'No volvería. Esperaba más.','2024-08-09 00:00:00'),(30,54,4,'Bonito lugar, tranquilo.','2024-12-21 00:00:00'),(31,55,5,'Todo salió perfecto.','2024-06-26 00:00:00'),(32,58,3,'Estuvo bien, sin más.','2024-07-31 00:00:00'),(33,60,4,'Disfrutamos mucho nuestra estancia.','2025-04-29 00:00:00'),(34,63,2,'Ruido de vecinos molestó.','2025-01-19 00:00:00'),(35,64,5,'Increíble, muy limpio y moderno.','2025-02-11 00:00:00'),(36,69,5,'Perfecto, muy recomendable.','2024-08-11 00:00:00'),(37,71,4,'Camas cómodas, buen espacio.','2025-03-06 00:00:00'),(38,73,3,'Le falta mantenimiento.','2024-09-04 00:00:00'),(39,75,5,'Nos encantó el lugar.','2024-06-21 00:00:00'),(40,79,4,'Servicio al cliente excelente.','2024-07-25 00:00:00');
/*!40000 ALTER TABLE `resenas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservas`
--

DROP TABLE IF EXISTS `reservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_alojamiento` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `fecha_reserva` datetime DEFAULT NULL,
  `adultos` int(11) DEFAULT 1,
  `niños` int(11) DEFAULT NULL,
  `id_estado_reserva` int(11) DEFAULT NULL,
  `total_pago` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_alojamiento` (`id_alojamiento`),
  KEY `id_estado_reserva` (`id_estado_reserva`),
  CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_alojamiento`) REFERENCES `alojamientos` (`id_alojamiento`),
  CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`id_estado_reserva`) REFERENCES `estados_reserva` (`id_estado_reserva`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservas`
--

LOCK TABLES `reservas` WRITE;
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
INSERT INTO `reservas` VALUES (1,18,8,'2024-06-15','2024-06-22','2024-06-06 00:00:00',1,3,1,2787.82),(2,10,14,'2024-07-25','2024-07-30','2024-07-18 00:00:00',3,1,3,2678.27),(3,12,8,'2025-05-07','2025-05-10','2025-05-01 00:00:00',4,1,1,7785.07),(4,15,4,'2024-10-17','2024-10-19','2024-10-10 00:00:00',2,3,3,9293.17),(5,8,6,'2024-09-08','2024-09-15','2024-08-16 00:00:00',4,3,3,3725.18),(6,9,3,'2024-12-05','2024-12-09','2024-11-21 00:00:00',4,2,3,4026.96),(7,7,12,'2024-07-19','2024-07-23','2024-07-09 00:00:00',3,2,3,2463.67),(8,17,10,'2024-08-04','2024-08-09','2024-07-29 00:00:00',1,2,3,1671.78),(9,14,2,'2024-07-08','2024-07-14','2024-06-15 00:00:00',1,0,3,4351.39),(10,13,9,'2025-01-07','2025-01-14','2024-12-08 00:00:00',3,0,3,7095.83),(11,7,11,'2024-10-22','2024-10-27','2024-10-01 00:00:00',3,3,1,1876.99),(12,19,15,'2025-02-01','2025-02-06','2025-01-01 00:00:00',1,0,2,2501.68),(13,14,5,'2024-12-22','2024-12-29','2024-12-04 00:00:00',3,1,3,4953.88),(14,10,1,'2024-08-15','2024-08-20','2024-08-02 00:00:00',4,2,3,1861.24),(15,20,7,'2025-03-09','2025-03-12','2025-02-24 00:00:00',3,3,2,2489.17),(16,16,13,'2024-06-24','2024-06-29','2024-06-17 00:00:00',2,3,3,4796.35),(17,11,1,'2025-04-15','2025-04-20','2025-03-10 00:00:00',1,3,2,6367.71),(18,8,14,'2024-09-15','2024-09-17','2024-09-01 00:00:00',2,0,1,1833.17),(19,13,15,'2025-02-12','2025-02-18','2025-02-01 00:00:00',4,3,1,4784.23),(20,17,3,'2024-07-20','2024-07-24','2024-07-08 00:00:00',1,3,3,6575.98),(21,18,5,'2025-01-12','2025-01-14','2025-01-01 00:00:00',4,3,3,4471.67),(22,9,10,'2024-10-28','2024-11-01','2024-10-13 00:00:00',3,2,1,9377.13),(23,7,11,'2025-03-02','2025-03-04','2025-02-12 00:00:00',3,3,1,9157.72),(24,8,13,'2024-12-10','2024-12-14','2024-11-25 00:00:00',4,0,3,7357.65),(25,20,2,'2024-07-05','2024-07-09','2024-06-22 00:00:00',4,2,3,7895.54),(26,15,12,'2025-04-10','2025-04-13','2025-03-21 00:00:00',3,2,1,2280.28),(27,10,1,'2025-03-17','2025-03-22','2025-02-28 00:00:00',4,0,1,2107.83),(28,9,6,'2025-01-23','2025-01-25','2025-01-13 00:00:00',4,1,2,5273.97),(29,12,4,'2024-08-22','2024-08-24','2024-08-11 00:00:00',3,0,2,5101.72),(30,14,2,'2025-01-09','2025-01-13','2024-12-27 00:00:00',3,3,3,6767.97),(31,16,9,'2025-04-18','2025-04-21','2025-04-01 00:00:00',4,0,3,3545.55),(32,19,7,'2024-06-29','2024-07-02','2024-06-10 00:00:00',4,0,3,5584.78),(33,13,6,'2024-10-05','2024-10-09','2024-09-20 00:00:00',2,2,3,6542.92),(34,18,5,'2025-05-13','2025-05-15','2025-04-15 00:00:00',4,0,1,5917.83),(35,7,14,'2024-06-11','2024-06-13','2024-06-01 00:00:00',2,3,3,1761.24),(36,16,11,'2024-11-07','2024-11-10','2024-10-22 00:00:00',1,3,1,1694.24),(37,19,4,'2024-09-28','2024-10-03','2024-09-10 00:00:00',3,1,3,2960.86),(38,20,13,'2024-12-02','2024-12-05','2024-11-17 00:00:00',2,1,1,4125.15),(39,15,15,'2024-09-17','2024-09-23','2024-08-25 00:00:00',3,2,1,3557.33),(40,8,8,'2025-01-19','2025-01-22','2025-01-07 00:00:00',2,0,3,8600.49),(41,14,12,'2024-06-20','2024-06-23','2024-06-01 00:00:00',2,1,3,3361.27),(42,12,7,'2024-11-01','2024-11-05','2024-10-10 00:00:00',3,1,2,3060.54),(43,10,9,'2025-02-24','2025-02-27','2025-02-10 00:00:00',4,2,1,7585.34),(44,7,4,'2024-07-27','2024-08-01','2024-07-01 00:00:00',1,2,1,6126.15),(45,17,5,'2025-04-05','2025-04-07','2025-03-21 00:00:00',4,1,3,2224.73),(46,13,2,'2024-12-13','2024-12-18','2024-11-22 00:00:00',4,1,2,8321.19),(47,19,10,'2024-09-10','2024-09-13','2024-08-24 00:00:00',3,2,3,2731.90),(48,15,6,'2024-08-28','2024-08-30','2024-08-08 00:00:00',2,3,1,4630.74),(49,18,1,'2024-07-15','2024-07-17','2024-07-01 00:00:00',4,1,3,2016.84),(50,9,8,'2024-11-20','2024-11-22','2024-11-01 00:00:00',4,2,3,5116.97),(51,16,14,'2025-01-03','2025-01-07','2024-12-11 00:00:00',4,3,1,8954.20),(52,20,3,'2024-08-12','2024-08-16','2024-07-26 00:00:00',1,1,2,6018.75),(53,11,12,'2024-10-02','2024-10-07','2024-09-09 00:00:00',2,1,3,4632.92),(54,14,11,'2024-12-29','2025-01-01','2024-12-10 00:00:00',3,1,3,2415.26),(55,10,13,'2024-07-03','2024-07-06','2024-06-18 00:00:00',2,2,1,5401.84),(56,8,15,'2025-03-27','2025-04-01','2025-03-10 00:00:00',1,2,3,6925.33),(57,19,9,'2025-04-09','2025-04-12','2025-03-20 00:00:00',3,3,3,5673.24),(58,7,7,'2024-08-10','2024-08-13','2024-07-25 00:00:00',3,2,2,3456.32),(59,17,10,'2024-09-04','2024-09-06','2024-08-22 00:00:00',2,2,3,6111.86),(60,13,5,'2025-05-01','2025-05-05','2025-04-15 00:00:00',4,1,1,4899.90),(61,15,6,'2024-10-11','2024-10-14','2024-09-28 00:00:00',4,2,1,3891.73),(62,12,2,'2024-06-30','2024-07-04','2024-06-16 00:00:00',4,0,2,4675.38),(63,9,4,'2025-01-28','2025-02-01','2025-01-10 00:00:00',2,1,3,3126.70),(64,18,13,'2025-02-16','2025-02-21','2025-01-25 00:00:00',3,1,3,7018.48),(65,16,11,'2024-07-28','2024-08-01','2024-07-10 00:00:00',2,3,1,2268.11),(66,20,14,'2024-11-10','2024-11-14','2024-10-20 00:00:00',4,1,3,3301.64),(67,7,1,'2024-06-18','2024-06-21','2024-06-02 00:00:00',2,2,2,4517.34),(68,11,3,'2025-01-01','2025-01-04','2024-12-16 00:00:00',3,1,3,2836.80),(69,14,8,'2024-08-25','2024-08-28','2024-08-05 00:00:00',3,2,1,7815.27),(70,9,7,'2024-10-07','2024-10-10','2024-09-23 00:00:00',1,2,3,5112.09),(71,10,10,'2025-03-15','2025-03-18','2025-02-28 00:00:00',1,3,1,3738.20),(72,17,6,'2025-04-01','2025-04-05','2025-03-15 00:00:00',4,0,3,8992.45),(73,8,9,'2024-09-13','2024-09-18','2024-08-25 00:00:00',2,3,1,7356.10),(74,13,15,'2024-11-04','2024-11-08','2024-10-14 00:00:00',3,1,3,4561.88),(75,20,5,'2024-06-25','2024-06-28','2024-06-10 00:00:00',2,2,3,6110.41),(76,14,11,'2024-10-17','2024-10-21','2024-09-30 00:00:00',1,0,2,3246.00),(77,16,2,'2025-02-19','2025-02-22','2025-02-01 00:00:00',2,3,3,4412.78),(78,12,8,'2024-07-16','2024-07-21','2024-06-25 00:00:00',3,1,3,3421.57),(79,19,4,'2024-08-03','2024-08-07','2024-07-17 00:00:00',4,1,1,6118.99),(80,11,3,'2025-01-19','2025-01-23','2025-01-05 00:00:00',4,2,3,5213.34),(81,7,7,'2024-09-10','2024-09-14','2024-08-22 00:00:00',2,2,1,3442.67),(82,9,13,'2025-03-23','2025-03-28','2025-03-01 00:00:00',3,1,3,4821.66),(83,15,6,'2024-12-19','2024-12-22','2024-11-30 00:00:00',1,2,1,3190.82),(84,18,12,'2025-04-25','2025-04-29','2025-04-08 00:00:00',3,0,3,5680.25),(85,10,14,'2024-11-13','2024-11-17','2024-10-25 00:00:00',2,1,3,4451.56),(86,8,9,'2025-02-10','2025-02-14','2025-01-20 00:00:00',3,2,1,5709.30),(87,13,1,'2024-07-22','2024-07-26','2024-07-02 00:00:00',2,3,2,6301.78),(88,17,10,'2025-05-06','2025-05-09','2025-04-19 00:00:00',1,0,1,2197.84),(89,14,2,'2024-06-14','2024-06-18','2024-05-25 00:00:00',2,2,3,7114.02),(90,12,6,'2025-03-11','2025-03-14','2025-02-24 00:00:00',3,1,3,6528.88),(91,19,11,'2024-08-18','2024-08-23','2024-07-28 00:00:00',1,3,1,5236.18),(92,16,4,'2024-10-30','2024-11-04','2024-10-12 00:00:00',4,0,3,3625.00),(93,20,5,'2025-01-17','2025-01-21','2025-01-01 00:00:00',2,1,3,7483.41),(94,7,15,'2024-07-09','2024-07-12','2024-06-24 00:00:00',4,2,1,2033.67),(95,11,13,'2024-09-01','2024-09-04','2024-08-15 00:00:00',3,1,3,4882.90),(96,9,8,'2024-12-26','2024-12-30','2024-12-05 00:00:00',1,0,1,3956.14),(97,10,7,'2025-04-14','2025-04-17','2025-03-25 00:00:00',3,2,2,4195.32),(98,18,2,'2024-11-06','2024-11-10','2024-10-20 00:00:00',2,1,3,6754.78),(99,15,14,'2025-02-03','2025-02-07','2025-01-17 00:00:00',2,3,1,5120.66),(100,13,3,'2024-10-23','2024-10-26','2024-10-01 00:00:00',4,2,3,2685.01),(101,7,1,'2025-06-10','2025-06-13','2025-06-01 10:00:00',2,1,2,4500.00),(102,7,1,'2025-07-10','2025-07-13','2025-07-01 10:00:00',2,1,2,4500.00);
/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_usuario`
--

DROP TABLE IF EXISTS `roles_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles_usuario` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_usuario`
--

LOCK TABLES `roles_usuario` WRITE;
/*!40000 ALTER TABLE `roles_usuario` DISABLE KEYS */;
INSERT INTO `roles_usuario` VALUES (1,'Admin'),(2,'Anfitrión'),(3,'Huésped');
/*!40000 ALTER TABLE `roles_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios`
--

LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` VALUES (1,'WiFi'),(2,'Aire acondicionado'),(3,'Desayuno'),(4,'TV'),(5,'Estacionamiento');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_alojamiento`
--

DROP TABLE IF EXISTS `tipos_alojamiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos_alojamiento` (
  `id_tipo_alojamiento` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_alojamiento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_alojamiento`
--

LOCK TABLES `tipos_alojamiento` WRITE;
/*!40000 ALTER TABLE `tipos_alojamiento` DISABLE KEYS */;
INSERT INTO `tipos_alojamiento` VALUES (1,'Casa'),(2,'Hotel'),(3,'Hostal'),(4,'Departamento');
/*!40000 ALTER TABLE `tipos_alojamiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `origen` varchar(255) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`),
  KEY `id_rol` (`id_rol`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles_usuario` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,1,'Admin','admin@host.com','admin123','999000001','admin.jpg','Masculino','México','1985-06-15','2024-07-01 08:00:00'),(2,2,'Anfitrión2','anfitrion2@host.com','hostpass','999000002','host2.jpg','Femenino','México','1980-04-22','2024-08-10 10:30:00'),(3,2,'Anfitrión3','anfitrion3@host.com','hostpass','999000003','host3.jpg','Masculino','México','1975-12-05','2024-09-15 11:20:00'),(4,2,'Anfitrión4','anfitrion4@host.com','hostpass','999000004','host4.jpg','Femenino','México','1983-07-19','2024-06-05 09:45:00'),(5,2,'Anfitrión5','anfitrion5@host.com','hostpass','999000005','host5.jpg','Masculino','México','1987-02-14','2024-11-21 14:50:00'),(6,2,'Anfitrión6','anfitrion6@host.com','hostpass','999000006','host6.jpg','Femenino','México','1982-09-08','2025-01-10 13:25:00'),(7,3,'Huésped7','huesped7@mail.com','guestpass','999000007','guest7.jpg','Femenino','Estados Unidos','1990-01-10','2024-07-15 10:00:00'),(8,3,'Huésped8','huesped8@mail.com','guestpass','999000008','guest8.jpg','Masculino','Canadá','1988-03-22','2024-09-18 08:45:00'),(9,3,'Huésped9','huesped9@mail.com','guestpass','999000009','guest9.jpg','Femenino','Francia','1992-05-30','2024-08-05 12:00:00'),(10,3,'Huésped10','huesped10@mail.com','guestpass','999000010','guest10.jpg','Masculino','Alemania','1987-07-09','2024-11-11 15:00:00'),(11,3,'Huésped11','huesped11@mail.com','guestpass','999000011','guest11.jpg','Masculino','Argentina','1993-09-18','2025-01-22 09:30:00'),(12,3,'Huésped12','huesped12@mail.com','guestpass','999000012','guest12.jpg','Femenino','México','1995-11-12','2024-10-10 07:55:00'),(13,3,'Huésped13','huesped13@mail.com','guestpass','999000013','guest13.jpg','Femenino','España','1989-06-28','2024-07-30 13:40:00'),(14,3,'Huésped14','huesped14@mail.com','guestpass','999000014','guest14.jpg','Masculino','México','1991-08-25','2024-09-02 11:10:00'),(15,3,'Huésped15','huesped15@mail.com','guestpass','999000015','guest15.jpg','Femenino','Alemania','1996-04-05','2024-12-19 08:20:00'),(16,3,'Huésped16','huesped16@mail.com','guestpass','999000016','guest16.jpg','Masculino','Brasil','1994-02-18','2025-02-03 14:10:00'),(17,3,'Huésped17','huesped17@mail.com','guestpass','999000017','guest17.jpg','Femenino','Canadá','1986-10-15','2024-07-28 16:00:00'),(18,3,'Huésped18','huesped18@mail.com','guestpass','999000018','guest18.jpg','Masculino','Alemania','1998-12-07','2024-10-25 10:35:00'),(19,3,'Huésped19','huesped19@mail.com','guestpass','999000019','guest19.jpg','Femenino','Canadá','1997-05-11','2025-01-08 09:15:00'),(20,3,'Huésped20','huesped20@mail.com','guestpass','999000020','guest20.jpg','Masculino','México','1990-03-03','2024-08-17 12:25:00'),(21,1,'jesusM','jesus@gmail.com','730bb68d3f5dff9d6abe26629612256baf7e5ad1a72c2c636bf5a1a5dcd14fbe497b31dbbc0918850bcc1bfcb3e7f25f4021a2fcdf05d948396c0ec871d1b3ec','123412',NULL,'masculino','Yucatan','2025-07-02','2025-07-20 00:00:00'),(22,1,'jesusM2','jesus1@gmail.com','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','123412',NULL,'masculino','Yucatan','2025-07-02','2025-07-20 00:00:00'),(23,1,'jesus2','08028@gmail.com','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','121212',NULL,'masculino','yucatan','2025-07-06','2025-07-20 00:00:00'),(24,2,'jesus2','080281@gmail.com','61b01aa0ba0a42ca6fdda935f173450e671ed3ea14781a7cdb6c6718fdc4f1bb924d420f6ca95b4d14e69c44cb71f59cef7c54c8e4221ad0afc896ec860b0987','121212',NULL,'masculino','yucatan','2025-07-06','2025-07-20 00:00:00');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-20 17:51:19
