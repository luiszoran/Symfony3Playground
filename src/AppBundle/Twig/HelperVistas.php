<?php

namespace AppBundle\Twig;


class HelperVistas extends \Twig_Extension {

    public function getFunctions(){
        return array(
            'generateTable' => new \Twig_Function_Method($this, 'generateTable')
        );
    }

    public function generateTable($num_rows, $num_columns){
        $table = "<table class='table' border='1'>";
        for($i = 0; $i < $num_rows; $i++){
            $table .= "<tr>";
            for($j = 0; $j < $num_columns; $j++){
                $table .= "<td>$i - $j</td>";
            }
            $table .= "</tr>";
        }
        $table .= "</table>";
        return $table;
    }

    public function getName() {
        return "app_bundle";
    }
}