<?php

class InterfaceBuilder(){
    private $target;

    function __construct($buildMe){
        $validTags = array(
            'mainMenu',     //roles-categories
            'userMenu',     //users-categories
            'how-to-Page'   //how-to-do-stuff
        )

        if($buildMe,$validTags){
            $this->target = $buildMe;
        }else{
            $this->target = 'error'     //bad tag? bad page
        }
    }

    function build(){
        include_once($this->target . '.php');
    }
}
