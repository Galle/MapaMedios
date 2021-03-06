<?php

namespace Medios\MapaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MediosMapaBundle:Default:index.html.twig');
    }
    
    public function d3Action()
    {
        return $this->render('MediosMapaBundle:Default:d3.html.twig');
    }
    
    public function d32Action()
    {
        return $this->render('MediosMapaBundle:Default:d32.html.twig');
    }
    
    public function d33Action()
    {
        return $this->render('MediosMapaBundle:Default:d33.html.twig');
    }
    
    public function sigmaAction()
    {
        return $this->render('MediosMapaBundle:Default:sigma.html.twig');
    }
    
    public function d3jsonAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nodos_array = array();
        $tag_id= array();
        $tag_index = 0;
        $links_array = array();
        $grupo = 1;
        

        $anclas = $em->getRepository('MediosMapaBundle:Tag')->findAnclas();   
        
        foreach($anclas as $ancla)
        {
            $nodos_array[] = array("name"=>$ancla->getNombre(),"group"=>$grupo, 'classname' => 'ancla');
            $tag_id[$ancla->getId()][] = $tag_index;
            $ancla_index = $tag_index;
            $tag_index++;
            foreach($ancla->getTagsHijos() as $tag)
            {
                $nodos_array[] = array("name"=>$tag->getNombre(),"group"=>$grupo, 'classname' => 'tag');
                $tag_id[$tag->getId()][] = $tag_index;
                $links_array[] = array("source" => $ancla_index ,"target" => $tag_index,"classname" => 'ancla_tag');
                $tag_index++;
            }
            $grupo++;
        }
        
        $articulos = $em->getRepository('MediosMapaBundle:Articulo')->findAll();   
        
        foreach($articulos as $articulo)
        {
            $nodos_array[] = array("name"=>$articulo->getTitulo(),"group"=>$grupo, 'classname' => 'articulo');
            foreach($articulo->getTags() as $tag)
            {
                if (array_key_exists($tag->getId(),$tag_id))
                {
                    foreach($tag_id[$tag->getId()] as $semitag)
                    {
                        $links_array[] = array("source" => $tag_index ,"target" => $semitag,'classname' => 'tag_articulo');
                    }
                }
            }
            $tag_index++;
        }
        
        $retorno = array("nodes"=>$nodos_array,"links"=>$links_array);
        $response = new Response(json_encode($retorno));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    private function recursiveNode(&$tag_id, &$links_array, &$tag_index, &$nodos_array, $tag, $padre, $grupo)
    {
        
        $tag_padre = $tag_index;
        $nodos_array[] = array("name"=>$tag->getNombre(),"group"=>$grupo, 'classname' => 'tag', 'fuerzas' => array());
        $tag_id[$tag->getId()][] = array('index'=>$tag_index,'grupo'=>$grupo);
        $links_array[] = array("source" => $padre ,"target" => $tag_index,"classname" => 'ancla_tag');
        $tag_index++; 
        
        foreach($tag->getTagsHijos() as $tagHijo)
        {
            $this->recursiveNode($tag_id, $links_array, $tag_index, $nodos_array, $tagHijo, $tag_padre, $grupo);
        }
        
    }
    
    public function d3json2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $nodos_array = array();
        $tag_id= array();
        $tag_index = 0;
        $links_array = array();
        $grupo = 1;
        // $x = 16*cos($angulo);
        // $y = 9*sin($angulo);
        // deg2rad();

        $anclas = $em->getRepository('MediosMapaBundle:Tag')->findAnclas();   
        $cantidad = count($anclas);
        $contador = 0;
        $angulo = 0;
        $escala = 200;
        
        foreach($anclas as $ancla)
        {
            $angulo = $contador*360/$cantidad;
            $nodos_array[] = array("name"=>$ancla->getNombre(),"group"=>$grupo,'x' =>$escala*8*cos(deg2rad(90+$angulo)), 'y' =>$escala*5*sin(deg2rad(90+$angulo)), 'classname' => 'ancla', 'fuerzas' => array());
            $tag_id[$ancla->getId()][] = array('index'=>$tag_index,'grupo'=>$grupo);
            $ancla_index = $tag_index;
            $tag_index++;
            
            /*foreach($ancla->getTagsHijos() as $tag)
            {
                $nodos_array[] = array("name"=>$tag->getNombre(),"group"=>$grupo, 'classname' => 'tag', 'fuerzas' => array());
                $tag_id[$tag->getId()][] = $tag_index;
                $links_array[] = array("source" => $ancla_index ,"target" => $tag_index,"classname" => 'ancla_tag');
                $tag_index++;
            }*/
            
            foreach($ancla->getTagsHijos() as $tag)
            {
                $this->recursiveNode($tag_id, $links_array, $tag_index, $nodos_array, $tag, $ancla_index, $grupo);
            }
            
            $grupo++;
            $contador++;
        }
        
        //Articulos
        $articulos = $em->getRepository('MediosMapaBundle:Articulo')->findAll();   
        $x = 0; $y=0;
        foreach($articulos as $articulo)
        {
            //Ver que grupo es el más frecuente
            $grupo_count = array();
            
            //Busca el tag y todas sus copias en las distintas anclas
            $fuerzas_temp = array();
            foreach($articulo->getTags() as $tag)
            {
                if (array_key_exists($tag->getId(),$tag_id))
                {
                    foreach($tag_id[$tag->getId()] as $semitag)
                    {
                        $fuerzas_temp[] = array('nodo' => $semitag['index'], 'grupo' => $semitag['grupo']);
                        if(array_key_exists($semitag['grupo'],$grupo_count))
                        {
                            $grupo_count[$semitag['grupo']]+=1;
                        }
                        else
                        {
                            $grupo_count[$semitag['grupo']]=1;
                        }
                        //$links_array[] = array("source" => $tag_index ,"target" => $semitag,'classname' => 'tag_articulo');
                    }
                }
            }
            
            $grupo_tag = array_keys($grupo_count, max($grupo_count));
            arsort($grupo_count);
            $keys = array_keys($grupo_count);
            $grupo_diff= $grupo_count[$keys[0]] - $grupo_count[$keys[1]];
            
            
            //crea el nodo
            $nodos_array[] = array(
                                "name"=>$articulo->getTitulo(),
                                "group"=>$grupo,
                                'x' => $x, 'y' => $y, 
                                'classname' => 'articulo',
                                'medio' => $articulo->getMedio(),
                                'medioClass' => $articulo->getMedioClass(),  
                                'fuerzas' => $fuerzas_temp,
                                'titulo' => $articulo->getTitulo(), 
                                'bajada' => $articulo->getBajada(),
                                'img_path' => $articulo->getWebPath(),
                                'grupo_tag' => $grupo_tag,
                                'grupo_weight' => 1.1+$grupo_diff/count($articulo->getTags()),
                                'fecha' => $articulo->getFecha()->format('h:i d/m/Y'));
            $tag_index++;
            
            //posicion inicial pre convergencia
            ($x+$y)%2==0 ? $x++ : $y++;
        }
        
        //Links entre el mismo tag en distintas anclasl
        foreach($tag_id as $nodos)
        {
            if(count($nodos) > 1)
            {
                foreach ($nodos as $nodo)
                {
                    for($i=0;$i<count($nodos);$i++)
                    {
                        if ($nodo != $nodos[$i])
                        {
                            $links_array[] = array('source'=>$nodo['index'], 'target' => $nodos[$i]['index'], 'classname' => 'tags');
                        }
                    }
                }    
            }
        }
        
        $retorno = array("nodes"=>$nodos_array,"links"=>$links_array);
        $response = new Response(json_encode($retorno));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    public function sigmajsonAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nodos_array = array();
        $tag_id= array();
        $tag_index = 0;
        $links_array = array();
        $grupo = 1;
        $id_links = 0;
        srand(24);
        

        $anclas = $em->getRepository('MediosMapaBundle:Tag')->findAnclas();   
        
        foreach($anclas as $ancla)
        {
            $nodos_array[] = array("label"=>$ancla->getNombre(),"color"=>'#0FD456', 'x' => rand(0,300), 'y' => rand(0,300), 'id' => $tag_index.'', 'size' => 40);
            $tag_id[$ancla->getId()][] = $tag_index;
            $ancla_index = $tag_index;
            $tag_index++;
            foreach($ancla->getTagsHijos() as $tag)
            {
                $nodos_array[] = array("label"=>$tag->getNombre(), "color"=>'#555555', 'x' => rand(0,300), 'y' => rand(0,300), 'id' => $tag_index.'', 'size' => 15 );
                $tag_id[$tag->getId()][] = $tag_index;
                $links_array[] = array("source" => $ancla_index.'' ,"target" => $tag_index.'',"id" => $id_links.'', 'edgeWeight' => 100);
                $tag_index++;
                $id_links++;
            }
            $grupo++;
        }
        
        $articulos = $em->getRepository('MediosMapaBundle:Articulo')->findAll();   
        
        foreach($articulos as $articulo)
        {
            $nodos_array[] = array("label"=>$articulo->getTitulo(), "color"=>'#E56351', 'x' => rand(0,300), 'y' => rand(0,300), 'id' =>$tag_index.'', 'size' => 30 );
            foreach($articulo->getTags() as $tag)
            {
                if (array_key_exists($tag->getId(),$tag_id))
                {
                    foreach($tag_id[$tag->getId()] as $semitag)
                    {
                        $links_array[] = array("source" => $tag_index.'' ,"target" => $semitag.'','id' => $id_links.'', 'edgeWeight' => 10);
                        $id_links++;
                    }
                }
            }
            $tag_index++;
        }
        
        $retorno = array("nodes"=>$nodos_array,"edges"=>$links_array);
        $response = new Response(json_encode($retorno));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    public function sigmajson2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $nodos_array = array();
        $tag_id= array();
        $tag_index = 0;
        $links_array = array();
        $grupo = 1;
        $id_links = 0;
        srand(24);

        $anclas = $em->getRepository('MediosMapaBundle:Tag')->findAnclas();   
        
        foreach($anclas as $ancla)
        {
            $nodos_array[] = array("label"=>$ancla->getNombre(),"color"=>'#0FD456', 'x' => rand(0,300), 'y' => rand(0,300), 'id' => $tag_index.'', 'size' => 40);
            $tag_id[$ancla->getId()][] = $tag_index;
            $ancla_index = $tag_index;
            $tag_index++;
            foreach($ancla->getTagsHijos() as $tag)
            {
                $tag_id[$tag->getId()][] = $ancla_index;
            }
        }
        
        $articulos = $em->getRepository('MediosMapaBundle:Articulo')->findAll();   
        
        foreach($articulos as $articulo)
        {
            $nodos_array[] = array("label"=>$articulo->getTitulo(), "color"=>'#E56351', 'x' => rand(0,300), 'y' => rand(0,300), 'id' =>$tag_index.'', 'size' => 30 );
            foreach($articulo->getTags() as $tag)
            {
                if (array_key_exists($tag->getId(),$tag_id))
                {
                    $memoria = array();
                    $peso = 0;
                    foreach($tag_id[$tag->getId()] as $semitag)
                    {
                        $links_array[] = array("source" => $tag_index.'' ,"target" => $semitag.'','id' => $id_links.'');
                        $id_links++;
                    }
                }
            }
            $tag_index++;
        }
        
        $retorno = array("nodes"=>$nodos_array,"edges"=>$links_array);
        $response = new Response(json_encode($retorno));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}

