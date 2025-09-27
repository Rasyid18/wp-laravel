# Laravel + Vue WordPress Admin Tool

This project is an internal/admin tool that connects to a WordPress database to manage users. Below are the steps required to set up and run the project.

## Prerequisites

* PHP >= 8.x
* Composer
* Node.js & NPM/Yarn
* MySQL
* A working WordPress project with an existing database

## Setup Instructions

1. **Clone the repository**

```bash
git clone <repository-url>
cd <project-folder>
```

2. **Install Laravel dependencies**

```bash
composer install
```

3. **Install frontend dependencies**

```bash
npm install
# or
yarn install
```

4. **Setup environment**

* Copy `.env.example` to `.env`
* Configure your Laravel database connection in `.env`
* Set up other environment variables as needed

5. **Run migrations**

```bash
php artisan migrate
```

6. **Seed the default admin user**

```bash
php artisan db:seed --class=UserSeeder
```

> **Note:** The default admin user is:
>
> * Email: `admin@wplaravel.com`
> * Password: `Test123!`

7. **Compile frontend assets & serve the application**

```bash
composer run dev
```

8. **Access the website**

* Open your browser and go to `http://localhost:8000`
* Login with the default admin credentials above

9. **Setup WordPress connection**

* Navigate to the WordPress Connection page in the admin panel
* Provide your WordPress database credentials and table prefix

10. **Manage WordPress Users**

* Once the connection is configured, you can access the WordPress Users page
* Add, edit, and delete users as needed

## Notes

* This project uses a **dynamic WordPress connection**, so all WordPress tables are queried using the credentials set in the WordPress Connection form.
* Passwords are stored using WordPress-compatible hashing.
* User roles are serialized in the `wp_usermeta` table and automatically handled in the API responses.

## Troubleshooting

* If you encounter `Base table or view not found` errors, make sure the WordPress connection is set up correctly.
* For frontend issues, ensure `composer run dev` has successfully compiled the assets.
