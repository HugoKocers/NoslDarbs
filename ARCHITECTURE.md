# Architecture & Implementation Guide

## System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        Client Browser                           │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Vue.js 3 SPA with Vuetify UI Components                │  │
│  │  - Responsive design                                     │  │
│  │  - Dark theme                                            │  │
│  │  - Material Design components                            │  │
│  └──────────────────────────────────────────────────────────┘  │
└────────────┬─────────────────────────────────────────────┬─────┘
             │ HTTP/REST API (Axios)                      │
             │ localStorage for auth tokens               │
     ┌───────▼──────────────────────────────────────────────▼────┐
     │          Laravel REST API (Backend)                        │
     │  ┌──────────────────────────────────────────────────────┐ │
     │  │  Controllers                                         │ │
     │  │  - AuthController (register, login, logout)         │ │
     │  │  - CardController (fetch cards, user collection)    │ │
     │  │  - DeckController (CRUD operations)                 │ │
     │  └──────────────────────────────────────────────────────┘ │
     │  ┌──────────────────────────────────────────────────────┐ │
     │  │  Models & Routes                                     │ │
     │  │  - User (with Sanctum tokens)                        │ │
     │  │  - Card (card definitions)                           │ │
     │  │  - Deck (user decks)                                 │ │
     │  │  - Battle (battle history)                           │ │
     │  │  - API routes with auth middleware                   │ │
     │  └──────────────────────────────────────────────────────┘ │
     └────────────────────────┬─────────────────────────────────┘
                              │
                              │ SQL Queries
                              │ (Eloquent ORM)
                      ┌───────▼────────┐
                      │  MySQL Database│
                      │  - users       │
                      │  - cards       │
                      │  - decks       │
                      │  - battles     │
                      │  - user_cards  │
                      │  - deck_cards  │
                      └────────────────┘
```

## Frontend Architecture

### File Structure
```
frontend/
├── src/
│   ├── components/          # Reusable Vue components
│   │   ├── CardGrid.vue
│   │   ├── CardCard.vue
│   │   └── Header.vue
│   ├── views/               # Page components
│   │   ├── Home.vue         # Landing page
│   │   ├── Cards.vue        # Card collection
│   │   ├── Play.vue         # Battle arena
│   │   ├── Profile.vue      # User profile
│   │   └── NotFound.vue     # 404 page
│   ├── services/            # API integration
│   │   └── api.js          # Axios instance & API methods
│   ├── stores/              # State management (Pinia)
│   │   └── auth.js         # Authentication store
│   ├── router/
│   │   └── index.js        # Vue Router configuration
│   ├── App.vue             # Root component
│   └── main.js             # Entry point with Vuetify setup
├── index.html
├── vite.config.js          # Vite build configuration
├── package.json
└── .env.example
```

### Technology Stack
- **Vue.js 3**: Progressive framework for UI
- **Vuetify 3**: Material Design component library
- **Vite**: Lightning-fast build tool
- **Vue Router**: Client-side routing
- **Pinia**: State management
- **Axios**: HTTP client for API calls

### Data Flow
```
User Action (Click, Form Submit)
    ↓
Vue Component Event Handler
    ↓
Action/Store (Pinia)
    ↓
API Service Call (axios)
    ↓
Backend API
    ↓
Response Data
    ↓
Update State/Store
    ↓
Component Re-render (Reactive)
    ↓
Display Updated UI
```

## Backend Architecture

### File Structure
```
backend/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Controller.php          # Base controller
│   │       └── Api/
│   │           ├── AuthController.php  # Auth logic
│   │           ├── CardController.php  # Card endpoints
│   │           ├── DeckController.php  # Deck endpoints
│   │           └── BattleController.php # Battle logic
│   ├── Models/
│   │   ├── User.php                    # User model
│   │   ├── Card.php                    # Card model
│   │   ├── Deck.php                    # Deck model
│   │   └── Battle.php                  # Battle model
│   └── Policies/
│       ├── DeckPolicy.php              # Authorization for decks
│       └── BattlePolicy.php            # Authorization for battles
├── database/
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_create_cards_table.php
│   │   ├── *_create_user_cards_table.php
│   │   ├── *_create_decks_table.php
│   │   ├── *_create_deck_cards_table.php
│   │   └── *_create_battles_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── CardSeeder.php              # Seed sample cards
├── routes/
│   └── api.php                         # API routes
└── .env.example
```

### Technology Stack
- **Laravel 10**: PHP web application framework
- **Laravel Sanctum**: API token authentication
- **Eloquent ORM**: Database abstraction layer
- **MySQL/PostgreSQL**: Relational database

## Authentication Flow

### Registration
```
User submits registration form
    ↓
Frontend: POST /api/auth/register
    ↓
Backend: AuthController@register
    ↓
Validate input (email unique, password confirmed)
    ↓
Hash password and create user
    ↓
Generate Sanctum token
    ↓
Return user + token
    ↓
Frontend: Store token in localStorage
    ↓
User logged in and authenticated
```

### Login
```
User submits login form
    ↓
Frontend: POST /api/auth/login
    ↓
Backend: AuthController@login
    ↓
Find user by email
    ↓
Verify password hash
    ↓
Generate Sanctum token
    ↓
Return user + token
    ↓
Frontend: Store token in localStorage
    ↓
Add token to future API requests
    ↓
User authenticated
```

### Protected Requests
```
User clicks "Get My Cards"
    ↓
Frontend: Include Authorization header
    ↓
GET /api/user/cards (Header: Bearer {token})
    ↓
Backend: Sanctum middleware validates token
    ↓
Token valid? → Retrieve request->user()
    ↓
Get user's cards from database
    ↓
Return card collection
    ↓
Frontend: Display cards
```

## Database Schema

### Users Table
```sql
id          | INT PRIMARY KEY AUTO_INCREMENT
name        | VARCHAR(255)
email       | VARCHAR(255) UNIQUE
password    | VARCHAR(255) HASHED
level       | INT DEFAULT 1
experience  | INT DEFAULT 0
created_at  | TIMESTAMP
updated_at  | TIMESTAMP
```

### Cards Table
```sql
id          | INT PRIMARY KEY AUTO_INCREMENT
name        | VARCHAR(255)
description | TEXT
power       | INT (damage value)
cost        | INT (mana/resource cost)
element     | VARCHAR(255) (fire, ice, etc)
rarity      | VARCHAR(255) (common, rare, legendary)
image_url   | VARCHAR(255)
created_at  | TIMESTAMP
updated_at  | TIMESTAMP
```

### User Cards Table (Collection)
```sql
id          | INT PRIMARY KEY AUTO_INCREMENT
user_id     | INT FK users(id)
card_id     | INT FK cards(id)
quantity    | INT (how many copies)
created_at  | TIMESTAMP
updated_at  | TIMESTAMP
UNIQUE(user_id, card_id)
```

### Decks Table
```sql
id          | INT PRIMARY KEY AUTO_INCREMENT
user_id     | INT FK users(id)
name        | VARCHAR(255)
description | TEXT
created_at  | TIMESTAMP
updated_at  | TIMESTAMP
```

### Deck Cards Table
```sql
id          | INT PRIMARY KEY AUTO_INCREMENT
deck_id     | INT FK decks(id)
card_id     | INT FK cards(id)
quantity    | INT (copies of card in deck)
created_at  | TIMESTAMP
updated_at  | TIMESTAMP
UNIQUE(deck_id, card_id)
```

### Battles Table
```sql
id          | INT PRIMARY KEY AUTO_INCREMENT
player1_id  | INT FK users(id)
player2_id  | INT FK users(id)
winner_id   | INT FK users(id) NULLABLE
status      | VARCHAR(255) (pending, in_progress, completed)
started_at  | TIMESTAMP
ended_at    | TIMESTAMP NULLABLE
created_at  | TIMESTAMP
updated_at  | TIMESTAMP
```

## Key Design Patterns

### 1. RESTful API Design
- Uses HTTP verbs (GET, POST, PUT, DELETE)
- Resource-based routing (`/api/cards`, `/api/decks`)
- Consistent response format
- Proper HTTP status codes

### 2. Authentication
- Token-based with Laravel Sanctum
- Tokens stored in localStorage on frontend
- Included in Authorization header for protected routes
- Automatic token validation on backend

### 3. Authorization
- Middleware for route protection
- Policies for model-level authorization
- Users can only modify their own resources

### 4. State Management
- Frontend: Pinia stores for auth state
- Backend: Session data in database
- Token expiration handling

### 5. Error Handling
- Frontend: Axios interceptors for errors
- Backend: Validation middleware
- User-friendly error messages

## API Response Format

### Success Response (200 OK)
```json
{
  "data": {
    "id": 1,
    "name": "Fire Dragon",
    "power": 85,
    ...
  }
}
```

### Paginated Response (200 OK)
```json
{
  "data": [...],
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 100
  }
}
```

### Error Response (400/401/422/500)
```json
{
  "message": "Validation Error",
  "errors": {
    "email": ["The email has already been taken."]
  }
}
```

## Security Considerations

1. **CORS**: Configured to allow frontend domain
2. **CSRF**: Protected by Laravel's built-in protection
3. **Password Hashing**: bcrypt with Laravel's Hash facade
4. **Token Validation**: Sanctum validates all API tokens
5. **Input Validation**: Server-side validation required
6. **SQL Injection**: Prevented by Eloquent ORM
7. **Rate Limiting**: Can be added to API routes

## Performance Optimization

1. **Frontend**:
   - Code splitting with lazy-loaded routes
   - Image optimization
   - Caching API responses

2. **Backend**:
   - Database indexing on foreign keys
   - Query optimization with eager loading
   - API response caching
   - Pagination for large datasets

---

This architecture provides a scalable, secure foundation for the NoslDarbs card game platform.
