<?php
/**
 * Created by PhpStorm.
 * User: jhinchley
 * Date: 7/17/16
 * Time: 1:26 PM
 */

$host = "localhost";
$db_name="mysqlcartlevel1";
$username = "cart_user";
$password="xCBvRUf28EfpcYpxee";

// UTF-8 is a character encoding scheme that allows you to conveniently store
// a wide varienty of special characters, like ¢ or €, in your database.
// By passing the following $options array to the database connection code we
// are telling the MySQL server that we want to communicate with it using UTF-8
// See Wikipedia for more information on UTF-8:
// http://en.wikipedia.org/wiki/UTF-8
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

// A try/catch statement is a common method of error handling in object oriented code.
// First, PHP executes the code within the try block.  If at any time it encounters an
// error while executing that code, it stops immediately and jumps down to the
// catch block.  For more detailed information on exceptions and try/catch blocks:
// http://us2.php.net/manual/en/language.exceptions.php
try
{
    // This statement opens a connection to your database using the PDO library
    // PDO is designed to provide a flexible interface between PHP and many
    // different types of database servers.  For more information on PDO:
    // http://us2.php.net/manual/en/class.pdo.php
    $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
}
catch(PDOException $ex)
{
    // If an error occurs while opening a connection to your database, it will
    // be trapped here.  The script will output an error and stop executing.
    // Note: On a production website, you should not output $ex->getMessage().
    // It may provide an attacker with helpful information about your code
    // (like your database username and password).
    die("Failed to connect to the database: " );//. $ex->getMessage()
}

// This statement configures PDO to throw an exception when it encounters
// an error.  This allows us to use try/catch blocks to trap database errors.
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// This block of code is used to undo magic quotes.  Magic quotes are a terrible
// feature that was removed from PHP as of PHP 5.4.  However, older installations
// of PHP may still have magic quotes enabled and this code is necessary to
// prevent them from causing problems.  For more information on magic quotes:
// http://php.net/manual/en/security.magicquotes.php
if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
{
    function undo_magic_quotes_gpc(&$array)
    {
        foreach($array as &$value)
        {
            if(is_array($value))
            {
                undo_magic_quotes_gpc($value);
            }
            else
            {
                $value = stripslashes($value);
            }
        }
    }

    undo_magic_quotes_gpc($_POST);
    undo_magic_quotes_gpc($_GET);
    undo_magic_quotes_gpc($_COOKIE);
}

// This tells the web browser that your content is encoded using UTF-8
// and that it should submit content back to you using UTF-8
header('Content-Type: text/html; charset=utf-8');
?>