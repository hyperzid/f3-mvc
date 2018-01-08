<?php

class UserController extends Controller {

    //event before routing:
    function beforeroute() {
    }

    //event after routing:
    function afterroute() {
    }

    public function index()
    {
      $user = new User($this->db);
      $this->f3->set('users',$user->showall());
      $this->f3->set('page_head','User List');
      $this->f3->set('content','users.htm');
      echo \Template::instance()->render('layout.htm');

    }

    public function items() {

      $item = new Item($this->db);
      $this->f3->set('items',$item->all());
      $this->f3->set('page_head','Item List');
      $this->f3->set('content','items.htm');
      echo \Template::instance()->render('layout.htm');

      $this->f3->clear('SESSION.delete_succ');
      $this->f3->clear('SESSION.add_succ');
    }

    public function update() {

      $item = new Item($this->db);
      $item_id = $this->f3->get('PARAMS.itemid');

      if($this->f3->exists('POST.update')) {

        $item_name = $this->f3->get('POST.item_name');
        $item->update_item($item_id, $item_name);

        $logger = new \Log('logs/items-event.log');
        $logger->write('Item ID #' . $item_id . ' has been edited.');

        $this->f3->set('SESSION.update_succ', TRUE);
        $this->f3->reroute('/item/update/' . $this->f3->get('PARAMS.itemid'));

      }


        if($item->existing($item_id)) {

          $this->f3->error(404);

        }

        //$db-exec
        $result = $item->test($item_id);

        //return POST
        $item->getById($item_id);

        $this->f3->set('item', $item);
        $this->f3->set('itemname', $result);
        $this->f3->set('page_head', 'Update/View Item');
        $this->f3->set('content','view-item.htm');
        echo \Template::instance()->render('layout.htm');
        $this->f3->clear('SESSION.update_succ');
    }

    public function delete() {

      $item = new Item($this->db);
      $item_id = $this->f3->get('PARAMS.itemid');
      if($item->existing($item_id)) {

        $this->f3->error(404);

      }
      else {

        $logger = new \Log('logs/items-event.log');
        $logger->write('Item ID #' . $item_id . ' has been deleted.');

        $item->delete($item_id);
        $this->f3->set('SESSION.delete_succ', TRUE);
        $this->f3->reroute('/items');


      }
    }

      public function add() {

        if($this->f3->exists('POST.add')) {
          $item_name = $this->f3->get('POST.item_name');
          $item = new Item($this->db);
          $item->add($item_name);

          $logger = new \Log('logs/items-event.log');
          $logger->write('Item ' . $item_name . ' has been added.');

          $this->f3->set('SESSION.add_succ', TRUE);
          $this->f3->reroute('/items');
        }
        else {

          $this->f3->error(404);

        }

      }


}


?>
