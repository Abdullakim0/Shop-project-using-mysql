# Shop Project
Welcome to the Shop Project, an engaging web application designed to seamlessly integrate user and admin functionalities with a robust database backend. This project leverages the power of XAMPP Apache 
server and MySQL through phpMyAdmin, with HTML and PHP driving the interface and logic.

# Project Overview
Our website features distinct user roles: regular users and administrators, each with tailored interfaces and functionalities. All interactions are meticulously recorded in a relational database, 
ensuring data integrity and security through foreign key and primary key relationships.

# User Experience
Upon entering the website, users are greeted with three primary options:

Registration: New users can create an account, providing their details for authentication and personalized service.
Login: Returning users can access their accounts using secure authentication mechanisms that verify their credentials against the database.
Contact: Users can reach out with inquiries or feedback, facilitating open communication.
# Admin Capabilities
Administrators enjoy a streamlined experience with no need for registration. Two default admin accounts are pre-configured in the MySQL admins table, ensuring immediate access for authorized personnel. 
Admin credentials are securely managed and only accessible through the database.

# User Activities
Post-login, users can explore and order from five specialized plant categories:

Medical: Discover plants with medicinal properties.
Industrial: Explore plants used in industrial applications.
Scientific: Find plants significant for scientific research.
Chemical: Order plants with chemical applications.
Gardening: Select from a variety of gardening plants.
Each category showcases only the relevant plants, streamlining the ordering process. Once an order is placed, it is directed to the admin portal for processing.

# Admin Portal
The admin portal is a hub of activity, offering comprehensive management capabilities:

View Applications: Review and manage user applications.
View Questions: Respond to user inquiries and feedback.
Manage Plants: Add or remove plants, ensuring the catalog is up-to-date.
Order Products: Procure products from suppliers, maintaining an optimal inventory.
Admins can effortlessly handle client requests, ensuring a smooth and responsive service experience.

# Database Design
The backbone of the project is a meticulously crafted database comprising 12 interconnected tables. This relational design ensures data consistency and integrity, supporting the seamless operation of 
both user and admin functionalities.

# Technologies Used
Frontend: HTML for structuring the user interface.
Backend: PHP for server-side logic and database interaction.
Database: MySQL, managed via phpMyAdmin, for storing and retrieving data.
Getting Started
To explore this project, set up the environment using XAMPP and import the provided SQL schema into phpMyAdmin. With the server running, users can start interacting with the application, while admins 
can log in to manage and oversee operations.
