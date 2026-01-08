# Digital Library System

## Overview
The Digital Library System is a web-based application designed to manage library operations efficiently. It allows users to authenticate, manage books, log visitor entries, and generate reports. Built using PHP 8+, MySQL, and Bootstrap 5, this system is optimized for shared hosting environments.

## Features
- **User Authentication**: Secure login and registration system for users.
- **Book Management**: Add, edit, delete, and view books in the library.
- **Visitor Logs**: Record and manage visitor entries with purpose and details.
- **Reporting**: Generate reports for borrowed books and visitor logs.
- **Responsive Design**: Built with Bootstrap 5 for a mobile-friendly interface.

## Installation
1. **Clone the Repository**: 
   ```
   git clone <repository-url>
   ```
2. **Set Up Database**:
   - Import the `schema.sql` file located in the `database` directory into your MySQL database.
   - Update the database connection settings in `config/database.php`.

3. **Configuration**:
   - Modify `config/config.php` to set your site name and other constants.

4. **Deploy**:
   - Upload the project files to your shared hosting server.
   - Ensure that the server meets the requirements for PHP 8+ and MySQL.

## Usage
- Access the application via the public directory (e.g., `http://yourdomain.com/digital-library-system/public`).
- Use the login page to authenticate or register as a new user.
- Navigate through the dashboard to manage books and visitor logs.

## Contributing
Contributions are welcome! Please fork the repository and submit a pull request for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for more details.