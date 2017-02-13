<?

 /*** specify extensions that may be loaded ***/
    spl_autoload_extensions('.php');

    /*** class Loader ***/
    function classLoader($class)
    {
       
        $filename = strtolower($class).'.php';
        $file ='../classes/' . $filename;
        if (!file_exists($file))
        {
            return false;
        }
        include $file;
    }
    
	spl_autoload_register('classLoader');
