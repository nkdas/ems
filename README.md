Before deploying:

1. Please create a database 'emp' and import the 'localhost.sql' present in 'ems/database' directory.
Database configurations are saved in db_connection.php

2. This app sends an activation link through email, I have used Gmail and have provided the login credentials.
If you need to use your own email id (should be gmail) then  make sure to turn on "Allow less secure apps in Gmail" by visiting the following links :

About allowing less secure apps - https://support.google.com/accounts/answer/6010255?hl=en
link to turn on 'less secure apps' - http://www.google.com/settings/security/lesssecureapps

and provide your credentials (email id and password) in mail.php


------------------------------

##DB Design Guidelines for **Rapid Funnel**

Created By: Rajkumar and Neeraj  
Date:       16th March 2016  
This document is applicable only for **Rapid Funnel** application.


**Storage Engine:**
- Choose storage engine smartly based on the data in tables.
[Storage Engines](https://dev.mysql.com/doc/refman/5.0/en/storage-engines.html)


**Tables:**
- Table names will be in lower case.
- In case of multiple words then follow **camelCaps** capitalization convention. 
e.g:  for "users payment info" name should be **usersPaymentInfo**

**Fields:**
- Field names will be in lower case. 
- In case of multiple words then follow **camelCaps** capitalization convention. 
e.g for "user id" name should be **userId**

**Foreign Keys:**
- If  a table has a foreign key column of another table then the column will be like
**userId**
where user is the singular of users**table name** and "id** is the reference column name in users table.

**Collation:**
**utf8_general_ci** for all char, varchar or text fields.

**Datatypes:**
- Should be choosen smartly.
- Choose datatype as timestamp if allowed instead of datetime as datetime takes 4 bytes where as timestamp is only 2 bytes.
- Using tiny int instead of enum in fileds like status or user types as tiny int takes only one byte where as enum one or two bytes based on the options (Please do not forget to add proper comment)
-  Look into datatypes properly before choosing for the field like **TINYINT, SMALLINT, MEDIUMINT** and INT takes 1, 2, 3 and 4 bytes respectively.

**Field Size:**
- Choose appopriate number looking into column like name should not be VARCHAR(255) as in real a name cannot have 255 character long.

**Points to Takecare:**
- Avoiding to allow Null in fields if possible.
- Using unsigned instead of signed if the column expected to take only positive values like auto increament fileds.
- Use comments wherever required.
