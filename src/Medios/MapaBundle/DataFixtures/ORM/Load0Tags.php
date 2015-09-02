<?php
namespace Medios\MapaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Medios\MapaBundle\Entity\Tag;

class LoadTag extends AbstractFixture implements OrderedFixtureInterface,  ContainerAwareInterface
{
	private $container;

	public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
	
    public function load(ObjectManager $manager)
    {

		    $tag1 = new Tag();
		    $tag1->setNombre("Tag1");
		    $tag1->SetAncla(true);
		    $tag1->SetPosx(100);
		    $tag1->SetPosy(100);
		    
		    $tag2 = new Tag();
		    $tag2->setNombre("Tag2");
		    
		    $tag3 = new Tag();
		    $tag3->setNombre("Tag3");
		    
		    $tag4 = new Tag();
		    $tag4->setNombre("Tag4");
		    
		    $tag5 = new Tag();
		    $tag5->setNombre("Tag5");
		    
		    $tag6 = new Tag();
		    $tag6->setNombre("Tag6");
		    
		    $tag7 = new Tag();
		    $tag7->setNombre("Tag7");
		    
		    $tag8 = new Tag();
		    $tag8->setNombre("Tag8");
		    
		    $tag9 = new Tag();
		    $tag9->SetAncla(true);
		    $tag9->setNombre("Tag9");
		    $tag9->SetPosx(450);
		    $tag9->SetPosy(150);
		    
		    $tag10 = new Tag();
		    $tag10->setNombre("Tag10");
		    
		    $tag11 = new Tag();
		    $tag11->setNombre("Tag11");
		    
		    $tag12 = new Tag();
		    $tag12->setNombre("Tag12");
		    
		    $tag13 = new Tag();
		    $tag13->setNombre("Tag13");
		    $tag13->SetAncla(true);
		    $tag13->SetPosx(350);
		    $tag13->SetPosy(0);
		    
		    $tag1->addTagsHijo($tag2);
		    $tag1->addTagsHijo($tag5);
		    $tag1->addTagsHijo($tag10);
		    $tag1->addTagsHijo($tag7);
		    $tag1->addTagsHijo($tag4);
		    $tag1->addTagsHijo($tag8);
		    
		    $tag9->addTagsHijo($tag10);
		    $tag9->addTagsHijo($tag2);
		    $tag9->addTagsHijo($tag12);
		    $tag9->addTagsHijo($tag6);
		    $tag9->addTagsHijo($tag7);
		    
		    $tag13->addTagsHijo($tag3);
		    $tag13->addTagsHijo($tag4);
		    $tag13->addTagsHijo($tag5);
		    $tag13->addTagsHijo($tag8);
		    $tag13->addTagsHijo($tag10);
		    $tag13->addTagsHijo($tag11);
		    
		    $manager->persist($tag1);
		    $manager->persist($tag2);
		    $manager->persist($tag3);
		    $manager->persist($tag4);
		    $manager->persist($tag5);
		    $manager->persist($tag6);
		    $manager->persist($tag7);
		    $manager->persist($tag8);
		    $manager->persist($tag9);
		    $manager->persist($tag10);
		    $manager->persist($tag11);
		    $manager->persist($tag12);
		    $manager->persist($tag13);
		
		    $manager->flush();
		
		    $this->addReference('tag1', $tag1);
		    $this->addReference('tag2', $tag2);
		    $this->addReference('tag3', $tag3);
		    $this->addReference('tag4', $tag4);
		    $this->addReference('tag5', $tag5);
		    $this->addReference('tag6', $tag6);
		    $this->addReference('tag7', $tag7);
		    $this->addReference('tag8', $tag8);
		    $this->addReference('tag9', $tag9);
		    $this->addReference('tag10', $tag10);
		    $this->addReference('tag11', $tag11);
		    $this->addReference('tag12', $tag12);
		    $this->addReference('tag13', $tag13);
	}
	
	public function getOrder()
    {
        return 0;
    }
	
}
