<?php
namespace Data
{
	abstract class MySQLDataPersister implements iDataPersister
	{
		//better messages in the future
		const CONNECTION_FAILED="Connection failed!";		

		protected function __construct($server="",$user="",$pass="")
		{
			$this->server=$server;
			$this->user=$user;
			$this->pass=$pass;
		}

		protected $server;
		protected $user;
		protected $pass;

		protected $connection;

		protected function openConnection()
		{			
			//open mysql connection
			$this->connection=mysql_connect($this->server,$this->user,$this->pass);
			if(!$this->connection)
			{
				throw new Exception(self::CONNECTION_FAILED);	
			}					
		}

		//singleton here...
		public static function create($server,$user,$pass)
		{
	        static $instance = null;
	        if (null === $instance) {
	            $instance = new static($server,$user,$pass);
	        }

	        return $instance;			
		}

		protected function closeConnection()
		{
			mysql_close($this->connection);
		}

		public abstract function loadEntities();

		public abstract function saveEntities();
	}	
}
?>