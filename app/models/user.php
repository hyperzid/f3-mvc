<?php
class User extends DB\SQL\Mapper {

    public function __construct(DB\SQL $db) {
        parent::__construct($db,'messages');
    }

    public function showall() {
        $this->load();
        return $this->query;
    }

    public function getByName($name) {
        $this->load(array('name=?',$name));
        $this->copyTo('POST');
    }

}

?>
