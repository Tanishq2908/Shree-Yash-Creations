# 🚀 Shree Yash Creations - Complete E-commerce Setup Guide

## 📋 **What You Now Have:**

### **Frontend Files:**
- `home.html` - Main website with Indian theme
- `admin_panel.html` - Admin dashboard for managing products/orders
- `cart.html` - Shopping cart with checkout system
- `EDITING_GUIDE.md` - Guide for editing photos, prices, contact info

### **Backend Files:**
- `config.php` - Database configuration
- `api/products.php` - Product management API
- `api/orders.php` - Order management API
- `setup.php` - Database initialization

---

## 🛠️ **Step-by-Step Setup Instructions:**

### **Step 1: Install Local Server**
You need a local web server with PHP and MySQL. Install one of these:

**Option A: XAMPP (Recommended for beginners)**
1. Download XAMPP from: https://www.apachefriends.org/
2. Install XAMPP
3. Start Apache and MySQL services

**Option B: WAMP (Windows)**
1. Download WAMP from: https://www.wampserver.com/
2. Install WAMP
3. Start WAMP services

**Option C: MAMP (Mac)**
1. Download MAMP from: https://www.mamp.info/
2. Install MAMP
3. Start MAMP services

### **Step 2: Place Files in Server Directory**
1. Copy all your files to the server's web directory:
   - **XAMPP:** `C:\xampp\htdocs\shree-yash-creations\`
   - **WAMP:** `C:\wamp\www\shree-yash-creations\`
   - **MAMP:** `/Applications/MAMP/htdocs/shree-yash-creations/`

### **Step 3: Set Up Database**
1. Open your web browser
2. Go to: `http://localhost/shree-yash-creations/setup.php`
3. This will create the database and tables automatically
4. You'll see a success message with admin login details

### **Step 4: Test Your System**
1. **Main Website:** `http://localhost/shree-yash-creations/home.html`
2. **Admin Panel:** `http://localhost/shree-yash-creations/admin_panel.html`
3. **Shopping Cart:** `http://localhost/shree-yash-creations/cart.html`

---

## 🔧 **Database Configuration:**

### **Default Settings (config.php):**
```php
DB_HOST = 'localhost'
DB_USER = 'root'
DB_PASS = '' (empty password)
DB_NAME = 'shree_yash_creations'
```

### **If You Need to Change Database Settings:**
1. Open `config.php`
2. Edit the database credentials
3. Run `setup.php` again

---

## 👨‍💼 **Admin Panel Access:**

### **Default Login:**
- **Username:** `admin`
- **Password:** `admin123`

### **Admin Panel Features:**
- ✅ **Dashboard** - Overview of orders, revenue, customers
- ✅ **Product Management** - Add, edit, delete products
- ✅ **Order Management** - View and update order status
- ✅ **Customer Management** - View customer details
- ✅ **Inventory Tracking** - Monitor stock levels

---

## 💳 **Payment Methods Available:**

### **Frontend Payment Options:**
1. **Cash on Delivery (COD)** - Pay when you receive
2. **UPI** - Unified Payment Interface
3. **Credit/Debit Cards** - Visa, MasterCard, etc.
4. **Net Banking** - Online banking

### **To Add Real Payment Gateway:**
1. Sign up for payment gateway (Razorpay, PayU, etc.)
2. Get API keys
3. Integrate payment gateway APIs
4. Update payment processing in backend

---

## 📱 **Mobile Responsive Design:**

All pages are mobile-friendly and work on:
- ✅ Smartphones
- ✅ Tablets
- ✅ Desktop computers
- ✅ All modern browsers

---

## 🎨 **Customization Options:**

### **Easy to Customize:**
- **Colors:** Edit CSS variables in each file
- **Images:** Replace photo URLs with your product images
- **Text:** Edit product names, descriptions, prices
- **Contact Info:** Update phone, email, address
- **Logo:** Replace with your company logo

### **Advanced Customization:**
- **Add new products:** Use admin panel or edit database
- **Change categories:** Modify category names
- **Add payment methods:** Integrate new payment gateways
- **Email notifications:** Set up order confirmation emails

---

## 🔒 **Security Features:**

### **Built-in Security:**
- ✅ SQL injection protection
- ✅ Input validation
- ✅ Secure password hashing
- ✅ CSRF protection ready
- ✅ XSS protection

### **Additional Security Recommendations:**
1. **Change default admin password**
2. **Use HTTPS in production**
3. **Regular database backups**
4. **Keep software updated**

---

## 📊 **Analytics & Reporting:**

### **Admin Dashboard Shows:**
- Total orders
- Revenue
- Customer count
- Product inventory
- Recent orders
- Order status tracking

### **To Add Google Analytics:**
1. Sign up for Google Analytics
2. Get tracking code
3. Add to `home.html` head section

---

## 🚀 **Going Live (Production):**

### **Steps to Deploy Online:**
1. **Choose Hosting Provider:**
   - Shared hosting (GoDaddy, HostGator)
   - VPS (DigitalOcean, AWS)
   - Cloud hosting (Google Cloud, Azure)

2. **Upload Files:**
   - Upload all files to web server
   - Set up database on hosting
   - Update database credentials

3. **Domain Setup:**
   - Buy domain name
   - Point domain to hosting
   - Set up SSL certificate

4. **Final Configuration:**
   - Update contact information
   - Add real product images
   - Test all functionality
   - Set up email notifications

---

## 🆘 **Troubleshooting:**

### **Common Issues:**

**Database Connection Error:**
- Check if MySQL is running
- Verify database credentials
- Ensure database exists

**Images Not Loading:**
- Check file paths
- Verify image files exist
- Check file permissions

**Admin Panel Not Working:**
- Verify PHP is installed
- Check file permissions
- Ensure all files are uploaded

**Payment Issues:**
- Test with COD first
- Verify payment gateway setup
- Check API credentials

---

## 📞 **Support & Help:**

### **If You Need Help:**
1. **Check the EDITING_GUIDE.md** for basic editing
2. **Review error messages** in browser console
3. **Check server error logs**
4. **Contact your hosting provider** for server issues

### **For Advanced Features:**
- **Real payment gateway integration**
- **Email automation setup**
- **Advanced inventory management**
- **Customer analytics**

---

## 🎯 **Quick Start Checklist:**

- [ ] Install XAMPP/WAMP/MAMP
- [ ] Copy files to web directory
- [ ] Run `setup.php` to create database
- [ ] Test main website
- [ ] Test admin panel login
- [ ] Add your product images
- [ ] Update contact information
- [ ] Test shopping cart
- [ ] Test checkout process
- [ ] Change admin password

---

## 🏆 **Congratulations!**

Your Shree Yash Creations e-commerce website is now ready with:
- ✅ Beautiful Indian-themed design
- ✅ Complete product management
- ✅ Order processing system
- ✅ Payment integration ready
- ✅ Mobile responsive design
- ✅ Admin dashboard
- ✅ Database backend

**You can now start selling your packaging products online!** 🎉

## 🚀 **Server Deployment Guide**

### **Option 1: Shared Hosting (Recommended for beginners)**

#### **Step 1: Choose a Hosting Provider**
- **Recommended:** Hostinger, GoDaddy, or HostGator
- **Requirements:** PHP 7.4+ and MySQL 5.7+

#### **Step 2: Upload Files**
1. **Download all files** from your local setup
2. **Upload via FTP/File Manager:**
   - Use FileZilla (FTP) or cPanel File Manager
   - Upload all files to `public_html` folder
   - Maintain folder structure:
     ```
     public_html/
     ├── home.html
     ├── cart.html
     ├── admin_panel.html
     ├── config.php
     ├── setup.php
     ├── OIP.jpeg
     ├── api/
     │   ├── products.php
     │   ├── orders.php
     │   └── contact.php
     └── SETUP_GUIDE.md
     ```

#### **Step 3: Database Setup**
1. **Create MySQL Database:**
   - Go to cPanel → MySQL Databases
   - Create new database: `shree_yash_creations`
   - Create database user with full privileges
   - Note down database name, username, and password

2. **Update Database Configuration:**
   - Edit `config.php`
   - Update these lines with your hosting details:
     ```php
     define('DB_HOST', 'localhost'); // Usually localhost
     define('DB_USER', 'your_db_username');
     define('DB_PASS', 'your_db_password');
     define('DB_NAME', 'your_db_name');
     ```

#### **Step 4: Initialize Database**
1. **Run setup script:**
   - Visit: `https://yourdomain.com/setup.php`
   - This will create all tables and sample data
   - **Important:** Delete `setup.php` after successful setup

#### **Step 5: Test Your Website**
- Visit: `https://yourdomain.com/home.html`
- Test admin panel: `https://yourdomain.com/admin_panel.html`
- Login: admin / admin123

---

### **Option 2: VPS/Dedicated Server**

#### **Step 1: Server Setup**
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install LAMP stack
sudo apt install apache2 mysql-server php php-mysql php-curl php-gd php-mbstring -y

# Start services
sudo systemctl start apache2
sudo systemctl start mysql
sudo systemctl enable apache2
sudo systemctl enable mysql
```

#### **Step 2: Configure Apache**
```bash
# Set document root permissions
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html

# Enable mod_rewrite
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### **Step 3: Configure MySQL**
```bash
# Secure MySQL installation
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p
```

```sql
CREATE DATABASE shree_yash_creations;
CREATE USER 'shreeyash'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON shree_yash_creations.* TO 'shreeyash'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### **Step 4: Upload Files**
```bash
# Upload files to /var/www/html/
# Use SFTP or SCP to transfer files
```

#### **Step 5: Update Configuration**
Edit `config.php` with your database credentials.

---

### **Option 3: Cloud Platforms**

#### **Heroku (Free Tier Available)**
1. **Install Heroku CLI**
2. **Create Procfile:**
   ```
   web: vendor/bin/heroku-php-apache2
   ```
3. **Deploy:**
   ```bash
   heroku create your-app-name
   git add .
   git commit -m "Initial commit"
   git push heroku main
   ```

#### **Vercel (Free Tier Available)**
1. **Connect GitHub repository**
2. **Deploy automatically**
3. **Note:** Requires database service (PlanetScale, etc.)

---

## 🔧 **Troubleshooting Common Issues**

### **Issue 1: Database Connection Error**
**Error:** "Connection failed"
**Solution:**
1. Check database credentials in `config.php`
2. Verify database exists
3. Check if MySQL service is running
4. Ensure database user has proper privileges

### **Issue 2: 404 Errors**
**Error:** "Page not found"
**Solution:**
1. Check file permissions (755 for folders, 644 for files)
2. Verify .htaccess file (if using Apache)
3. Check file paths are correct
4. Ensure files are in correct directory

### **Issue 3: PHP Errors**
**Error:** "PHP Fatal error"
**Solution:**
1. Check PHP version (requires 7.4+)
2. Enable error reporting in `config.php`:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```
3. Check PHP extensions are installed

### **Issue 4: Contact Form Not Working**
**Error:** "Failed to send message"
**Solution:**
1. Check if `mail()` function is enabled
2. Configure SMTP settings in hosting
3. Use alternative email service (SendGrid, Mailgun)
4. Check server logs for errors

### **Issue 5: Images Not Loading**
**Error:** "Image not found"
**Solution:**
1. Verify `OIP.jpeg` is uploaded
2. Check file permissions
3. Ensure correct file path
4. Check file size (should be under 5MB)

### **Issue 6: Admin Panel Login Issues**
**Error:** "Invalid credentials"
**Solution:**
1. Run `setup.php` to create admin user
2. Default login: admin / admin123
3. Check database connection
4. Verify admin table exists

---

## 📧 **Email Configuration**

### **For Contact Form to Work:**

#### **Option 1: Configure SMTP (Recommended)**
Add to `api/contact.php`:
```php
// Configure SMTP
ini_set('SMTP', 'smtp.gmail.com');
ini_set('smtp_port', '587');
```

#### **Option 2: Use External Email Service**
Replace mail() function with SendGrid or Mailgun API.

#### **Option 3: Manual Email Setup**
1. Contact your hosting provider
2. Enable mail() function
3. Configure email settings in cPanel

---

## 🔒 **Security Checklist**

### **Before Going Live:**
- [ ] Change default admin password
- [ ] Delete `setup.php` after database setup
- [ ] Set proper file permissions
- [ ] Enable HTTPS (SSL certificate)
- [ ] Configure firewall rules
- [ ] Regular database backups
- [ ] Update contact email to real address

### **File Permissions:**
```bash
# Folders
chmod 755 /path/to/website

# Files
chmod 644 /path/to/website/*.php
chmod 644 /path/to/website/*.html

# Config file (more restrictive)
chmod 600 /path/to/website/config.php
```

---

## 📞 **Support**

### **If Still Having Issues:**
1. **Check hosting provider's documentation**
2. **Contact hosting support**
3. **Check server error logs**
4. **Test with simple PHP file first**

### **Quick Test File:**
Create `test.php`:
```php
<?php
phpinfo();
?>
```
Upload and visit to verify PHP is working.

---

## 🎯 **Final Steps**

1. **Test all functionality:**
   - Homepage loads correctly
   - Products display with images
   - Contact form sends emails
   - Admin panel works
   - Cart and checkout function

2. **Update content:**
   - Replace sample data with real products
   - Update contact information
   - Add real product images
   - Customize colors and branding

3. **SEO and Performance:**
   - Add meta tags
   - Optimize images
   - Enable caching
   - Add Google Analytics

Your Shree Yash Creations e-commerce website should now be live and fully functional! 🚀 