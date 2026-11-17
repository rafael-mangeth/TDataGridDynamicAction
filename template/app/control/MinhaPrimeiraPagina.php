<?php

use Adianti\Control\TPage;
use Adianti\Widget\Util\TImage;
use Adianti\Widget\Chart\TPieChart;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Container\TPanelGroup;

class MinhaPrimeiraPagina extends TPage{
    public function __construct()
    {
        parent::__construct();

        $chart = new TPieChart();
        $chart->setTitle('Áreas de Atuação do Estágio',);
        $chart->addSlice('Design', 6);
        $chart->addSlice('Programação', 7);
        $chart->addSlice('Hardware', 8);
        $chart->addSlice('Suporte', 10);
        $chart->addSlice('Redes', 3);

        $panel = new TPanelGroup;
        $panel->add($chart);

        $panel2 = new TPanelGroup;
        $panel2->add(new TImage('app/images/sunshine.jpg'));

        $container = new TVBox;
        $container->style = "width: 100%";
        $container->add($panel);
        $container->add($panel2);
    

        parent::add($container);
    

    }
}