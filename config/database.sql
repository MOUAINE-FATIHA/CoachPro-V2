create table users (
    id INT AUTO_INCREMENT primary key,
    nom VARCHAR(20) not null,
    prenom VARCHAR(20) not null,
    email VARCHAR(50) not null UNIQUE,
    password VARCHAR(10) not null,
    role ENUM('admin', 'coach', 'sportif') not null
);
-----------------------------------------------
create table coaches (
    id INT AUTO_INCREMENT primary key,
    id_user INT not null,
    discipline VARCHAR(50) not null,
    annees_exp INT not null,
    description TEXT,
    FOREIGN KEY (id_user) REFERENCES users(id)
);
---------------------------------------------
create table sportifs (
    id INT AUTO_INCREMENT primary key,
    id_user INT not null,
    foreign key (id_user) references users(id)
);
-----------------------------------------------
create table seances (
    id INT AUTO_INCREMENT primary key,
    id_coach int not null,
    date date not null,
    heure time not null,
    duree int not null,
    statut ENUM('disponible','reservee') default 'disponible',
    foreign KEY (id_coach) REFERENCES coaches(id)
);
------------------------------------------------
create table reservations (
    id INT AUTO_INCREMENT primary key,
    id_seance INT not null UNIQUE,
    id_sportif INT not null,
    date_reserv DATETIME default CURRENT_TIMESTAMP,
    foreign key (id_seance) REFERENCES seances(id),
    foreign key (id_sportif) REFERENCES sportifs(id)
);
---------------------------------------------------
insert into users (nom, prenom, email, password, role) values
('ali', 'alawi', 'ali@gmail.com', '111', 'coach'),
('salimi', 'ahmed', 'salimi@gmail.com', '222', 'sportif');
---------------------------------------------------