<?php

/*
  resumo: aqui são apresentados 5 DesigPaterns comuns em php para facilitar o
  desenvolvimento do humrum!
  fonte:http://www.ibm.com/developerworks/library/os-php-designptrns/


  « 1 - The factory pattern »
  <<------------------------------------------------------------------------------
  resultado da execução:
  Jack

  ------------------------------------------------------------------------------>>
 */


interface IUser {

    function getName();
}

class User implements IUser {

    public function __construct($id) {

    }

    public function getName() {
        return "Jack";
    }

}

class UserFactory {

    public static function Create($id) {
        return new User($id);
    }

}

$uo = UserFactory::Create(1);
echo( $uo->getName() . "\n" );
?>




<?php

/*
  « 2 - The singleton pattern »
  <<------------------------------------------------------------------------------
  resultado da execução:
  Handle = Object id #3
  Handle = Object id #3

  ------------------------------------------------------------------------------>>
 */


require_once("DB.php");

class DatabaseConnection {

    public static function get() {
        static $db = null;
        if ($db == null)
            $db = new DatabaseConnection();
        return $db;
    }

    private $_handle = null;

    private function __construct() {
        $dsn = 'mysql://root:password@localhost/photos';
        $this->_handle = & DB::Connect($dsn, array());
    }

    public function handle() {
        return $this->_handle;
    }

}

print( "Handle = " . DatabaseConnection::get()->handle() . "\n");
print( "Handle = " . DatabaseConnection::get()->handle() . "\n");
?>



<?php

/*
  « 3 - The observer pattern »
  <<------------------------------------------------------------------------------
  resultado da execução:
  'Jack' added to user list

  ------------------------------------------------------------------------------>>
 */
interface IObserver {

    function onChanged($sender, $args);
}

interface IObservable {

    function addObserver($observer);
}

class UserList implements IObservable {

    private $_observers = array();

    public function addCustomer($name) {
        foreach ($this->_observers as $obs)
            $obs->onChanged($this, $name);
    }

    public function addObserver($observer) {
        $this->_observers [] = $observer;
    }

}

class UserListLogger implements IObserver {

    public function onChanged($sender, $args) {
        echo( "'$args' added to user list\n" );
    }

}

$ul = new UserList();
$ul->addObserver(new UserListLogger());
$ul->addCustomer("Jack");
?>


<?php

/*
  « 4 - The chain-of-command pattern »
  <<------------------------------------------------------------------------------
  resultado da execução:
  UserCommand handling 'addUser'
  MailCommand handling 'mail'

  ------------------------------------------------------------------------------>>
 */

interface ICommand {

    function onCommand($name, $args);
}

class CommandChain {

    private $_commands = array();

    public function addCommand($cmd) {
        $this->_commands [] = $cmd;
    }

    public function runCommand($name, $args) {
        foreach ($this->_commands as $cmd) {
            if ($cmd->onCommand($name, $args))
                return;
        }
    }

}

class UserCommand implements ICommand {

    public function onCommand($name, $args) {
        if ($name != 'addUser')
            return false;
        echo( "UserCommand handling 'addUser'\n" );
        return true;
    }

}

class MailCommand implements ICommand {

    public function onCommand($name, $args) {
        if ($name != 'mail')
            return false;
        echo( "MailCommand handling 'mail'\n" );
        return true;
    }

}

$cc = new CommandChain();
$cc->addCommand(new UserCommand());
$cc->addCommand(new MailCommand());
$cc->runCommand('addUser', null);
$cc->runCommand('mail', null);
?>



<?php

/*
  « 5 - The strategy pattern »
  <<------------------------------------------------------------------------------
  resultado da execução:
  Array
  (
  [0] => Jack
  [1] => Lori
  [2] => Megan
  )
  Array
  (
  [0] => Andy
  [1] => Megan
  )

  ------------------------------------------------------------------------------>>
 */

interface IStrategy {

    function filter($record);
}

class FindAfterStrategy implements IStrategy {

    private $_name;

    public function __construct($name) {
        $this->_name = $name;
    }

    public function filter($record) {
        return strcmp($this->_name, $record) <= 0;
    }

}

class RandomStrategy implements IStrategy {

    public function filter($record) {
        return rand(0, 1) >= 0.5;
    }

}

class UserList2 {

    private $_list = array();

    public function __construct($names) {
        if ($names != null) {
            foreach ($names as $name) {
                $this->_list [] = $name;
            }
        }
    }

    public function add($name) {
        $this->_list [] = $name;
    }

    public function find($filter) {
        $recs = array();
        foreach ($this->_list as $user) {
            if ($filter->filter($user))
                $recs [] = $user;
        }
        return $recs;
    }

}

$ul = new UserList(array("Andy", "Jack", "Lori", "Megan"));
$f1 = $ul->find(new FindAfterStrategy("J"));
print_r($f1);

$f2 = $ul->find(new RandomStrategy());
print_r($f2);
?>