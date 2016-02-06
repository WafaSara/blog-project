<?php 

namespace Blog\Repository;
 
use Doctrine\ORM\EntityRepository;
 
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
}

?>