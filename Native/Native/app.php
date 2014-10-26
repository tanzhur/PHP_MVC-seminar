<?php
	//for production
	//error_reporting(0);

	//for debugging
	error_reporting(E_ALL);

	//const
	define("ENTITTIES_FOLDER","Entities",true);
	define("DATA_FOLDER","Data",true);
	
	//requires
	require_once (ENTITTIES_FOLDER."/iAppEntityRepository.php");
	require_once (ENTITTIES_FOLDER."/iAppEntity.php");
	require_once (ENTITTIES_FOLDER."/AppEntityState.php");
	require_once (ENTITTIES_FOLDER."/AppEntityRepository.php");
	require_once (ENTITTIES_FOLDER."/Note.php");
	//
	require_once (DATA_FOLDER."/iDataPersister.php");
	require_once (DATA_FOLDER."/MySQLDataPersister.php");
	//
	use Data\iDataPersister as iDataPersister;
	use Data\MySQLDataPersister as MySQLDataPersister;
	use Entities\AppEntityRepository as AppEntityRepository;
	use Entities\Note as Note;
	use Entities\AppEntityState as EntityState;
	//
	include_once ("AppDataPersister.php");

	class App
	{		
		private function __construct()
		{
			$this->dataPersister=AppDataPersister::create("localhost","root","");
			$this->entitiesRepository=AppEntityRepository::create();
		}

		//singleton...
		public static function create()
		{
	        static $instance = null;
	        if (null === $instance) {
	            $instance = new static();
	        }

	        return $instance;			
		}

		private function fillSomeMessages()
		{
			for($i=1;$i<=10;$i++)
			{
				$now=date("Y-m-d H:i:s");
				$newNote=new Note($i,"new note","some text",$now);
				$this->entitiesRepository->addEntity($newNote);
			}
			//var_dump($this->entitiesRepository->getEntities());
		}

		public function run()
		{			
			try
			{
				//main functionality
				//fill some dummy notes
				$this->dataPersister->data=&$this->entitiesRepository;
				//$this->fillSomeMessages();
				$this->entitiesRepository->loadEntities(array($this->dataPersister,"loadEntities"));
				//
				//var_dump($this->entitiesRepository->getEntities());
				//$this->entitiesRepository->deleteEntity(new Note(8));
				$this->entitiesRepository->updateEntity(new Note(4,$title="changed title","some text here..."));
				//
				//var_dump($this->entitiesRepository->getEntities());
				$this->entitiesRepository->saveEntities(array($this->dataPersister,"saveEntities"));				
				//include views here...		
				//include_once "index.php";
				
			}
			catch(Exception $boom)
			{
				echo $boom->getMessage();
			}
		}

		private $dataPersister;
		private $entitiesRepository;
	}

	//var_dump($_GET["g"]);
	//var_dump($_SERVER["REMOTE_ADDR"]);

	//echo "Hello world";

	//run app
	$app=App::create();

	$app->run();
?>