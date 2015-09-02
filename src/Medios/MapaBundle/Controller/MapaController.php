<?php

namespace Medios\MapaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Medios\MapaBundle\Entity\Articulo;
use Medios\MapaBundle\Entity\Tag;

class MapaController extends Controller
{
    public function contarSimilares($articulo,$tag)
    {
        $coincidencias = 0;
        if ($articulo->hasTag($tag)
            $coincidencias++;
        foreach ($tag->getTagsHijos as $tagH)
        {
            $coincidencias+= $this->contarSimilares($articulo,$tagH);
        }
        return $coincidencias;
    }
    
    
}
