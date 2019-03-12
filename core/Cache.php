<?php

/**
 * Caching class, based on files storage.
 *
 * Class stores all data to cache folder, where each named cache is a single file
 *
 * @package  Phonebook
 * @author   Andrey A. Kosinov <aka@portalmaster.ru>
 */


namespace Core;

class Cache {

	/**
	 * Path to the folder where will be stored all cache files
	 * @var string
	 */
	protected static $path = '../storage/cache';

	/**
	 * Warm up method to prepare cache for storing and receiving data
	 */
	protected static function warmUp() : void
	{
		if (!is_dir(self::$path))
			mkdir(self::$path,0775,true);
	}

	/**
	 * Check for data in cache and if there is data in cache and it's not expired then return data from cache otherwise return false
	 * @param  string $name    Cache name
	 * @param  int    $seconds Number of seconds for cache TTL
	 * @return mixed           Cache data
	 */
	protected function checkAndGet(string $name, int $seconds)
	{
		$fname = self::$path.'/'.$name;
		if (file_exists($fname))
		{
			$ftime = filemtime($fname);
			if (time()-$ftime>$seconds)
				return false;
			else
			{
				return unserialize(file_get_contents($fname));
			}
		}

		return false;
	}

	/**
	 * Serialize and store data in cache files
	 * @param  string $name Cache name
	 * @param  mixed  $data Data that will be serialized and stored in cache
	 */
	protected static function store($name, $data){
		$fname = self::$path.'/'.$name;
		$f = fopen($fname,'w+');
		fputs($f,serialize($data));
		fclose($f);
	}

	/**
	 * The only public method to remember data in cache
	 *
	 * If data in cache expired than method calls user's closure and result stores in cache and returns back to user.
	 * If data is actual than method return data from cache without calling user's closure
	 * @param  string   $name    Cache name
	 * @param  int      $seconds Seconds for cache TTL
	 * @param  Closure  $f       User's closure to get data for caching
	 * @return mixed             Data from cache
	 */
	public static function remember(string $name, int $seconds, \Closure $f)
	{
		self::warmUp();

		$data = self::checkAndGet($name,$seconds);
		if ($data)
			return $data;

		$data = call_user_func($f);
		self::store($name,$data);

		return $data;
	}
}