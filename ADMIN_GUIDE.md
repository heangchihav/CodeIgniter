# Admin Panel Guide

## Access Information

### Admin Login
- **URL:** http://localhost:8080/admin/login
- **Default Username:** admin
- **Default Password:** admin123

### Registration
- **URL:** http://localhost:8080/admin/register
- Create new admin accounts

## Features

### 1. Dashboard
- **URL:** `/admin/dashboard`
- View statistics:
  - Total Products
  - Total Categories
  - Total Orders
  - Total Customers
- Recent orders list

### 2. Product Management
- **List Products:** `/admin/products`
- **Add Product:** `/admin/products/create`
- **Edit Product:** `/admin/products/edit/{id}`
- **Delete Product:** `/admin/products/delete/{id}`

**Product Fields:**
- Name (required)
- Slug (required, unique)
- Category (required)
- Description
- Price (required)
- Stock (required)
- Image URL
- Status (Active/Inactive)

### 3. Category Management
- **List Categories:** `/admin/categories`
- **Add Category:** `/admin/categories/create`
- **Edit Category:** `/admin/categories/edit/{id}`
- **Delete Category:** `/admin/categories/delete/{id}`

**Category Fields:**
- Name (required)
- Slug (required, unique)
- Description

## Security

### Authentication
- Session-based authentication
- Password hashing with bcrypt
- Protected routes with `adminauth` filter
- CSRF protection on all forms

### Access Control
- All admin routes require authentication
- Automatic redirect to login if not authenticated
- Session timeout on logout

## Database

### Admin Users Table
```sql
admin_users
├── id (SERIAL)
├── username (VARCHAR, unique)
├── email (VARCHAR, unique)
├── password (VARCHAR, hashed)
├── full_name (VARCHAR)
├── is_active (BOOLEAN)
├── created_at (TIMESTAMP)
└── updated_at (TIMESTAMP)
```

## Usage Examples

### Creating a Product
1. Login to admin panel
2. Navigate to Products > Add New Product
3. Fill in all required fields
4. Upload/enter image URL
5. Set status to Active
6. Click "Create Product"

### Managing Categories
1. Go to Categories section
2. Add new categories for organizing products
3. Edit category names and descriptions
4. View product count per category

### Viewing Statistics
- Dashboard shows real-time counts
- Recent orders displayed on dashboard
- Quick access to all management sections

## Tips

1. **Product Images:** Use placeholder services like:
   - `https://via.placeholder.com/300x300?text=Product`
   - Or upload to image hosting service

2. **Slugs:** Use URL-friendly format:
   - Example: "wireless-headphones"
   - No spaces, lowercase, hyphens

3. **Stock Management:** 
   - Stock automatically decreases on orders
   - Set to 0 to mark as out of stock

4. **Categories:**
   - Create categories before adding products
   - Deleting category deletes all its products

## Troubleshooting

### Cannot Login
- Check database connection
- Verify admin user exists: `SELECT * FROM admin_users;`
- Run seeder: `php spark db:seed AdminUserSeeder`

### Session Issues
- Clear session: Delete files in `writable/session/`
- Check session configuration in `app/Config/App.php`

### Permission Denied
- Ensure you're logged in
- Check filter is registered in `app/Config/Filters.php`

## Development

### Adding New Admin Features
1. Create controller in `app/Controllers/Admin/`
2. Add routes in `app/Config/Routes.php`
3. Apply `adminauth` filter to protected routes
4. Create views in `app/Views/admin/`

### Custom Admin Users
Run migration and create users:
```bash
php spark migrate
php spark db:seed AdminUserSeeder
```

Or insert manually:
```sql
INSERT INTO admin_users (username, email, password, full_name, is_active)
VALUES ('newadmin', 'admin@example.com', '$2y$10$...', 'Admin Name', true);
```

## Navigation

### Main Menu
- Dashboard - Overview and statistics
- Products - Manage product catalog
- Categories - Organize products
- View Shop - See customer-facing store
- Logout - End admin session

### Quick Actions
- Add New Product (from Products page)
- Add New Category (from Categories page)
- Edit/Delete (inline actions on list pages)

## Best Practices

1. **Regular Backups:** Backup database regularly
2. **Strong Passwords:** Use secure passwords for admin accounts
3. **Active Status:** Disable inactive admin users
4. **Product Data:** Keep product information up-to-date
5. **Stock Levels:** Monitor and update stock regularly

## Support

For issues or questions:
1. Check application logs in `writable/logs/`
2. Review CodeIgniter documentation
3. Check database for data integrity
