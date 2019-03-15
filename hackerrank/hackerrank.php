<?php



// SQL

select * from city c where countrycode='USA' and population > 100000;

select distinct s.city from station s where mod(id, 2) = 0;