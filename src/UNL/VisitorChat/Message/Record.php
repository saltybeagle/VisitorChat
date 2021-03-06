<?php
namespace UNL\VisitorChat\Message;

class Record extends \Epoch\Record
{
    public $id;
    public $users_id;
    public $conversations_id;
    public $date_created;
    public $message;
    
    public static function getByID($id)
    {
        return self::getByAnyField('\UNL\VisitorChat\Message\Record', 'id', (int)$id);
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
        return 'messages';
    }
    
    function getPoster()
    {
        return \UNL\VisitorChat\User\Record::getByID($this->users_id);
    }
    
    function getEditURL()
    {
        //Inorder for operators to stay in the current chat, we need to pass the conversation id along.
        $conversation_id = "";
        if (isset($_GET['conversation_id'])) {
            $conversation_id = "?conversation_id=" . $_GET['conversation_id'];
        }
        
        return \UNL\VisitorChat\Controller::$URLService->generateSiteURL("conversation" . $conversation_id, true, true);
    }
    
    function save()
    {
        $this->message = nl2br($this->message);
        parent::save();
    }
    
    function getConversation()
    {
        return \UNL\VisitorChat\Conversation\Record::getByID($this->conversations_id);
    }
}