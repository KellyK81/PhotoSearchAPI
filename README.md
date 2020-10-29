<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Photo Search API
This project host API endpoints for searching photos from various sources.

## Pre-requisites
1. Git
2. PHP 7.3 - Install PHP only if setting up the Vagrant Server.
3. Composer: https://getcomposer.org/download/
4. Visual Studio Code - https://code.visualstudio.com/
5. Visual Studio Code Extensions - PHP Intellisense (optional), PHP IntelePhense, PHP Debug

## Setup Instructions

1. Checkout UI repository: git clone <repository name> photosearchui
2. Checkout API repository: git clone <repository name> photosearchapi
3. Switch to dev branch for both repository on local: git checkout dev
3. Run Composer Install: "composer install" inside PhotoSearchAPI folder
    - For Vagrant setup, execute "composer install —ignore-platform-reqs"
4. If you have setup vagrant, then run "vagrant box add laravel/homestead"
    - If there is any issue with composer SSL cert: run "composer config -g -- disable-tls true"
5. Run "vagrant up"  - This step will download a Laravel Homestead Image and setup the VM Image including all the LAMP stack
5. After your machine is installed and running, run "vagrant ssh" to go inside the machine.
6. You may need to add host entries to both API and Frontend APP from local (Mac: /etc/hosts and Windows: c:\windows\system32\drivers\etc\hosts)

## WAMP Setup
1.  WAMP Server: https://www.wampserver.com/en/
        - WAMP stands for Windows, Apache, MySql, & PHP

## Vagrant Setup

1. Install Vagrant: https://www.vagrantup.com/downloads
2. Vagrant Box and the extension pack: https://www.virtualbox.org/wiki/Downloads 
        - This will be needed for our development environment.
3. 

## References

- Laravel Homestead: https://laravel.com/docs/8.x/homestead	
- PHP Tutorial: https://www.w3schools.com/php/DEFAULT.asp	
- Laravel Tutorial: https://www.tutorialspoint.com/laravel/index.htm	
- Laravel API Tutorial: https://laravel.com/docs/8.x/passport	
- HTML5 Tutorial: https://www.w3schools.com/html/	
- JavaScript Tutorial: https://www.w3schools.com/js/DEFAULT.asp	
- Bootstrap Library Tutorial: https://www.w3schools.com/bootstrap/bootstrap_get_started.asp

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
