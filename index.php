<?php

/*
 * Class for working with sets. Grouping numbers by intervals
 */

class Set {

    private $intervalArr;
    private $data;
    private $count;
    private $resultArr;

    public function setIntervalArr($intervalArr) {
        // $intervalArr = [0-3][4-6]...
        $this->count = count($intervalArr);
        if ($this->count % 2 != 0) {
            echo 'Error: Count of numbers in interval must be even number';
            exit;
        }

        $this->intervalArr = $intervalArr;
    }

    public function load($filename, $numOfColumn) {
        $rows = file($filename);
        foreach($rows as $row) {
            $row = str_replace("\n", "", $row);
            $e = explode(";", $row);
            $this->data[] = $e[$numOfColumn];
        }
    }

    public function grouping() {
       
        foreach ($this->data as $row) {
           
            for ($i = 0; $i < $this->count; $i += 2) {
                if($row >=  $this->intervalArr[$i] && $row <= $this->intervalArr[$i+1]) {
                    // Value was included in the interval 
                    $this->resultArr["{$this->intervalArr[$i]}-{$this->intervalArr[$i+1]}"]++;
                }
            }
        }
        natsort($this->resultArr);
        $this->resultArr = array_reverse($this->resultArr);
    }
    
    public function save($filename) {
        
        $h = fopen($filename,"w");
        foreach( $this->resultArr as $key => $row) {
            fwrite($h, $key.";".$row."\n");
        }
        fclose($h);
    }

}
/*
$set = new Set();

$set->setIntervalArr(array(0, 3, 4, 5, 6, 10, 11, 20, 21, 30, 31, 50, 51, 100, 101, 10000));
$set->load("business_user.csv", 1);
$set->grouping();
$set->save("res.csv");
*/
