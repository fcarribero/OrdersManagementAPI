
## Usage
1. Start the server by running:

```bash
php artisan server
```

The server will start running on http://localhost:8000.

2. Use API endpoints to perform CRUD operations on orders:

    - GET /orders: Retrieve all orders. 
    - GET /orders/:id: Retrieve a specific order by ID.
    - POST /orders: Create a new order.
    - PUT /orders/:id: Update an existing order by ID.
    - DELETE /orders/:id: Delete an order by ID.

Postman Documentation: https://documenter.getpostman.com/view/1740622/2sA3JKdMuz
   
3. Send requests to the API using your preferred HTTP client (e.g., Postman, cURL).

## Running Unit Tests

This project includes unit tests to ensure the reliability of the API endpoints. To run the tests, execute the following command:

```bash
php artisan test
```

