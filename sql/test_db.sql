create schema if not exists test collate utf8mb4_0900_ai_ci;

create table if not exists user
(
  id int auto_increment
    primary key,
  name varchar(255) not null
);

create table if not exists car
(
  id int auto_increment
    primary key,
  user_id int not null,
  price int null,
  constraint car_user_id_fk
    foreign key (user_id) references user (id)
      on update cascade on delete cascade
);

