# Learning Management System (LMS)

This is a Learning Management System (LMS) built with Laravel 10 for the backend (API) and Vue 3 for the frontend.

## Installation and Setup

### Clone the Repository
```sh
git clone https://github.com/IsHereZahin/LMS.git
cd LMS
```

### Backend (Laravel 10 API)

#### Requirements:
- PHP 8.1+
- Composer
- MySQL
- Laravel 10

#### Steps:
1. Navigate to the backend folder:
   ```sh
   cd backend
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Copy the environment file and set up the database connection:
   ```sh
   cp .env.example .env
   ```
   Update the `.env` file with your database credentials.
4. Generate the application key:
   ```sh
   php artisan key:generate
   ```
5. Run database migrations and seed the data:
   ```sh
   php artisan migrate --seed
   ```
6. Start the server:
   ```sh
   php artisan serve
   ```

### Frontend (Vue 3)

#### Requirements:
- Node.js 16+
- npm or yarn

#### Steps:
1. Open a new terminal window and navigate to the frontend folder:
   ```sh
   cd frontend
   ```
2. Install dependencies:
   ```sh
   npm install
   ```
3. Start the development server:
   ```sh
   npm run dev
   ```

## Admin & Student Credentials

### Admin Login:
- **Email:** admin@gmail.com
- **Password:** 123456

### Student Login:
- **Email:** student@gmail.com
- **Password:** 123456
