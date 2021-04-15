# Task

The task described in [Task.md](TASK.md)

# How it works

To run the code, just run
```
php -f run.php
```

- Inside `run.php` the date range can be specified to test different dates.
- When requested more than 10 days it throws `DataLimitException` from the API, so that it goes to the splitting period scenario
- Time chunks are being saved to the `data/search.json` file
- Activity data sample is in the `data/logs.txt` (which api collector returns)
