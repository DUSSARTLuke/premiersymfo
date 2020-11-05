CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, salaire NUMERIC(9, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

insert into employe(nom, salaire) values
('Martin', 10000.00),
('Dupont', 23000.00),
('Russot', 45600.00),
('Delevoy', 12000.00),
('Dumans', 34000.00);

CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(60) NOT NULL, ville VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
ALTER TABLE employe ADD lieu_id INT DEFAULT NULL;
ALTER TABLE employe ADD CONSTRAINT FK_F804D3B96AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id);
CREATE INDEX IDX_F804D3B96AB213CC ON employe (lieu_id);

Insert into lieu(nom, ville) values 
('Ets Blanchard', 'Toulon'),
('Société Dipassa', 'Paris');

update employe
set idLieu=1
where id IN(1, 2,4);

update employe
set idLieu=2
where id IN(3, 5);
