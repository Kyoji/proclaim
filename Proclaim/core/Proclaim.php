<?php

declare(strict_types = 1);
namespace Proclaim\Core;

final class Proclaim
{
    protected $_DB;
    protected $_Router;
    protected $_Output;
    protected $_Theme;
    protected $_Loader;

    public $_Config;
    public $_memory_start;
    public $_memory_end;
    public $_memory_usage;
    public $_exec_time;

    
    public function __construct()
    {
        $this->init();
        $this->main();
    }

    protected function init()
    {
        // Start mem use recording
        $this->_memory_start = memory_get_usage();

        // Read defaults from proclaim-defaults.json
        // Update defaults with server info
        $Config = &$this->_Config;

        // Read defaults
        $Config = Utilities::json_decode( $_SERVER["DOCUMENT_ROOT"]."Proclaim/config/proclaim-defaults.json" );

        // Prepend server-specific info to default paths
        $Config['root'] = $_SERVER["DOCUMENT_ROOT"].$Config['root'];
        $Config['theme_root'] = $_SERVER["DOCUMENT_ROOT"].$Config['theme_root'];
        
    }

    // This is the scope of our entire program
    protected function main()
    {
        $Proclaim = &$this;
        $PDO = &$this->_PDO;
        $DB = &$this->_DB;
        $Router = &$this->_Router;
        $Output = &$this->_Output;
        $Theme = &$this->_Theme;
        $Loader = &$this->_Loader;
        $Config = &$this->_Config;

        $Loader = new Loader;

        $MySQL = new MySQLAdapter( 
            Utilities::json_decode( 
                $_SERVER["DOCUMENT_ROOT"]."Proclaim/config/proclaim-db.json" 
            ) 
        );
        $DB = new Database( $MySQL );

        $Router = new Router( $Proclaim );

        $Output = new Output( $Proclaim );
        $Output->render();

    }

    public function update_memory_usage( int $decimal_places = 2 )
    {
        $mem_use = ($this->_memory_end - $this->_memory_start) / 1000;
        $this->_mem_use = round( $mem_use, $decimal_places );
    }

    public function update_exec_time( int $decimal_places = 2 )
    {
        $exec_time = (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) * 1000;
        $this->_exec_time = round( $exec_time, $decimal_places );
    }

    public function report_efficiency() : String
    {
        return  "<strong>Memory used by Proclaim:</strong> ".$this->_mem_use." Kb"
                ."<br/>"
                ."<strong>Execution time:</strong> ".$this->_exec_time." ms";
    }

}