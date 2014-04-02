CREATE DATABASE mnc_challenge;
USE mnc_challenge;

CREATE TABLE person (
    user_id int not null auto_increment,
    firstname varchar(100) not null,
    lastnames varchar(100) not null,
    address varchar (250) not null,
    birthday date, 
    PRIMARY KEY (user_id)
);


CREATE TABLE job (
    job_id int not null auto_increment,
    description varchar(200) not null,
    salary numeric(6,2),
    immediate int not null,
    PRIMARY KEY(job_id),
    FOREIGN KEY(immediate) REFERENCES person(user_id)
);

CREATE TABLE job_rel (
    user_id int not null,
    job_id int not null,
    PRIMARY KEY (user_id, job_id),
    FOREIGN KEY (user_id) REFERENCES person(user_id),
    FOREIGN KEY (job_id) REFERENCES job(job_id)
);

CREATE TABLE attendance (
    att_id int not null auto_increment,
    user_id int not null,
    check_hour timestamp default now(),
    PRIMARY KEY (att_id),
    FOREIGN KEY (user_id) REFERENCES person(user_id)
);