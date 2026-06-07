CREATE TABLE account_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE monster_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password TEXT NOT NULL,
    account_type_id INTEGER NOT NULL REFERENCES account_types(id),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE monsters (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    image_url TEXT,
    monster_type_id INTEGER REFERENCES monster_types(id) ON DELETE SET NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS ratings;

CREATE TABLE ratings (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    monster_id INTEGER NOT NULL REFERENCES monsters(id) ON DELETE CASCADE,
    rating INTEGER NOT NULL CHECK (rating >= 1 AND rating <= 10),
    sourness INTEGER NOT NULL CHECK (sourness >= 1 AND sourness <= 10),
    sweetness INTEGER NOT NULL CHECK (sweetness >= 1 AND sweetness <= 10),
    carbonation INTEGER NOT NULL CHECK (carbonation >= 1 AND carbonation <= 10),
    energy_kick INTEGER NOT NULL CHECK (energy_kick >= 1 AND energy_kick <= 10),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, monster_id)
);

INSERT INTO account_types (name) VALUES ('user'), ('admin');