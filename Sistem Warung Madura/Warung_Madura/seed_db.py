#!/usr/bin/env python3
"""
Seed script for Warung Aripin SQLite DB (data/db.sqlite)
Run: python seed_db.py
"""
import sqlite3
from pathlib import Path

DB = Path(__file__).parent / 'data' / 'db.sqlite'
DB.parent.mkdir(parents=True,exist_ok=True)
conn = sqlite3.connect(DB)
c = conn.cursor()
# create tables
c.execute('''CREATE TABLE IF NOT EXISTS items(
  id INTEGER PRIMARY KEY,
  name TEXT,
  description TEXT,
  price INTEGER
)''')

c.execute('''CREATE TABLE IF NOT EXISTS payment_methods(
  id INTEGER PRIMARY KEY,
  method TEXT
)''')

c.execute('''CREATE TABLE IF NOT EXISTS customers(
  id INTEGER PRIMARY KEY,
  name TEXT,
  address TEXT,
  phone TEXT
)''')

c.execute('''CREATE TABLE IF NOT EXISTS orders(
  id INTEGER PRIMARY KEY,
  customer_id INTEGER,
  total INTEGER,
  payment_method INTEGER,
  items TEXT,
  created_at TEXT
)''')

# seed items
items = [
  (1,'Beras 5kg','Beras kualitas baik',65000),
  (2,'Gula 1kg','Gula pasir 1kg',12000),
  (3,'Minyak 2L','Minyak goreng botol 2L',38000),
  (4,'Indomie','Mie instan (1 pack)',3500),
  (5,'Sapu','Sapu lidi',25000),
]

c.executemany('INSERT OR REPLACE INTO items(id,name,description,price) VALUES(?,?,?,?)', items)

payments = [
  (1,'Tunai'),
  (2,'Transfer Bank'),
  (3,'QRIS')
]
c.executemany('INSERT OR REPLACE INTO payment_methods(id,method) VALUES(?,?)', payments)

conn.commit()
print('Seeded', DB)
conn.close()
