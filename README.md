# Test task examples collection

Here placed test scripts. Main goal is collect different tasks and issues. 


## Coding test snippets

### PHP 

- [OOP late static bindings](php/oop_class_late_static_bindings.php)

- [OOP sharing static property](php/oop_sharing_static_property.php)

- [sending email](php/email.php)

- [strcmp benchmark](php/strcmp_benchmark.php)

- [group shuffled words](php/words.php)

- [transport's issue OOP style](php/transport_oop.php)

- [simple sorting methods](php/sorting.php)

- [simple + heap + b-tree sorting OOP style](php/sorting_oop.php)

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

