CREATE TABLE user (
  id SERIAL PRIMARY KEY,
  username VARCHAR(20) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  updated_at TIMESTAMP
);

CREATE TABLE subject (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT
);

CREATE TABLE genre (
  id SERIAL PRIMARY KEY,
  subject_id INT REFERENCES subject(id) NOT NULL,
  name VARCHAR(255) NOT NULL,
  description TEXT
);

CREATE TABLE subgenre (
  id SERIAL PRIMARY KEY,
  subject_id INT REFERENCES subject(id),
  genre_id INT REFERENCES genre(id),
  name VARCHAR(255),
  description TEXT
);

CREATE TABLE title (
  id SERIAL PRIMARY KEY,
  subject_id INT REFERENCES subject(id),
  genre_id INT REFERENCES genre(id),
  subgenre_id INT REFERENCES subgenre(id),
  name VARCHAR(255),
  description TEXT
);

CREATE TABLE star (
  id SERIAL PRIMARY KEY,
  subject_id INT REFERENCES subject(id),
  genre_id INT REFERENCES genre(id),
  subgenre_id INT REFERENCES subgenre(id),
  title_id INT REFERENCES title(id),
  name VARCHAR(255),
  description TEXT
);