# [Project Name]

A real-time web application built with **Laravel** and **Laravel Reverb**.

## 🚀 Technologies

-   **Backend:** Laravel 11.x
-   **Frontend:** Blade / Vue / React (Vite)
-   **WebSockets:** Laravel Reverb
-   **Database:** MySQL / SQLite

## 📋 Prerequisites

Before you begin, ensure you have met the following requirements:

-   PHP >= 8.2
-   Composer
-   Node.js & NPM

## 🛠 Installation

1.  **Clone the repository**
    ```bash
    git clone [https://github.com/yourusername/repo-name.git](https://github.com/yourusername/repo-name.git)
    cd repo-name
    ```

2.  **Install PHP dependencies**
    ```bash
    composer install
    ```

3.  **Install Node dependencies**
    ```bash
    npm install
    ```

4.  **Environment Setup**
    Copy the example environment file and configure your variables.
    ```bash
    cp .env.example .env
    ```

5.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

6.  **Database Migration**
    ```bash
    php artisan migrate
    ```

## 📡 Reverb (WebSocket) Configuration

This project uses Laravel Reverb for real-time broadcasting. You must configure your `.env` file correctly for the browser to connect.

Open your `.env` file and ensure the Reverb section looks like this:

```ini
REVERB_APP_ID=my-app-id
REVERB_APP_KEY=my-app-key
REVERB_APP_SECRET=my-app-secret
REVERB_HOST="0.0.0.0"
REVERB_PORT=8080
REVERB_SCHEME=http

# IMPORTANT: VITE_REVERB_HOST must be reachable by the browser (e.g., localhost)
VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="localhost"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"

Note: Do not set VITE_REVERB_HOST to 0.0.0.0 locally, or the browser connection will fail.

🏃‍♂️ Running the Application

To run the application locally, you need to run three separate processes:

    Start the Laravel Server
    Bash

php artisan serve

Start the Vite Development Server (for assets and frontend HMR)
Bash

npm run dev

Start the Reverb WebSocket Server
Bash

    php artisan reverb:start

Access the application at http://localhost:8000.
🐛 Troubleshooting

WebSocket connection failed / interrupted:

    Ensure php artisan reverb:start is running.

    Check your .env file: VITE_REVERB_HOST should be localhost, while REVERB_HOST can remain 0.0.0.0.

    After changing .env, restart npm run dev to reload the environment variables.
