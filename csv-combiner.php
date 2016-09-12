<?php  
  //remove the filename from the arguments
  $arguments = array_diff($argv, ["csv-combiner.php"]);
  
  // Get the file path of the newly creted CSV
  combineCsv($arguments);
  
  function combineCsv($files) {
    // check to make sure all CSVs passed in exist before running the combiner
    verifyCsv($files);
    
    // Output Header Columns
    $columns = "email_hash, category, filename";
    print $columns;

    foreach ($files as &$file) {
      $file_path = "fixtures/" . $file;
      
      // Grab CSV
      $csv = fopen($file_path, 'r');

      // Get Header Row
      $header = fgetcsv($csv, 4096, ';', '"');

      rowData($csv, $header, $file);
    }
  }
  
  function verifyCsv($files) {
    foreach ($files as &$file) {
      $file_path = "fixtures/" . $file;
      
      if(!file_exists($file_path)) {
        print "The " .$file. " does not exist in the the fixtures folder.\n";
        exit;
      }
    }
  }
  
  function rowData($csv, $header, $file) {
    while($row = fgetcsv($csv, 4096, ';', '"'))
    {
      parseRow($row, $file);
    }
  } 
  
  function parseRow($row, $filename) {
    $format = "%s, %s, %s\n";
    
    // Remove escaped quotes from row columns if necessary
    $strip_row = str_replace(['\"', '"'], "", $row[0]);
    
    // Split the string into an array
    $separate_columns = explode(",", $strip_row);
    
    // Add row to the table
    print sprintf($format, $separate_columns[0], $separate_columns[1], $filename);
  }
?>