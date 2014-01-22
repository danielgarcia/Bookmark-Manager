<?php

class View {

    /**
     * It renders the views
     *
     * @param string $name The name of the view to render
     * @param array $data The data to be passed to be used in the view
     * @param boolean $includes To include the header and footer parts of the view
     */
    public function render($name, $data = false, $includes = true) {
        if($data){
            extract($data, EXTR_PREFIX_SAME, 'data');
        }

        if($includes){
            require 'views/layout/header.php';
        }
        require 'views/' . $name . '.php';
        if($includes){
            require 'views/modals/createnew.php';
            require 'views/layout/footer.php';
        }
    }
}