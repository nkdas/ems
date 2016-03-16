Before deploying:

1. Please create a database 'emp' and import the 'localhost.sql' present in 'ems/database' directory.
Database configurations are saved in db_connection.php

2. This app sends an activation link through email, I have used Gmail and have provided the login credentials.
If you need to use your own email id (should be gmail) then  make sure to turn on "Allow less secure apps in Gmail" by visiting the following links :

About allowing less secure apps - https://support.google.com/accounts/answer/6010255?hl=en
link to turn on 'less secure apps' - http://www.google.com/settings/security/lesssecureapps

and provide your credentials (email id and password) in mail.php


--

#Coding Guidelines for **Rapid Funnel**

Created By : Rajkumar and Neeraj  
Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 16th March 2016  
This document is applicable only for **Rapid Funnel** application.


##PHP File Formatting
**General:**
- For files that contain only PHP code, the closing tag **?>** is never permitted. It is not required by PHP, and omitting it prevents the accidental injection of trailing white space into the response.  
**Note:** Inclusion of arbitrary binary data as permitted by __HALT_COMPILER() is prohibited from PHP files in the Zend Framework project or files derived from them. Use of this feature is only permitted for some installation scripts. 


**Indentation:**
- Indentation should consist of 4 spaces. Tabs are not allowed.

**Maximum Line Length:**
- The target line length is 80 characters. That is to say, Zend Framework developers should strive keep each line of their code under 80 characters where possible and practical. However, longer lines are acceptable in some circumstances. The maximum length of any line of PHP code is 120 characters. 


##Naming Conventions
**Classes:**
- Zend Framework standardizes on a class naming convention whereby the names of the classes directly map to the directories in which they are stored.  
- The root level directory of Zend Framework's standard library is the "Zend/" directory, whereas the root level directory of Zend Framework's extras library is the "ZendX/" directory. All Zend Framework classes are stored hierarchically under these root directories.  
- Class names may only contain alphanumeric characters. Numbers are permitted in class names but are discouraged in most cases. Underscores are only permitted in place of the path separator; the filename "Zend/Db/Table.php" must map to the class name "Zend_Db_Table".  
- If a class name is comprised of more than one word, the first letter of each new word must be capitalized. Successive capitalized letters are not allowed, e.g. a class "Zend_PDF" is not allowed while "Zend_Pdf" is acceptable.  
- These conventions define a pseudo-namespace mechanism for Zend Framework. Zend Framework will adopt the PHP namespace feature when it becomes available and is feasible for our developers to use in their applications.  
**Note:** Code that must be deployed alongside Zend Framework libraries but is not part of the standard or extras libraries (e.g. application code or libraries that are not distributed by Zend) must never start with "Zend_" or "ZendX_". 
