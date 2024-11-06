-- Criação da tabela users
CREATE TABLE IF NOT EXISTS users (
    id CHAR(36) PRIMARY KEY, -- UUID
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0  -- 1 para admin, 0 para usuário normal
);


-- Criação da tabela movies
CREATE TABLE IF NOT EXISTS movies (
    id CHAR(36) PRIMARY KEY, -- UUID
    title VARCHAR(255) NOT NULL,
    release_year INT NOT NULL,
    duration INT NOT NULL,
    age_rating VARCHAR(10) NOT NULL,
    trailer_url TEXT NOT NULL,
    cover_image_url TEXT NOT NULL
);