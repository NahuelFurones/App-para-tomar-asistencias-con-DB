USE tecnica6moron;

INSERT INTO Alumno (NroMatricula, Apellido, Nombre) VALUES
(1001, 'Perez', 'Diego'),
(1002, 'Lopez', 'Ana'),
(1003, 'Ruiz', 'Marcelo'),
(1004, 'Tania', 'Alberto'),
(1005, 'Alvarez', 'Luisa'),
(1006, 'Rodriguez', 'Laura'),
(1007, 'Linch', 'Rodrigo'),
(1008, 'Fernandez', 'Federico'),
(1009, 'Busetti', 'Avril'),
(1010, 'Lima', 'Marcela');

INSERT INTO Materia (Nombre) VALUES ('ingles'), ('historia'), ('sado');

INSERT INTO Cursa (NroMatricula, MateriaId) VALUES
(1001,1),(1001,2),
(1002,1),(1002,3),
(1003,2),(1003,3),
(1004,1),
(1005,2),
(1006,1),(1006,2),
(1007,3),
(1008,1),
(1009,2),
(1010,1);
