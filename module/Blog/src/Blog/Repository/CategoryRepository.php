<?php 

namespace Blog\Repository;
 
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;

class CategoryRepository extends EntityRepository
{   
    /**
     * [getList retourne la liste des category en fonction des param]
     * @param  [integer]  $numPage le numéro de la page de résultat
     * @param  integer $limit nb de résultat par page
     * @return Zend\Paginator\Paginator
     */
    public function getList($numPage,$limit = 20)
    {
        $queryBuilder = $this
                            ->createQueryBuilder('c')
                            ->orderBy('c.label','ASC');

        $ORMPaginator     = new ORMPaginator($queryBuilder->getQuery(), false);
        $paginatorAdapter = new DoctrinePaginator($ORMPaginator);
        $paginator        = new Paginator($paginatorAdapter);
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($numPage);

        return $paginator;
    }

    public function getAllOrderBylabel()
    {
        $queryBuilder = $this
                            ->createQueryBuilder('c')
                            ->orderBy('c.label','ASC')
                            ->getQuery()
                            ->getResult();
        return $queryBuilder;
    }
}

?>