# Delivery Platform Backend

A Laravel backend for a delivery platform with JWT authentication, SMS verification, profile management, nearest delivery representative lookup, an admin panel, Firebase notifications, and profile image upload with thumbnail generation.

## Technologies

* Laravel 13
* PHP
* MySQL
* JWT Authentication (`tymon/jwt-auth`)
* Twilio Verify for SMS verification
* Firebase Cloud Messaging (FCM)
* Intervention Image
* Laravel Telescope
* Blade
* Postman

## Main Features

### API

* User registration
* Profile image upload and thumbnail generation
* SMS/mobile verification
* JWT login
* Authenticated profile endpoint
* Nearest delivery representatives sorted by distance

### Admin Panel

* Admin login
* Dashboard with user counts
* User CRUD
* User types:

  * `user`
  * `delivery`
  * `admin`
* Firebase notification sending to users with FCM tokens

### Architecture

The project separates responsibilities using:

* Controllers
* Form Requests
* Services
* Repository
* Traits
* Events and Listeners
* Eloquent Models

External integrations are handled through dedicated services:

* `TwilioService`
* `FirebaseService`

## Requirements

Make sure the following are installed:

* PHP
* Composer
* MySQL
* Git
* Web browser
* Postman

## Installation

Clone the project and enter the project directory:

```bash
git clone <YOUR_GITHUB_REPOSITORY_URL>
cd delivery-platform
```

Install PHP dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

On Windows, you can also copy `.env.example` to `.env` manually.

Generate the Laravel application key:

```bash
php artisan key:generate
```

Generate the JWT secret:

```bash
php artisan jwt:secret
```

## Database Setup

Create a MySQL database named:

```text
delivery_platform
```

Configure the database values in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=delivery_platform
DB_USERNAME=root
DB_PASSWORD=YOUR_MYSQL_PASSWORD
```

Run the migrations:

```bash
php artisan migrate
```

Seed the database with development/test data:

```bash
php artisan db:seed
```

### Database Dump

A database dump is included at:

```text
database/delivery_platform.sql
```

The dump contains the database structure and development/test data.

To restore the dump:

```bash
mysql -u root -p delivery_platform < database/delivery_platform.sql
```

## Storage Setup

Create the public storage link:

```bash
php artisan storage:link
```

Profile images are stored under:

```text
storage/app/public/profile-images/
```

Thumbnails are stored under:

```text
storage/app/public/profile-images/thumbnails/
```

## Firebase Setup

The project uses Firebase Cloud Messaging through the Kreait Firebase Laravel package.

Place the Firebase service account JSON file at:

```text
storage/app/firebase/firebase-service-account.json
```

Configure `.env`:

```env
GOOGLE_APPLICATION_CREDENTIALS=storage/app/firebase/firebase-service-account.json
```

The Firebase credentials directory is excluded from Git.

**Do not commit the Firebase service account JSON file.**

## Twilio Setup

The registration flow uses Twilio Verify for SMS verification.

Configure the following values in `.env`:

```env
TWILIO_ACCOUNT_SID=YOUR_TWILIO_ACCOUNT_SID
TWILIO_AUTH_TOKEN=YOUR_TWILIO_AUTH_TOKEN
TWILIO_VERIFICATION_SID=YOUR_TWILIO_VERIFICATION_SID
```

**Do not commit real Twilio credentials.**

SMS verification requires valid Twilio credentials and a usable phone number.

## Run the Application

Start the Laravel development server:

```bash
php artisan serve
```

The application will normally be available at:

```text
http://127.0.0.1:8000
```

## API Endpoints

### Authentication

#### Register

```text
POST /api/register
```

Registers a new user.

Request fields:

* `username`
* `mobile`
* `password`
* `latitude`
* `longitude`
* `profile_image` — optional

For image upload, use `multipart/form-data`.

#### Verify Mobile

```text
POST /api/verify
```

Request fields:

* `mobile`
* `code`

#### Login

```text
POST /api/login
```

Request fields:

* `mobile`
* `password`

A successful login returns a JWT token.

### Profile

#### Get Profile

```text
GET /api/profile
```

Authentication:

```text
Authorization: Bearer <JWT_TOKEN>
```

### Delivery

#### Get Nearest Deliveries

```text
GET /api/deliveries/nearest
```

Authentication:

```text
Authorization: Bearer <JWT_TOKEN>
```

The endpoint returns delivery representatives sorted from nearest to farthest based on the authenticated user's coordinates.

## Admin Panel

### Admin Login

```text
GET /admin/login
POST /admin/login
```

### Dashboard

```text
GET /admin/dashboard
```

### User Management

```text
GET    /admin/users
GET    /admin/users/create
POST   /admin/users
GET    /admin/users/{user}/edit
PUT    /admin/users/{user}
DELETE /admin/users/{user}
```

### Firebase Notification

```text
POST /admin/notifications/send
```

This sends a notification to users who have an FCM token.

## Admin Credentials

The seeded development/admin account is:

```text
Mobile: +233200000010
Password: Password123!
```

These credentials are for the included development/test data and should not be used as production credentials.

## Seeded Test Data

The database seeder creates:

* 1 admin
* 3 normal users
* 5 delivery representatives

The seeded accounts use the development password:

```text
Password123!
```

The seeded data is for development and testing purposes.

## Architecture Overview

### Controllers

Controllers receive requests, call the appropriate service, and return responses.

Business/database logic is kept outside the controllers.

### Form Requests

Validation is handled through Laravel Form Request classes, including:

* `RegisterRequest`
* `LoginRequest`
* `VerifyCodeRequest`
* `AdminUserRequest`
* `AdminLoginRequest`

### Services

Business logic and external integrations are separated into services:

* `AuthService`
* `UserService`
* `DeliveryService`
* `TwilioService`
* `FirebaseService`
* `AdminAuthService`

### Repository

`UserRepository` handles user-related database operations.

This keeps direct database access out of the controllers.

### Traits

Reusable functionality includes:

* `ApiResponseTrait`
* `ImageUploadTrait`

### Events and Listeners

After successful mobile verification:

```text
UserRegistrationVerified
        ↓
SendRegistrationNotification
        ↓
FirebaseService
```

This allows registration verification to trigger a Firebase notification without placing Firebase logic directly inside the controller.

## Error Handling

API errors are handled centrally in `bootstrap/app.php`.

The API provides JSON responses for common errors:

| Error                        | Status |
| ---------------------------- | -----: |
| Validation failed            |    422 |
| Unauthenticated              |    401 |
| Unauthorized                 |    403 |
| Resource not found           |    404 |
| Unexpected application error |    500 |

Unexpected exceptions are logged for debugging.

## Laravel Telescope

Laravel Telescope is installed for application monitoring and debugging.

Open:

```text
http://127.0.0.1:8000/telescope
```

Telescope can be used to inspect:

* Requests
* Queries
* Exceptions
* Logs
* Notifications

## Testing

API testing can be performed using Postman.

Main API flow:

```text
Register
   ↓
Verify SMS
   ↓
Login
   ↓
Get Profile
   ↓
Get Nearest Deliveries
```

Additional failure cases include:

* Wrong password
* Unverified mobile
* Missing required fields
* Invalid coordinates
* Missing JWT
* Invalid JWT
* Unauthorized admin access
* Duplicate mobile number

## Security Notes

Do not commit any of the following:

* `.env`
* Firebase service account JSON
* Real Twilio credentials
* JWT secrets
* Production passwords
* Other private credentials

The Firebase credentials directory is already excluded from Git.

