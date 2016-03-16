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

**Filenames:**
- Only alphanumeric characters, underscore, and the dash character (-) are permitted. Spaces are strictly prohibited.  
- Any file that contains PHP code should end with the extension **.php**, with the notable exception of view scripts.  
The following examples show acceptable filenames for Zend Framework classes:  
```php
Zend/Db.php  
Zend/Controller/Front.php  
Zend/View/Helper/FormRadio.php  
```
- File names must map to class names as described above.  

**Functions and Methods:**
- Only alphanumeric characters may be used. Underscores are not permitted. Numbers are permitted but discouraged in most cases.  
- Must always start with a lowercase letter. When a function name consists of more than one word, the first letter of each new word must be capitalized. This is commonly called **camelCaps** formatting.  
- Function names should be as verbose as is practical to fully describe their purpose and behavior.  
These are examples of acceptable names for functions: 
```php
filterInput()  
getElementById()  
widgetFactory()  
```
- For object-oriented programming, accessors for instance or static variables should always be prefixed with **get** or **set**.  
In implementing design patterns, such as the singleton or factory patterns, the name of the method should contain the pattern name where practical to more thoroughly describe behavior.  
- For methods on objects that are declared with the **private** or **protected** modifier, the first character of the method name must be an **underscore**. This is the only acceptable application of an underscore in a method name. Methods declared **public** should never contain an underscore.  
- Functions in the global scope (a.k.a "floating functions") are permitted but discouraged in most cases. Consider wrapping these functions in a static class.  
 
**Variables:**
- May only contain alphanumeric characters. Underscores are not permitted. Numbers are permitted in variable names but are discouraged in most cases.  
- Variables that are declared with the **private** or **protected** modifier, the first character of the variable name may be a single **underscore**. This is the only acceptable application of an underscore in a variable name. Variables declared **public** should never start with an underscore.  
- Variables should always be as verbose as practical to describe the data that the developer intends to store in them. Terse variable names such as **$i** and **$n** are discouraged for all but the smallest loop contexts. If a loop contains more than 20 lines of code, the index variables should have more descriptive names.  

**Constants:**
- May contain both alphanumeric characters and underscores. Numbers are permitted in constant names.  
- All letters used in a constant name must be capitalized, while all words in a constant name must be separated by underscore character.  
- For example, **EMBED_SUPPRESS_EMBED_EXCEPTION** is permitted but **EMBED_SUPPRESSEMBEDEXCEPTION** is not.  
- Constants must be defined as class members with the **const** modifier. Defining constants in the global scope with the **define** function is permitted but strongly discouraged.  

##Coding Style
**PHP Code Demarcation**
- PHP code must always be delimited by the full-form, standard PHP tags:  
```php
<?php  
?>  
```
- Short tags are never allowed. For files containing only PHP code, the closing tag must always be omitted.  

**Strings**  
--
**String Literals**
- When a string is literal (contains no variable substitutions), the apostrophe or single quote (**' '**) should always be used to demarcate the string: 
```php
$a = 'Example String';
```

**String Literals Containing Apostrophes**
- When a literal string itself contains apostrophes, it is permitted to demarcate the string with quotation marks or double quotes (**" "**). This is especially useful for SQL statements:  
```php
$sql = "SELECT `id`, `name` from `people` "
     . "WHERE `name`='Fred' OR `name`='Susan'";  
```
- This syntax is preferred over escaping apostrophes as it is much easier to read.  

**Variable Substitution**
- Variable substitution is permitted using either of these forms:  
```php
$greeting = "Hello $name, welcome back!";    
$greeting = "Hello {$name}, welcome back!";  
```
- For consistency, this form is not permitted:  
```php
$greeting = "Hello ${name}, welcome back!";
```

**String Concatenation**
- Strings must be concatenated using the "." operator. A space must always be added before and after the "." operator to improve readability:  
```php
$company = 'Zend' . ' ' . 'Technologies';
```
- When concatenating strings with the "." operator, it is encouraged to break the statement into multiple lines to improve readability. In these cases, each successive line should be padded with white space such that the "."; operator is aligned under the "=" operator: 
```php
$sql = "SELECT `id`, `name` FROM `people` "
     . "WHERE `name` = 'Susan' "
     . "ORDER BY `name` ASC ";
```

**Arrays**  
**Numerically Indexed Arrays**
- Negative numbers are not permitted as indices.  
- An indexed array may start with any non-negative number, however all base indices besides 0 are discouraged.  
- When declaring indexed arrays with the Array function, a trailing space must be added after each comma delimiter to improve readability:  
```php
$sampleArray = array(1, 2, 3, 'Zend', 'Studio');
```
- It is permitted to declare multi-line indexed arrays using the "array" construct. In this case, each successive line must be padded with spaces such that beginning of each line is aligned: 
```php
$sampleArray = array(1, 2, 3, 'Zend', 'Studio',
                     $a, $b, $c,
                     56.44, $d, 500);
```
- Alternately, the initial array item may begin on the following line. If so, it should be padded at one indentation level greater than the line containing the array declaration, and all successive lines should have the same indentation;  
the closing parenthesis should be on a line by itself at the same indentation level as the line containing the array declaration: 
```php
$sampleArray = array(
    1, 2, 3, 'Zend', 'Studio',
    $a, $b, $c,
    56.44, $d, 500,
);
```
- When using this latter declaration, we encourage using a trailing comma for the last item in the array; this minimizes the impact of adding new items on successive lines, and helps to ensure no parse errors occur due to a missing comma.   

**Associative Arrays**
- When declaring associative arrays with the Array construct, breaking the statement into multiple lines is encouraged. In this case, each successive line must be padded with white space such that both the keys and the values are aligned: 
```php
$sampleArray = array('firstKey'  => 'firstValue',
                     'secondKey' => 'secondValue');
```
- Alternately, the initial array item may begin on the following line. If so, it should be padded at one indentation level greater than the line containing the array declaration, and all successive lines should have the same indentation; the closing parenthesis should be on a line by itself at the same indentation level as the line containing the array declaration. For readability, the various **"=>"** assignment operators should be padded such that they align. 
```php
$sampleArray = array(
    'firstKey'  => 'firstValue',
    'secondKey' => 'secondValue',
);
```
- When using this latter declaration, we encourage using a trailing comma for the last item in the array; this minimizes the impact of adding new items on successive lines, and helps to ensure no parse errors occur due to a missing comma. 

**Function and Method Usage**
- Function arguments should be separated by a single trailing space after the comma delimiter.  
The following is an example of an acceptable invocation of a function that takes three arguments: 
```php
threeArguments(1, 2, 3);
```
- Call-time pass-by-reference is strictly prohibited.   
- In passing arrays as arguments to a function, the function call may include the "array" hint and may be split into multiple lines to improve readability. In such cases, the normal guidelines for writing arrays still apply:
```php
threeArguments(array(1, 2, 3), 2, 3);
```
```php
threeArguments(array(1, 2, 3, 'Zend', 'Studio',
                     $a, $b, $c,
                     56.44, $d, 500), 2, 3);
```
```php
threeArguments(array(
    1, 2, 3, 'Zend', 'Studio',
    $a, $b, $c,
    56.44, $d, 500
), 2, 3);
```

**Control Statements**  
**If/Else/Elseif**
- Control statements based on the if and elseif constructs must have a single space before the opening parenthesis of the conditional and a single space after the closing parenthesis.  
- Within the conditional statements between the parentheses, operators must be separated by spaces for readability. Inner parentheses are encouraged to improve logical grouping for larger conditional expressions.  
- The opening brace is written on the same line as the conditional statement. The closing brace is always written on its own line. Any content within the braces must be indented using four spaces. 
```php
if ($a != 2) {
   $a = 2;
}
```
- If the conditional statement causes the line length to exceed the maximum line length and has several clauses, you may break the conditional into multiple lines. In such a case, break the line prior to a logic operator, and pad the line such that it aligns under the first character of the conditional clause. The closing parenthesis in the conditional will then be placed on a line with the opening brace, with one space separating the two, at an indentation level equivalent to the opening control statement. 
```php
if (($a == $b)
    && ($b == $c)
    || (Foo::CONST == $d)
) {
    $a = $d;
}
```
- The intention of this latter declaration format is to prevent issues when adding or removing clauses from the conditional during later revisions.  
- For "if" statements that include "elseif" or "else", the formatting conventions are similar to the "if" construct.  
- The following examples demonstrate proper formatting for "if" statements with "else" and/or "elseif" constructs: 
```php
if ($a != 2) {
    $a = 2;
} else {
    $a = 7;
}
```
```php
if ($a != 2) {
    $a = 2;
} elseif ($a == 3) {
    $a = 4;
} else {
    $a = 7;
}
```
```php
if (($a == $b)
    && ($b == $c)
    || (Foo::CONST == $d)
) {
    $a = $d;
} elseif (($a != $b)
          || ($b != $c)
) {
    $a = $c;
} else {
    $a = $b;
}
```
- PHP allows statements to be written without braces in some circumstances. This coding standard makes no differentiation- all "if", "elseif" or "else" statements must use braces. 

**Switch**
- Control statements written with the "switch" statement must have a single space before the opening parenthesis of the conditional statement and after the closing parenthesis. 
- All content within the "switch" statement must be indented using four spaces. Content under each "case" statement must be indented using an additional four spaces. 
```php
switch ($numPeople) {
    case 1:
        break;
 
    case 2:
        break;
 
    default:
        break;
}
```
- The construct default should never be omitted from a switch statement.  
**Note:** It is sometimes useful to write a case statement which falls through to the next case by not including a break or return within that case. To distinguish these cases from bugs, any case statement where break or return are omitted should contain a comment indicating that the break was intentionally omitted.  

**Inline Documentation**
- Class and function header should be present.

**Class and function**
- Braces should start in next line for classes and methods.
```php
/**
 * Documentation Block Here
 */
class Foo
{
    /**
     * Documentation Block Here
     */
    public function bar()
    {
        // all contents of function
        // must be indented four spaces
    }
    /**
     * Documentation Block Here
     */
    public function bar($arg1, $arg2, $arg3,
        $arg4, $arg5, $arg6
    ) {
        // all contents of function
        // must be indented four spaces
    }

}
```
