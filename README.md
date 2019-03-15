# Test task examples collection

Here placed test scripts. Main goal is collect different tasks and issues. 
They are specially placed in single file to more flexible management and distributed

## Coding test snippets

### PHP 

- [OOP late static bindings](php/oop-class-late-static-bindings.php)

- [OOP sharing static property](php/oop-sharing-static-property.php)

- [sending email](php/email.php)

- [strcmp benchmark](php/strcmp-benchmark.php)

- [group shuffled words](php/words.php)

- [transport's issue OOP style](php/transport-oop.php)

- [simple sorting methods](php/sorting.php)

- [simple + heap + b-tree sorting OOP style](php/sorting-oop.php)

### JS

 - [cycled setTimeout](js/settimeout.js)
 
 - [bind](js/bind.js)
 
 - [this](js/this.js)
 
 - [prototype](js/prototype.js)

### SQL

[Migrations SQL for test DB](sql/test_db.sql)
 
 - List of users with max car price which they have
 
     ```mysql
    # simple
    SELECT u.name, MAX(c.price) price
    FROM `user` u
      INNER JOIN `car` c ON c.user_id=u.id
    GROUP BY u.id;
    
    # sub-select
    SELECT
      (SELECT u.name FROM `user` u WHERE u.id=c.user_id) as name,
      MAX(c.price) as price
    FROM `car` c
    GROUP BY c.user_id;
    ```

 - List of users having car with max price
 
    ```mysql
    SELECT u.name, MAX(c.price) price
    FROM `user` u
       INNER JOIN `car` c ON c.user_id=u.id
    GROUP BY u.id
    HAVING price=(SELECT MAX(c.price) price FROM `car` c);
    ```


## HackerRank coding tests

[HackerRank coding tests](hackerrank/README.md)

