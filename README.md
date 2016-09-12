# PHP CSV Combiner

Combine multiple CSVs data with similar columns and output that information with an additional column containing the file name. Use the command below to run the script.

Run the following command in the terminal from the root folder to test. If you would like to use other files than the ones provided, you'll simply need to place the file inside the fixtures folder and add the filename as another argument to the command below.

`php csv-combiner.php accessories.csv clothing.csv household_cleaners.csv`

If you attempt to add another another argument that is not a valid CSV, it will not run the process and alert you what file is missing.