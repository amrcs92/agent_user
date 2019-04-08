#######################################
Agent/User management system with login
#######################################

An interactive agent profile management system with Create, List, Edit, Delete options in CodeIgniter.

*******************
Project Information
*******************

  - a login page with “Forgot Password”, “Register”, “Remember Me” (it store the login in a cookie and it still active until logged out).
	- Forgot password & reset password
	- Register form:
			- Username
			- Password BCRYPT
			- Agent Name (first name & last name)
			- Company Name
			- Email
			- Phone
			- Mobile 1
			- Mobile 2
			- Address
			- Postal code
			- State
			- Country

*********
Features
*********

•	Once register, user can login and after login user can view & edit profile. There should be “Change password” option if they wish to change the password.
•	When user login, the login ip are tracked & stored, login device(mobile/tab/pc) and it show last login date & time.


*******************
Server Requirements
*******************

PHP version 7.3.1 or newer is recommended.

It should work on 7.1.26 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************
1) create database with collation utf8_general_ci & import sql in project root 
"agent_mg_system.sql"

2) Just run this command below:
``composer install``

that's it enjoy !!
