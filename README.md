<p>files folder: </p>
<p>/storage/app/public/csv-files/IMDb movies.csv</p>
<p>/storage/app/public/csv-files/IMDb names.csv</p>

php artisan storage:link <br>
php artisan migrate <br>
php artisan casts:parse <br>
php artisan movies:parse <br>


sql:

SELECT ((year div 10) * 10) as decade, title, avg_vote FROM movies GROUP BY decade, title, avg_vote ORDER BY decade ASC, avg_vote DESC
