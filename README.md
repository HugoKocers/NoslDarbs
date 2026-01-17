# NoslDarbs - CardQuest Game Platform

A modern, full-stack card game platform built with Vue.js 3, Vuetify, and Laravel. Players can collect cards, build decks, and engage in strategic battles.

## 🎮 Project Overview

NoslDarbs (CardQuest) is a web-based card game where players:
- Collect and manage powerful trading cards
- Build custom decks with strategic card combinations
- Engage in real-time battles against other players
- Track achievements and climbing the leaderboard
- Manage their card collection and inventory

## 🏗️ Project Architecture

```
NoslDarbs/
├── frontend/                    # Vue.js 3 + Vuetify application
│   ├── src/
│   │   ├── components/         # Reusable Vue components
│   │   ├── views/              # Page components (Home, Cards, Play, etc.)
│   │   ├── services/           # API client services
│   │   ├── App.vue
│   │   └── main.js
│   ├── public/
│   ├── package.json
│   └── vite.config.js
├── backend/                     # Laravel API
│   ├── app/
│   │   ├── Http/Controllers/   # API Controllers
│   │   ├── Models/             # Database Models
│   │   └── Resources/          # API Resources
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── routes/
│   │   └── api.php             # API Routes
│   ├── .env.example
│   └── composer.json
├── .gitignore
└── README.md
```

## 🛠️ Tech Stack

### Frontend
- **Vue.js 3** - Progressive JavaScript framework
- **Vuetify 3** - Material Design component library
- **Vite** - Next-generation build tool
- **Axios** - HTTP client for API requests
- **Vue Router** - Client-side routing
- **Pinia** - State management

### Backend
- **Laravel 10** - PHP web application framework
- **MySQL/PostgreSQL** - Relational database
- **Laravel Sanctum** - API token authentication
- **Laravel Eloquent** - ORM for database operations

## 📋 Features

### Current Features
- ✅ Responsive hero section with featured cards showcase
- ✅ Navigation menu with smooth animations
- ✅ Card display grid with visual effects
- ✅ Modern dark theme UI

### Planned Features
- 🔄 User authentication (register/login)
- 🃏 Card collection system
- 🎯 Deck building interface
- ⚔️ Real-time multiplayer battles
- 📊 Player statistics and leaderboards
- 💾 Game state persistence
- 📱 Mobile-responsive design

## 🚀 Getting Started

### Prerequisites
- Node.js 16+ and npm/yarn
- PHP 8.1+
- Composer
- MySQL 5.7+ or PostgreSQL

### Frontend Setup

1. Navigate to the frontend directory:
```bash
cd frontend
```

2. Install dependencies:
```bash
npm install
```

3. Create a `.env.local` file with API configuration:
```
VITE_API_URL=http://localhost:8000/api
```

4. Start the development server:
```bash
npm run dev
```

The frontend will be available at `http://localhost:5173`

### Backend Setup

1. Navigate to the backend directory:
```bash
cd backend
```

2. Install dependencies:
```bash
composer install
```

3. Create a `.env` file from the example:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nosldarbs
DB_USERNAME=root
DB_PASSWORD=
```

6. Run migrations:
```bash
php artisan migrate
```

7. Seed the database with initial data (optional):
```bash
php artisan db:seed
```

8. Start the Laravel development server:
```bash
php artisan serve
```

The backend API will be available at `http://localhost:8000/api`

## 🗄️ Database Schema

### Tables
- `users` - Player accounts and profiles
- `cards` - Card definitions and attributes
- `user_cards` - User's card collection
- `decks` - User-created decks
- `deck_cards` - Cards in each deck
- `battles` - Battle history and results
- `achievements` - Player achievements

## 🔌 API Endpoints

### Authentication
- `POST /api/auth/register` - User registration
- `POST /api/auth/login` - User login
- `POST /api/auth/logout` - User logout
- `GET /api/auth/user` - Get current user

### Cards
- `GET /api/cards` - List all cards (paginated)
- `GET /api/cards/{id}` - Get card details
- `GET /api/user/cards` - Get user's card collection

### Decks
- `GET /api/decks` - List user's decks
- `POST /api/decks` - Create new deck
- `GET /api/decks/{id}` - Get deck details
- `PUT /api/decks/{id}` - Update deck
- `DELETE /api/decks/{id}` - Delete deck

### Battles
- `POST /api/battles` - Start new battle
- `GET /api/battles/{id}` - Get battle details
- `POST /api/battles/{id}/move` - Make a game move

## 🎨 Component Structure

### Frontend Components
- `Header.vue` - Navigation component
- `CardGrid.vue` - Card display grid
- `CardCard.vue` - Individual card component
- `DeckBuilder.vue` - Deck creation/editing
- `BattleArena.vue` - Game board
- `UserProfile.vue` - Player profile

### Pages/Views
- `Home.vue` - Landing page
- `Cards.vue` - Card collection browser
- `Play.vue` - Battle interface
- `Decks.vue` - Deck management
- `Profile.vue` - User profile

## 🔐 Authentication Flow

1. User registers via `/register` endpoint
2. Backend creates user and returns authentication token
3. Frontend stores token in localStorage (or secure cookie)
4. All subsequent API requests include token in headers
5. Backend validates token via Sanctum middleware

## 📦 Building for Production

### Frontend
```bash
cd frontend
npm run build
```

Compiled files will be in `frontend/dist/`

### Backend
```bash
cd backend
php artisan config:cache
php artisan route:cache
```

## 🧪 Testing

### Frontend Tests (Jest/Vitest)
```bash
cd frontend
npm run test
```

### Backend Tests (PHPUnit)
```bash
cd backend
php artisan test
```

## 📝 Environment Variables

### Frontend (.env.local)
```
VITE_API_URL=http://localhost:8000/api
VITE_APP_NAME=NoslDarbs
```

### Backend (.env)
```
APP_NAME=NoslDarbs
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nosldarbs
DB_USERNAME=root
DB_PASSWORD=

SANCTUM_STATEFUL_DOMAINS=localhost:5173
SESSION_DOMAIN=localhost
```

## 🚢 Deployment

### Frontend (Vercel/Netlify)
1. Connect your GitHub repository
2. Set build command: `npm run build`
3. Set output directory: `dist`
4. Configure environment variables

### Backend (Heroku/DigitalOcean)
1. Set up server with PHP 8.1+
2. Install Composer dependencies
3. Configure `.env` for production database
4. Run migrations: `php artisan migrate --force`
5. Set up proper web server (Nginx/Apache)

## 📚 Documentation

- [Vue.js Documentation](https://vuejs.org/)
- [Vuetify Documentation](https://vuetifyjs.com/)
- [Laravel Documentation](https://laravel.com/docs)
- [API Documentation](./API.md) (to be created)

## 🤝 Contributing

1. Create a feature branch: `git checkout -b feature/feature-name`
2. Commit changes: `git commit -m 'Add feature description'`
3. Push to branch: `git push origin feature/feature-name`
4. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👨‍💻 Authors

- **Hugo Kocers** - Project Lead

## 📞 Support

For support, email support@nosldarbs.com or open an issue on GitHub.

## 🎯 Future Enhancements

- [ ] WebSocket integration for real-time battles
- [ ] Tournament system
- [ ] Trading marketplace
- [ ] Mobile app (React Native)
- [ ] Advanced AI opponent
- [ ] Social features (guilds, chat)
- [ ] In-game currency system
- [ ] Cosmetic customization

---

**Last Updated:** January 17, 2026

**Status:** 🟡 In Development

Visit the repository: [github.com/HugoKocers/NoslDarbs](https://github.com/HugoKocers/NoslDarbs)
