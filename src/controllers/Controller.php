<?php

abstract class Controller {
    abstract public function index($params = []);

    protected function render($view, $data = []) {
        extract($data);
        
    }
}