<?php

namespace App;

class Controller {
    protected function render($view, $data = null) {
        if($data){
           extract($data); 
        }
        include "views/$view.php";
    }
}
