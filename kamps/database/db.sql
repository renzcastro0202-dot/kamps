-- =============================
-- DATABASE & TABLES
-- =============================
CREATE DATABASE IF NOT EXISTS kape_agosto
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE kape_agosto;

-- Roles
CREATE TABLE IF NOT EXISTS roles ( 
  id   INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) UNIQUE NOT NULL
) ENGINE=InnoDB;

-- Users
CREATE TABLE IF NOT EXISTS users (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  username    VARCHAR(50) NOT NULL UNIQUE,
  password    VARCHAR(255) NOT NULL,
  full_name   VARCHAR(100) NOT NULL,
  email       VARCHAR(100) NOT NULL UNIQUE,
  contact     VARCHAR(20),
  role_id     INT NOT NULL,
  status      ENUM('pending','approved','rejected','active') DEFAULT 'active', -- 🔥 changed default
  approved_by INT NULL,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT,
  CONSTRAINT fk_user_approved FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Permissions
CREATE TABLE IF NOT EXISTS permissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  description VARCHAR(255)
) ENGINE=InnoDB;

-- Insert Permissions
INSERT INTO permissions (name, description) VALUES
  ('manage_users', 'Create, edit, and delete users'),
  ('manage_roles', 'Create, edit, and delete roles'),
  ('manage_categories', 'Create, edit, and delete categories'),
  ('manage_items', 'Create, edit, and delete items'),
  ('manage_orders', 'Create, edit, and delete orders'),
  ('view_items', 'View items')
ON DUPLICATE KEY UPDATE description = VALUES(description);

-- Role-Permissions
CREATE TABLE IF NOT EXISTS role_permissions (
  role_id INT NOT NULL,
  permission_id INT NOT NULL,
  PRIMARY KEY (role_id, permission_id),
  CONSTRAINT fk_role_perm_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
  CONSTRAINT fk_role_perm_perm FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Categories
CREATE TABLE IF NOT EXISTS categories (
  id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_name  VARCHAR(100) NOT NULL,
  category_image VARCHAR(255),
  created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Items
CREATE TABLE IF NOT EXISTS items (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id INT UNSIGNED NOT NULL,
  name        VARCHAR(100) NOT NULL,
  price       DECIMAL(10,2) NOT NULL,
  stock       INT DEFAULT 0,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Orders
CREATE TABLE IF NOT EXISTS orders (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  user_id      INT NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  status       ENUM('pending','completed','cancelled') DEFAULT 'pending',
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_order_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================
-- Insert Roles
-- =============================
INSERT INTO roles (name) VALUES
('super_admin'), ('admin'), ('staff'), ('guest')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- =============================
-- Map Permissions to Roles
-- =============================

-- Super Admin: All permissions
INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id 
FROM roles r, permissions p 
WHERE r.name = 'super_admin';

-- Admin
INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id 
FROM roles r
JOIN permissions p ON p.name IN ('manage_users','manage_categories','manage_items','manage_orders','view_items')
WHERE r.name = 'admin';

-- Staff
INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id 
FROM roles r
JOIN permissions p ON p.name IN ('manage_orders','view_items')
WHERE r.name = 'staff';

-- Guest
INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id 
FROM roles r
JOIN permissions p ON p.name = 'view_items'
WHERE r.name = 'guest';

-- =============================
-- Create Default Super Admin User
-- =============================
-- password = "superadmin123!"
INSERT INTO users (username, password, full_name, email, contact, role_id, status)
VALUES (
  'superadmin',
  '$2y$10$yOxK7cIQKbg2WvhwVSGb7u0MMP2qJvD6BgO7B2DPLV1PykW8Z39Ba', -- bcrypt hash of "superadmin123!"
  'Super Administrator',
  'superadmin@example.com',
  '09123456789',
  (SELECT id FROM roles WHERE name = 'super_admin'),
  'active'
)
ON DUPLICATE KEY UPDATE
  password   = VALUES(password),
  full_name  = VALUES(full_name),
  email      = VALUES(email),
  contact    = VALUES(contact),
  role_id    = VALUES(role_id),
  status     = VALUES(status);
