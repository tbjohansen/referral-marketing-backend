==== STEPS TO SETUP AND RUN THIS PROJECT ON LOCAL MACHINE ====

1. Clone GitHub repo for this project locally
Since the project is hosted on github, use git on your local computer to clone it from github onto your local computer.

Once this runs, you will have a copy of the project on your computer.

2. cd into your project
You will need to be inside that project file to enter all of the rest of the commands.

3. Install Composer Dependencies
Since you cloned a new Laravel project you must now install all of the project dependencies. This is what actually installs Laravel itself, among other necessary packages to get started.
So to install all this source code you run composer with the following command.

*composer install*

4. Install NPM Dependencies
Just like how you must install composer packages to move forward, you must also install necessary NPM packages to move forward.

*npm install*
or
*yarn*

5. Create a copy of your .env file
.env files are not generally committed to source control for security reasons. But there is a .env.example which is a template of the .env file that the project expects us to have. So you will make a copy of the .env.example file and create a .env file that you can start to fill out to do things like database configuration in the next few steps.

*cp .env.example .env*

This will create a copy of the .env.example file in your project and name the copy simply .env.

6. Generate an app encryption key
Laravel requires you to have an app encryption key which is generally randomly generated and stored in your .env file. The app will use this encryption key to encode various elements of your application from cookies to password hashes and more.

*php artisan key:generate*

If you check the .env file again, you will see that it now has a long random string of characters in the APP_KEY field. We now have a valid app encryption key.

7. Create an empty database for your application
Create an empty database for your project using the database tools you prefer.

8. In the .env file, add database information to allow Laravel to connect to the database
You will want to allow Laravel to connect to the database that you just created in the previous step. To do this, you must add the connection credentials in the .env file and Laravel will handle the connection from there.

In the .env file fill in the DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD options to match the credentials of the database you just created. This will allow you to run migrations and seed the database in the next step.

9. Migrate the database
Once your credentials are in the .env file, now you can migrate your database.

*php artisan migrate*

It’s not a bad idea to check your database to make sure everything migrated the way you expected.

10. Start your project
Run the followong command to start your project locally, and make sure you have xampp or wamp server runs on your computer.

*php artisan serve*
