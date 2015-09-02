<?php
namespace Medios\MapaBundle\Entity; 
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Medios\MapaBundle\Entity\Articulo;

/**
 * @ORM\Entity(repositoryClass="Medios\MapaBundle\Repository\TagRepository")
 * @ORM\Table(name="tag")
 */
class Tag
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
	protected $nombre;
    
    /**
     * @ORM\ManyToMany(targetEntity="Articulo", mappedBy="tags")
     **/
    protected $articulos;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Tag", mappedBy="tagsHijos")
     **/
    protected $tagsPadres;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="tagsPadres")
     * @ORM\JoinTable(name="tags_relacion",
     *      joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_hijo_id", referencedColumnName="id")}
     *      )
     **/
    protected $tagsHijos;
    
    /**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $posx;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $posy;
	
	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $ancla;
    
    public function __construct() 
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->articulos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function __toString()
    {
        return $this->nombre;
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
     * Set nombre
     *
     * @param string $nombre
     * @return Tag
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set posx
     *
     * @param integer $posx
     * @return Tag
     */
    public function setPosx($posx)
    {
        $this->posx = $posx;

        return $this;
    }

    /**
     * Get posx
     *
     * @return integer 
     */
    public function getPosx()
    {
        return $this->posx;
    }

    /**
     * Set posy
     *
     * @param integer $posy
     * @return Tag
     */
    public function setPosy($posy)
    {
        $this->posy = $posy;

        return $this;
    }

    /**
     * Get posy
     *
     * @return integer 
     */
    public function getPosy()
    {
        return $this->posy;
    }

    /**
     * Set ancla
     *
     * @param boolean $ancla
     * @return Tag
     */
    public function setAncla($ancla)
    {
        $this->ancla = $ancla;

        return $this;
    }

    /**
     * Get ancla
     *
     * @return boolean 
     */
    public function getAncla()
    {
        return $this->ancla;
    }

    /**
     * Add articulos
     *
     * @param \Medios\MapaBundle\Entity\Articulo $articulos
     * @return Tag
     */
    public function addArticulo(\Medios\MapaBundle\Entity\Articulo $articulos)
    {
        $this->articulos[] = $articulos;

        return $this;
    }

    /**
     * Remove articulos
     *
     * @param \Medios\MapaBundle\Entity\Articulo $articulos
     */
    public function removeArticulo(\Medios\MapaBundle\Entity\Articulo $articulos)
    {
        $this->articulos->removeElement($articulos);
    }

    /**
     * Get articulos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticulos()
    {
        return $this->articulos;
    }

    /**
     * Add tagsPadres
     *
     * @param \Medios\MapaBundle\Entity\Tag $tagsPadres
     * @return Tag
     */
    public function addTagsPadre(\Medios\MapaBundle\Entity\Tag $tagsPadres)
    {
        $this->tagsPadres[] = $tagsPadres;

        return $this;
    }

    /**
     * Remove tagsPadres
     *
     * @param \Medios\MapaBundle\Entity\Tag $tagsPadres
     */
    public function removeTagsPadre(\Medios\MapaBundle\Entity\Tag $tagsPadres)
    {
        $this->tagsPadres->removeElement($tagsPadres);
    }

    /**
     * Get tagsPadres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTagsPadres()
    {
        return $this->tagsPadres;
    }

    /**
     * Add tagsHijos
     *
     * @param \Medios\MapaBundle\Entity\Tag $tagsHijos
     * @return Tag
     */
    public function addTagsHijo(\Medios\MapaBundle\Entity\Tag $tagsHijos)
    {
        $this->tagsHijos[] = $tagsHijos;

        return $this;
    }

    /**
     * Remove tagsHijos
     *
     * @param \Medios\MapaBundle\Entity\Tag $tagsHijos
     */
    public function removeTagsHijo(\Medios\MapaBundle\Entity\Tag $tagsHijos)
    {
        $this->tagsHijos->removeElement($tagsHijos);
    }

    /**
     * Get tagsHijos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTagsHijos()
    {
        return $this->tagsHijos;
    }
}
