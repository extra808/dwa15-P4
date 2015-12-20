## P4: ATC Delivery

## Live URL
<http://p4.dwa15.cognize.org>

## Description
A site for delivering files to student clients of the Assistive Technology Center (ATC). Staff login, add the students, courses (organized by semester and year), then upload files to the courses. Student clients login and can only download the files for courses they're allowed access to.

## Demo
[Part 1, user interface (9:34)](https://youtu.be/7FhOelfLZYs)
[Part 2, the code (15:13)](https://youtu.be/DDyeV-izAjc) You might want to skip this, it's long and rambling

## Details for teaching team
* Authentication is external using OAuth with Google and limited to addresses of a single domain. Login information for test users provided separately
* Jill is a staff member, Jamal is a student
* [Logout of Google link](https://accounts.google.com/logout) provided for testing convenience
* Validation performed in models
* `onDelete('cascade')` in foreign key relationship makes database take care of deleting related records in courses and course_file tables, instead of code in controllers or models
* Uploaded filenames converted and transliterated to ASCII for compatibility with <a href="http://laravel.com/docs/5.1/responses#file-downloads">Laravel File Downloads</a> method.
* FilesTableSeeder uses `$faker->imageUrl()` to get random image data but writes it into files on the file system with different filename extensions.

## Outside code
* [Bootstrap Default navbar](http://getbootstrap.com/examples/navbar/)
* [Trick: Validation within models.](http://daylerees.com/trick-validation-within-models/)
* Check for empty directory before removing [PHP: What is the best and easiest way to check if directory is empty or not](http://stackoverflow.com/questions/18685576/php-what-is-the-best-and-easiest-way-to-check-if-directory-is-empty-or-not)
* OAuth package [adamwathan/eloquent-oauth-l5](https://github.com/adamwathan/eloquent-oauth-l5)
* [Laravel 5 routes - restricting based on user type](http://laravel.io/forum/02-17-2015-laravel-5-routes-restricting-based-on-user-type)
* For orphan files [Get all eloquent models without relationship](http://stackoverflow.com/questions/31535024/get-all-eloquent-models-without-relationship)