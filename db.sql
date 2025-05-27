CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Создание таблицы заявлений
CREATE TABLE Applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_number VARCHAR(20) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('новое', 'подтверждено', 'отклонено') DEFAULT 'новое',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);

-- Пример добавления пользователя
INSERT INTO Users (full_name, phone, email, username, password)
VALUES ('Иванов Иван Иванович', '1234567890', 'ivanov@example.com', 'ivanov', 'hashed_password');

-- Пример добавления заявления
INSERT INTO Applications (user_id, car_number, description)
VALUES (1, 'A123BC', 'Превышение скорости');