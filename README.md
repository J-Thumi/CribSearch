#  CribSearch

**CribSearch** is a web-based house and accommodation discovery platform designed to make it easier for students and other tenants to find suitable houses, apartments, and rental spaces.

The platform focuses on simplifying the process of discovering available houses, viewing property information, contacting landlords/agents, and navigating to properties.

> **CribSearch — Find your next crib without the hassle.**

---

##  Table of Contents

* [Overview](#-overview)
* [Key Features](#-key-features)
* [How It Works](#-how-it-works)
* [Technology Stack](#-technology-stack)
* [Project Structure](#-project-structure)
* [Requirements](#-requirements)
* [Installation](#-installation)
* [Environment Configuration](#-environment-configuration)
* [Database Setup](#-database-setup)
* [Frontend Setup](#-frontend-setup)
* [Running the Application](#-running-the-application)
* [Docker](#-docker)
* [Deployment](#-deployment)
* [House Listings](#-house-listings)
* [Contact & Communication](#-contact--communication)
* [Payments](#-payments)
* [Email](#-email)
* [Security](#-security)
* [Testing](#-testing)
* [Useful Artisan Commands](#-useful-artisan-commands)
* [Troubleshooting](#-troubleshooting)
* [Contributing](#-contributing)
* [License](#-license)

---

##  Overview

Finding accommodation can be frustrating, especially for students who are new to an area and don't know where available houses are located.

CribSearch provides a centralized platform where users can:

* Search for available houses.
* Filter properties according to their preferences.
* View house details and images.
* Check property locations.
* Contact the property owner or agent.
* Navigate to a property.
* Unlock additional house information where applicable.
* Discover accommodation around their preferred location.

The platform is particularly useful for students looking for accommodation around university campuses and surrounding residential areas.

---

##  Key Features

###  House Search

Users can search for available houses based on criteria such as:

* Location
* House type
* Price
* Number of bedrooms
* Availability
* Other property attributes

The search interface is designed to make it easy to narrow down a large number of listings.

---

###  House Listings

Each property can contain information such as:

* House name
* Description
* Monthly rent
* House type
* Number of bedrooms
* Amenities
* Location
* Property images
* Contact information
* Map/navigation information

---

###  Property Images

House listings support multiple images so users can get a better understanding of the property before visiting.

A lightbox/gallery interface can be used to browse images without leaving the property page.

---

### Location & Navigation

CribSearch provides location information for properties and can integrate map/navigation functionality.

Users can use the provided location to find the property physically.

---

###  WhatsApp Contact

Users can contact property owners or agents directly through WhatsApp.

A property-specific message can be generated automatically, for example:

> Hi, I am interested in this house.

The WhatsApp link can also contain information identifying the specific property the user is interested in.

---

###  Authentication

CribSearch supports user authentication, including:

* Registration
* Login
* Logout
* Authenticated user sessions
* Protected routes

Certain house information or actions can be restricted to authenticated users.

---

###  House Details Unlocking

CribSearch can restrict certain property details until a user completes the required action.

The application keeps track of whether a user has unlocked access to additional house information.

This can be used together with the platform's payment functionality.

---

###  Payments

CribSearch supports payment integration for paid features.

The payment architecture can be used to allow users to pay for services such as accessing additional property information.

Payment providers can be configured through environment variables.

---

###  Contact Us

Users can submit inquiries through the Contact Us functionality.

Contact submissions can be stored in the database so that administrators can review and respond to them later.

---

###  Responsive Design

The interface is designed to work across:

* Desktop
* Laptop
* Tablet
* Mobile phones

The frontend uses responsive layouts to provide a usable experience on smaller screens.

---

##  Technology Stack

### Backend

* **PHP**
* **Laravel**
* Laravel Eloquent ORM
* Laravel Blade
* Laravel Authentication

### Frontend

* **Blade**
* **Tailwind CSS**
* **JavaScript**
* **Alpine.js**
* **Vite**

### Database

CribSearch can be configured to work with a supported Laravel database such as:

* MySQL
* MariaDB
* PostgreSQL
* SQLite

### External Services

Depending on the deployment/configuration, CribSearch may integrate with services such as:

* WhatsApp
* M-Pesa/payment providers
* SMTP/email providers
* Maps/navigation services
* Cloud storage
* Docker
* Container hosting platforms

---

#  Project Structure

A simplified Laravel project structure looks like:

```text
cribsearch/
│
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   │
│   ├── Models/
│   ├── Providers/
│   └── Services/
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   ├── build/
│   ├── images/
│   └── index.php
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
│   ├── web.php
│   └── console.php
│
├── storage/
│
├── tests/
│
├── .env.example
├── artisan
├── composer.json
├── package.json
├── vite.config.js
├── Dockerfile
├── docker-compose.yml
└── README.md
```

---

#  Requirements

Before installing CribSearch locally, make sure you have the required development tools.

### Required

* PHP
* Composer
* Node.js
* npm
* Git
* A supported database

### Optional

* Docker
* Docker Compose
* Redis
* Nginx
* Supervisor

You can verify your installations with:

```bash
php -v
composer -V
node -v
npm -v
git --version
```

---

#  Installation

## 1. Clone the repository

```bash
git clone https://github.com/J-Thumi/CribSearch.git

git clone git@github.com:J-Thumi/CribSearch.git
```

Move into the project directory:

```bash
cd cribsearch
```

---

## 2. Install PHP dependencies

```bash
composer install
```

For production installations, use:

```bash
composer install --no-dev --optimize-autoloader
```

---

## 3. Create the environment file

Copy the example environment file:

```bash
cp .env.example .env
```

---

## 4. Generate the application key

```bash
php artisan key:generate
```

---

## 5. Configure the database

Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cribsearch
DB_USERNAME=root
DB_PASSWORD=
```

Create the database before running the migrations.

---

#  Environment Configuration

A typical `.env` configuration contains:

```env
APP_NAME=CribSearch
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cribsearch
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database

CACHE_STORE=database

QUEUE_CONNECTION=database
```

Additional environment variables may be required for external services.

### Never commit `.env`

The `.env` file contains sensitive configuration and credentials.

It should remain in `.gitignore` and `.dockerignore`.

---

#  Database Setup

Run the migrations:

```bash
php artisan migrate
```

If the application provides seeders:

```bash
php artisan db:seed
```

Or:

```bash
php artisan migrate --seed
```

For a completely fresh development database:

```bash
php artisan migrate:fresh --seed
```

>  Do not use `migrate:fresh` on a production database unless you intentionally want to delete the existing database tables and data.

---

#  Frontend Setup

Install JavaScript dependencies:

```bash
npm install
```

Start the Vite development server:

```bash
npm run dev
```

For production:

```bash
npm run build
```

The generated frontend assets will be placed in:

```text
public/build/
```

---

# Running the Application

Start Laravel's development server:

```bash
php artisan serve
```

The application will normally be available at:

```text
http://127.0.0.1:8000
```

In another terminal, start Vite:

```bash
npm run dev
```

A typical development workflow therefore uses:

### Terminal 1

```bash
php artisan serve
```

### Terminal 2

```bash
npm run dev
```

---

#  Docker

CribSearch can also be containerized using Docker.

Build the image:

```bash
docker build -t cribsearch .
```

Run the container:

```bash
docker run -p 8000:8000 cribsearch
```

If using Docker Compose:

```bash
docker compose up -d
```

View running containers:

```bash
docker compose ps
```

View application logs:

```bash
docker compose logs -f
```

Stop the application:

```bash
docker compose down
```

---

## Docker Production Build

A production Docker build should generally:

1. Install PHP dependencies.
2. Install frontend dependencies.
3. Build frontend assets.
4. Remove development dependencies.
5. Copy only the required application files.
6. Run the application using an appropriate production web server/process setup.

Example:

```bash
docker build \
    --no-cache \
    -t cribsearch:latest \
    .
```

Run:

```bash
docker run -d \
    --name cribsearch \
    -p 8000:8000 \
    cribsearch:latest
```

---

#  Deployment

CribSearch can be deployed using container-based hosting.

A typical production workflow is:

```text
Developer
   │
   ▼
Git Repository
   │
   ▼
GitHub Actions
   │
   ├── Run tests
   ├── Build Docker image
   └── Push image
           │
           ▼
      Container Registry
           │
           ▼
      Production Server
           │
           ▼
       CribSearch
```

For Docker-based deployment, make sure the production environment provides:

* Application environment variables
* Database connection
* Storage configuration
* Mail configuration
* Payment credentials
* External API credentials
* HTTPS
* Proper application secrets

---

#  House Listings

House listings are the core of CribSearch.

A typical house contains information such as:

```text
House
├── Name
├── Description
├── Location
├── Rent
├── Type
├── Bedrooms
├── Amenities
├── Images
├── Contact Number
├── Coordinates
└── Availability
```

Listings should contain accurate information to help users make informed decisions.

---

#  Contact & Communication

CribSearch can provide several communication channels.

### WhatsApp

A property-specific WhatsApp URL can be generated using the property's contact number and name.

Example:

```php
<a
    href="https://wa.me/{{ $phone }}?text={{ urlencode(
        'Hi, I am interested in ' . $house->name
    ) }}"
    target="_blank"
>
    Contact on WhatsApp
</a>
```

This allows the recipient to know which property the user is asking about.

---

#  Email

Contact form submissions can be saved to the database.

A typical contact record can contain:

```text
id
name
email
phone
subject
message
created_at
updated_at
```

Mail delivery can be configured through Laravel's mail environment variables.

Example:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

#  Payment Integration

Payment functionality should be configured using environment variables rather than hard-coding credentials.

Example:

```env
PAYMENT_API_KEY=
PAYMENT_SECRET=
PAYMENT_CALLBACK_URL=
```

For M-Pesa-based integrations, additional provider-specific credentials may be required.

> **Security:** Never commit payment credentials, API keys, access tokens, or private keys to Git.

---

#  Security

Security is an important part of CribSearch because the application handles user accounts, contact information, property information, and potentially payment data.

### Environment Variables

Never commit:

```text
.env
API keys
Passwords
Private keys
Payment credentials
SMTP credentials
Database credentials
```

---

### Input Validation

User input should always be validated before being stored or processed.

Laravel Form Requests can be used for complex validation.

Example:

```php
$request->validate([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'email'],
    'message' => ['required', 'string'],
]);
```

---

### Authentication

Protected functionality should use Laravel authentication and authorization mechanisms.

Users should only be able to access resources they are authorized to access.

---

### Production Configuration

Production environments should use:

```env
APP_ENV=production
APP_DEBUG=false
```

Do not expose detailed exception messages to production users.

---

#  Testing

Run the Laravel test suite using:

```bash
php artisan test
```

Alternatively:

```bash
./vendor/bin/phpunit
```

Run a specific test:

```bash
php artisan test --filter=HouseTest
```

For more verbose output:

```bash
php artisan test -v
```

---

#  Code Quality

Before committing changes, it is recommended to run your project's configured code-formatting and static-analysis tools.

For Laravel Pint:

```bash
./vendor/bin/pint
```

Check the project for common issues before pushing:

```bash
php artisan route:list
php artisan config:clear
php artisan cache:clear
```

---

# Useful Artisan Commands

### Clear application caches

```bash
php artisan optimize:clear
```

### Cache configuration

```bash
php artisan config:cache
```

### Cache routes

```bash
php artisan route:cache
```

### Cache views

```bash
php artisan view:cache
```

### Run migrations

```bash
php artisan migrate
```

### Roll back the latest migration batch

```bash
php artisan migrate:rollback
```

### Create a controller

```bash
php artisan make:controller HouseController
```

### Create a model and migration

```bash
php artisan make:model House -m
```

### Create a seeder

```bash
php artisan make:seeder HouseSeeder
```

### List routes

```bash
php artisan route:list
```

### Open Laravel Tinker

```bash
php artisan tinker
```

---

#  Troubleshooting

## Permission problems

If Laravel cannot write to storage:

```bash
chmod -R 775 storage bootstrap/cache
```

On Linux, you may also need to ensure the web-server user owns the directories.

---

## Application key error

Run:

```bash
php artisan key:generate
```

---

## Configuration changes not taking effect

Run:

```bash
php artisan optimize:clear
```

Then rebuild the relevant caches.

---

## Composer dependency problems

Try:

```bash
rm -rf vendor
composer install
```

---

## NPM dependency problems

Try:

```bash
rm -rf node_modules
rm -f package-lock.json
npm install
```

> If this is a shared/production project, avoid deleting `package-lock.json` unless you intentionally want to regenerate the dependency lockfile.

---

## Database connection problems

Check:

```bash
php artisan about
```

Verify the database configuration in `.env` and ensure the database server is running.

---

## Vite assets not loading

Run:

```bash
npm install
npm run build
```

For development:

```bash
npm run dev
```

Then verify that Laravel's Vite configuration is correctly configured.

---

#  Contributing

Contributions are welcome.

### 1. Fork the repository

Create your own fork of the CribSearch repository.

### 2. Create a feature branch

```bash
git checkout -b feature/my-new-feature
```

### 3. Make your changes

Implement and test your changes.

### 4. Run tests

```bash
php artisan test
```

### 5. Commit your changes

```bash
git add .
git commit -m "feat: add my new feature"
```

### 6. Push your branch

```bash
git push origin feature/my-new-feature
```

### 7. Open a Pull Request

Describe:

* What changed
* Why it changed
* How it was tested
* Any configuration changes required

---

#  Suggested Commit Convention

CribSearch can follow conventional commit-style messages:

```text
feat: add house search filters
fix: resolve WhatsApp property link
docs: update installation instructions
refactor: simplify house service
test: add house search tests
chore: update dependencies
style: improve mobile house cards
```

---

#  Roadmap

Potential future improvements include:

* [ ] Advanced house filtering
* [ ] Saved/favourite houses
* [ ] House comparison
* [ ] User reviews and ratings
* [ ] Landlord/agent dashboards
* [ ] House availability tracking
* [ ] Improved map-based house discovery
* [ ] Notifications
* [ ] Email notifications
* [ ] WhatsApp notifications
* [ ] More payment integrations
* [ ] Mobile application
* [ ] Recommendation system
* [ ] Analytics dashboard
* [ ] Admin moderation tools
* [ ] Property verification
* [ ] Fraud/scam reporting

---

#  Development Philosophy

CribSearch aims to solve a practical problem:

> **Make finding accommodation simpler, faster, and more transparent.**

The platform should prioritize:

* Simplicity
* Accurate property information
* Mobile usability
* Security
* Performance
* Accessibility
* Reliable communication
* A good user experience

---

#  License

This project is proprietary unless otherwise stated by the project owner.

If this repository is intended to be open source, replace this section with the appropriate license, such as the MIT License.

---

#  Author

**CribSearch**

Built to make house hunting easier for students and tenants.

---

##  Support the Project

If you find CribSearch useful, consider:

* Starring the repository
*  Reporting bugs
*  Suggesting improvements
*  Contributing features
*  Sharing the platform with people looking for accommodation

**Find your next crib. Search smarter.**
