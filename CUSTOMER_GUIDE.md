# Customer Account Guide

## Overview

Customers can now create accounts, login, and track their orders through a personalized dashboard.

## Features

### 1. Registration
- **URL:** http://localhost:8080/register
- Create a new customer account
- Required fields: Name, Email, Password
- Optional: Phone, Address

### 2. Login
- **URL:** http://localhost:8080/login
- Sign in with email and password
- Access to order history and profile

### 3. Customer Dashboard
- **URL:** http://localhost:8080/account
- Overview of account statistics
- Quick access to orders and profile
- Recent orders display

### 4. Order History
- **URL:** http://localhost:8080/account/orders
- View all past orders
- Track order status
- See order details

### 5. Order Details
- **URL:** http://localhost:8080/account/orders/{id}
- View specific order information
- See all items in the order
- Check shipping address
- View order notes

### 6. Profile Management
- **URL:** http://localhost:8080/account/profile
- Update name, phone, and address
- Email cannot be changed (used for login)

## Shopping Flow

### Guest Checkout
1. Browse products
2. Add items to cart
3. Go to checkout
4. Fill in shipping information
5. Place order
6. Order is saved to email address

### Logged-in Checkout
1. Login to account
2. Browse products
3. Add items to cart
4. Go to checkout
5. Information pre-filled
6. Place order
7. View order in dashboard

## Benefits of Creating an Account

✅ **Faster Checkout** - Information pre-filled
✅ **Order History** - Track all your orders
✅ **Order Status** - See current order status
✅ **Profile Management** - Update your information
✅ **Reorder** - Easy access to previous orders

## Navigation

### Header Menu (When Logged In)
- **User Icon** - Dropdown menu with:
  - Dashboard
  - My Orders
  - Profile
  - Logout

### Header Menu (When Not Logged In)
- **User Icon** - Login link

## Order Status

Orders can have the following statuses:
- **Pending** - Order received, awaiting processing
- **Processing** - Order being prepared
- **Shipped** - Order dispatched
- **Delivered** - Order completed
- **Cancelled** - Order cancelled

## Security

- Passwords are hashed with bcrypt
- Session-based authentication
- Protected routes require login
- CSRF protection on all forms
- Secure password requirements (minimum 6 characters)

## Tips

1. **Remember Your Email** - Used for login
2. **Complete Profile** - Add phone and address for faster checkout
3. **Check Order History** - Track your purchases
4. **Update Address** - Keep shipping information current
5. **Logout on Shared Devices** - For security

## Troubleshooting

### Cannot Login
- Check email and password
- Email is case-sensitive
- Password must match exactly

### Forgot Password
- Currently no password reset (feature to be added)
- Contact admin for assistance

### Order Not Showing
- Check you're logged in with correct email
- Guest orders are linked to email address
- Login with the email used at checkout

### Profile Update Failed
- Check all required fields are filled
- Name must be at least 3 characters
- Ensure form is submitted correctly

## Guest vs Registered Customers

### Guest Checkout
- ✅ Can place orders
- ✅ Receives order confirmation
- ❌ Cannot view order history
- ❌ Must re-enter info each time
- ❌ No dashboard access

### Registered Customers
- ✅ Can place orders
- ✅ View all order history
- ✅ Track order status
- ✅ Faster checkout
- ✅ Profile management
- ✅ Dashboard access

## API Endpoints

### Authentication
- `GET /login` - Login page
- `POST /login` - Process login
- `GET /register` - Registration page
- `POST /register` - Process registration
- `GET /logout` - Logout

### Account (Protected)
- `GET /account` - Dashboard
- `GET /account/orders` - Order list
- `GET /account/orders/{id}` - Order details
- `GET /account/profile` - Profile page
- `POST /account/profile/update` - Update profile

## Database

### Customer Record
```
customers
├── id
├── name
├── email (unique, used for login)
├── password (hashed)
├── phone
├── address
├── created_at
└── updated_at
```

### Order Relationship
- Orders are linked to customer via `customer_id`
- Guest orders also create customer records
- Email is used to link orders

## Future Enhancements

Potential features to add:
- Password reset functionality
- Email verification
- Order notifications
- Wishlist
- Product reviews
- Address book (multiple addresses)
- Payment methods storage
- Loyalty points
- Order cancellation
- Return requests

## Support

For customer support:
1. Check order status in dashboard
2. Review order details
3. Contact shop admin if needed
4. Keep order number for reference
