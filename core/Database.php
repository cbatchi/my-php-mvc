<?php

namespace App\Core;

use Exception;
use PDO;
use PDOException;

/**
 * Database
 * @author BATCHI <claude.batchi@epitech.eu>
 */
class Database {

  public PDO $pdo;
  public object $config;
  public string $dns;
  public string $dbname;
  public string $username;
  public string $password;
  /**
   * __construct
   *
   * @param object $config
   * @return PDO
   */
  public function __construct(object $config)
  {
    try {
      $this->dns = $config->dns;
      $this->dbname = $config->dbname;
      $this->username = $config->username;
      $this->password = $config->password;
      
      return $this->pdo = new PDO($this->dns , $this->username, $this->password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
      ]);
    } catch (PDOException $e) {
      echo 'Connection to database failed '. $e->getMessage();
    }
  }
  
  /**
   * Méthode applyMigration
   * @return void
   * Permet de creer une table de migration uniquement si la requête de création de la database
   * renvoi true sinon capture l'erreur
   */
  public function applyMigrations (): void {
    try {
      if ($this->createDatabaseIfNotExist()) {
  
        $this->createMigrationsTable();
        
        $newMigrations = [];
    
        $applyMigrations = $this->getAppliedMigration();
    
        $files = scandir(implode(DIRECTORY_SEPARATOR, [Core::$rootPath, 'migrations']));
        $toApplyMigration = array_diff($files, $applyMigrations);
    
        foreach($toApplyMigration as $migration) {
    
          if ($migration === '.' || $migration === '..') continue;
    
          require_once Core::$rootPath . '/migrations/' . $migration;
          $className = pathinfo($migration, PATHINFO_FILENAME);
    
          $newInstance = new $className();
          // echo 'Appliying migration ' . $migration . '<br />';
    
          $newInstance->up();
          $this->log('Applied migration ' . $migration);
    
          $newMigrations[] = $migration;
    
          if (!empty($newMigrations)) {
            $this->saveMigrations ($newMigrations);
          } else {
            $this->log('all migrations are applied');
          }
        }
      }
    } catch (Exception $e) {
      echo 'Creation of database failed ' . $e->getMessage();
    }
  }
  
  /**
   * createDatabaseIfNotExist
   *
   * @return void
   */
  public function createDatabaseIfNotExist () {
    return $this->pdo->exec(createDatabaseIfNotExistSql($this->dbname));
  }

  /**
   * createMigrationsTable
   * Execute la requete de creation de table de migration en appelant la fonction 
   * createTableMigrationSql proveneant du fichier helper.php
   * @return void
   */
  public function createMigrationsTable (): void {
    $this->pdo->exec(createTableMigrationSql());
  }
  
  /**
   * getAppliedMigration
   * Execute la requete de recuperation de colonne en appelant la fonction 
   * getAppliedMigrationSql proveneant du fichier helper.php
   * @param void
   * @return array|object
   */
  public function getAppliedMigration () {
    $statement = $this->pdo->prepare(getAppliedMigrationSql());
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_COLUMN);
  }
  
  /**
   * saveMigrations
   * Save migration inside the database
   * @param array $migrations
   * @return void
   */
  public function saveMigrations (array $migrations): void {
    $str = implode(',' , array_map(fn($m) => "('$m')", $migrations));
    $statement = $this->pdo->prepare(saveMigrationsSql($str));
    $statement->execute() ?? false;
  }
  
  /**
   * Function de log
   * Affiche les informations d'execution
   * @param string $message
   * @return void
   */
  protected function log (string $message): void {
    echo '[' . date('Y-m-d H:i:s') . '] -' . $message . PHP_EOL;
  }
}