# inserção de alguns dados iniciais

INSERT INTO role (role_name) VALUES ("ADMIN");
INSERT INTO role (role_name) VALUES ("SIMPLE_CUSTOMER");
INSERT INTO user (name, email, active, password) VALUES 
("admin", "admin@gmail.com", 1, "admin123admin");
INSERT INTO user_role (id_user, id_role) VALUES (1,1);