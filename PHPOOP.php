<?php
//using namespaces
/*namespace Classes
{
	//exception fix
	use \Exception as Exception;
}

use Classes\Class as Class;*/
//with keyword "namespace"
	//PHP OOP is being around since 
	
	//class example
	class SimpleClass
	{
	    //constructor
	    public function __construct($field_init_value)
	    {
	    	$this->field=$field_init_value;
	    }

	    // property declaration
	    private $field = 'a default value';

	    // method declaration
	    public function displayField() {
	        echo $this->field;
	    }

	    public function getType()
	    {
	    	return get_class($this);
	    }
	}

	//instance
	$instance = new SimpleClass(10);

	$assigned   =  $instance;
	$reference  =& $instance;

	$instance->field = '$assigned will have this value';

	$instance = null; // $instance and $reference become null

	var_dump($instance);
	var_dump($reference);
	var_dump($assigned);

	//extending classes
	class ExtendClass extends SimpleClass
	{
		public function __construct($field_init_value="default value")//notice default value here
		{
			parent::__construct($field_init_value);
			//do more stuff here...			
		}		

	    // Redefine the parent method
	    function displayField()
	    {
	        echo "Extending class\n";
	        parent::displayField();
	    }
	}

	$extended = new ExtendClass();
	$extended->displayField();//geting fields, properties and methos with "->"

	//static methods
	class Printer
	{
		public static function printNewLine($line)
		{
			echo "\n".$line;
		}	
	}

	//using static methods...
	Printer::printNewLine("Hello, Ivan!");	
	Printer::printNewLine("Hello, Petar!");

	//abstract classes and interfaces	
	interface iBattery
	{
	    public function charge($power_input);	    	   

	    public function getCharge();

	    public function discharge($power_output);
	}



	interface iSubmarineBattery
	{
		public function chargeUnderwater($power_input);
	}

	abstract class Battery implements iBattery
	{
		protected $batteryCharge;

		protected function __construct($init_charge)
		{
			$this->batteryCharge=$init_charge;
		}	

		public abstract function charge($power_input);

		public function getCharge()
		{
			return $this->batteryCharge;
		}

		public abstract function discharge($power_output);	

		//magic method! Note: Show others!
		public function __toString()
		{
			$class_type=get_class($this);
			$charge=$this->batteryCharge;
			return "battery type: $class_type charge: $charge";
		}	
	}


	class SubmarineBattery extends Battery implements iSubmarineBattery
	{
		public function __construct($init_charge)
		{
			parent::__construct($init_charge);
		}

		public function charge($power_input)
		{
			$this->batteryCharge+=$power_input;
		}

		public function discharge($power_output)
		{
			$this->batteryCharge-=$power_output;
		}

		public function getCharge()
		{
			return parent::getCharge();
		}

		public function chargeUnderwater($power_input)
		{
			$this->charge($power_input/2);
		}

		public function __toString()
		{
			return parent::__toString();
		}
	}



	class LaptopBattery extends Battery
	{
		/**
	    * Creates a new instance of the LaptopBattery class.
	    *
	    * @access  public 
	    * @param   string  The inital charge for the laptop battery.		
	    * @return  void
	    */	
		public function __construct($init_charge)
		{
			$this->batteryCharge=$init_charge;
		}

		/**
	    * Returns the current amount of battery charge.
	    *
	    * @access  public 	    
	    * @return  float
	    */	
		public function getCharge()
		{
			return parent::getCharge();
		}

		/**
	    * Adds charge to the battery.
	    *
	    * @access  public 	    
	    * @param   float  How much charge to add.
	    * @return  void
	    */	
		public function charge($power_input)
		{
			$this->batteryCharge+=$power_input;
		}

		/**
	    * Discharges the battery.
	    *
	    * @access  public 	    
	    * @param   float  How much of the battery charge is consumed.
	    * @return  void
	    */	
		public function discharge($power_output)
		{
			$this->batteryCharge-=$power_input;
		}

		public function __toString()
		{
			return parent::__toString();
		}
	}	

	//Cant instance an abstract class
	//$battery=new Battery(100);
	//an error will be given
	
	$submarine_battery=new SubmarineBattery(100);
	$laptop_battery=new LaptopBattery(100);
	
	//do some stuff with batteries
	$submarine_battery->chargeUnderwater(10);
	$submarine_battery->charge(10);
	echo "\n".$submarine_battery->__toString();//expect 115
	//add documentation and magic methods
	$laptop_battery->charge(10);
	echo "\n".$laptop_battery->__toString();//expect 110
	
	
	//check if class implements interface
	//if ($cls instanceof iInterface)
	
	//Enumerations
	abstract class DaysOfWeek
	{
		const Sunday = 0;
		const Monday = 1;
		// etc.
	}

	$today = DaysOfWeek::Sunday;
	
	//Singleton
	/*		public static function create($server,$user,$pass)
		{
	        static $instance = null;
	        if (null === $instance) {
	            $instance = new static($server,$user,$pass);
	        }

	        return $instance;			
		}
	*/
?>