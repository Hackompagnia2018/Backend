<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

//----------------USER-----------------------------------
//______________GET_____________________________
$app->group('/user', function () {
    $this->group('/get', function () {
        $this->get('/credentials', function (Request $request, Response $response){
            $id = $this->token_id;
            $result = $this->db->query("SELECT name, surname, mail, birth, cell FROM users WHERE id ='$id'")->fetch();
            if($result){
                return $response->withJson($result,200);
            }else{
                return $response->withJson(false,422);
            }
       });
    });
//______________________________________________
    
//_____________POST__________________________
     $this->group('/post', function () {
        $this->post('/credentials', function(Request $request, Response $response){
           $result = $this->db->query("INSERT INTO suggestions(id) VALUES ('$this->token_id')");
            if(!$result){
                return $response->withJson(false,422);
                } else {
                return $response->withJson($result ,200);
            }
        });
    });
//____________________________________________
    
//_________PUT_______________________________
    $this->group('/put', function () {
        $this->put('/credentials/{cell}', function(Request $request, Response $response, $args){
            $cell = $args['cell'];
            $result = $this->db->query("UPDATE suggestions SET cell = '$cell' WHERE id = '$this->token_id'");
            if(!$result){
                return $response->withJson(false,422);
            } else {
                return $response->withJson($result ,200);
            }
        });
    });
//____________________________________________
    
//__________DELETE____________________________
    $this->group('/delete', function () {

    });
//_____________________________________________
    
})->add($mw); 

//---------END USER---------------------------

//--------------STAFF-------------------------

$app->group('/staff', function () {

})->add($mw);

//--------------ADMIN--------------------------

$app->group('/adimn', function () {

})->add($mw);


//------------ROUTES TEST------------------------
$app->get('/test/prova', function (Request $request, Response $response) {
    return $response->withJson($request->getMethod());
});
