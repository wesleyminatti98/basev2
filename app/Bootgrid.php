<?php

namespace App;

class Bootgrid
{
    public $current;
    public $rowCount;
    public $total;
    public $rows;


    public function show(){
        $ret['current'] = $this->current;
        $ret['rowCount'] = $this->rowCount;
        $ret['total'] = $this->total;
        $ret['rows'] = $this->rows;

        echo json_encode($ret);

    }
}
