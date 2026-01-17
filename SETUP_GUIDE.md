# NoslDarbs Setup Guide

This guide will walk you through setting up the NoslDarbs project locally and pushing it to GitHub.

## 📋 Quick Start

### Frontend Setup (Vue.js + Vuetify)

```bash
# Navigate to frontend directory
cd frontend

# Install dependencies
npm install

# Create .env.local from example
copy .env.example .env.local

# Start development server (runs on http://localhost:5173)
npm run dev
```

### Backend Setup (Laravel)

```bash
# Navigate to backend directory
cd backend

# Install PHP dependencies
composer install

# Create .env file from example
copy .env.example .env

# Generate application key
php artisan key:generate

# Create database
# Option 1: Create MySQL database manually
# CREATE DATABASE nosldarbs;

# Run migrations
php artisan migrate

# Seed database with sample data (optional)
php artisan db:seed

# Start Laravel development server (runs on http://localhost:8000)
php artisan serve
```

## 🔧 Prerequisites

### Required Software
- **Node.js** 16+ ([Download](https://nodejs.org/))
- **npm** (comes with Node.js)
- **PHP** 8.1+ ([Download](https://www.php.net/))
- **Composer** ([Download](https://getcomposer.org/))
- **MySQL** 5.7+ ([Download](https://www.mysql.com/))
- **Git** ([Download](https://git-scm.com/))

### Verify Installation
```bash
node --version      # Should be v16+
npm --version       # Should be 8+
php --version       # Should be 8.1+
composer --version  # Should be 2+
git --version       # Should be 2+
```

## 🗄️ Database Setup

### Create Database
```bash
# Using MySQL command line
mysql -u root -p
CREATE DATABASE nosldarbs;
EXIT;
```

### Configure Laravel .env
Edit `backend/.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nosldarbs
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Run Migrations
```bash
cd backend
php artisan migrate
```

This will create the following tables:
- users
- cards
- user_cards
- decks
- deck_cards
- battles
- password_reset_tokens
- sessions
- personal_access_tokens (Sanctum)

## 🚀 Pushing to GitHub

### Initial Push (First Time)
```bash
cd c:\Users\hugok\OneDrive\Desktop\NoslDarbs

# Verify remote is set
git remote -v

# Push to GitHub (will prompt for credentials)
git push -u origin main

# If using SSH:
# First, generate SSH key (if you don't have one)
# ssh-keygen -t ed25519 -C "your_email@example.com"
# Then add public key to GitHub: https://github.com/settings/keys
# Update remote to SSH: git remote set-url origin git@github.com:HugoKocers/NoslDarbs.git
# Then push: git push -u origin main
```

### Subsequent Pushes
```bash
# Make your changes, then:
git add .
git commit -m "Your commit message"
git push
```

## 📦 Project Structure

```
NoslDarbs/
├── frontend/                    # Vue.js 3 + Vuetify
│   ├── src/
│   │   ├── components/         # Reusable components
│   │   ├── views/              # Page components
│   │   ├── services/           # API services
│   │   ├── stores/             # Pinia state management
│   │   ├── App.vue
│   │   └── main.js
│   ├── index.html
│   ├── package.json
│   └── vite.config.js
├── backend/                     # Laravel API
│   ├── app/
│   │   ├── Http/Controllers/   # API Controllers
│   │   └── Models/             # Eloquent Models
│   ├── database/
│   │   └── migrations/         # Database migrations
│   ├── routes/
│   │   └── api.php             # API routes
│   ├── composer.json
│   └── .env.example
├── .gitignore
└── README.md
```

## 🔌 API Endpoints

### Authentication
- `POST /api/auth/register` - Register user
- `POST /api/auth/login` - Login user
- `POST /api/auth/logout` - Logout user
- `GET /api/auth/user` - Get current user

### Cards
- `GET /api/cards` - List cards
- `GET /api/cards/{id}` - Get card details
- `GET /api/user/cards` - Get user's cards

### Decks
- `GET /api/decks` - List user's decks
- `POST /api/decks` - Create deck
- `GET /api/decks/{id}` - Get deck details
- `PUT /api/decks/{id}` - Update deck
- `DELETE /api/decks/{id}` - Delete deck

## 🧪 Development Commands

### Frontend
```bash
cd frontend

# Development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview

# Run tests
npm run test

# Lint and fix code
npm run lint
```

### Backend
```bash
cd backend

# Create new migration
php artisan make:migration create_tablename_table

# Create new model
php artisan make:model ModelName

# Create new controller
php artisan make:controller Api/ControllerName

# Run tests
php artisan test

# Clear cache
php artisan cache:clear
```

## 🔐 Environment Variables

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
DB_CONNECTION=mysql
DB_DATABASE=nosldarbs
DB_USERNAME=root
DB_PASSWORD=
SANCTUM_STATEFUL_DOMAINS=localhost:5173
SESSION_DOMAIN=localhost
```

## 🐛 Troubleshooting

### Frontend Issues

**Port 5173 already in use:**
```bash
# Kill process on port 5173
netstat -ano | findstr :5173
taskkill /PID <PID> /F

# Or use different port
npm run dev -- --port 3000
```

**Dependencies not installing:**
```bash
# Clear npm cache
npm cache clean --force
rm -rf node_modules
npm install
```

### Backend Issues

**Composer error:**
```bash
# Update Composer
composer self-update

# Clear composer cache
composer clear-cache
```

**Database connection error:**
- Check MySQL is running
- Verify .env database credentials
- Ensure database exists: `CREATE DATABASE nosldarbs;`

**Migration error:**
```bash
# Rollback last migration
php artisan migrate:rollback

# Reset all migrations
php artisan migrate:reset

# Run fresh migrations
php artisan migrate:fresh
```

## 📚 Useful Resources

- [Vue.js 3 Docs](https://vuejs.org/)
- [Vuetify Docs](https://vuetifyjs.com/)
- [Vite Docs](https://vitejs.dev/)
- [Laravel Docs](https://laravel.com/docs)
- [Sanctum Docs](https://laravel.com/docs/sanctum)
- [Pinia Docs](https://pinia.vuejs.org/)

## 🤝 Next Steps

1. **Install dependencies** for both frontend and backend
2. **Set up database** with migrations
3. **Create .env files** from examples
4. **Run development servers** for both projects
5. **Start developing** new features
6. **Commit and push** changes to GitHub

## 💡 Tips

- Keep frontend and backend servers running in separate terminal windows
- Use Vue DevTools for debugging frontend
- Use Laravel Debugbar or Horizon for debugging backend
- Always create a new branch for features: `git checkout -b feature/feature-name`
- Write meaningful commit messages
- Test thoroughly before pushing to GitHub

---

Happy coding! 🚀
