<?php

class cat
{
    //to creat the new information about a new cat
    
    private function newCat($newCat)
    {
       $firstname ='';
       $age ='';
       $color ='';
       $sex ='';
       $race ='';
       
       if (!(is_string($firstname)) && (strlen($firstname) < 3 || strlen($firstname)) > 20) 
       {
           throw new Exception();
       }
       
       if (!is_int($age))
       {
           throw new Exception();
       }
       
       if (!(is_string($color)) && (strlen($color) < 3 || strlen($color)) > 10)
       {
           throw new Exception();
       }
       
       if (!(is_string($color)))
       {
           throw new Exception();
       }
       
       if (!(is_string($race)) && (strlen($race) < 3 || strlen($race)) > 20)
       {
           throw new Exception();
       }
       
       $this->cat = $newCat;
       return $this;
    }
    
    
    //put the information inside the array
    
    public function catInfo()
    {
        return [
            'firstname' => $this->firstname,
            'age' => $this->age,
            'color' => $this->color,
            'sex' => $this->sex,
            'race' => $this->race
            
        ];
    }
}

?>