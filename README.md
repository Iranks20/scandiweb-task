
# Scandiweb Junior Developer Product Management Web App

This is a web application built using PHP that allows users to manage products. It provides two main pages: the Product List page and the Add Product page.

## Features

### 1. Product List Page

- Displays a list of products with the following information:
  - SKU (unique for each product)
  - Name
  - Price in $
  - One of the product-specific attributes and its value:
    - Size (in MB) for DVD-disc
    - Weight (in Kg) for Book
    - Dimensions (HxWxL) for Furniture

- UI elements on the Product List page:
  - "ADD" button to navigate to the Add Product page
  - "MASS DELETE" action to delete selected products
  - No pagination, all products are displayed on a single page

### 2. Add Product Page

- Allows users to add a new product to the database.
- The form includes fields for:
  - SKU
  - Name
  - Price
  - Product type switcher with options for DVD, Book, and Furniture
  - Product type-specific attribute:
    - Size (in MB) for DVD-disc
    - Weight (in Kg) for Book
    - Dimensions (HxWxL) for Furniture

- UI elements on the Add Product page:
  - Dynamically updates the form based on the selected product type
  - Provides a description related to the selected product type attribute
  - Validates input fields and displays appropriate notifications for missing or invalid data
  - "Save" button to save the product and return to the Product List page
  - "Cancel" button to cancel adding the product and return to the Product List page

## Technical Details

- The project follows object-oriented programming (OOP) principles to handle differences in product types.
- The PHP code is structured using meaningful classes that extend each other.
- MySQL logic is handled by objects with properties and uses setters and getters for data manipulation.
- The project adheres to PSR standards for coding style and best practices.
- The front-end technologies such as jQuery, jQuery-UI, and Bootstrap are optional.
- SASS can be used for styling advantages.
- The project requires PHP version 7.0 or higher and MySQL version 5.6 or higher.

## Getting Started

To run the web application locally, follow these steps:

1. Clone the repository: `git clone <repository_url>`
2. Set up a web server with PHP and MySQL support (e.g., Apache + PHP + MySQL or XAMPP).
3. Import the provided MySQL database schema and sample data.
4. Configure the database connection in the `config.php` file.
5. Access the web app using the URL provided by your web server.

## Conclusion

This web application provides a simple and efficient way to manage products with different attributes. It demonstrates the use of object-oriented programming principles and best practices in PHP development. Feel free to explore and customize the code to fit your specific needs.

If you have any questions or suggestions, please feel free to reach out. Happy coding!
