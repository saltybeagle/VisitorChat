<?php
namespace UNL\VisitorChat\User;

class Record extends \Epoch\Record
{
    public $id;
    public $uid;
    public $name;
    public $email;
    public $date_created;
    public $date_updated;
    public $ip;
    public $type; //Client or Operator
    public $max_chats;
    public $status;
    
    public static function getByID($id)
    {
        return self::getByAnyField('\UNL\VisitorChat\User\Record', 'id', (int)$id);
    }
    
    public static function getByUID($uid)
    {
        return self::getByAnyField('\UNL\VisitorChat\User\Record', 'uid', $uid);
    }
    
    public static function getByEmail($email)
    {
        return self::getByAnyField('\UNL\VisitorChat\User\Record', 'email', $email);
    }

    function insert()
    {
        return parent::insert();
    }
    
    function keys()
    {
        return array('id');
    }
    
    public static function getTable()
    {
        return 'users';
    }
    
    public static function getCurrentUser()
    {
        if (isset($_SESSION['id'])) {
            return self::getByID($_SESSION['id']);
        }
        
        return false;
    }
    
    function ping()
    {
        $this->date_updated = \UNL\VisitorChat\Controller::epochToDateTime();
        $this->save();
    }
    
    function getConversation()
    {
        return \UNL\VisitorChat\Conversation\Record::getLatestForClient($this->id);
    }
    
    /**
     * returns the total number of messages in all open
     * conversations that this user is assigned to and the 
     * total number of read messages for each conversation.
     * 
     * @return int messageCount
     */
    function getCurrentUnreadMessageCounts()
    {
        $totals = array();
        
        $conversations = \UNL\VisitorChat\Conversation\RecordList::getOpenConversations($this->id);
        
        foreach($conversations as $conversation) {
            $totals[$conversation->id] = $conversation->getUnreadMessageCount();
        }
        
        return $totals;
    }
}