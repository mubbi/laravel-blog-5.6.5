# Laravel Blog - Based on Laravel v5.6.5
This is a sample blog based on Laravel 5.6 framework and Bootstrap 4.


# Features!
  - Blogs/Articles
  - Categories
  - Comments
  - Featured Image
  - Admin Area
  - Role Based Access
  - RSS Feed
  - Subscribers
  - SEO Friendly
  - Social Friendly
  - Automated Emails On Registration with Queue/Job
  - Automated Emails on Subscriber with Queue/Job
  - Automated Emails for newsletters with Queue/Job
  - Laravel Migrations
  - Laravel Seeders
  - Simple & Minimal UI Design


# Tech
This blog project uses some open source projects and free projects to work properly:
* Twitter Bootstrap 4 - great UI boilerplate for modern web apps
* Laravel 5.6.5 - Framework for Web Artisans
* jQuery - duh
* FontAwesome - Design savy icons for developers
* TinyMCE - WYSIWYG rich text editor
* DataTable - Easily Manage Data sets for management purpose using jquery
* Sluggable - make slugs easily in laravel
* Roumen Feed - make RSS Feed easily in laravel
* Yajra Laravel Datatables - Easily integrat DataTable backend for laravel

And of course blog project itself is open source with a public repository on GitHub.

# Live Demo
 ` http://mubbiqureshi.com/laravel-blog/public/ `

Admin ID: ` mubbi@test.com `

Admin Pass: ` mubbi123 `


# Minimum Requirements
* PHP >= 7.1.3
* MySQL >= 5.0.12
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension

# Installation Guide
1. `git clone https://github.com/mubbi/laravel-blog-5.6.5.git`
2. `cd laravel-blog-5.6.5`
3. `composer install`
4. `rename .env.example to .env`
5. `php artisan key:generate`
6.  Edit file `config/app.php & .env` - and set your correct app url
7.  Edit file `config/database.php` - and set your DB connection details
8. `php artisan migrate --seed`
9. `php artisan storage:link`
10. `set mailtrap credentials in .env file to avoid swift email errors`
11. `After installing, you may need to configure some permissions. Directories within the "storage" and the "bootstrap/cache" directories should be writable by your web server or the project will not run.`
12. `Register in the application as the first user and get all admin roles by default`

NOTE: Automatic user registration activation emails and subscriber verification emails are sent using the queue worker, therefore you must enable the queue worker on the project: https://laravel.com/docs/5.6/queues#running-the-queue-worker

### Weekly Newsletter Guide
1. Set Queue Driver in .env or config/queue.php file
2. Follow: https://laravel.com/docs/5.6/scheduling#introduction
3. From the above link learn how to make a cron job for ` schedule:run `
4. Once this cron job is set for every minute then the weekly emails will be sent automatically

# Screenshots
### Home Page

![Home Page](https://preview.ibb.co/ku0G7n/screencapture_localhost_81_laravel_blog_laravel_blog_5_6_5_public_1520539108112.png)

### Admin Area

![Admin Area](https://preview.ibb.co/cSRQYS/screencapture_localhost_81_laravel_blog_laravel_blog_5_6_5_public_admin_blogs_1520532879922.png)

# License
GNU GPLv3
