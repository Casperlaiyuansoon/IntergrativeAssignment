<?php
// app/config/ORMDatabase.php
namespace App\Config;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class ORMDatabase {
    private $entityManager;

    public function __construct() {
        // Setup Doctrine configuration
        $paths = [__DIR__ . '/../entity']; // Adjust path to your entity folder
        $isDevMode = true;

        // Configuration for Doctrine
        $dbParams = [
            'driver' => 'pdo_mysql', // Use your specific driver
            'user' => 'your_db_user', // Update with your DB username
            'password' => 'your_db_password', // Update with your DB password
            'dbname' => 'your_db_name', // Update with your DB name
        ];

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $this->entityManager = EntityManager::create($dbParams, $config);
    }

    public function getEntityManager() {
        return $this->entityManager;
    }
}
