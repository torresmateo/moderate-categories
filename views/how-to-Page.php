<!-- Main Menu Template

Shows the role-category rules table and the "Add Rule" button

Mateo Torres 2013-->

<?php 
//include the header file
include("template/header.php");?>

<p>This plug-in was built having in mind the ease-of-use as a major feature. If you manage to understand some simple rules you should be very comfortable using it.</p>

<h1>Understanding Rules</h1>
<p>To create a rule, you first have to think whether you should create a User-Category or Role-Category Rule.</p>
<p>Role-Category rules are there for you to <b>give</b> access to a group of users and let them see posts under such and such categories.</p>
<p>User-Category rules, on the other hand, are made for giving single users more access than that given from Role-Category rules. In this version, you can only give MORE access to specific users, not restrict some categories for a single user. Future releases will let you choose the behavior of the User-Category rule for a specific user.</p>
<p>Keep in mind that by default, WordPress allows every User visibility for every post, even the ones he/she doesn't have rights to Update, Edit, or comment. This plugin does not change this behavior, if you have a Role (or User) that is not affected by any rule, default visibility is applied to that Role (or User).</p>


<h2>Creating Rules</h2>
<p>You probably can figure out how to assign rules to specific roles and/or users, but this will briefly explain how to do it.</p>
<p>This plug-in have 3 tabs, each tab with one specific purpose (the current tab is just for displaying this text). The <i>Role-Category Rules</i> tab is there for creating Role-Category Rules (pretty straightforward) and the same goes for the <i>User-Category Rules</i> tab.
<p>Inside any of those tabs, you will find two Sections:
  <table border="1">
	<tr><th>Rule Table</th><th>Add/Edit Form</th></tr>
	<tr><td>Role (or User)</td><td>User (or Role) Selector</td></tr>
	<tr><td>List of assigned categories</td><td>Category Tree</td></tr>
	<tr><td>Delete Rule Button</td><td>Add/Edit Button</td></tr>

  </table>
</p>
<p>The <b>Rule Table</b> will show the current rules you have in your configuration and let you delete them (irreversible, if you delete a rule, you have to "manually" recreate it). The <b>Add/Edit Form</b> will let you create new rules or editing the existing ones.</p>
<p>The creation process is simple, you just select an User (or Role), if there's an existing rule involving that User (or Role) it will be automatically checked in the Category Tree, and when submitted, that rule will be updated. If the User (or Role) didn't have any rule assigned, a new rule will be added to the table.</p>


 
<?php //include the footer file
include("template/footer.php");?>

