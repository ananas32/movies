<p>files folder: </p>
<p>/storage/app/public/csv-files/IMDb movies.csv</p>
<p>/storage/app/public/csv-files/IMDb names.csv</p>

php artisan storage:link
php artisan migrate
php artisan casts:parse
php artisan movies:parse
