Warung Aripin - Simple Kelontong Web

Files added:

- index.html : Landing page
- shop.php : Shop + customer form
- process_order.php : Order processor (stores in SQLite at data/db.sqlite)
- assets/css/style.css : Styles
- assets/js/main.js : Minimal cart JS
- assets/img/logo.svg : Logo
- seed_db.py : Python seeder to create initial data

Quick start (Windows PowerShell):

1. Seed database (requires Python 3):

   python .\seed_db.py

2. Start PHP built-in server (from project folder):

   php -S localhost:8000

Open http://localhost:8000/index.html or http://localhost:8000/shop.php

Notes:

- If using Laragon or XAMPP, place the project folder in the web root and open via local host.
- Orders are saved to `data/db.sqlite`.
- This is a minimal example for demonstration and not hardened for production.
