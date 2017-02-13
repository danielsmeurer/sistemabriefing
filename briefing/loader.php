<?
 /*** specify extensions that may be loaded ***/
    spl_autoload_extensions('.php, .class.php, .lib.php');

    /*** class Loader ***/
    function classLoader($class)
    {
        $filename = strtolower($class) . '.class.php';
        $file ='classes/' . $filename;
        if (!file_exists($file))
        {
            return false;
        }
        include $file;
    }

    function libLoader($class)
    {
        $filename = strtolower($class) . '.lib.php';
        $file ='libs/' . $filename;
        if (!file_exists($file))
        {
            return false;
        }
        include $file;
    }
