<?php

class Controller
{
    // Load a model
    public function model($model)
    {
        // Require the model file
        require_once  __DIR__ . '/../models/' . $model . '.php';


        // Instantiate the model
        return new $model();
    }

    // Load a view
    protected function view($view, $data = []) {
        $file = __DIR__ . '/../views/' . $view . '.php'; // Adjust this line if needed

        if (file_exists($file)) {
            extract($data);
            require_once $file;
        } else {
            die('View does not exist: ' . $file);
        }
    }
}
