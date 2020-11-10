<?php

/**
|--------------------------------------------------
|  Début => Regroupe les fonctions diverses
|--------------------------------------------------
*/
  /**
   * Fonction  de debogage dd => die and dump
   * Permet d'avoir un rendu plus convenable lorsque que l'on dump une variable
   * @param mixed $values
   * @return void
   */
  function dd (...$values): void {
    $preTag = '<pre>';
    echo $preTag . print_r($values, true) . str_replace('<', '</', $preTag);
  }

  /**
   * my_scandir
   *
   * @param string $pathToDirectory
   * @return mixed
   */
  function my_scandir (string $pathToDirectory) {
    $dir = new DirectoryIterator($pathToDirectory);
    foreach ($dir as $file) {
      if ($file->isDot()) continue;
      if ($file->isDir()) $directories[] = $file->getFilename();
    }
    if (empty($directories)) { return null; }
    return $directories;
  }

  /**
   * Fonction dbConf
   * @author BATCHI <claude.batchi@epitech.eu>
   * @param void
   * @return object
   * Cette fonction permet de recupérer les données sur la forme de clé => valeur depuis la .env
   * Peux être utilisé getEnv|$_SERVER|$_ENV attention: $_ENV a été déprécié
   */
  function dbConf (): object {
    return (object) [
      'db' => (object) [
        'dns' => $_SERVER['DB_DNS'],
        'dbname' => $_SERVER['DB_NAME'],
        'username' => $_SERVER['DB_USER'],
        'password' => $_SERVER['DB_PASSWORD']
      ]
    ];
  }
/**
|--------------------------------------------------
|  Fin => Regroupe les fonctions diverses
|--------------------------------------------------
*/



/**
|--------------------------------------------------
|  Début => Regroupe les fonctions contenant les requêtes sql
|--------------------------------------------------
*/
  /**
   * Fonction createDatabaseIfNotExistSql
   * @author BATCHI <claude.batchi@epitech.eu>
   * Permet de stocker la requêtes sql permettant de creer une base donnée;
   * @param string $databaseName
   * Elle prend en paramètre une string qui est le nom de la base de donnée que l'on souhaite créer
   * @return void
   */
  function createDatabaseIfNotExistSql (string $databaseName): string {
    return "CREATE DATABASE IF NOT EXISTS $databaseName; USE $databaseName";
  }


  /**
   * Fonction createTableMigrationSql
   * @author BATCHI <claude.batchi@epitech.eu>
   * @param void
   * @return string
   */
  function createTableMigrationSql (): string {
    return "CREATE TABLE IF NOT EXISTS migrations (
      `id` INT NOT NULL AUTO_INCREMENT,
      `migration` VARCHAR(255) NOT NULL,
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8";
  }

  /**
   * Fonction getAppliedMigrationSql
   * @author BATCHI <claude.batchi@epitech.eu>
   * @return string
   * 
   */
  function getAppliedMigrationSql (): string { return "SELECT migration FROM migrations"; }

  /**
   * Fonction saveMigrationsSql
   * @author BATCHI <claude.batchi@epitech.eu>
   * @param string $str
   * @return string
   */
  function saveMigrationsSql ($str): string { return "INSERT INTO migrations (migration) VALUES ($str)"; }
/**
|--------------------------------------------------
|  Fin => Regroupe les fonctions contenant les requêtes sql
|--------------------------------------------------
*/