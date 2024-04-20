# Subscriptions Service

This guide provides instructions on how to set up and run the Subscriptions Service using Docker. The setup includes an Adminer interface for database management and seeded data for users and websites. A Postman collection is also provided for API testing.

## Prerequisites

Docker needs to be installed on the host machine to run the Subscriptions Service in a containerized environment.

## Getting Started

Follow these steps to get the application up and running:

### Step 1: Clone the Repository

Clone this repository to your local machine using:

```bash
git clone https://github.com/Ntezi/subscription-service.git
cd subscription-service
```

### Step 2: Set Up Environment

*`.env` will be shared separately, I will share the `.env` file separately, which contains all necessary configurations, including database settings.* 

But you can create a new `.env` file by copying the example file:
```bash
cp .env.example .env
```

### Step 3: Start Docker Containers

Run the following command in the root directory of the project to build and start the Docker containers:

```bash
docker-compose up --build
```

This command builds the application and starts all services defined in `docker-compose.yml`, including the Subscriptions Service, MySQL database, and Adminer. It also run the migrations and seed the database.

### Step 4: Access the Application

Once the containers are up and running, the Subscriptions Service will be accessible at:

```
http://localhost:2403
```

### Step 5: Database Management with Adminer

Adminer is set up to manage the application's database. You can access it at:

```
http://localhost:2402
```

Use the database credentials defined in your `.env` file to log in.

### Step 6: API Testing with Postman

A Postman collection is included to test the API endpoints. Import the collection into your Postman application to start making API requests to the application.
Check the root directory for the `Subscription Service APIs.postman_collection.json` file.

## Troubleshooting

If you encounter any issues during the setup, ensure Docker is running correctly and all environment variables in your `.env` file are set accurately. Restarting Docker containers can also resolve many configuration-related issues:

```bash
docker-compose down
docker-compose up --build
```
