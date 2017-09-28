Endpoints:
1) To get all data use domain/values (Method GET)
2) To get some data filtering with key use domain/values?keys=key1,key2... (Method POST)
3) To add new data use domain/values 
   add your input at body like {"a":"a1", "b":"b1", "c":"c1"}
   and use method POST.

To delete records older than five minutes will be deleted by scduled task for that I have used code at Kernel.php

Run: php /path/to/artisan schedule:run
to start the script.
For better documentation https://laravel.com/docs/5.3/scheduling
