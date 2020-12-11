<?php
namespace view;
use model\Model;
include_once ('model/Model.php');
use model\Patient;
include_once('model/Patient.php');
use model\User;
include_once ('model/User.php');
class View
{

    private $model;
    public function __construct($model){
        $this->model = $model;
    }

    public function showPatienten($result = null){
        $patienten = $this->model->getPatienten();
        $users = $this->model->getUser($_SESSION['user']);

        /*de html template */
        echo "<!DOCTYPE html>
                <html lang=\"en\">
                <head>
                    <meta charset=\"UTF-8\">
                    <title>Overzicht patienten</title>
                    <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>
                </head>
                <body>";
        echo "
                            <div class='d-flex justify-content-center'>
                                <div><h2>profile</h2>
                                <a>Ingelogd als, </a>$users->name<br />
                                <a>Gebruikersrechten, </a>$users->apotheek<br />
                               <form action='index.php' method='post'>
                                <input type='hidden' name='logout' value='0'>
                                <input class='btn btn-outline-secondary' type='submit' value='logout'/>
                               </form></div><br />
                            </div>
                            <div class='d-flex justify-content-center'>
                               <div><h2>Drugs</h2>
                               <form action='index.php' method='post'>
                               <input type='hidden' name='showDrugs'>
                               <input class='btn btn-outline-secondary' type='submit' value='Drugs'>
                               </form>
                               </div><br />
                            </div>
                            <div class='d-flex justify-content-center'>
                               <h2>Patienten overzicht</h2> <form action='index.php' method='post'>
                            </div>"; if ($_SESSION['roles'] == 'arts' || $_SESSION['roles'] == 'admin'){
                                echo "
                            <div class='d-flex justify-content-center'>
                               <input type='hidden' name='showForm' value='0'>
                               <input class='btn btn-outline-secondary' type='submit' value='toevoegen'/>
                               </form></div><br />
                            </div>
                                </body></html>";}
        if($patienten !== null) { echo "
                        <div class='row d-flex justify-content-center'>";
            foreach ($patienten as $patient) {
                echo "<div class='col-sm-12 col-md-6 col-lg-4 jumbotron'>
                        <div class='d-flex justify-content-center'>
                                      $patient->naam<br />
                                      $patient->adres<br />
                                      $patient->woonplaats<br />
                                      $patient->zknummer<br />
                                      $patient->geboortedatum<br />
                                      $patient->soortverzekering<br />
                        </div>"; if($_SESSION['roles'] == 'arts' || $_SESSION['roles'] == 'admin'){echo"
                        <div class='d-flex justify-content-center'>
                                      <form action='index.php' method='post'>
                                       <input type='hidden' name='showForm' value='$patient->id'><input class='btn btn-outline-secondary' type='submit' value='wijzigen'/></form>
                                        <form action='index.php' method='post'>
                                       <input type='hidden' name='delete' value='$patient->id'><input class='btn btn-outline-secondary' type='submit' value='verwijderen'/></form>
                        </div>";}
            }
        }
        else{
            echo "Geen patienten gevonden";
        }
    }

    public function showFormPatienten($id=null){
        if($id !=null && $id !=0){
            $patient = $this->model->selectPatient($id);
        }
        /*de html template */
        echo "<!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <title>Beheer patientengegevens</title>
                    <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>
        </head><body>";

        if(isset($patient)){
            echo "<div class='jumbotron'><div class='d-flex justify-content-center'><h2>Formulier patientgegevens</h2></div>
        <div class='d-flex justify-content-center'>
        <form method='post' >
        <table>
            <tr><td></td><td>
                <input type=\"hidden\" name=\"id\" value='$id'/></td></tr>
             <tr><td>   <label for=\"naam\">Patient naam</label></td><td>
                <input type=\"text\" name=\"naam\" value= '".$patient->naam."'/></td></tr>
            <tr><td>
                <label for=\"adres\">adres</label></td><td>
                <input type=\"text\" name=\"adres\" value = '".$patient->adres."'/></td></tr>
            <tr><td>
                <label for=\"woonplaats\">woonplaats</label></td><td>
                <input type=\"text\" name=\"woonplaats\" value= '".$patient->woonplaats."'/></td></tr>
            <tr><td>
                <label for=\"geboortedatum\">geboortedatum</label></td><td>
                <input type=\"text\" name=\"geboortedatum\" value= '".$patient->geboortedatum."'/></td></tr>
            <tr><td>
                <label for=\"zknummer\">zknummer</label></td><td>
                <input type=\"text\" name=\"zknummer\" value= '".$patient->zknummer."'/></td></tr>
                 <tr><td>
                <label for=\"soortverzekering\">soortverzekering</label></td><td>
                <input type=\"text\" name=\"soortverzekering\" value= '".$patient->soortverzekering."'/></td></tr>
            <tr><td>
                <input class='btn btn-outline-secondary' type='submit' name='update' value='opslaan'></td><td>
            </td></tr></table>
            </form></div></div><div class='d-flex justify-content-center'>
            <form action='index.php' method='post'>
            <input type='hidden' name='showPatienten' value='0'>
            <input class='btn btn-outline-secondary' type='submit' value='terug'/>
            </form>
            </div>" .
                "
        </body>
        </html>";
        }
        else{
            /*de html template */
            echo "<div class='jumbotron'><div class='d-flex justify-content-center'><h2>Formulier patientgegevens</h2></div>
        <div class='d-flex justify-content-center'>
        <form method='post' action='index.php'>
        <table>
            <tr><td></td><td>
                <input type=\"hidden\" name=\"id\" value=''/></td></tr>
             <tr><td>   <label for=\"naam\">Patient naam</label></td><td>
                <input type=\"text\" name=\"naam\" value= ''/></td></tr>
            <tr><td>
                <label for=\"adres\">adres</label></td><td>
                <input type=\"text\" name=\"adres\" value = ''/></td></tr>
            <tr><td>
                <label for=\"woonplaats\">woonplaats</label></td><td>
                <input type=\"text\" name=\"woonplaats\" value= ''/></td></tr>
            <tr><td>
                <label for=\"geboortedatum\">geboortedatum</label></td><td>
                <input type=\"text\" name=\"geboortedatum\" value= ''/></td></tr>
            <tr><td>
                <label for=\"zknummer\">zknummer</label></td><td>
                <input type=\"text\" name=\"zknummer\" value= ''/></td></tr>
                 <tr><td>
                <label for=\"soortverzekering\">soortverzekering</label></td><td>
                <input type=\"text\" name=\"soortverzekering\" value= ''/></td></tr>
            <tr><td>
                <input class='btn btn-outline-secondary' type='submit' name='create' value='opslaan'></td><td>
            </td></tr></table>
            </form></div></div>
            <div class='d-flex justify-content-center'>
            <form action='index.php' method='post'>
            <input type='hidden' name='showPatienten' value='0'>
            <input class='btn btn-outline-secondary' type='submit' value='terug'/>
            </form>
            </div>
        </body>
        </html>";
        }
    }

    public function showLogin(){
        echo "<!DOCTYPE html>
                <html lang=\"en\">
                <head>
                    <meta charset=\"UTF-8\">
                    <title>Overzicht patienten</title>
                    <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>
                </head>
                <body>      
                <div class='col-sm-4 container-fluid pt-5 bg-light '>
                <h2 class='d-flex justify-content-center'>Login</h2>
                <form method='post' action='index.php'>
                <table class='login .table-dark' >
                    <div>
                        <input type=\"hidden\" name=\"id\" value=''/>
                    </div><div class='d-flex justify-content-center'>   
                        <label class='form-group' for=\"naam\">user naam</label>
                        </div><div class='d-flex justify-content-center'>
                        <input class='form-group d-flex justify-content-center' type=\"text\" name=\"naam\" value= ''/>                              
                    </div><div class='d-flex justify-content-center'>
                        <label class='form-group' for=\"wachtwoord\">wachtwoord</label>
                        </div><div class='d-flex justify-content-center'>
                        <input class='form-group d-flex justify-content-center' type=\"text\" name=\"wachtwoord\" value = ''/>
                    </div><div class='d-flex justify-content-center'>
                        <input class='form-group d-flex justify-content-center btn btn-outline-secondary' type='submit' name='login' value='login'>
                    </div>
                </table>
                </form>
                </div>                     
                </body>
                </html>";
    }
    public function showDrugs(){
        $drugs = $this->model->getDrugs();
        echo "<!DOCTYPE html>
                <html lang=\"en\">
                <head>
                    <meta charset=\"UTF-8\">
                    <title>Overzicht patienten</title>
                    <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>
                    <style>
                    </style>
                </head>
                <body>";
        echo "<div class='d-flex justify-content-center'><h2>Terug</h2></div>
            <div class='d-flex justify-content-center'>
                <form action='index.php' method='post'>
                               <input type='hidden' name='showPatienten' value='0'>
                               <input class='btn btn-outline-secondary' type='submit' value='terug'/>
                               </form>
            </div>
                <div class='d-flex justify-content-center'><h2>Drugs</h2></div>
            <div class='d-flex justify-content-center'>
                <form action='index.php' method='post'>
                               <input type='hidden' name='showDrugForm' value='0'>
                               <input class='btn btn-outline-secondary' type='submit' value='toevoegen'/>
                               </form>
            </div>
              <br />";
        if($drugs !== null) { echo "
                        <div class='row d-flex justify-content-center'>";
            foreach ($drugs as $drug) {
                echo "<div class='col-sm-12 col-md-6 col-lg-4 jumbotron'>
                            <div class='d-flex justify-content-center'>
                            <table class='table-striped '>
                            <tr><th>Naam, </th><th> $drug->naam</th></tr>
                            <tr><th>Maker, </th><th> $drug->maker</th></tr>
                            <tr><th>Compensated by,</th><th> $drug->compensated</th></tr>
                            <tr><th>Side effects, </th><th> $drug->side_efect</th></tr>
                            <tr><th>Benefits, </th><th> $drug->benefits</th></tr> 
                            </table>
                        </div><div class='d-flex justify-content-center'>
                                      <form action='index.php' method='post'>
                                       <input type='hidden' name='showDrugForm' value='$drug->id'><input class='btn btn-outline-secondary' type='submit' value='wijzigen'/></form>
                                        <form action='index.php' method='post'>
                                       <input type='hidden' name='deleteDrug' value='$drug->id'><input class='btn btn-outline-secondary' type='submit' value='verwijderen'/></form>
                                    </div></div>";
            }
        }
    }
    public function showDrugForm($id=null){
        if($id !=null && $id !=0){
            $drug = $this->model->selectDrug($id);
        }
        /*de html template */
        echo "<!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <title>Beheer druggegevens</title>
                    <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script>
                    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>
        </head><body>";
        if(isset($drug)){
            echo "<div class='jumbotron'><div class='d-flex justify-content-center'><h2>Formulier Medicijnen</h2></div>
        <div class='d-flex justify-content-center'><form method='post' >
        <table>
            <tr><td></td><td>
                <input type=\"hidden\" name=\"id\" value='$id'/></td></tr>
             <tr><td>   <label for=\"naam\">Drug naam</label></td><td>
                <input type=\"text\" name=\"naam\" value= '".$drug->naam."'/></td></tr>
            <tr><td>
                <label for=\"maker\">maker</label></td><td>
                <input type=\"text\" name=\"maker\" value = '".$drug->maker."'/></td></tr>
            <tr><td>
                <label for=\"compensated\">compensated</label></td><td>
                <input type=\"text\" name=\"compensated\" value= '".$drug->compensated."'/></td></tr>
            <tr><td>
                <label for=\"side_efect\">side_efect</label></td><td>
                <input type=\"text\" name=\"side_efect\" value= '".$drug->side_efect."'/></td></tr>
            <tr><td>
                <label for=\"benefits\">benefits</label></td><td>
                <input type=\"text\" name=\"benefits\" value= '".$drug->benefits."'/></td></tr>
            <tr><td>
                <input class='btn btn-outline-secondary' type='submit' name='updateDrug' value='opslaan'></td><td>
            </td></tr></table>
            </form></div></div>
            <div class='d-flex justify-content-center'><h2>Terug</h2></div>
            <div class='d-flex justify-content-center'>
            <form action='index.php' method='post'>
            <input type='hidden' name='showDrugs' value='0'>
            <input class='btn btn-outline-secondary' type='submit' value='terug'/>
            </form>
            </div>
        </body>
        </html>";
        }
        else{
            /*de html template */
            echo "<div class='jumbotron'><div class='d-flex justify-content-center'><h2>Formulier Medicijnen</h2></div>
        <div class='d-flex justify-content-center'>
        <form method='post' action='index.php'>
        <table>
            <tr><td></td><td>
                <input type=\"hidden\" name=\"id\" value=''/></td></tr>
             <tr><td>   <label for=\"naam\">Drug naam</label></td><td>
                <input type=\"text\" name=\"naam\" value= ''/></td></tr>
            <tr><td>
                <label for=\"maker\">maker</label></td><td>
                <input type=\"text\" name=\"maker\" value = ''/></td></tr>
            <tr><td>
                <label for=\"compensated\">compensated</label></td><td>
                <input type=\"text\" name=\"compensated\" value= ''/></td></tr>
            <tr><td>
                <label for=\"side_efect\">side_efect</label></td><td>
                <input type=\"text\" name=\"side_efect\" value= ''/></td></tr>
            <tr><td>
                <label for=\"benefits\">benefits</label></td><td>
                <input type=\"text\" name=\"benefits\" value= ''/></td></tr>
            <tr><td>
                <input class='btn btn-outline-secondary' type='submit' name='addDrug' value='opslaan'></td><td>
            </td></tr></table>
            </form></div></div>
            <div class='d-flex justify-content-center'><h2>Terug</h2></div>
            <div class='d-flex justify-content-center'>
            <form action='index.php' method='post'>
            <input type='hidden' name='showDrugs' value='0'>
            <input class='btn btn-outline-secondary' type='submit' value='terug'/>
            </form>
            </div>
        </body>
        </html>";
        }
    }
}