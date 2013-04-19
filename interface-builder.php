<?php
/*
* Interface Builder 
* 
* Interface Manager for Moderate Categories
*
* @author Mateo Torres <torresmateo@gmail.com>
*/
class InterfaceBuilder{
    private $target;

    function __construct($buildMe){
        $validTags = array(
            'mainMenu',     //roles-categories
            'userMenu',     //users-categories
            'how-to-Page'   //how-to-do-stuff
        );

        if(in_array($buildMe,$validTags)){
            $this->target = $buildMe;
        }else{
            $this->target = 'error';    //bad tag? bad page
        }
    }

    public function build(){
        include( 'views/'.$this->target . '.php'); //se llama al template correspondiente
    }
}
