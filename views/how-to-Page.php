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

<h2>Creating Rules</h2>
<p>You probably can figure out how to assign rules to specific roles and/or users, but this will briefly explain how to do it.</p>
<p>This plug-in have 3 tabs, each tab with one specific purpose (the current tab is just for displaying this text). The <i>Role-Category Rules</i> tab is there for creating Role-Category Rules (pretty straightforward) and the same goes for the <i>User-Category Rules</i> tab.
<p>Inside any of those tabs, you will find two Sections:
  <ul>
	<li>The Rule Table
	  <ul>
		<li>Role (or User)</li>
		<li>Categories assigned</li>
		<li>Reset Button</li>
	  </ul>
	</li>

  </ul>


 
<?php //include the footer file
include("template/footer.php");?>

