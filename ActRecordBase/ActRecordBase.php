<?php
/**
 * KumbiaPHP web & app Framework
 *
 * @category   Kumbia
 * @package    ActRecord
 * @copyright  Copyright (c) 2005-2013 KumbiaPHP Team (http://www.kumbiaphp.com)
 * @license    http://wiki.kumbiaphp.com/Licencia     New BSD License
 */

/**
 * ActRecord Clase para el Mapeo Objeto Relacional
 *
 * @category   Kumbia
 * @package    ActRecord
 */

//NAMESPACE

class ActRecordBase
{
  
	function __construct()
	{
		// debe ser small_case por defecto
		self::getTable(strtolower(get_called_class()));
		$this->initialize();


	}

	public function initialize()
	{

	}

	protected function getDB()
	{
		//static 

	}

	protected static function getTable($table = NULL)
	{
		static $source;
		if($table) return $source = $table;

		return $source;
	}

	public static function all()
	{
		$sql = 'SELECT * FROM '.self::getTable();
		$db = DB::get();
		return $db::all($sql);
	}

	public function get($id)
	{
		$sql = 'SELECT * FROM '.self::getTable().' where id='.(int)id;
		$db = DB::get();

		return $db::$dbh->query($sql, PDO::FETCH_INTO, $this);
	}

	public function update()
	{
		$sql = 'SELECT * FROM '.self::getTable().' where id='.(int)id;
		$db = DB::get();

		return $db::$dbh->query($sql, PDO::FETCH_INTO, $this);
	}
  
}
