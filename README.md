Before deploying:

1. Please create a database 'emp' and import the 'localhost.sql' present in 'ems/database' directory.
Database configurations are saved in db_connection.php

2. This app sends an activation link through email, I have used Gmail and have provided the login credentials.
If you need to use your own email id (should be gmail) then  make sure to turn on "Allow less secure apps in Gmail" by visiting the following links :

About allowing less secure apps - https://support.google.com/accounts/answer/6010255?hl=en
link to turn on 'less secure apps' - http://www.google.com/settings/security/lesssecureapps

and provide your credentials (email id and password) in mail.php  

----

===========================
 Account Contact Advance Search:
===========================

These are various filter that used to do contact search 

Various cases :-

1. CASE OptIn :-
	$val[2] = 0
   	$val[0] = from date
   	$val[1] = to date

2. CASE Email Address :-
	$val[2] = 1
	$val[1] = email to search
	
	CASE Contains
   		$val[0] = 0
	CASE Does Not Contains
	  	$val[0] = 1	
		
3. CASE State :-
	$val[2] = 2
   	$val[1] = state name to search

   	CASE Contains
   		$val[0] = 0
	CASE Does Not Contains
	  	$val[0] = 1

4. CASE Added by :-
	$val[2] = 3
   	$val[1] = Contact added by user name
   	
	CASE Contains
   		$val[0] = 0
	CASE Does Not Contains
	  	$val[0] = 1

5. CASE Campaign :-
	$val[2] = 4
   	$val[1] = Campaign name

   	CASE Contains
   		$val[0] = 0
	CASE Does Not Contains
	  	$val[0] = 1
