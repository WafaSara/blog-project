<?php 

namespace Blog\Repository;
 
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;

class CommentRepository extends EntityRepository
{
    /**
     * [getList retourne la liste des category en fonction des param]
     * @param  [integer]  $numPage le numéro de la page de résultat
     * @param  integer $limit nb de résultat par page
     * @return Zend\Paginator\Paginator
     */
    public function getList($numPage,$limit = 10, $tabFiltre)
    {
        $queryBuilder = $this->createQueryBuilder('c');

        if(!empty($tabFiltre['post']))
        {
            $queryBuilder = $queryBuilder->andWhere('c.post = :post')
                                        ->setParameter('post',$tabFiltre['post']);
        }

        $queryBuilder = $queryBuilder->orderBy('c.updatedAt','DESC');

        $ORMPaginator     = new ORMPaginator($queryBuilder->getQuery(), false);
        $paginatorAdapter = new DoctrinePaginator($ORMPaginator);
        $paginator        = new Paginator($paginatorAdapter);
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($numPage);

        return $paginator;
    }
}

?>