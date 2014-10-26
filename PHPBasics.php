<?php
/*
Naming convensions:
	╔═══════════════════════╦═════════════╦════════════╦══════════════╦════════════╦════════════╗
	║      PHP Project      ║   Classes   ║  Methods   ║  Properties  ║ Functions  ║ Variables  ║
	╠═══════════════════════╬═════════════╬════════════╬══════════════╬════════════╬════════════╣
	║ Akelos Framework      ║ PascalCase  ║ camelCase  ║ camelCase    ║ lower_case ║ lower_case ║
	║ CakePHP Framework     ║ PascalCase  ║ camelCase  ║ camelCase    ║ camelCase  ║ camelCase  ║
	║ CodeIgniter Framework ║ Proper_Case ║ lower_case ║ lower_case   ║ lower_case ║ lower_case ║
	║ Concrete5 CMS         ║ PascalCase  ║ camelCase  ║ camelCase    ║ lower_case ║ lower_case ║
	║ Doctrine ORM          ║ PascalCase  ║ camelCase  ║ camelCase    ║ camelCase  ║ camelCase  ║
	║ Drupal CMS            ║ PascalCase  ║ camelCase  ║ camelCase    ║ lower_case ║ lower_case ║
	║ Joomla CMS            ║ PascalCase  ║ camelCase  ║ camelCase    ║ camelCase  ║ camelCase  ║
	║ modx CMS              ║ PascalCase  ║ camelCase  ║ camelCase    ║ camelCase  ║ lower_case ║
	║ Pear Framework        ║ PascalCase  ║ camelCase  ║ camelCase    ║            ║            ║
	║ Prado Framework       ║ PascalCase  ║ camelCase  ║ Pascal/camel ║            ║ lower_case ║
	║ SimplePie RSS         ║ PascalCase  ║ lower_case ║ lower_case   ║ lower_case ║ lower_case ║
	║ Symfony Framework     ║ PascalCase  ║ camelCase  ║ camelCase    ║ camelCase  ║ camelCase  ║
	║ WordPress CMS         ║             ║            ║              ║ lower_case ║ lower_case ║
	║ Zend Framework        ║ PascalCase  ║ camelCase  ║ camelCase    ║ camelCase  ║ camelCase  ║
	╚═══════════════════════╩═════════════╩════════════╩══════════════╩════════════╩════════════╝
Go with:
  ->ClassName
  ->methodName
  ->propertyName
  ->function_name (meant for global functions)
  ->$variable_name
  and...
  ->iInterfaceName
*/

//Connecting code files

/*The require function is used exactly the same as the include function.*/
//require('<filename>');

/*The last of the four functions is the require_once, which is 
a combination of the require and include_once function. It 
will make sure that the file exists before adding it to the 
page if it's not there it will throw a fatal error. 
Plus it will make sure that the file can only be used once on the page.*/
//require_once('<filename>');//The strict one.

/*The include function is used in PHP when you want to include a 
file within the current process.*/
//include('<filename>');

/*The include_once function is exactly the same as 
the include function except it will limit the file to be used once.*/
//include_once('<filename>');

//Variables
//$<identifier>=<value>;

//constants
define("GREETING", "Hello.", true);
echo GREETING; // outputs "Hello."

$age = 20;
$ivan="Ivan";
$maria='Maria';//Notice: strings can be used with single or double quotes

//concatenating strings!!!
$married=$ivan." and ".$maria." are married!";//with dot

$PI=3.14;
$condition=false;

//cool or not?
$var_name="variable";
$$var_name="value";

//see variable info
var_dump($variable);

//Arrays
$collections = array (
    "fruits"  => array("a" => "orange", "b" => "banana", "c" => "apple"),
    "numbers" => array(1, 2, 3, 4, 5, 6),
    "holes"   => array("first", 5 => "second", "third")
);

//Lists
//Like array().
//this is not really a function, but a language construct.
//list() is used to assign a list of variables in one operation. 

$info = array('coffee', 'brown', 'caffeine');

list($drink, $color, $power) = $info;
//NOTICE ECHO HERE, SAY SOMETHING ABOUT sprintf() too.
echo "$drink is $color and $power makes it special.\n";

//mention resources...

//cycles
foreach($collections as $key=>$collection)
{
	echo "$key=>";
	//alternative- printf, like sprintf, but prints
	printf("%s",$key);	
	//sprintf is like String.Format in C#.NET
	/*sprintf function format type specifiers:
	---
	% - a literal percent character. No argument is required.
    b - the argument is treated as an integer, and presented as a binary number.
    c - the argument is treated as an integer, and presented as the character with that ASCII value.
    d - the argument is treated as an integer, and presented as a (signed) decimal number.
    e - the argument is treated as scientific notation (e.g. 1.2e+2). The precision specifier stands for the number of digits after the decimal point since PHP 5.2.1. In earlier versions, it was taken as number of significant digits (one less).
    E - like %e but uses uppercase letter (e.g. 1.2E+2).
    f - the argument is treated as a float, and presented as a floating-point number (locale aware).
    F - the argument is treated as a float, and presented as a floating-point number (non-locale aware). Available since PHP 4.3.10 and PHP 5.0.3.
    g - shorter of %e and %f.
    G - shorter of %E and %f.
    o - the argument is treated as an integer, and presented as an octal number.
    s - the argument is treated as and presented as a string.
    u - the argument is treated as an integer, and presented as an unsigned decimal number.
    x - the argument is treated as an integer and presented as a hexadecimal number (with lowercase letters).
    X - the argument is treated as an integer and presented as a hexadecimal number (with uppercase letters).*/

    //if statements

    $conditionA=true;
    $conditionB=true;
    if(is_array($collection) AND ($conditionA && $conditionB) || (!$conditionA OR $conditionB))
    {
    	foreach ($collection as $item) {
    		echo $item;
    	}
    }
    else
    {
    	echo $collection;
    }
}

try
{
	//troll
	throw new Exception("Just kidding!");
}
catch(Exception $boom)
{
	var_dump($boom);
}

//for, while, switch are the same like in other c languages...

include_once "PHPOOP.php";

//use addslashes for escaping
//use stripslashes for counter escaping
