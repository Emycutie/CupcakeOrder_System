CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) UNIQUE,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    birth_date DATE,
    email VARCHAR(100),
    area_code VARCHAR(10),
    phone_number VARCHAR(20),
    cupcake_flavor VARCHAR(100),
    cupcake_size VARCHAR(100),
    quantity INT,
    frosting_flavor VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);