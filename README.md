# PHP CSV Combiner

Combine multiple CSV files and output that information with an additional column containing the file name. Use the commands below to run the script.

Once in the root folder of the combiner.php script, you can run multiple commands based on whether or not you want to pass in individual files, directories, or both. If you want to pass in an individual file, just type -f followed by the path to the file.

By default, the script is only expecting CSVs and will throw an error message if you attempt to pass in excel files.

`php csv-combiner.php -f csv/accessories.csv  -f csv/clothing.csv -f csv/household_cleaners.csv`

To pass in a directory, type -d followed by the path to the directory and it will attempt to grab all files within that directory.

`php csv-combiner.php -d csv`

To pass in multiple directories, you can use the options in any combination.

`php csv-combiner.php -d csv -d other_files -f csv/clothing.csv`

## Validation

The combiner verifies that all files exist, that they are all the correct type of file, and that all files have the same column headers. If the same file is passed in multiple times, it will only output that file's information once.