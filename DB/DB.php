<?php
/**
 * KumbiaPHP web & app Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://wiki.kumbiaphp.com/Licencia
 *
 * @category   Kumbia
 * @package    DB
 * @copyright  Copyright (c) 2005-2013 Kumbia Team (http://www.kumbiaphp.com)
 * @license    http://wiki.kumbiaphp.com/Licencia     New BSD License
 */

/**
 * Clase que maneja el pool de conexiones
 *
 * @category   Kumbia
 * @package    DB
 */
class DB
{
    /**
     * Singleton de conexiones a base de datos
     *
     * @var array
     */    
    protected static $dbc = array();

    /**
     * Devuelve la conexión, si no existe llama a Db::connect para crearla
     *
     * @param string $database nombre base de datos a donde conectar
     * @param array $config array de configuración opcional
     *
     * @return db
     */
    public static function get($database = 'default', $config = FALSE)
    {

        if (isset(self::$dbc[$database])) {
            return self::$dbc[$database];
        }

        return self::$dbc[$database] = self::connect($database, $config);
    }

    /**
     * Realiza una conexión directa al motor de base de datos
     * usando el driver de Kumbia
     *
     * @param string $database base de datos a donde conectar
     * @return db
     */
    private static function connect($database, $config)
    {
        if(!$config){ // Cambiar para no usar el config de kumbiaphp
            $databases = Config::read('databases');
            $config = $databases[$database];
        }
        
        if(!$driver = $config['driver']){
            throw new KumbiaException(_("Debe definir un driver en la configuración de esta base de datos"));
        }

        if (!include_once __DIR__ . "/drivers/$driver.php") {
            throw new KumbiaException(_("No existe el driver $driver, necesario para iniciar la base de datos"));
        }
        $dbclass = "DB{$driver]}";
        
        return new $dbclass($config);
    }
        // carga los valores por defecto para la conexión, si no existen
        //$default = array('port' => 0, 'dsn' => NULL, 'dbname' => NULL, 'host' => 'localhost', 'username' => NULL, 'password' => NULL);
        //$config = $config + $default;

        //Si usa PDO
        //if (isset($config['pdo'])) {
        //    $dbclass = "DBPdo{$config['type']}";
        //    $db_file = "libs/db/adapters/pdo/{$config['type']}.php";
        //} else {
        //    $dbclass = "DB{$config['type']}";
        //    $db_file = "libs/db/adapters/{$config['type']}.php";
        //}

        //Carga la clase adaptadora necesaria
        //if (!include_once __DIR__ . $db_driver) {
        //    throw new KumbiaException(_("No existe el driver $dbclass, necesaria para iniciar el adaptador"));
        //}

        //return new $dbclass($config);
    }

}
