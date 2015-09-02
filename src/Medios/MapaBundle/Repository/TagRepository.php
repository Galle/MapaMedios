<?php

namespace Medios\MapaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    public function findAnclas()
    {
        return $query = $this->getEntityManager()
            ->createQuery('
                SELECT t 
                FROM MediosMapaBundle:Tag t
                WHERE t.ancla = 1')
            ->getResult();
    }
    
    public function findNotAnclas()
    {
        return $query = $this->getEntityManager()
            ->createQuery('
                SELECT t 
                FROM MediosMapaBundle:Tag t
                WHERE t.ancla = 0')
            ->getResult();
    }

}
