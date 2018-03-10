<?php
class Item extends DB\SQL\Mapper {

    public function __construct(DB\SQL $db) {
        parent::__construct($db,'items');
    }

    public function all() {

      $this->load();
      return $this->query;

    }

    public function getById($id) {

      $this->load(array('id=?',$id));
      $this->copyTo('POST');

    }

    public function existing($id) {

      $this->load(array('id=?',$id));
      //check if id has no match return true
      if($this->dry()) return true;

    }

    public function test($id) {

      $this->db->exec('SELECT item FROM items WHERE id = 1');
      return $this->item;

    }

    public function update_item($id, $item_name) {

      $this->load(array('id = ?', $id));
      $this->item = $item_name;
      $this->update();

    }

    public function delete($id) {

      $this->load(array('id = ?', $id));
      $this->erase();

    }

    public function add($item_name) {

      $this->reset();
      $this->item = $item_name;
      $this->save();

    }

}

?>
