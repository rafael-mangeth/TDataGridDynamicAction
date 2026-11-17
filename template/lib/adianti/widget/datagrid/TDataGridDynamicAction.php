<?php

use Adianti\Control\TAction;
use Adianti\Widget\Datagrid\TDataGridAction;
class TDataGridActionGroup extends TDataGridAction 
{
    private $variants = [];
    
    public function __construct($field)
    {
        parent::__construct([__CLASS__])
    }
}