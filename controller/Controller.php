<?php
namespace controller;

use view\View;
include_once ("view/View.php");
use model\Model;
include_once ("model/Model.php");

class Controller
{
    private $model;
    private $view;
    //constructor

    public function __construct()
    {
        $this->model = new Model();
        $this->view = new View($this->model);
    }
    public function readPatientenAction(){
        $this->view->showPatienten();
    }
    public function readLoginAction(){
        $this->view->showLogin();
    }
    public function showDrugFormAction($id=null){
        $this->view->showDrugForm($id);
    }
    public function showFormPatientAction($id=null){
        $this->view->showFormPatienten($id);
    }
    public function createPatientAction(){
        $naam = filter_input(INPUT_POST,'naam');
        $adres = filter_input(INPUT_POST,'adres');
        $woonplaats = filter_input(INPUT_POST,'woonplaats');
        $geboortedatum = filter_input(INPUT_POST,'geboortedatum');
        $soortverzekering = filter_input(INPUT_POST,'soortverzekering');
        $zknummer = filter_input(INPUT_POST,'zknummer');
        if ($naam == ""){
            echo "geen naam";
            $this->view->showFormPatienten();
        } else {
            $result = $this->model->insertPatient($naam,$adres,$woonplaats,$geboortedatum,$zknummer,$soortverzekering);
            $this->view->showPatienten($result);
        }
    }
    public function updatePatientAction(){
        $id = filter_input(INPUT_POST,'id');
        $naam = filter_input(INPUT_POST,'naam');
        $adres = filter_input(INPUT_POST,'adres');
        $woonplaats = filter_input(INPUT_POST,'woonplaats');
        $geboortedatum = filter_input(INPUT_POST,'geboortedatum');
        $zknummer = filter_input(INPUT_POST,'zknummer');
        $soortverzekering = filter_input(INPUT_POST,'soortverzekering');
        $result=$this->model->updatePatient($id,$naam,$adres,$woonplaats,$geboortedatum,$zknummer,$soortverzekering);
        $this->view->showPatienten($result);
    }
    public function deletePatientAction($id){
        $result = $this->model->deletePatient($id);
        $this->view->showPatienten($result);
    }
    public function createUserAction(){
        $naam = filter_input(INPUT_POST,'naam');
        $wachtwoord = filter_input(INPUT_POST,'wachtwoord');
        $apotheek = filter_input(INPUT_POST,'apotheek');
        $result = $this->model->insertUser($naam,$wachtwoord,$apotheek);
        //$this->view->showPatienten($result);
    }
    public function loginAction(){
        $naam = filter_input(INPUT_POST,'naam');
        $wachtwoord = filter_input(INPUT_POST,'wachtwoord');
        $this->model->login($naam,$wachtwoord);
        if ($_SESSION['loggedin']=="true"){
            $this->view->showPatienten();
        } else{
            $_SESSION['loggedin']="false";
            $this->view->showLogin();
        }
    }
    public function logoutAction(){
        $this->model->logout();
        $this->view->showLogin();
    }
    public function showDrugsAction(){
        $this->view->showDrugs();
    }
    public function deleteDrugAction($id){
        $result = $this->model->deleteDrug($id);
        $this->view->showDrugs($result);
    }
    public function addDrugAction(){
        $naam = filter_input(INPUT_POST,'naam');
        $maker = filter_input(INPUT_POST,'maker');
        $compensated = filter_input(INPUT_POST,'compensated');
        $side_efect = filter_input(INPUT_POST,'side_efect');
        $benefits = filter_input(INPUT_POST,'benefits');
        if ($naam == ""){
            echo "geen naam";
            $this->view->showDrugForm();
        } else {
            $result = $this->model->addDrug($naam,$maker,$compensated,$side_efect,$benefits);
            $this->view->showDrugs($result);
        }
    }
    public function updateDrugAction(){
        $id = filter_input(INPUT_POST,'id');
        $naam = filter_input(INPUT_POST,'naam');
        $maker = filter_input(INPUT_POST,'maker');
        $compensated = filter_input(INPUT_POST,'compensated');
        $side_efect = filter_input(INPUT_POST,'side_efect');
        $benefits = filter_input(INPUT_POST,'benefits');
        $result=$this->model->updateDrug($id,$naam,$maker,$compensated,$side_efect,$benefits);
        $this->view->showDrugs($result);
    }
}