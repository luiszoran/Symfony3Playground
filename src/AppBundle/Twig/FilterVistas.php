<?php

namespace AppBundle\Twig;


class FilterVistas extends \Twig_Extension {

    public function getFilters() {
        return array(
            new \Twig_SimpleFilter("addText", array($this, "addText"))
        );
    }

    public function getName() {
        return "filter_vista";
    }

    public function addText($string){
        return $string." TEXTO CONCATENADO";
    }
}