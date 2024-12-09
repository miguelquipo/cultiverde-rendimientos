CREATE TABLE Usuarios (
    id INT PRIMARY KEY IDENTITY(1,1),
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    session_active BIT NOT NULL DEFAULT 0,
    FOREIGN KEY (role_id) REFERENCES Roles(role_id)
);
CREATE TABLE Roles (
    role_id INT PRIMARY KEY IDENTITY(1,1),
    role_name VARCHAR(50) NOT NULL UNIQUE
);
CREATE TABLE PageAccess (
    id INT PRIMARY KEY IDENTITY(1,1),
    role_id INT NOT NULL,
    page VARCHAR(255) NOT NULL,
    FOREIGN KEY (role_id) REFERENCES Roles(role_id)
);
CREATE TABLE Sesiones (
    session_id INT PRIMARY KEY IDENTITY(1,1),
    user_id INT,
    session_start DATETIME,
    session_end DATETIME,
    FOREIGN KEY (user_id) REFERENCES Usuarios(id)
);
INSERT INTO Roles (role_name) VALUES
('admin'),
('editor'),
('viewer');

INSERT INTO PageAccess (role_id, page) VALUES
((SELECT role_id FROM Roles WHERE role_name = 'admin'), 'admin_dashboard.php'),
((SELECT role_id FROM Roles WHERE role_name = 'admin'), 'editor_dashboard.php'),
((SELECT role_id FROM Roles WHERE role_name = 'admin'), 'viewer_page.php'),
((SELECT role_id FROM Roles WHERE role_name = 'editor'), 'editor_dashboard.php'),
((SELECT role_id FROM Roles WHERE role_name = 'editor'), 'viewer_page.php'),
((SELECT role_id FROM Roles WHERE role_name = 'viewer'), 'viewer_page.php');

---script en ejecion:
--CREATE TABLE script_status (
  --  id INT PRIMARY KEY IDENTITY(1,1),
  --  script_name VARCHAR(255),
  --  is_running BIT,
  --  last_update DATETIME
--);

