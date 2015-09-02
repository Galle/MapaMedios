<?php
namespace Medios\MapaBundle\Entity; 
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Medios\MapaBundle\Entity\Tag;

/**
 * @ORM\Entity
 * @ORM\Table(name="articulo")
 */
class Articulo
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $titulo;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $bajada;
	
	/**
	 * @ORM\Column(type="date")
	 */
	protected $fecha;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $medio;
	
    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articulos")
     * @ORM\JoinTable(name="articulos_tags")
     **/
    protected $tags;
    
    /**
     * @ORM\ManyToMany(targetEntity="Articulo", mappedBy="articulosHijos")
     **/
    protected $articulosPadres;

    /**
     * @ORM\ManyToMany(targetEntity="Articulo", inversedBy="articulosPadres")
     * @ORM\JoinTable(name="articulos_relacionados",
     *      joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_hijo_id", referencedColumnName="id")}
     *      )
     **/
    protected $articulosHijos;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->articulosPadres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->articulosHijos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fecha = new \DateTime('now');
        $this->medio = "Medios UC";
    }
    
    public function __toString()
    {
        return $this->titulo;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Articulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set bajada
     *
     * @param string $bajada
     * @return Articulo
     */
    public function setBajada($bajada)
    {
        $this->bajada = $bajada;

        return $this;
    }

    /**
     * Get bajada
     *
     * @return string 
     */
    public function getBajada()
    {
        return $this->bajada;
    }

    /**
     * Add tags
     *
     * @param \Medios\MapaBundle\Entity\Tag $tags
     * @return Articulo
     */
    public function addTag(\Medios\MapaBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Medios\MapaBundle\Entity\Tag $tags
     */
    public function removeTag(\Medios\MapaBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    public function hasTag($tag)
    {
        return $this->tags->contains($tag);
    }

    /**
     * Add articulosPadres
     *
     * @param \Medios\MapaBundle\Entity\Articulo $articulosPadres
     * @return Articulo
     */
    public function addArticulosPadre(\Medios\MapaBundle\Entity\Articulo $articulosPadres)
    {
        $this->articulosPadres[] = $articulosPadres;

        return $this;
    }

    /**
     * Remove articulosPadres
     *
     * @param \Medios\MapaBundle\Entity\Articulo $articulosPadres
     */
    public function removeArticulosPadre(\Medios\MapaBundle\Entity\Articulo $articulosPadres)
    {
        $this->articulosPadres->removeElement($articulosPadres);
    }

    /**
     * Get articulosPadres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticulosPadres()
    {
        return $this->articulosPadres;
    }

    /**
     * Add articulosHijos
     *
     * @param \Medios\MapaBundle\Entity\Articulo $articulosHijos
     * @return Articulo
     */
    public function addArticulosHijo(\Medios\MapaBundle\Entity\Articulo $articulosHijos)
    {
        $this->articulosHijos[] = $articulosHijos;

        return $this;
    }

    /**
     * Remove articulosHijos
     *
     * @param \Medios\MapaBundle\Entity\Articulo $articulosHijos
     */
    public function removeArticulosHijo(\Medios\MapaBundle\Entity\Articulo $articulosHijos)
    {
        $this->articulosHijos->removeElement($articulosHijos);
    }

    /**
     * Get articulosHijos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticulosHijos()
    {
        return $this->articulosHijos;
    }
    
    public function getFecha()
    {
        return $this->fecha;
    }
    
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    
    public function getMedio()
    {
        return $this->medio;
    }
    
    public function setMedio($medio)
    {
        $this->medio = $medio;
    }
    
    public function getMedioClass()
    {
        switch ($this->medio) {
            case "Señal UC":
                return "senal";
                break;
            case "Radio UC":
                return "radio";
                break;
            case "KM Cero":
                return "kmcero";
                break;
        }
        return "mediosuc";
    
    }
    
    
}