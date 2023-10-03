# PHP_project
The project is a basic online store written in pure PHP.
Registration and logging of users who are registered in the database.
Any user can upload products to the store and has access to edit their uploads. Foreign products have no access to change them. When adding products from the store to your cart, it says how many products you have added. When you press the view cart button, it refers to a list of the products you have selected, an opportunity to remove which product you want. From below, the total amount that the products cost is shown and there is a button to buy them.

# Instalation
First you need to create the tables in the database<br>
Create database - "app"<br>
Tables:<br>
CREATE TABLE users (<br>
    id INT PRIMARY KEY AUTO_INCREMENT,<br>
    password VARCHAR(255) NOT NULL,<br>
    username VARCHAR(255) NOT NULL,<br>
    email VARCHAR(255) NOT NULL<br>
);<br>

CREATE TABLE products (<br>
    id INT PRIMARY KEY AUTO_INCREMENT,<br>
    title VARCHAR(255) NOT NULL,<br>
    content TEXT,<br>
    user_id INT NOT NULL,<br>
    image_path VARCHAR(255),<br>
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,<br>
    price DECIMAL(10, 2) NOT NULL<br>
);<br>
