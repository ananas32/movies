<p>files folder: </p>
<p>/storage/app/public/csv-files/IMDb movies.csv</p>
<p>/storage/app/public/csv-files/IMDb names.csv</p>
>>>>>>> 4f89cd4ba1301a926c4c0be07b7910646d9ccd31

php artisan storage:link <br>
php artisan migrate <br>
php artisan casts:parse <br>
php artisan movies:parse <br>



php artisan queue:listen --timeout=0
