# Moderate Categories

Gives the WordPress admin the ability to give visibility access to roles and users for posts in a by-category way.

This plugin does NOT modify the roles capabilities, your users will be able to do whatever their role says they can do, this tool just limits the back-end interface. 

This plug-in was written mainly because of the lack of intuitive category-moderation plug-ins, and because most of the plug-ins have "restrict access" logic rather than the more intuitive "give access" logic. 

## Features

* By default, all categories are accessible (WP default)
* Role-Category rules define permissions for the entire role.
* User-Category rules define permissions for particular users and have higher priority.
* Adding a Rule for a single category, gives permission for this category ancestors (the whole parent branch in the category tree).
    * Adding a rule also removes permission to edit under other categories. 
