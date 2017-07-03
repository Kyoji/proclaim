<?php

declare(strict_types = 1);
namespace Proclaim\Core;

class Output
{
    /**
     * Components array
     * Holds components to be rendered. Only two components are required - head and foot
     * which contain the opening and closing HTML statements.
     *  Positions:
     *      'head' - 1
     *      'foot' - automatically inserted last
     * 
     * @see registerComponent()
     * @var array $components
     */
    protected $components = [];
    protected $components_size = 0;

    protected $Proclaim;

    public function __construct( Proclaim &$Proclaim )
    {
        $this->Proclaim = $Proclaim;
        $this->init();
    }

    protected function init()
    {
        $Config = &$this->Proclaim->_Config;
        $components = &$this->components;
        $head = new Component('head');
        $foot = new Component('foot');
        $components[1] = $head;
        $components[20] = $foot;
        $components_size = 20;
    }

    /**
     * Register Component
     * Adds a component to the component array
     *
     * @param Component $component
     * @param int $index (optional) (specifies the position of the component to be output)
     * @return void
     */
    public function registerComponent( Component $component, int $index = null )
    {
        $components = &$this->components;

        if( !(is_null($index)) ) {
            if( $index === 1 )
                throw new \Exception("Attempting to register component to 'head' index (1). Please register at another index.");
            if( empty( $components[$index] ) || is_null( $components[$index] ) )
                $components[ $index ] = $component;
                if( $index > $components_size )
                    $components_size = $index;
            else {
                $this->bumpComponents( $index );
                $components[ $index ] = $component;
            }
        } else {
            $components[] = $components[ $components_size ];
            $components[ $components_size ] = $component;
            $components_size++;
        }
    }

    protected function bumpComponents( int $index )
    {
        $components = &$this->components;
        $tmp;
        
        function swap( &$a, &$b )
        {
            $ntmp = $a;
            $a = $b;
            $b = $ntmp;
        }

        // Prepare array for processing
        $tmp = $components[ $index ];
        $components[ $index ] = null;
        $index++;

        for($i = $index; $i <= $this->components_size + 1; $i++)
        {
            swap( $tmp, $components[ $i ]);
            if( !empty( $components[ $i + 1 ] ) )
                swap( $components[ $i + 1 ], $tmp );
        }
    }

    public function render()
    {
        $Config = &$this->Proclaim->_Config;
        $Proclaim = &$this->Proclaim;

        foreach ($this->components as $key => $component) {
            require $Config['theme_root'].$Config['active_theme']."/components/".$component->name.".php";
        }

        if( $Config['debug'] )
            require $Config['root']."Core/Templates/debug_panel.php";
       
    }


}