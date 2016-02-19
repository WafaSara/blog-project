<?php 

namespace Blog\Repository;
 
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;

class PostRepository extends EntityRepository
{
    public function getByCategory($category)
    {
        $querybuilder = $this->createQueryBuilder('p');

        $result = $querybuilder
        				->where('p.category = :category')
        				->andWhere('p.deleted = :deleted')
        				->orderBy('p.updatedAt','DESC')
        				->setParameters(array(
        					'category' => $category,
        					'deleted' => 0))
        				->getQuery()
        				->getResult();

        return $result;
    }

    /**
     * @param none
     * @return ArrayCollection of Post
     */
    public function getLastPosts()
    {
        $querybuilder = $this->createQueryBuilder('p');

        $result = $querybuilder
        				->where('p.deleted = :deleted')
        				->orderBy('p.updatedAt','DESC')
        				->setParameters(array(
        					'deleted' => 0))
        				->setMaxResults(10)
        				->getQuery()
        				->getResult();

        return $result;
    }

    /**
     * [getList retourne la liste des posts en fonction des param]
     * @param  [integer]  $numPage le numéro de la page de résultat
     * @param  integer $limit nb de résultat par page
     * @param  array tabFiltre
     * @return Zend\Paginator\Paginator
     */
    public function getList($numPage,$limit = 10)
    {
        $queryBuilder = $this
                            ->createQueryBuilder('p')
                            ->orderBy('p.updatedAt','DESC');

        $ORMPaginator     = new ORMPaginator($queryBuilder->getQuery(), false);
        $paginatorAdapter = new DoctrinePaginator($ORMPaginator);
        $paginator        = new Paginator($paginatorAdapter);
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($numPage);

        return $paginator;
    }

}

?>