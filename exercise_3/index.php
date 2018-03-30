<?php

class cars
{
    public function newVehicle()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST')
        {
            
            $make = $_POST['make'] ?? null;
            $model = $_POST['model'] ?? null;
            $year = $_POST['year'] ?? null;
            $color = $_POST['color'] ?? null;
            
            $makeValid = (is_string($make) && strlen($make)>3);
            $modelValid = (is_string($model) && strlen($model)>3);
            $yearValid = (is_string($year) && strlen($year)>3);
            $colorValid = (is_string($color) && strlen($color)>2);
            
            
            if ($makeValid && $modelValid && $yearValid && $colorValid )
            {
                
                $connection = new PDO('mysql:host=localhost;dbname=cars', 'root', '');            
                $sql = "INSERT INTO car(make, model, year, color) VALUES (:make, :model, :year, :color)";
                $statement = $connect->prepare($sql);
                $statement->bindParam('make', $make);
                $statement->bindParam('model', $model);
                $statement->bindParam('year', $year);
                $statement->bindParam('color', $color);
                $working = $statement->execute();
                if (!$working){
                    $errorMessage = 'Unsuccessful request';
                    echo $statement;
                    die();
                }
                
                session_start();
                
                echo 'registered';
                
            }
        }    
    }
}
?>

