Before deploying:

1. Please create a database 'emp' and import the 'localhost.sql' present in 'ems/database' directory.
Database configurations are saved in db_connection.php

2. This app sends an activation link through email, I have used Gmail and have provided the login credentials.
If you need to use your own email id (should be gmail) then  make sure to turn on "Allow less secure apps in Gmail" by visiting the following links :

About allowing less secure apps - https://support.google.com/accounts/answer/6010255?hl=en
link to turn on 'less secure apps' - http://www.google.com/settings/security/lesssecureapps

and provide your credentials (email id and password) in mail.php  

----


#Account User Advance Search:

These are various filter that used to do user search 

Various cases :-
```text
1. CASE Create Date :-
	$val[2] = 0
   	$val[0] = from date
   	$val[1] = to date

2. CASE Last Login :-
	$val[2] = 1
   	$val[0] = from date
   	$val[1] = to date

3. CASE Phone Number :-
	$val[2] = 2
	$val[1] = Phone number to be search
	
	CASE contains
   		$val[0] = 0
	CASE Does not contains
	  	$val[0] = 1	
		
4. CASE First Name :-
	$val[2] = 3
   	$val[1] = user first name to search

   	CASE contains
   		$val[0] = 0
	CASE Does not contains
	  	$val[0] = 1

5. CASE Last Name :-
	$val[2] = 4
   	$val[1] = user last name to search
   	
	CASE contains
   		$val[0] = 0
	CASE Does not contains
	  	$val[0] = 1

6. CASE Role :-
	$val[2] = 5
   	$val[1] = user role(Admin, Manager, User)

   	CASE contains
   		$val[0] = 0
	CASE Does not contains
	  	$val[0] = 1

7. CASE Groups :-
	$val[2] = 6
   	$val[1] = Group name

   	CASE contains
   		$val[0] = 0
	CASE Does not contains
	  	$val[0] = 1

8. CASE User Types :-
	$val[2] = 7
   	$val[1] = User Type(Paid, Free, Suspended, Inactive)

   	CASE contains
   		$val[0] = 0

9. CASE COntact Total :-
	$val[2] = 8
   	$val[1] = Total number of contacts 

   	CASE Greater Than
   		$val[0] = 0
	CASE Less Than
	  	$val[0] = 1

10. CASE Rep Id :-
	$val[2] = 9

   	CASE Is Blank
   		$val[1] = 0
	CASE Is Not Blank
	  	$val[1] = 1

   	CASE contains
   		$val[0] = 0
	CASE Does not contains
	  	$val[0] = 1
```
