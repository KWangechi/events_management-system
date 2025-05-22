# Shikisha Events Management System

This document explains how the API and client systems work in the Events Management System.

---

## API System

The API is responsible for handling all backend operations, including user authentication, event management, and data storage.

### Key Features

- **User Authentication:** Register, login, and manage user sessions.
- **Event Management:** Create, update, delete, and list events.
- **Attendee Management:** Register and manage event attendees.
- **RESTful Endpoints:** Communicate using standard HTTP methods (GET, POST, PUT, DELETE).
- **Data Storage:** Uses a database (e.g., PostgreSQL, MongoDB) for persistent storage.

### Example Endpoints

| Method | Endpoint                | Description                |
|--------|------------------------|----------------------------|
| POST   | `/api/auth/register`   | Register a new user        |
| POST   | `/api/auth/login`      | User login                 |
| GET    | `/api/events`          | List all events            |
| POST   | `/api/events`          | Create a new event         |
| PUT    | `/api/events/:id`      | Update an event            |
| DELETE | `/api/events/:id`      | Delete an event            |

---

## Client System

The client is a web application that interacts with the API to provide a user-friendly interface.

### Key Features

- **User Interface:** Allows users to register, login, and manage events.
- **Event Dashboard:** View, create, edit, and delete events.
- **Attendee Management:** Register for events and view attendee lists.
- **API Integration:** Communicates with the backend via HTTP requests (e.g., using `fetch` or `axios`).

### Typical Workflow

1. **User Authentication:** User registers or logs in.
2. **Event Interaction:** User views or manages events.
3. **Data Sync:** Client sends requests to API and updates UI based on responses.

---

## System Architecture

```
[ Client (Vue/Nuxt JS) ]
            |
        HTTP Requests
            |
[      API Server (Laravel) ]
            |
        Database (PostgreSQL)
```

---

## Getting Started

### Prerequisites

- Node.js and npm installed - Client
- PHP and Composer installed - API
- Database server (e.g., PostgreSQL, MySQL, or MongoDB)

### Setup Instructions

#### 1. API Setup

Refer to [`api/README.md`](api/README.md) for detailed backend setup instructions.

#### 2. Client Setup

Refer to [`client/README.md`](client/README.md) for frontend setup and usage.

#### 3. Running the System

- Start the API server as described in the API README.
- Start the client application as described in the Client README.
- Access the client in your browser and interact with the system.

---

<!-- For more details, see the `/docs` directory or API reference. -->

## License

This project is licensed under the [MIT License](LICENSE).