# Microsoft Chat Web App

## Overview

This project is a chat web application that integrates with Microsoft Entra ID to fetch user data and allows users to view and manage chat conversations. The application uses a Laravel backend and a Vue.js frontend, and it also communicates with a Python Flask app for specific tasks.

## Features

- **User Management**: View and manage users from Microsoft Entra ID.
- **Chat Management**: View and manage chat conversations between users.
- **Data Synchronization**: Fetch and store users and chats in a Microsoft SQL Server database.

## Technologies Used

- **Backend**: Laravel
- **Frontend**: Vue.js with Inertia.js
- **Database**: Microsoft SQL Server
- **Other**: Python Flask app for specific tasks

## Getting Started

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js and npm
- Microsoft SQL Server instance

### Installation

#### Laravel App

1. **Clone the repository**:

    ```bash
    git clone https://github.com/Spyros34/TeamsChatWebApp.git
    cd microsoft-chat-web-app
    ```

2. **Set up environment variables**:

    Create a `.env` file in the root directory and configure your database and other settings:

    ```dotenv
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://localhost

    LOG_CHANNEL=stack

    DB_CONNECTION=sqlsrv
    DB_HOST=your_sql_server_host
    DB_PORT=1433
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    ```

3. **Install dependencies**:

    ```bash
    composer install
    npm install
    npm run dev
    ```

4. **Generate application key**:

    ```bash
    php artisan key:generate
    ```

5. **Run database migrations**:

    ```bash
    php artisan migrate
    ```

6. **Serve the application**:

    ```bash
    php artisan serve
    ```

#### Flask App

1. **Navigate to the Flask app directory**:

    ```bash
    cd path/to/your/flask_app
    ```

2. **Set up a virtual environment**:

    ```bash
    python3 -m venv venv
    source venv/bin/activate
    ```

3. **Install dependencies**:

    ```bash
    pip install -r requirements.txt
    ```

4. **Run the Flask app**:

    ```bash
    flask run
    ```

## Usage

- Navigate to `http://localhost:8000` to access the application.
- Use the navbar to switch between users and chat management.

## Project Structure

- **Laravel Backend**: Manages API endpoints, user authentication, and database interactions.
- **Vue.js Frontend**: Provides a reactive user interface for managing users and chats.
- **Python Flask App**: Handles specific tasks such as fetching user data from Microsoft Entra ID.

## Additional Information

### Users Feature

The users feature allows you to view all the users that are listed in the Microsoft Entra ID. You can navigate to the users page by pressing the user icon on the navbar.

In the users page, all the users that are currently in the SQL database server in Microsoft Azure are displayed. If there are no users, you can press the reload users button to automatically load the users from the Microsoft Entra ID, save them in the database, and display them on the web page.

### Chats Feature

The chats feature allows you to view all the chat conversations between the users listed in the Microsoft Entra ID and saved in the SQL database server. You can navigate to the chats page by pressing the chat icon on the navbar.

In the chat page, there is an option to choose the "From" - "To" period dates to display all the chats between the users from that period. All the chats are saved in the SQL database server in Microsoft Azure. If there are no chats, there is an option to generate and load the chats in the database by pressing the reload chats icon.
