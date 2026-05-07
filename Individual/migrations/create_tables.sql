DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user' CHECK (role IN ('user', 'admin')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE jobs (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(150) NOT NULL,
    company VARCHAR(150) NOT NULL,
    city VARCHAR(100) NOT NULL,
    salary NUMERIC(10, 2),
    employment_type VARCHAR(30) NOT NULL CHECK (employment_type IN ('full-time', 'part-time', 'remote', 'internship')),
    description TEXT NOT NULL,
    is_remote BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin password: admin123
INSERT INTO users (name, email, password, role)
VALUES (
    'Admin',
    'admin@example.com',
    '$2y$10$JD3W0Jpvf4rQnwbz2JWS0eCJFYmmzbTHnPKqDTWf7dOY78FWKw1TK',
    'admin'
);

INSERT INTO jobs (user_id, title, company, city, salary, employment_type, description, is_remote)
VALUES
(1, 'Junior PHP Developer', 'TechSoft', 'Chisinau', 12000, 'full-time', 'Development of web applications using PHP and PostgreSQL.', false),
(1, 'Frontend Developer', 'Web Studio', 'Balti', 10000, 'remote', 'Creating user interfaces with HTML, CSS and JavaScript.', true),
(1, 'Intern Web Developer', 'StartUp Lab', 'Chisinau', 5000, 'internship', 'Internship for students who want to learn web development.', true);
