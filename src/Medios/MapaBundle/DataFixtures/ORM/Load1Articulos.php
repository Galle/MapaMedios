<?php
namespace Medios\MapaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Medios\MapaBundle\Entity\Articulo;

class LoadArticulo extends AbstractFixture implements OrderedFixtureInterface,  ContainerAwareInterface
{
	private $container;

	public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
	
    public function load(ObjectManager $manager)
    {

		    $articulo1 = new Articulo();
		    $articulo1->setTitulo("Titulo");
		    $articulo1->setBajada("Bajada");
		    $articulo1->setMedio("Radio UC");
		    $manager->persist($articulo1);
		    
		    $articulo2 = new Articulo();
		    $articulo2->setTitulo("Titulo");
		    $articulo2->setBajada("Bajada");
		    $articulo2->setMedio("Medios UC");
		    $manager->persist($articulo2);
		    
		    $articulo3 = new Articulo();
		    $articulo3->setTitulo("Titulo");
		    $articulo3->setBajada("Bajada");
		    $articulo3->setMedio("Señal UC");
		    $manager->persist($articulo3);
		    
		    $articulo4 = new Articulo();
		    $articulo4->setTitulo("Titulo");
		    $articulo4->setBajada("Bajada");
		    $articulo4->setMedio("Radio UC");
		    $manager->persist($articulo4);
		    
		    $articulo5 = new Articulo();
		    $articulo5->setTitulo("Titulo");
		    $articulo5->setBajada("Bajada");
		    $articulo5->setMedio("Medios UC");
		    $manager->persist($articulo5);
		    
		    $articulo6 = new Articulo();
		    $articulo6->setTitulo("Titulo");
		    $articulo6->setBajada("Bajada");
		    $articulo6->setMedio("KM Cero");
		    $manager->persist($articulo6);
		    
		    $articulo1->addTag($manager->merge($this->getReference('tag1')));
		    $articulo1->addTag($manager->merge($this->getReference('tag6')));
		    $articulo1->addTag($manager->merge($this->getReference('tag8')));
		    $articulo1->addTag($manager->merge($this->getReference('tag11')));
		    $articulo1->addTag($manager->merge($this->getReference('tag12')));
		    $articulo1->addTag($manager->merge($this->getReference('tag13')));
		    
		    $articulo2->addTag($manager->merge($this->getReference('tag2')));
		    $articulo2->addTag($manager->merge($this->getReference('tag4')));
		    $articulo2->addTag($manager->merge($this->getReference('tag5')));
		    $articulo2->addTag($manager->merge($this->getReference('tag8')));
		    
		    $articulo3->addTag($manager->merge($this->getReference('tag1')));
		    $articulo3->addTag($manager->merge($this->getReference('tag3')));
		    $articulo3->addTag($manager->merge($this->getReference('tag4')));
		    $articulo3->addTag($manager->merge($this->getReference('tag10')));
		    $articulo3->addTag($manager->merge($this->getReference('tag6')));
		    $articulo3->addTag($manager->merge($this->getReference('tag11')));
		    
		    $articulo4->addTag($manager->merge($this->getReference('tag8')));
		    $articulo4->addTag($manager->merge($this->getReference('tag9')));
		    $articulo4->addTag($manager->merge($this->getReference('tag10')));
		    
		    $articulo5->addTag($manager->merge($this->getReference('tag5')));
		    $articulo5->addTag($manager->merge($this->getReference('tag7')));
		    $articulo5->addTag($manager->merge($this->getReference('tag13')));
		    $articulo5->addTag($manager->merge($this->getReference('tag9')));
		    $articulo5->addTag($manager->merge($this->getReference('tag3')));
		    
		    $articulo6->addTag($manager->merge($this->getReference('tag1')));
		    $articulo6->addTag($manager->merge($this->getReference('tag2')));
		    $articulo6->addTag($manager->merge($this->getReference('tag3')));
		    $articulo6->addTag($manager->merge($this->getReference('tag4')));
		    $articulo6->addTag($manager->merge($this->getReference('tag5')));
		    $articulo6->addTag($manager->merge($this->getReference('tag6')));
		    $articulo6->addTag($manager->merge($this->getReference('tag7')));
		    $articulo6->addTag($manager->merge($this->getReference('tag8')));
		    $articulo6->addTag($manager->merge($this->getReference('tag9')));
		    $articulo6->addTag($manager->merge($this->getReference('tag10')));
		    $articulo6->addTag($manager->merge($this->getReference('tag11')));
		    $articulo6->addTag($manager->merge($this->getReference('tag12')));
		    $articulo6->addTag($manager->merge($this->getReference('tag13')));
		    
		    
		    $manager->flush();
		
		    /*$this->addReference('articulo-1', $articulo1);
		    $this->addReference('articulo-2', $articulo2);
		    $this->addReference('articulo-3', $articulo3);
		    $this->addReference('articulo-4', $articulo4);
		    $this->addReference('articulo-5', $articulo5);
		    $this->addReference('articulo-6', $articulo6);*/
	}
	
	public function getOrder()
    {
        return 1;
    }
	
}
