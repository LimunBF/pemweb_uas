<?php
try {
   $pdo = new PDO("mysql:host=localhost;dbname=loket_com", "root", "");
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
   $search = isset($_GET['search']) ? $_GET['search'] : '';
   
   // Query untuk mendapatkan lokasi unik dari events
   $query = "SELECT DISTINCT location FROM events WHERE location LIKE :search ORDER BY location ASC";
   $stmt = $pdo->prepare($query);
   $stmt->execute(['search' => "%$search%"]);
   
   $locations = $stmt->fetchAll(PDO::FETCH_COLUMN);
   
   echo json_encode($locations);
} catch(PDOException $e) {
   echo json_encode(['error' => $e->getMessage()]);
}
?> 
>