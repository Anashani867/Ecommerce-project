<?php

// Include the config file
require_once 'config/db.php';

// Create a new Database instance
$db = new db();

// Get the PDO connection
$pdo = $db->getConnection();

$excutedMigrations = $pdo->query("SELECT migration FROM migrations") -> fetchAll(PDO::FETCH_COLUMN);

$migrationFiles = scandir(__DIR__.'/migrations');

$batch = (int) $pdo->query("SELECT MAX(batch) FROM migrations")->fetchColumn() +1;


foreach ($migrationFiles as $file) {
    if ($file === "." || $file === "..") {
        continue;
    }

    $className = convertToClassName(pathinfo($file, PATHINFO_FILENAME));

    if (!in_array($className, $excutedMigrations)) {
        require __DIR__.'/migrations/'.$file;
        $migration = new $className();
        $pdo ->exec($migration->up());
       $stmt = $pdo->prepare("INSERT INTO `migrations` (`migration`, `batch`) VALUES (?, ?); ");
        $stmt->execute([$className, $batch]);
        echo "Created migration: ".$className;
    }
}
function convertToClassName($file) {
    $fileNameWithoutDate = preg_replace('/^(\d{4}_\d{2}_\d{2})_/', '', $file);
    $parts = explode('_', $fileNameWithoutDate);
    $className='';
    foreach ($parts as $part) {
        $className .= ucfirst($part);
    }
    return  $className;
}