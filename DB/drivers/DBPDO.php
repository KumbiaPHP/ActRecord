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
 * Driver DB para PDO
 *
 * @category   Kumbia
 * @package    DB
 */
class DBPDO //extends PDO
{

    protected static $dbh = false;
    
    //protected static $sth;
	//protected static $fetch = PDO::FETCH_OBJ;
	
	function __construct($config)
    {
		try { // se enviara la conexion ya creada en el $config
		    $dbh = new PDO($config['dsn'], $config['user'], $config['pass'], $config['options']);
		    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $dbh->exec("SET NAMES utf8"); //por ahora fijo
		    $dbh->fetch_mode = PDO::FETCH_OBJ;
            self::$dbh = $dbh;
		} catch(PDOException $ex) {
            echo 'Error conexión: ', $ex;
        }
	}

    public static function query($sql)
    {
        $data = NULL;
        if(func_num_args() > 1){
            $data = array_shift(func_get_args());
            if(is_array($data[0])){
                $data = $data[0];
            }
        }
        echo $sql;
        try {
            $stmt = self::$dbh->prepare($sql);
            //if($data){
                $stmt->execute($data);
            //} else {
            //    $stmt->execute();
            //}
            
        } catch(PDOException $ex) {
            echo 'Error consulta: ', $ex;
        }
        
        return $stmt;
    }
    
    public static function all($sql)
    {
        $stmt = self::query(implode(',',func_get_args()));
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public static function driver()
    {
        return self::$dbh->getAttribute(constant("PDO::ATTR_DRIVER_NAME"));
    }

    public static function info()
    {
        return array(
            'driver' => self::$dbh->getAttribute(constant("PDO::ATTR_DRIVER_NAME")),
            'server' => self::$dbh->getAttribute(constant("PDO::ATTR_SERVER_VERSION")),
            'version' => self::$dbh->getAttribute(constant("PDO::ATTR_SERVER_VERSION")),
            'client' => self::$dbh->getAttribute(constant("PDO::ATTR_CLIENT_VERSION"))
            );
    }

}
