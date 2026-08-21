# Online Vehicle Spare Parts Store

Full working project: customer catalog + search/filter + checkout (mock payment),
admin login + inventory CRUD + order tracking.

## File ownership (4 members)

| Member | Files | Feature |
|---|---|---|
| 1 | `db.php`, `setup.sql`, `admin/login.php`, `admin/logout.php`, `admin/auth_check.php` | DB + Admin Auth |
| 2 | `index.php` | Catalog + Search/Filter |
| 3 | `checkout.php`, `process_order.php` | Checkout + Mock Payment |
| 4 | `admin/dashboard.php`, `admin/add_part.php`, `admin/edit_part.php`, `admin/delete_part.php`, `admin/orders.php`, `style.css`, `script.js` | Admin CRUD + Design |

## Setup (5 minutes)

1. Copy this whole folder into `C:\xampp\htdocs\` (rename folder if you like, e.g. `vehicle-store`)
2. Start Apache + MySQL in XAMPP
3. Open `http://localhost/phpmyadmin` → **SQL** tab → paste contents of `setup.sql` → **Go**
4. Visit `http://localhost/vehicle-store/index.php` — customer store
5. Visit `http://localhost/vehicle-store/admin/login.php` — admin login
   - Username: `admin`
   - Password: `admin123`

## Group Git workflow

Each member, on their own laptop:

```bash
git clone https://github.com/<username>/<repo>.git
cd <repo>
git checkout -b member1-auth      # member2-catalog / member3-checkout / member4-admin
```

Edit ONLY your assigned files, then:

```bash
git add .
git commit -m "describe what you did"
git push -u origin member1-auth
```

Merge via GitHub: **Pull requests → New pull request → base: main, compare: your-branch → Merge**

Everyone then:
```bash
git checkout main
git pull origin main
```

## Adapting further (if lecturer asks for changes)

- **Add a new field** (e.g. part condition: New/Used): add column via phpMyAdmin
  (`ALTER TABLE parts ADD condition_type VARCHAR(20);`), then add the input field
  to `add_part.php`, `edit_part.php`, and display it in `index.php`.
- **Add search by vehicle model too**: copy the `make` filter pattern in `index.php`
  and repeat for `vehicle_model`.
- **Real payment gateway**: replace the mock check in `process_order.php` with an
  actual API call (Stripe/PayHere test mode) — but for exam purposes, mock is fine
  since the brief says "secure payment gateway" conceptually, not a real integration.

## Common errors

- **"Connection failed"** → check `db.php` matches your DB name/user/password.
- **Admin login fails** → make sure `setup.sql` ran fully (creates the `admins` table
  with the default hashed password for `admin123`).
- **Blank page** → add this temporarily at the top of the broken file:
  ```php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  ```
