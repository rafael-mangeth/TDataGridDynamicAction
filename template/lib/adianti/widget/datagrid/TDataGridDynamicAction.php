<?php

namespace Adianti\Widget\Datagrid;

use Adianti\Control\TAction;
use Adianti\Widget\Datagrid\TDataGridAction;
class TDataGridDynamicAction extends TDataGridAction 
{
    private $variants = [];
    private $resolved = false;
    
    public function __construct(?string $field)
    {
        parent::__construct([__CLASS__], 'placeholder');
        $this->setField($field);
    }

    public function placeholder(){}

    public function addVariant(callable $condition, array $callback, $image = null, $label = null, $parameters = null, $title = null)
    {
        $probe = new TAction($callback);

        $this->variants[] = [
            'condition'  => $condition,
            'callack'    => $probe->getAction(),
            'image'      => $image,
            'label'      => $label,
            'title'      => $title,
            'parameters' => $parameters,
        ];

        return $this;
    }

    public function prepare($object)
    {
        if ($this->resolved) {
            $parentPrepared = parent::prepare($object);
            return $parentPrepared;
        }

        $template = clone $this;
        $template->resolved = true;

        if (($variant = $this->resolveVariant($object)) !== null) {
            $template->action = $variant['callback'];
            $template->setImage($variant['image']);
            $template->setLabel($variant['label']);
            $template->setTitle($variant['title'] ?? $variant['label']);

            foreach($variant['parameters'] ?? [] as $name => $value) {
                $template->setParameter((string) $name, $value);
            }
        } else {
            $template->setDisplayCondition(static fn(): bool => false);
        }

        $prepared = $template->prepare($object);

        if ($prepared instanceof self){
            $prepared->resolved= false;
        }
        
        return $prepared;
       
    }

    private function resolveVariant($object)
    {
        foreach ($this->variants as $variant) {
            if (($variant['condition'])($object)) {
                return $variant;
            }
        }

        return null;
    }
}