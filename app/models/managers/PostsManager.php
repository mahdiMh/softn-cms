<?php
/**
 * PostsManager.php
 */

namespace SoftnCMS\models\managers;

use SoftnCMS\models\CRUDManagerAbstract;
use SoftnCMS\models\tables\Post;
use SoftnCMS\util\Arrays;
use SoftnCMS\util\MySQL;

/**
 * Class PostsManager
 * @author Nicolás Marulanda P.
 */
class PostsManager extends CRUDManagerAbstract {
    
    const TABLE          = 'posts';
    
    const POST_TITLE     = 'post_title';
    
    const POST_STATUS    = 'post_status';
    
    const POST_DATE      = 'post_date';
    
    const POST_UPDATE    = 'post_update';
    
    const POST_CONTENTS  = 'post_contents';
    
    const COMMENT_STATUS = 'comment_status';
    
    const COMMENT_COUNT  = 'comment_count';
    
    const USER_ID        = 'user_ID';
    
    /**
     * PostsManager constructor.
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * @param int $id
     *
     * @return bool|mixed
     */
    public function getById($id) {
        return parent::getById($id);
    }
    
    /**
     * @return array
     */
    public function read() {
        parent::setColumns('*');
        
        return parent::readData();
    }
    
    /**
     * @param Post $object
     *
     * @return bool
     */
    public function create($object) {
        parent::addPrepareInsert(self::POST_TITLE, $object->getPostTitle(), \PDO::PARAM_STR);
        parent::addPrepareInsert(self::POST_STATUS, $object->getPostStatus(), \PDO::PARAM_INT);
        parent::addPrepareInsert(self::POST_DATE, $object->getPostDate(), \PDO::PARAM_STR);
        parent::addPrepareInsert(self::POST_UPDATE, $object->getPostUpdate(), \PDO::PARAM_STR);
        parent::addPrepareInsert(self::POST_CONTENTS, $object->getPostContents(), \PDO::PARAM_STR);
        parent::addPrepareInsert(self::COMMENT_STATUS, $object->getCommentStatus(), \PDO::PARAM_INT);
        parent::addPrepareInsert(self::COMMENT_COUNT, $object->getCommentCount(), \PDO::PARAM_INT);
        parent::addPrepareInsert(self::USER_ID, $object->getUserID(), \PDO::PARAM_INT);
        
        return parent::createData();
    }
    
    /**
     * @param Post $object
     *
     * @return bool
     */
    public function update($object) {
        parent::addPrepareUpdate(self::POST_TITLE, $object->getPostTitle(), \PDO::PARAM_STR);
        parent::addPrepareUpdate(self::POST_STATUS, $object->getPostStatus(), \PDO::PARAM_INT);
        parent::addPrepareUpdate(self::POST_DATE, $object->getPostDate(), \PDO::PARAM_STR);
        parent::addPrepareUpdate(self::POST_UPDATE, $object->getPostUpdate(), \PDO::PARAM_STR);
        parent::addPrepareUpdate(self::POST_CONTENTS, $object->getPostContents(), \PDO::PARAM_STR);
        parent::addPrepareUpdate(self::COMMENT_STATUS, $object->getCommentStatus(), \PDO::PARAM_INT);
        parent::addPrepareUpdate(self::COMMENT_COUNT, $object->getCommentCount(), \PDO::PARAM_INT);
        parent::addPrepareUpdate(self::USER_ID, $object->getUserID(), \PDO::PARAM_INT);
        
        parent::addPrepareWhere(self::ID, $object->getId(), \PDO::PARAM_INT);
        
        return parent::updateData();
    }
    
    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete($id) {
        parent::addPrepareWhere(self::ID, $id, \PDO::PARAM_INT);
        
        return parent::deleteData();
    }
    
    protected function getTable() {
        return self::TABLE;
    }
    
    protected function buildObjectTable($result, $fetch = MySQL::FETCH_ALL) {
        if (empty($result)) {
            throw new \Exception('Error');
        }
        
        $post = new Post();
        
        switch ($fetch) {
            case MySQL::FETCH_ALL:
                $post->setId(Arrays::get($result, self::ID));
                $post->setUserID(Arrays::get($result, self::USER_ID));
                $post->setCommentCount(Arrays::get($result, self::COMMENT_COUNT));
                $post->setCommentStatus(Arrays::get($result, self::COMMENT_STATUS));
                $post->setPostContents(Arrays::get($result, self::POST_CONTENTS));
                $post->setPostUpdate(Arrays::get($result, self::POST_UPDATE));
                $post->setPostDate(Arrays::get($result, self::POST_DATE));
                $post->setPostStatus(Arrays::get($result, self::POST_STATUS));
                $post->setPostTitle(Arrays::get($result, self::POST_TITLE));
                break;
        }
        
        return $post;
    }
    
}
