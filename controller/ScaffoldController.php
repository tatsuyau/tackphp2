<?php
// Scaffoldを使う場合は、このクラスを継承してください。
// 対象のModelと同じControllerClass命名をしてください。
class ScaffoldController extends Controller
{
    // model_nameを指定するとControllerの名前に左右されずにModelを指定できる。
    protected $model_name;

    public function __construct()
    {
        parent::__construct();
        $model_name = $this->_getModelName();
        $this->ScaffoldModel = new $model_name();
        $this->model_name = $model_name;
    }

    public function index()
    {
        if (!$this->ScaffoldModel->hasTable()) {
            $this->redirect($this->controller_name . "/start");
        }
        $primary_key = $this->_getPrimaryKey();
        $column_list = $this->ScaffoldModel->getColumnList();
        $list = $this->ScaffoldModel->getList();
        $this->set("primary_key", $primary_key);
        $this->set("column_list", $column_list);
        $this->set("list", $list);
        $this->render("scaffold/index");
    }

    public function view($id)
    {
        $primary_key = $this->_getPrimaryKey();
        $data = $this->ScaffoldModel->getData(array($primary_key => $id));
        if (!$data) {
            $this->error();
        }
        $this->set("data", $data);
        $this->render("scaffold/view");
    }

    public function edit($id)
    {
        $primary_key = $this->_getPrimaryKey();
        if (Request::hasPost()) {
            $this->begin();
            $res = $this->ScaffoldModel->setData(Request::getParams("POST"), array($primary_key => $id));
            $this->commit();
        }
        $data = $this->ScaffoldModel->getData(array($primary_key => $id));
        if (!$data) {
            $this->error();
        }
        $this->set("data", $data);
        $this->render("scaffold/edit");
    }

    public function add()
    {
        if (Request::hasPost()) {
            $this->ScaffoldModel->addData(Request::getParams("POST"));
            $this->redirect($this->controller_name);
        }
        $column_list = $this->ScaffoldModel->getColumnList();
        $this->set("column_list", $column_list);
        $this->render("scaffold/add");
    }

    public function delete($id)
    {
        $primary_key = $this->_getPrimaryKey();
        $data = $this->ScaffoldModel->getData(array($primary_key => $id));
        if (!$data) {
            $this->error();
        }
        $res = $this->ScaffoldModel->deleteData(array($primary_key => $id));
        $this->redirect($this->controller_name);
    }

    public function start($install = false)
    {
        if ($this->ScaffoldModel->hasTable()) {
            $this->redirect($this->controller_name);
        }
        $has_created = false;
        if ($install) {
            $this->ScaffoldModel->createTable();
            $has_created = true;
        }
        $this->set("table_name", $this->ScaffoldModel->getTableName());
        $this->set("has_created", $has_created);
        $this->render("scaffold/start");
    }

    protected function _getModelName()
    {
        if ($this->model_name) {
            return $this->model_name;
        }

        return substr(get_class($this), 0, strpos(get_class($this), "Controller"));
    }

    protected function _getPrimaryKey()
    {
        $column_list = $this->ScaffoldModel->getColumnList();
        if (!$column_list) {
            $this->error();
        }
        $primary_key = $column_list[0];    // index:0をprimaryKeyとしよう。
        return $primary_key;
    }
}
