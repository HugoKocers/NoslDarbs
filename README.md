# CardQuest - Web-Based Card Game Platform

A modern, full-stack card game platform built with Vue.js 3, Vuetify, and Laravel. Collect cards, play flip games, and track your progress.

## ✨ Features

### Game Features
- **Card Collection System** - Flip cards to discover and unlock new cards
- **Player Profiles** - Track game stats, level, and experience points
- **Card Browser** - Browse all cards with search and filtering (by element/rarity)
- **Bilingual Support** - English and Latvian language toggle
- **Responsive Design** - Mobile-friendly interface with dark theme
- **Admin Panel** - Create, edit, and delete cards; manage users

### Technical Features
- **User Authentication** - Register, login, secure token-based access
- **Real-time Data Sync** - Stats update immediately after games
- **Element System** - Cards organized by elements (Fire, Water, Nature, Lightning, Dark, Light)
- **Rarity System** - Common, Uncommon, Rare, Epic, Legendary cards
- **PWA Ready** - Progressive Web App with service workers
- **WCAG Accessible** - Full accessibility support with ARIA attributes

## 🚀 Quick Start

### Prerequisites
- Node.js 16+ and npm
- PHP 8.1+
- Composer
- MySQL 8.0+

### Frontend Setup
```bash
cd frontend
npm install
npm run dev
```
Frontend runs at `http://localhost:5173`

### Backend Setup
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate

# Configure database in .env:
# DB_DATABASE=nosldarbs

php artisan migrate
php artisan serve
```
Backend runs at `http://localhost:8000`

### Create Admin Account
```bash
cd backend
php artisan tinker
App\Models\User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('password123'), 'role' => 'admin']);
exit
```

Login with: `admin@test.com` / `password123`

## 🛠️ Tech Stack

**Frontend:** Vue.js 3, Vuetify 3, Vite, Axios, Pinia, Vue Router
**Backend:** Laravel 10, MySQL 8.0, PHP 8.1, Sanctum Authentication

## 📱 Pages

- **Home** - Landing page with featured cards
- **Cards** - Browse and search your card collection
- **Play** - Flip card game to unlock new cards
- **Profile** - View stats, level, experience, and unlocked cards
- **Admin** - Create/edit/delete cards and manage users (admin only)

## 📊 Database Schema

**7 Tables:**
- `users` - Player accounts (with role: user/admin)
- `cards` - 50+ card definitions with element, rarity, description
- `user_cards` - User's unlocked cards with timestamps
- `decks` - User-created deck collections
- `deck_cards` - Cards assigned to decks
- `battles` - Battle records and results
- `game_records` - Game session history with points/stats

## 🔌 Key API Endpoints

**Auth:**
- `POST /api/register` - Create account
- `POST /api/login` - Login and get token
- `GET /api/user` - Get current user

**Cards & Games:**
- `GET /api/cards` - All cards (public)
- `GET /api/game/collection` - Your unlocked cards
- `POST /api/game/start` - Start a new game
- `POST /api/game/end` - End game and record stats
- `GET /api/leaderboard` - Top players

**Admin (requires admin role):**
- `GET /api/admin/cards` - List all cards
- `POST /api/admin/cards` - Create card
- `PUT /api/admin/cards/{id}` - Update card
- `DELETE /api/admin/cards/{id}` - Delete card
- `GET /api/admin/users` - List users
- `PUT /api/admin/users/{id}/role` - Toggle admin role
- `DELETE /api/admin/users/{id}` - Delete user

## 🔒 Security

- Token-based authentication with Laravel Sanctum
- Admin middleware protection for protected routes
- Password hashing with bcrypt
- CORS enabled for localhost development
- OWASP security best practices implemented

## 📄 License

MIT License - See LICENSE file for details
