## P4: ATC Delivery

## Live URL
<http://p4.dwa15.cognize.org>

## Description
A site for delivering files to student clients of the Assistive Technology Center (ATC). Staff login, add the students, courses (organized by semester and year), then upload files to the courses. Student clients login and can only download the files for courses they're allowed access to.

## Demo

## Details for teaching team
* Authentication is external using OAuth with Google and limited to addresses of a single domain. Login information for test users provided separately
* Jill is a staff member, Jamal is a student
* [Logout of Google link](https://accounts.google.com/logout) provided for testing convenience
* Validation performed in models
* `onDelete('cascade')` in foreign key relationship makes database take care of deleting related records in courses and course_file tables, instead of code in controllers or models
* Uploaded filenames converted and transliterated to ASCII for compatibility with <a href="http://laravel.com/docs/5.1/responses#file-downloads">Laravel File Downloads</a> method.

## Outside code
* [Bootstrap Fixed top navbar](http://getbootstrap.com/examples/navbar-fixed-top/)
* [Trick: Validation within models.](http://daylerees.com/trick-validation-within-models/)
* [Download File to server from URL](http://stackoverflow.com/questions/3938534/download-file-to-server-from-url)
* [PHP: What is the best and easiest way to check if directory is empty or not](http://stackoverflow.com/questions/18685576/php-what-is-the-best-and-easiest-way-to-check-if-directory-is-empty-or-not)
* [adamwathan/eloquent-oauth-l5](https://github.com/adamwathan/eloquent-oauth-l5)
* [Laravel 5 routes - restricting based on user type](http://laravel.io/forum/02-17-2015-laravel-5-routes-restricting-based-on-user-type)
