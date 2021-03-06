<?php
namespace Medios\MapaBundle\Entity; 
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Medios\MapaBundle\Entity\Tag;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $path;
	
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
     * @Assert\Image(maxSize="6000000")
     */
    protected $mainPic;
    
    /**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $isFileChanged = false;

    
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
    
    public function getLogoMedioPath()
    {
        switch ($this->medio) {
            case "Señal UC":
                return "logo_senal_uc.png";
                break;
            case "Radio UC":
                return "logo-radio.jpg";
                break;
            case "KM Cero":
                return "logo-kmcero.png";
                break;
        }
        return "earth.jpg";
    }

    /**
     * Get absolute path
     *
     * @return string 
     */
    public function getAbsolutePath()
    {
        return null === $this->path ? $this->getImageRootDir().$this->getLogoMedioPath() : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * Get web path
     *
     * @return string 
     */
    public function getWebPath()
    {
        return null === $this->path ? $this->getImageDir().$this->getLogoMedioPath(): $this->getUploadDir().'/'.$this->path;
    }

    /**
     * Get upload root dir
     *
     * @return string 
     */
    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'img/article';
    }
    
    /**
     * Get image root dir
     *
     * @return string 
     */    
    protected function getImageRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getImageDir();
    }

    /**
     * Get image dir
     *
     * @return string 
     */
    protected function getImageDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return '../img/';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->mainPic) {
            // do whatever you want to generate a unique name
            $fecha = new \DateTime();
            $this->path = $fecha->getTimestamp().'_'.$this->mainPic->getClientOriginalName();
            $this->isFileChanged = false;
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->mainPic) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->mainPic->move($this->getUploadRootDir(), $this->path);

        unset($this->mainPic);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->mainPic == $this->getAbsolutePath()) {
            unlink($this->mainPic);
        }
    }

    /**
     * Get profile pic
     *
     */
    public function getMainPic()
    {
        return $this->mainPic;
    }
    
    /**
     * Set profile pic
     *
     */
    public function setMainPic($var)
    {
        $this->mainPic = $var;
    }
    
    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    
    
}
