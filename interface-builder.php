<?php
/*
* Interface Builder 
* 
* Interface Manager for Moderate Categories
*
* @author Mateo Torres <torresmateo@gmail.com>
*/

/*
This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/

class InterfaceBuilder{
    private $target;

    function __construct($buildMe){
        $validTags = array(
            'mainMenu',     //roles-categories
            'userMenu',     //users-categories
            'postTypes',   //how-to-do-stuff
            'how-to-Page'   //how-to-do-stuff
        );

        if(in_array($buildMe,$validTags)){
            $this->target = $buildMe;
        }else{
            $this->target = 'error';    //bad tag? bad page
        }
    }

    public function build(){
        include( 'views/'.$this->target . '.php'); //call the template files
    }
}
